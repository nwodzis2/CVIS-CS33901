<?php
//Made by Jaden Kandel Spring Semester 2021 for Software Engineering
    include_once("../backend/db.php");

    $DB_link = new DB_Link();
    $connection = $DB_link->connect("localhost", "cvis");
    
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
    //returns a list of appointments at a campus, on a certain day... can be used to print the entire list of students at a campus on a day
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
        //the following can be used to print out the email of each user at the campus with a time at it, on a certain date.
        echo "<h1>" . $campus . "</h1>";
        foreach($appointments_by_campus as $appointment){
            echo "name = " . $appointment->get_fname() . " " . $appointment->get_lname() . " time = " . $appointment->get_time_of() . " on = " . $appointment->get_month() . "/" . $appointment->get_day(); 
            echo "<br>";
        }
    
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
?>



<?php 
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
    