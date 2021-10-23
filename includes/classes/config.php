<?php 
ob_start(); //tunrs on output buffering
session_start(); //it starts the session-if user is logged in

date_default_timezone_set("Europe/Bucharest");

try {
    $con = new PDO("mysql:dbname=kiraflix;host=localhost", "root", "");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // set attributes on PDO
} 
catch (PDOException $e) { //listening vor a variable called PDOException- php data object
    exit("Connection failed:" . $e->getMessage());
}
?>