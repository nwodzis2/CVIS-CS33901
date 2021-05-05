<?php
include_once("../backend/db.php");
include_once("../backend/campus.php");
$array = ["kent", "stark", "ashtabula", "eastliverpool", "salem", "geauga", "trumbull", "tuscarawas"];
foreach($array as $element){
    if($element == "kent"){
        $campus = Campus::with_name($element);
        $campus->make_request(500);
    }
    else{
        $campus = Campus::with_name($element);
        $campus->make_request(100);
    }
}

?>