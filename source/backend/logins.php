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
  //checks if a correct user and password were given
check_if_correct_credentials($connection, $email, $password);
}

//doesn't really return anything right now,,, not sure how you want to do this with sessions but ya it currently just echos what is going down
function check_if_correct_credentials($connection, $email, $password){
        $sql = "SELECT * FROM Users WHERE email = '$email' AND password = '$password'";

        $stmt = $connection->prepare($sql);

        $stmt->execute();

        $result = $stmt->get_result();
        
        if(!$result){
            echo "query failed";
        }
        else{
            $row = mysqli_fetch_assoc($result);
            if(empty($row)){
                $_SESSION['authenticated'] = false;
                echo 'no user has these details';
            }
            else{
                $_SESSION['authenticated'] = true;
                echo 'a user has these details';
            }
        }
}

    
?>