<?php
include '../models/connection.php';
/*
Ajax call for validating if invoice number already exists
*/
if(isset($_GET['num'])){

	$q = $_GET['num'];
	$hint = '';
	
	$stmt = $con->prepare('SELECT `ProformaInvNo` FROM `tbl_importation` WHERE ProformaInvNo=?');
	$stmt->bind_param('s', $q);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($inv); #match all result from query
    $stmt->fetch();

	// lookup all hints from array if $q is different from "" 
	if ($inv == '') {
		$hint = 'Invoice number is valid.';
	}
	else{
		$hint = 'Invoice number already exists.';
	}
    
    echo $hint;
}
?>