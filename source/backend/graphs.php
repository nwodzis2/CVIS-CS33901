<?php
include_once("../backend/db.php");
class graph{
    protected $thearray;
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
    protected function return_array(){

    }
}
class paymentGraph extends graph{
    //will get constructor from graph
    public function get_total_data(){
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
                $output = "2021-"+ $day + "-" + $month;
                $date = DateTime::createFromFormat('Y-M-D', $output);
                $sql = "SELECT COUNT(*) AS total FROM Appointments WHERE day = $day AND month = $month AND completed = 1";
                $stmt = $this->connection->prepare($sql);

                $stmt->execute();
                $result2 = $stmt->get_result();
                if(!$result2){
                    echo "query failed";
                }
                else{
                    $row2 = mysqli_fetch_assoc($result);
                    $thearray[$date] = $row2['total'];
                    
                }
            }
        }
        return json_encode($thearray);
    }
    public function get_campus_data($campus){

    }
}
class vaccineGraph extends graph{
    //will get constructor from graph
    public function get_total_data(){
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
                $output = "2021-" . $day . "-" . $month;
                $date = DateTime::createFromFormat('Y-m-D', $output);
                $sql2 = "SELECT COUNT(*) AS total FROM Appointments WHERE day = '$day' AND month = '$month' AND completed = 1";
                $stmt2 = $this->connection->prepare($sql2);
               
                $stmt2->execute();
                
                $result2 = $stmt2->get_result();
                if(!$result2){
                    echo "query failed";
                }
                else{
                    //need an array of arrays
                    $row2 = mysqli_fetch_assoc($result);
                    $thearray[$output] = $row2['total'];
                    
                }
            }
        }
        return json_encode($thearray);
    }
    public function get_campus_data($campus){
        
    }
}
?>