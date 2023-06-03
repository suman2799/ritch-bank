<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "bank_management";

	$con = new mysqli($servername, $username, $password, $dbname);

	if($con -> connect_error)
	{
		echo "Failed to connect!";
		exit();
	}
	else
		// echo "Connection is built successfully.";
?>