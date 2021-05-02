<?php
/* 

CITATIONS FOR CODE AND IMAGES:
-inspiration and most of the code: https://www.youtube.com/watch?v=OWNxUVnY3pg&ab_channel=EasyTutorials
-background image from flashline sign in page.

*/
?>

<html>
<head>
    <title>Login Page for CVIS</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
    <div class="loginbox">
        <img src="images/kent-logo.png" class="avatar">
            <h1>Login Here</h1>
            <form method="post">
                <p>Email</p>
                <input type="text" name="email" placeholder="Enter Email">
                <p>Password</p>
                <input type="password" name="password" placeholder="Enter Password">
                <input type="submit" name="log" value="Login">
                <a href="register.php">Don't have an account?</a>
                <br>
            
            </form>
        
        
    </div>
<?php
session_start();
include_once("../backend/db.php");
include_once("../backend/logins.php");

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
?>

</body>
</head>
</html>
