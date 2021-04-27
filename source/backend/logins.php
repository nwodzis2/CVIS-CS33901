<?php
session_start();
include_once("../backend/db.php");

$DB_link = new DB_Link();
$connection = $DB_link->connect("localhost", "cvis");

$email = "";
$password = "";


if(isset($_POST['log'])){
  $email = $_POST['email'];
  $password = $_POST['password'];
}

//doesn't really return anything right now,,, not sure how you want to do this with sessions but ya it currently just echos what is going down
function check_if_correct_credentials($connection, $email, $password){
        $sql = "SELECT * FROM users WHERE user_email = '$email' AND user_password = '$password'";

        $stmt = $connection->prepare($sql);

        $stmt->execute();

        $result = $stmt->get_result();
        
        if(!$result){
            echo "query failed";
        }
        else{
            $row = mysqli_fetch_assoc($result);
            if(empty($row)){
                echo 'no user has these details';
            }
            else{
                echo 'a user has these details';
            }
        }
}
//checks if a correct user and password were given
check_if_correct_credentials($connection, $email, $password);
    
?>