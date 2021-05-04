<?php
session_start();
/* 
Created by Jaden Kandel Spring 2021 Semester
CITATIONS FOR CODE AND IMAGES:
-inspiration and most of the code: https://www.youtube.com/watch?v=OWNxUVnY3pg&ab_channel=EasyTutorials
-background image from flashline sign in page.

*/
?>

<html>
<head>
    <title>Register Page for CVIS</title>
    <link rel="stylesheet" type="text/css" href="register.css">
</head>
<body>
    <div class="loginbox">
        <img src="images/kent-logo.png" class="avatar">
            <h1>Register Here</h1>
            <form method="post"">
                <p>Email</p>
                <input type="text" name="email" placeholder="Enter Email">
                <p>Password</p>
                <input type="password" name="password_1" placeholder="Enter Password">
                <p>Confirm Password</p>
                <input type="password" name="password_2" placeholder="Re-enter Password">
                <input type="submit" name="reg" value="Register">
                <a href="login.php">Already have an account?</a>
                <br>           
            </form>    
    </div>
<?php

include_once("../backend/db.php");

$DB_link = new DB_Link();
$connection = $DB_link->connect("localhost", "cvis");
include_once("../backend/db.php");
include_once("../backend/registration.php");
   
//values to store the form from
$email = "";
$password = "";
$pass_check = "";

//runs when the form is hit
if(isset($_POST['reg'])){
  $email = $_POST['email'];
  $password = $_POST['password_1'];
  $pass_check = $_POST['password_2'];
  create_new_user($connection, $email, $password, $pass_check);
}   
?>

</body>
</head>
</html>