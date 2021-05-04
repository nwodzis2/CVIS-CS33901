
<?php
//Created by Nathan Wodzisz on April 27th 2021

include_once("../backend/db.php");

class Campus{
    protected $c_name;
    protected $c_vaccinated;
    protected $c_revenue;
    protected $c_regional;
    protected $c_doses_on_hand;
    protected $c_id;
    protected $connection;
    
        public function __construct()
        {
            $DB_link = new DB_Link();
            $this->connection = $DB_link->connect();

        }
    //********setters
        public function set_c_all($c_name, $c_vaccinated = 0, $c_revenue = 0, $c_regional = 0, $c_doses_on_hand = 0, $id = 0){
            $this->c_name = $c_name;
            $this->c_vaccinated = $c_vaccinated;
            $this->c_revenue = $c_revenue;
            $this->c_regional = $c_regional;
            $this->c_doses_on_hand = $c_doses_on_hand;
            $this->c_id = $id;
        }
        public static function with_name($name){
            $instance = new self();
            $instance->load_by_name($name);
            return $instance;
        }
        public function load_by_name($name){
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
                $this->c_name = $name;
                $this->c_id = $row['campus_id'];
                $this->c_vaccinated = $row['vaccinated'];
                $this->c_revenue = $row['revenue'];
                $this->c_regional = $row['regional'];
                $this->c_doses_on_hand = $row['doses_on_hand'];
            }
        }
        public static function with_id($id){
            $instance = new self();
            $instance->load_by_id($id);
            return $instance;
        }
        public function load_by_id($id){
            $sql = "SELECT * FROM campus WHERE campus_id = $id";
            $stmt = $this->connection->prepare($sql);
        
            $stmt->execute();
        
            $result = $stmt->get_result();
            if(!$result){
                echo "query failed";
            }
            else{
                $row = mysqli_fetch_assoc($result);
                $this->c_name = $row['campus_name'];
                $this->c_id = $id;
                $this->c_vaccinated = $row['vaccinated'];
                $this->c_revenue = $row['revenue'];
                $this->c_regional = $row['regional'];
                $this->c_doses_on_hand = $row['doses_on_hand'];
            }
        }
        public function create_campus(){
            $sql = "SELECT * FROM campus WHERE campus_name = '$this->c_name'";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $i=0;
            while($row = mysqli_fetch_assoc($result)){

                $i++;
            }
            if($i == 0){
                $sql = "INSERT INTO campus(campus_name, campus_id, vaccinated, revenue, regional, doses_on_hand) VALUES ('$this->c_name', '$this->c_id', '$this->c_vaccinated','$this->c_revenue', '$this->c_regional', '$this->c_doses_on_hand')";
            
                $stmt = $this->connection->prepare($sql);
                
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                return true;
            }
            else{
                
                return false;
            }
            
        }
        public function get_connection(){
            return $this->connection;
        }
            /*
            public function set_c_name($c_name){
                $this->c_name = $c_name;
            }
            public function set_c_vaccinated($c_vaccinated){
                $this->c_vaccinated = $c_vaccinated;
            }
            public function set_c_revenue($c_revenue){
                $this->c_revenue = $c_revenue;
            }
            public function set_c_regional($c_regional){
                $this->c_regional = $c_regional;
            }
            public function set_c_doses_on_hand($c_doses_on_hand){
                $this->c_doses_on_hand = $c_doses_on_hand;
            }*/
    //*********getters
        public function get_c_name(){
            return $this->c_name;
        }
        public function get_c_vaccinated(){
            return $this->c_vaccinated;
        }
        public function get_c_revenue(){
            $this->update_revenue();
            return $this->c_revenue;
            
        }
        public function get_c_regional(){
            return $this->c_regional;
        }
        public function get_c_doses_on_hand(){
            return $this->c_doses_on_hand;
        }
    //*********Workers
        public function get_vaccinated(){
            return $this->c_vaccinated;
        } //returns number of vac
        protected function increase_vaccinated(){
            $this->c_vaccinated = $this->c_vaccinated + 1;
            $all_name = "all";
            $sql = "UPDATE campus SET vaccinated = (vaccinated + 1) WHERE campus_name = $all_name";
        
            $stmt = $this->connection->prepare($sql);
        
            $stmt->execute();
        
            $result = $stmt->get_result();
            if(!$result){
                echo "query failed";
            }
        } // increments total vaccinated in our table row "all" in campus by 1
        public function increase_vaccinated_at_campus(){
            $sql = "UPDATE campus SET vaccinate = (vacinated + 1) WHERE campus_name = $this->c_name";
        
            $stmt = $this->connection->prepare($sql);
        
            $stmt->execute();
        
            $result = $stmt->get_result();
            if(!$result){
                echo "query failed";
            }
            else{
                $this->increase_vaccinated();
            }
        } //increments vaccinated at a campus by 1 in db table
        public function get_doses(){
            return $this->c_doses_on_hand;
        }// returns number of doses in the db table 
        public function remove_dose(){
            //*********need to add to appointments still************
            $this->c_doses_on_hand = $this->c_doses_on_hand - 1;
            $sql = "UPDATE campus SET doses_on_hand = (doses_on_hand - 1) WHERE campus_name = $this->c_name";
        
            $stmt = $this->connection->prepare($sql);
        
            $stmt->execute();
        
            $result = $stmt->get_result();
            if(!$result){
                echo "query failed";
            }
        } //everytime an appointment is completed it removes 1 from the db table
        private function update_revenue(){
            $sql = "SELECT * FROM Appointments WHERE campus = '$this->c_name' AND completed = 1";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            if(!$result){
                echo "error could not get appointment from db";
            }
            else{
                while($row = mysqli_fetch_assoc($result)){
                    $theEmail = $row['user_email'];
                    $sql = "SELECT * FROM PatientDetails WHERE campus = '$theEmail'";
                    $stmt = $this->connection->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if(!$result){
                        echo "error could not get patient from db";
                    }
                    else{
                        $row2 = mysqli_fetch_assoc($result);
                        if($row2['has_insurance']){
                            $this->increase_revenue();
                        }
                        else{
                            $this->decrease_revenue();
                        }
                    }
                    
                }
            }
            
        }
        public function make_request($doses_requested){
            if($this->c_doses_on_hand < 50){
                $request = rand(0, 1);
                if($request){
                    $this->update_doses($doses_requested);
                }
                return $request;
            }
            else if($this->c_name == 'kent' && $this->c_doses_on_hand < 50){
                $request = rand(0, 1);
                if($request){
                    $this->update_doses($doses_requested);
                }
                return $request;
            }
            else{
                return 0;
            }
        } //request to get more doses at a campus
        public function update_doses($doses_requested){
            $sql = "UPDATE campus SET doses_on_hand = (doses_on_hand + $doses_requested) WHERE campus_name = $this->c_name";
        
            $stmt = $this->connection->prepare($sql);
        
            $stmt->execute();
        
            $result = $stmt->get_result();
            if(!$result){
                echo "query failed";
            }
        } //idk somehow answers the request function
        public function get_vaccine_type($campus){
            return 1;
        } //returns the vaccine type being given at a campus
        public function get_revenue(){
            return $this->c_revenue;
        }
        public function increase_revenue(){
            $this->c_revenue = $this->c_revenue + 120;
            $sql = "UPDATE campus SET revenue = (revenue + 120) WHERE campus_name = $this->c_name";
        
            $stmt = $this->connection->prepare($sql);
        
            $stmt->execute();

            $result = $stmt->get_result();
            if(!$result){
                echo "query failed";
            }
        } //These 3 just do as expected on the db column "revenue" under each campus.
        public function decrease_revenue(){
            $this->c_revenue = $this->c_revenue - 20;
            $sql = "UPDATE campus SET revenue = (revenue - 20) WHERE campus_name = '$this->c_name'";
        
            $stmt = $this->connection->prepare($sql);
        
            $stmt->execute();
        
            $result = $stmt->get_result();
        }
        public function is_regional(){
            if($this->c_regional){
                return true;
            }
            else{
                return false;
            }
        } //so we know how to divi up vaccines

    }
?>


