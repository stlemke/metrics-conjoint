<?php
	//Insert your DB credentials here:
	$servername = "";
	$username = "";
	$password = "";
	$dbname = "";
	
	// Create connection
	$conn = new PDO('mysql:host='.$servername.';dbname='.$dbname, $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
?>

