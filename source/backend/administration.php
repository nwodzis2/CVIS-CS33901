<?php 
//Created by Jaden Kandel Spring Semester 2021
include_once("../backend/db.php");

function complete_appointments_on_day($connection, $month, $day){
    $sql = "UPDATE appointments SET completed = 1 WHERE day = '$day' and month = '$month'";

    $stmt = $connection->prepare($sql);

    $stmt->execute();

    $result = $stmt->get_result();
    
    if(!$result){
        echo "query failed";
    }
    else{
        echo "Appointments completed";
    }
}

function uncomplete_appointments_on_day($connection, $month, $day){
    $sql = "UPDATE appointments SET completed = 0 WHERE day = '$day' and month = '$month'";

    $stmt = $connection->prepare($sql);

    $stmt->execute();

    $result = $stmt->get_result();
    
    if(!$result){
        echo "query failed";
    }
    else{
        echo "Appointments un-completed";
    }
}

?>
