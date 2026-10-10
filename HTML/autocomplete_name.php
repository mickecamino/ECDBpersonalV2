<?php
// Program: Autocomplete Name
// Pete Willard
	require_once "include/login/auth.php";
	include "include/mysql_connect.php";

	//get search term
	$searchTerm = $_GET['term'];
	//get matched data from skills table
	$query = "SELECT DISTINCT name as name FROM data WHERE name LIKE '%".$searchTerm."%' ORDER by name ASC";
	$result = mysqli_query($connection,$query);
	$jsonData = array();

	while($row = mysqli_fetch_array($result)){
    	$jsonData[] = $row['name'];
   	}
	echo json_encode($jsonData);
?>
