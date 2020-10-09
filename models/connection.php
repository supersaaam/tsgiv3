<?php
	/*ini_set("display_errors", 0);
	error_reporting(0);*/
	
	$db		= "tsgi";
	$user		= "transcendo_admin";
	$pw		= "transcendo_admin";
    	$server		= "localhost";
    
	// Create connection
	$con = new mysqli($server, $user, $pw, $db);

	// Check connection
	if ($con->connect_error) {
		die('Connection failed: ' . $con->connect_error);
	}
?>