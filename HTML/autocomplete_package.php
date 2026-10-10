<?php
// Program: Autocomplete Package
// Pete Willard
	require_once "include/login/auth.php";
	include "include/mysql_connect.php";

	//get search term
	$searchTerm = $_GET['term'];
	//get matched data from skills table
	$query = "SELECT DISTINCT package as package FROM data WHERE package LIKE '%".$searchTerm."%' ORDER by package ASC";
	$result = mysqli_query($connection,$query);
	$jsonData = array();

	while($row = mysqli_fetch_array($result)){
	    $jsonData[] = $row['package'];
   	}
	echo json_encode($jsonData);
?>
