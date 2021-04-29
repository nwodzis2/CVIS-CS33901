<?php
include_once("../backend/db.php");
class graph{
    
    protected $connection;
    public function __construct()
    {
        $DB_link = new DB_Link();
        $this->connection = $DB_link->connect();

    }
    

}
?>