<?php
//Created by Nathan Wodzisz on April 27th 2021
include_once("../backend/db.php");
/*
using sessions in db
 */
class Session {
    
/*
*/
function __construct()
{
    $DB_link = new DB_Link();
    $connection = $DB_link->connect("localhost", "cvis");
    
    // this is our handler to override the sessions deault
    @session_set_save_handler(
        array($this, "openSession"),
        array($this, "closeSession"),
        array($this, "readSession"),
        array($this, "writeSession"),
        array($this, "destroySession"),
        array($this, "gcSession")
    );
    //starts the sessions
    session_start();
}
    private $_db;
    
}

session_set_save_handler(
    "openSession",
    "closeSession",
    "readSession",
    "writeSession",
    "destroySession",
    "gcSession"
);
?>