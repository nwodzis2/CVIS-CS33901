<?php
include_once("../backend/appointment.php");
include_once("../backend/db.php");

$DB_link = new DB_Link();
$connection = $DB_link->connect("localhost", "cvis");

//make_appointment($connection, 'jaden', 'kandel', 'jdasd@gmail.com', 'stark', 5, 6, '13:00', '0', 'boby something'); //makes an appointment
//make_appointment($connection, 'bob', 'smith', 'bobby@gmail.com', 'stark', 5, 6, '13:10', '0', 'boby something');

//get_appointments_by_campus($connection, 'stark', '5','6'); //returns values on june 5th at stark
//cancel_appointment($connection, 'jdasd@gmail.com');

reschedule_appointment($connection, 'jdasd@gmail.com', 'kent', 14, 6, '13:30', 'bryan miller');
?>