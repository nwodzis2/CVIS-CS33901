<?php
//unused, used to test an email

include_once("../backend/email.php");
//who I'm sending it to
$address = "dlajsdkasdafasdasd@kent.edu";
//subject
$subject = "Need appointments";
//Text in body
$body = "This is a test";

$campus = "Stark";

send_email($address,$subject, $body);


?>