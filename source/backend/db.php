<?php
    class DB_Link {
        //used for our connect value
        private $connection;
        //mysql username (on phpmyadmin)
        private $username = "root";
        //password for phpmyadmin
        private $password = "";
        //this just does this connection
        function connect($host, $db){
            $this->connection = new mysqli($host, $this->username, $this->password, $db);
            if($this->connection->connect_error){
                die("Couldn't connect to db : " . $this->connection->connect_error);
            }
            else{
                return $this->connection;
            }
        }
    }
?>