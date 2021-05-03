<?php

//Made by Jaden Kandel Spring Semester 2021 for Software Engineering
    include_once("../backend/db.php");
    $DB_link = new DB_Link();
    $connection = $DB_link->connect("localhost", "cvis");
    /*$appointmentArray = [];
    
    $datetime = DateTime::createFromFormat('G:i', "8:00");
    for($i = 0; $i < 60; $i++){
        if(!check_for_appointment_at_time_and_location($connection, $_POST['campus'], $_POST['day'], $_POST['month'], $datetime->format('G:i:s'))){
            array_push($appointmentArray, $datetime->format('G:i'));
        }
        $datetime->modify('+10 minutes');
    }
    $_SESSION['apt-array'] = $appointmentArray;*/
    
    //echo $datetime->format('G:i:s');
    //$appointmentArray = check_for_appointment_at_time_and_location($connection, $_POST['campus'], $_POST['day'], $_POST['month'], );
    
    class Appointment {
        private $a_fname;
        private $a_lname;
        private $a_email;
        private $a_campus;
        private $a_day;
        private $a_month;
        private $a_time_of;
        private $a_completed;
        private $a_giver;
        
        //setters
        function set_fname($a_fname){
            $this->a_fname = $a_fname;
        }
        function set_lname($a_lname){
            $this->a_lname = $a_lname;
        }
        function set_email($a_email){
            $this->a_email = $a_email;
        }
        function set_campus($a_campus){
            $this->a_campus = $a_campus;
        }
        function set_day($a_day){
            $this->a_day = $a_day;
        }        
        function set_month($a_month){
            $this->a_month = $a_month;
        }        
        function set_time_of($a_time_of){
            $this->a_time_of = $a_time_of;
        }        
        function set_completed($a_completed){
            $this->a_completed = $a_completed;
        }
        function set_giver($a_giver){
            $this->a_giver = $a_giver;
        }
        
        //getters
        function get_fname(){
            return $this->a_fname;
        }
        function get_lname(){
            return $this->a_lname;
        }
        function get_email(){
            return $this->a_email;
        }
        function get_campus(){
            return $this->a_campus;
        }        
        function get_day(){
            return $this->a_day;
        }        
        function get_month(){
            return $this->a_month;
        }        
        function get_time_of(){
            return $this->a_time_of;
        }        
        function get_completed(){
            return $this->a_completed;
        }
        function get_giver(){
            return $this->a_giver;
        }
    }
    function get_appointments_by_campus($connection, $campus, $day, $month){
        $sql = "SELECT * FROM appointments WHERE campus = '$campus' AND day = '$day' AND month = '$month'";

        $stmt = $connection->prepare($sql);

        $stmt->execute();

        $result = $stmt->get_result();
        
        if(!$result){
            echo "query failed";
        }
        else{
            $appointments_by_campus = [];
            
            while($row = mysqli_fetch_assoc($result)){
                $appointment = new Appointment();
                
                $appointment->set_fname($row['first']);
                $appointment->set_lname($row['last']);
                $appointment->set_email($row['user_email']);
                $appointment->set_campus($row['campus']);
                $appointment->set_day($row['day']);
                $appointment->set_month($row['month']);
                $appointment->set_time_of($row['time_of']);
                $appointment->set_completed($row['completed']);
                $appointment->set_giver($row['vaccine_giver']);
                
                array_push($appointments_by_campus, $appointment);
            }
        }
        
        $blank_times = [
        "-","-","-","-","-",
        "-","-","-","-","-","-",
        "-","-","-","-","-","-",
        "-","-","-","-","-","-",
        "-","-","-","-","-","-",
        "-","-","-","-","-","-",
        "-","-","-","-","-","-",
        "-","-","-","-","-","-",
        "-","-","-","-","-","-",
        "-","-","-","-","-","-",
        ];
        
        $time = array();
        foreach($appointments_by_campus as $appointment){
            $time[$appointment->get_time_of()] = $appointment->get_email();
            $spot = get_location($appointment->get_time_of());
            $blank_times[$spot] = $appointment->get_email();
        }
        return $blank_times;
    }
    
    //checks by user_email if a person has an appointment
    function has_appointment($connection, $user_email){
        $sql = "SELECT * FROM appointments WHERE user_email = '$user_email'";

        $stmt = $connection->prepare($sql);

        $stmt->execute();

        $result = $stmt->get_result();
        
        if(!$result){
            echo "query failed";
        }
        else{
            $count = 0;
            while($row = mysqli_fetch_assoc($result)){
                $done_or_not = $row['completed'];
                if($done_or_not === 1){
                    
                }
                else{
                    $count = $count + 1;
                } 
            }
            if($count != 0){
                return true;
            }
            else{
                return false;
            }
        }
    
    }
    //returns false if the an appointment is at this time and returns true if there is an appointment at the time and campus
    function check_for_appointment_at_time_and_location($connection, $campus, $day, $month, $time) {
        $sql = "SELECT * FROM `appointments` WHERE campus = '$campus' AND day = '$day' AND month = '$month' AND time_of = '$time'";
        
        $stmt = $connection->prepare($sql);

        $stmt->execute();

        $result = $stmt->get_result();

        if(!$result){
            echo "query failed";
        }
        else{
            $row = mysqli_fetch_assoc($result);
            if(empty($row)){
                return false;
            }
            else{
                return true;
            }
        }
    }
    //for scheduling an appointment... gonna be a ton of if statements :)
    function make_appointment($connection, $first, $last, $user_email, $campus, $day, $month, $time, $completed, $vaccine_giver){
        if(has_appointment($connection, $user_email)) {
            echo "You may not schedule another appointment as you already have one";
        }
        else{
            if(check_for_appointment_at_time_and_location($connection, $campus, $day, $month, $time)){
                echo "There is already an appointment at this time and location";
            }
            else{
                $sql = "INSERT INTO Appointments(first, last, user_email, campus, day, month, time_of, completed, vaccine_giver)
                VALUES ('$first', '$last','$user_email', '$campus', '$day','$month','$time','$completed','$vaccine_giver')";

                $stmt = $connection->prepare($sql);

                $stmt->execute();

                $result = $stmt->get_result();
                echo "your appointment has been scheduled!";
                echo "<br>";
                $sql = "UPDATE campus SET doses_on_hand = (doses_on_hand - 1) WHERE campus_name = '$campus'";
        
                $stmt = $connection->prepare($sql);
            
                $stmt->execute();
            
                $result = $stmt->get_result();
            }
        } 
    }
    
    function cancel_appointment($connection, $user_email){
        if(!has_appointment($connection, $user_email)) {
            echo "You do not have a pending appointment";
        }
        else{
            $sql = "DELETE FROM Appointments WHERE user_email = '$user_email' AND completed = 0";

            $stmt = $connection->prepare($sql);

            $stmt->execute();

            $result = $stmt->get_result();
            echo "Your appointment has been cancelled!";
            echo "<br>";
        }
    }
    function reschedule_appointment($connection, $user_email, $new_campus, $new_day, $new_month, $new_time_of, $new_vaccine_giver){
        if(!has_appointment($connection, $user_email)) {
            echo "You do not have a pending appointment to reschedule";
        }
        //Im too lazy to just update the row so instead I delete the row and make a new one... haha
        else{
            $sql = "SELECT * FROM Appointments WHERE user_email = '$user_email' AND completed = 0";

            $stmt = $connection->prepare($sql);

            $stmt->execute();

            $result = $stmt->get_result();
            if(!$result){
                echo "query failed";
            }
            else{
                
                while($row = mysqli_fetch_assoc($result)){
                    //data to carry over for the rescheduling
                    $first = $row['first'];
                    $last = $row['last'];
                    $email = $row['user_email'];
                    $completed = $row['completed'];
                }
            }

            //deletes current appointment 
            $sql = "DELETE FROM Appointments WHERE user_email = '$user_email' AND completed = 0";

            $stmt = $connection->prepare($sql);

            $stmt->execute();

            $result = $stmt->get_result();
            
            //makes new appointment
            make_appointment($connection, $first, $last, $email, $new_campus, $new_day, $new_month, $new_time_of, $completed, $new_vaccine_giver);
        }  
    }
    function get_appointments_by_email($connection, $email){
        if(!has_appointment($connection, $email)) {
            echo "You do not have a pending appointment";
        }
        else{
            $sql = "SELECT * FROM Appointments WHERE user_email = '$email' AND completed = 0";

            $stmt = $connection->prepare($sql);

            $stmt->execute();

            $result = $stmt->get_result();
            $row = mysqli_fetch_assoc($result);
            $return_campus = $row['campus'];
            $return_time = $row['time_of'];
            $return_month = $row['month'];
            $return_day = $row['day'];
            echo "<p style='font-size: 20px;'> <span style='color: #053B74;'>campus:</span> " . $return_campus . "<br> <span style='color: #053B74;'>date: </span>" . "2021/". $return_month . "/" . $return_day . "<br><span style='color: #053B74;'> time: </span>" . $return_time . "</p>" ;
            
        }
    }

/*
CREATE TABLE `Appointments` (
	`appointment_id` INT(32) NOT NULL AUTO_INCREMENT,
    `first` VARCHAR(64),
    `last` VARCHAR(64),
	`user_email` VARCHAR(64),
	`campus` VARCHAR(64),
	`day` VARCHAR(16),
	`month` VARCHAR(16),
	`time_of` VARCHAR(16),
	`completed` INT(2),
	`vaccine_giver` VARCHAR(64),
	PRIMARY KEY (`appointment_id`)
);

INSERT INTO Appointments(user_email, campus, day, month, time_of, completed, vaccine_giver) VALUES ('jkandel4@kent.edu', 'stark', '25','4','9:00','1','bob smith')

*/
?>