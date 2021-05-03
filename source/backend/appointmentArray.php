
<?php
session_start();
include_once("../backend/db.php");
include_once("./appointment.php");
$DB_link = new DB_Link();
$connection = $DB_link->connect("localhost", "cvis");
$appointmentArray = [];

$datetime = DateTime::createFromFormat('G:i', "8:00");
for($i = 0; $i < 60; $i++){
    if(!check_for_appointment_at_time_and_location($connection, $_Session['campus'], $_SESSION['day'], $_SESSION['month'], $datetime->format('G:i'))){
        array_push($appointmentArray, $datetime->format('G:i'));
    }
    $datetime->modify('+10 minutes');
}
$_SESSION['apt-array'] = $appointmentArray;
session_write_close();
?>