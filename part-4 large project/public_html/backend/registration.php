<?php
//Created by Jaden Kandel Spring 2021 Semester
//Sessions added by Nathan Wodzisz
include_once("../backend/db.php");

$DB_link = new DB_Link();
$connection = $DB_link->connect("localhost", "id16720870_cvismain");


//returns false if email is not in use and returns true if the email is in use.
function check_if_email_used($connection, $email){
        $sql = "SELECT * FROM users WHERE email = '$email'";

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
                $sql = "INSERT INTO users(email, password) VALUES ('$email', '$password')";

                $stmt = $connection->prepare($sql);

                $stmt->execute();

                $result = $stmt->get_result();
                $_SESSION['authenticated'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['first_name'] = "first"; //unused
                $_SESSION['last_name'] = "last"; //unused
                $_SESSION['user'] = explode('@', $email)[0];
                echo '<script>
                alert("Your account has been registered!");
                window.location.href="../frontend/index.php";
                </script>';
            }
            else{
                echo '<script>alert("Passwords do not match")</script>';
        }}
        else{
            echo '<script>alert("This was not a kent email")</script>';
        }}
    else{
        echo '<script>alert("This email is already in use")</script>';
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
//remove_user($connection, $email, $password);
?>