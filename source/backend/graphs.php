<?php
include_once("../backend/db.php");
class graph{
    protected $thearray;
    protected $jsonString;
    protected $connection;
    public function __construct()
    {
        $DB_link = new DB_Link();
        $this->connection = $DB_link->connect();

    }
    public function get_total_data(){
        //virtual
    }
    public function get_campus_data($campus){
        //virtual
    }
}
class paymentGraph extends graph{
    //will get constructor from graph
    public function get_total_data(){
        
    }
    public function get_campus_data($campus){

    }
}
class vaccineGraph extends graph{
    //will get constructor from graph
    public function get_total_data(){
        $this->thearray = array();
        $sql = "SELECT DISTINCT day, month FROM Appointments WHERE completed = 1";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute();

            $result = $stmt->get_result();
        if(!$result){
                echo "query failed";
            }
        else{
            while($row = mysqli_fetch_assoc($result)){
                $day = $row['day'];
                $month = $row['month'];
                
                
                $sql2 = "SELECT COUNT(*) AS total FROM Appointments WHERE day = '$day' AND month = '$month' AND completed = 1";
                $stmt2 = $this->connection->prepare($sql2);
               
                $stmt2->execute();
                
                $result2 = $stmt2->get_result();
                if(!$result2){
                    echo "query failed";
                }
                else{
                    $month = sprintf("%02d", $month);
                    $output = "2021-" . $month . "-" . $day;
                    //need an array of arrays
                    $row2 = mysqli_fetch_assoc($result2);
                    $date = DateTime::createFromFormat('Y-m-d', $output);
                    $this->thearray[$date->format('Y-m-d')] = $row2['total'];
                }
            }
        }
        ksort($this->thearray);
        foreach($this->thearray as $x => $x_value){
            $this->jsonString = $this->jsonString . "{ time: '" . $x . "', value: " . $x_value . " },";
        }
        return $this->jsonString;
    }
    public function get_campus_data($campus){
        $this->thearray = array();
        $sql = "SELECT DISTINCT day, month FROM Appointments WHERE completed = 1 AND campus = '$campus'";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute();

            $result = $stmt->get_result();
        if(!$result){
                echo "query failed";
            }
        else{
            while($row = mysqli_fetch_assoc($result)){
                $day = $row['day'];
                $month = $row['month'];
                
                
                $sql2 = "SELECT COUNT(*) AS total FROM Appointments WHERE day = '$day' AND month = '$month' AND completed = 1 AND campus = '$campus'";
                $stmt2 = $this->connection->prepare($sql2);
               
                $stmt2->execute();
                
                $result2 = $stmt2->get_result();
                if(!$result2){
                    echo "query failed";
                }
                else{
                    $month = sprintf("%02d", $month);
                    $output = "2021-" . $month . "-" . $day;
                    //need an array of arrays
                    $row2 = mysqli_fetch_assoc($result2);
                    $date = DateTime::createFromFormat('Y-m-d', $output);
                    $this->thearray[$date->format('Y-m-d')] = $row2['total'];
                }
            }
        }
        ksort($this->thearray);
        foreach($this->thearray as $x => $x_value){
            $this->jsonString = $this->jsonString . "{ time: '" . $x . "', value: " . $x_value . " },";
        }
        return $this->jsonString;
    }
    public function get_total_count(){
        $sql2 = "SELECT COUNT(*) AS total FROM Appointments WHERE completed = 1";
        $stmt2 = $this->connection->prepare($sql2);
        
        $stmt2->execute();
        
        $result2 = $stmt2->get_result();
        if(!$result2){
            return 0;
        }
        else{
            $row2 = mysqli_fetch_assoc($result2);
            $count = $row2['total'];
            return $count;
        }
    }
    public function get_campus_count($campus){
        $sql2 = "SELECT COUNT(*) AS total FROM Appointments WHERE completed = 1 AND campus = '$campus'";
        $stmt2 = $this->connection->prepare($sql2);
        
        $stmt2->execute();
        
        $result2 = $stmt2->get_result();
        if(!$result2){
            return 0;
        }
        else{
            $row2 = mysqli_fetch_assoc($result2);
            $count = $row2['total'];
            return $count;
        }
    }
}
?>