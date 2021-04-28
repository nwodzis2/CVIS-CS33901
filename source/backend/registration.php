<?php
session_start();
include_once("../backend/db.php");

$DB_link = new DB_Link();
$connection = $DB_link->connect("localhost", "cvis");

//values to store the form from
$email = "";
$password = "";
$pass_check = "";

//runs when the form is hit
if(isset($_POST['reg'])){
  $email = $_POST['email'];
  $password = $_POST['password_1'];
  $pass_check = $_POST['password_2'];
}

//returns false if email is not in use and returns true if the email is in use.
function check_if_email_used($connection, $email){
        $sql = "SELECT * FROM Users WHERE email = '$email'";

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

//returns true if a kent email and returns false if not a kent email (looks for @kent.edu
function check_if_kent_email($email){
    $email_val = $email;
    $split = explode("@", $email_val);
    if($split[1] === 'kent.edu'){
        return true;
    }
    else{
        return false;
    }
}

//just checks if the password and password_check are the same
function check_if_passwords_match($password, $pass_check){
    if($password === $pass_check){
        return true;
    }
    else{
        return false;
    }
}

//this attempts to a new user... it needs to return the proper values from the functions to actually add them otherwise it echoes out an "error msg"
function create_new_user($connection, $email, $password, $pass_check){
    if(!check_if_email_used($connection, $email)){
        if(check_if_kent_email($email)){
            if(check_if_passwords_match($password, $pass_check)){
                $sql = "INSERT INTO Users(email, password) VALUES ('$email', '$password')";

                $stmt = $connection->prepare($sql);

                $stmt->execute();

                $result = $stmt->get_result();
                echo "Your account has been registered!";
            }
            else{
                echo "passwords do not match";
        }}
        else{
            echo "This was not a kent email";
        }}
    else{
        echo "This email is already in use";
    }   
}
function remove_user($connection, $email, $password){ //function created by Nathan Wodzisz, contact w/ q's
    if(check_if_email_used($connection, $email)){
            $sql = "DELETE FROM Users WHERE email = $email AND password = $password";

            $stmt = $connection->prepare($sql);

            $stmt->execute();

            echo "The user: $email has been deleted!";
    }
    else{
        echo "This email is NOT in use";
    }   
}
//creates new user from the form... mess around with it if u wanna bug hunt
create_new_user($connection, $email, $password, $pass_check);
//remove_user($connection, $email, $password);
?>