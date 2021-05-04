<?php
//Made by Jaden Kandel Spring Semester 2021 for Software Engineering
    include_once("../backend/db.php");

    $DB_link = new DB_Link();
    $connection = $DB_link->connect("localhost", "cvis");
    
    class User {
        private $u_id;
        private $u_email;
        private $u_password;
        private $u_ap1;
        private $u_ap2;
        private $u_vaccine_type;
        private $u_vaccinated;
        private $u_has_insurance;
        
        //setters
        function set_u_id($u_id){
            $this->u_id = $u_id;
        }
        function set_u_email($u_email){
            $this->u_email = $u_email;
        }
        function set_u_password($u_password){
            $this->u_password = $u_password;
        }
        function set_u_ap1($u_ap1){
            $this->u_ap1 = $u_ap1;
        }  
        function set_u_ap2($u_ap2){
            $this->u_ap2 = $u_ap2;
        }           
        function set_u_vaccine_type($u_vaccine_type){
            $this->u_vaccine_type = $u_vaccine_type;
        }        
        function set_u_vaccinated($u_vaccinated){
            $this->u_vaccinated = $u_vaccinated;
        }
        function set_u_has_insurance($u_has_insurance){
            $this->u_has_insurance = $u_has_insurance;
        }
        
        //getters
        function get_u_id(){
            return $this->u_id;
        }
        function get_u_email(){
            return $this->u_email;
        }
        function get_u_password(){
            return $this->u_password;
        }
        function get_u_ap1(){
            return $this->u_ap1;
        }        
        function get_u_ap2(){
            return $this->u_ap2;
        }        
        function get_u_vaccine_type(){
            return $this->u_vaccine_type;
        }        
        function get_u_vaccinated(){
            return $this->u_vaccinated;
        }        
        function get_u_has_insurance(){
            return $this->u_has_insurance;
        }
    }
    function update_insurance($connection, $email, $expression){
        $sql = "UPDATE users SET has_insurance = '$expression' WHERE email = '$email'";
        $stmt = $connection->prepare($sql);
        
        $stmt->execute();

        $result = $stmt->get_result();   
    }
    function get_user_details_by_email($connection, $email){
        $sql = "SELECT * FROM users WHERE email = '$email'";
        

        $stmt = $connection->prepare($sql);

        $stmt->execute();

        $result = $stmt->get_result();   
        if(!$result){
            echo "query failed";
        }
        else{    
            while($row = mysqli_fetch_assoc($result)){
                $u = new User();
                
                $u->set_u_id($row['id']);
                $u->set_u_email($row['email']);
                $u->set_u_password($row['password']);
                $u->set_u_ap1($row['appointment_1']);
                $u->set_u_ap2($row['appointment_2']);
                $u->set_u_vaccine_type($row['vaccine_type']);
                $u->set_u_vaccinated($row['vaccinated']);
                $u->set_u_has_insurance($row['has_insurance']);
                
                return $u;
            }
        }
   
    }
    function logOut(){
        $_SESSION['authenticated'] = false;
    }
?>

    