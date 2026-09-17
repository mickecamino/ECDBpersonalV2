<?php
// File: include/mysql_connect.php
// Function: Connect to the database
// Revision date: 2026-09-16
// Revised by: Mikael Karlsson
// This file is distributed under the license: 
// Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
// 
// Lets only have the DB access information in one place
    require_once "include/login/config.php";
    $db_host = DB_HOST;
    $db_username = DB_USER;
    $db_pass = DB_PASSWORD;
    $db_name = DB_DATABASE;

// Try and connect to the database
//$connection = mysqli_connect('localhost',$username,$password,$dbname);
$connection = mysqli_connect($db_host,$db_username, $db_pass, $db_name);
// If connection was not successful, handle the error
if($connection === false) {
    // Handle error - notify administrator, log to a file, show an error screen, etc.
    die ("Could not connect connect to MySQL Server") ;
}
?>