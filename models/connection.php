<?php
	/*ini_set("display_errors", 0);
	error_reporting(0);*/
	
	$db		= "heroku__8b68aad9c22988c";
	$user		= "b88802b15e6949";
	$pw		= "8d7ede0b";
    	$server		= "us-cdbr-east-02.cleardb.com";
    
	// Create connection
	$con = new mysqli($server, $user, $pw, $db);

	// Check connection
	if ($con->connect_error) {
		die('Connection failed: ' . $con->connect_error);
	}
?>


/*
mysql://
user: b88802b15e6949
pass: 8d7ede0b
hostname:us-cdbr-east-02.cleardb.com/
heroku_8b68aad9c22988c?reconnect=true
*/