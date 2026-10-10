<?php
// Program: Autocomplete Location
// Pete Willard
	require_once "include/login/auth.php";
	include "include/mysql_connect.php";

	//get search term
	$searchTerm = $_GET['term'];
	//get matched data from skills table
	$query = "SELECT DISTINCT location as location FROM data WHERE location LIKE '%".$searchTerm."%' ORDER by location ASC";
	$result = mysqli_query($connection,$query);
	$jsonData = array();

	while($row = mysqli_fetch_array($result)){
    	$jsonData[] = $row['location'];
	}
	echo json_encode($jsonData);
?>
