<?php
//need cron job
class orderRequest{
    protected $connection;
    protected $instance;
    protected function __construct()
    {
        $DB_link = new DB_Link();
        $this->connection = $DB_link->connect();
    }
    
}
class orderReciever extends orderRequest{
    public function accept_order_request(){
        $sql = "SELECT * FROM campus WHERE campus_name = '$name'";
        $stmt = $this->connection->prepare($sql);
        if(!$stmt){
            echo "Prepare failed: (". $this->connection->errno.") ".$this->connection->error."<br>";
            }
        $stmt->execute();
    
        $result = $stmt->get_result();
        if(!$result){
            echo "query failed";
        }
        else{
            $row = mysqli_fetch_assoc($result);
        }
    }

}
class orderPlacer extends orderRequest{
    public function create_order_request(){
        $sql = "SELECT * FROM campus WHERE campus_name = '$name'";
        $stmt = $this->connection->prepare($sql);
        if(!$stmt){
            echo "Prepare failed: (". $this->connection->errno.") ".$this->connection->error."<br>";
            }
        $stmt->execute();
    
        $result = $stmt->get_result();
        if(!$result){
            echo "query failed";
        }
        else{
            $row = mysqli_fetch_assoc($result);
        }
    }

}
?>