<?php
//need cron job
//alt singleton
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
    }
    public static function getInstance($campus){
        if (self::$instance == null)
        {
        self::$instance = new orderReciever();
        }
 
        return self::$instance;
    }
}
class orderPlacer extends orderRequest{
    public function create_order_request(){
    }
    public static function getInstance(){
        
    }
}
?>