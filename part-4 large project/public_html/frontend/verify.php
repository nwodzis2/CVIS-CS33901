<?php
    error_reporting(0);
    //include the files from the backend that we are using 
    include_once("../backend/db.php");
    include_once("../backend/verification.php");

    //db connection with our db class
    $DB_link = new DB_Link();
    //db connection for all of our functions, localhost is where our db is located and the second value is the db name, for me its cvis
    $connection = $DB_link->connect("localhost", "id16720870_cvismain");
  

      
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Verify Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/CVIS.css?v=<?php echo time(); ?>">
    </head>
    <body>
    <form action="verify.php">
      <label for="email">Your Email:</label><br>
      <input type="text" id="email" name="email"><br>
      <input type="submit" value="Submit">
    </form> 
    
<?php 
//checks to see if the value from our get form (above) is set.
if(isset($_GET['email'])){
//if its set, we set a new variable equal to the value that is set.
  $user_email = $_GET['email'];
//we call our function in verification.php (backend) with the value we just got from the form
  check_if_user_verified($connection, $user_email);
}
?>

    </body>
</html>


<?php 
//database files used here
/*
CREATE TABLE `VerifiedEmails` (
	`email` VARCHAR(64),
	PRIMARY KEY (`email`)
);

//everyones email from the class for verfication 
INSERT INTO VerifiedEmails VALUES ('ccasper3@kent.edu');
INSERT INTO VerifiedEmails VALUES ('dearley2@kent.edu');
INSERT INTO VerifiedEmails VALUES ('aguercio@kent.edu');
INSERT INTO VerifiedEmails VALUES ('jkandel4@kent.edu');
INSERT INTO VerifiedEmails VALUES ('jlee131@kent.edu');
INSERT INTO VerifiedEmails VALUES ('kmill227@kent.edu');
INSERT INTO VerifiedEmails VALUES ('rsilvey2@kent.edu');
INSERT INTO VerifiedEmails VALUES ('csmit292@kent.edu');
INSERT INTO VerifiedEmails VALUES ('sstrange@kent.edu');
INSERT INTO VerifiedEmails VALUES ('ateleric@kent.edu');
INSERT INTO VerifiedEmails VALUES ('tvander5@kent.edu');
INSERT INTO VerifiedEmails VALUES ('kbloch@kent.edu');
INSERT INTO VerifiedEmails VALUES ('swellin4@kent.edu');
INSERT INTO VerifiedEmails VALUES ('nwodzis2@kent.edu');
INSERT INTO VerifiedEmails VALUES ('awolff6@kent.edu');


*/
?>