<?php
    include_once("../backend/db.php");

    $DB_link = new DB_Link();
    $connection = $DB_link->connect("localhost", "cvis");

    class Vaccine{

     private $brand_name;

     //setter
     function set_vaccine_name($brand_name){
        $this->brand_name = $brand_name;
      }

     //getters
     function get_vaccine_name(){
        return $this->brand_name;
      }
      // returns 1 for johnson and johnson and 2 for pfizer or moderna 
     function get_vaccine_doses(){
         if ($this->brand_name == "johnson and johnson")
         {
             return 1;
         } 
         else if ($this->brand_name == "pfizer" || $this->brand_name == "moderna") {
             return 2;
         }
         else{
            echo "invalid vaccine name";
         }
     }
 }
