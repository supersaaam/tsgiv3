<?php
	$dr = $_POST['dr'];
	$drnum = $_POST['drnum'];
	
	include 'connection.php';
	
	$stmt = $con->prepare('UPDATE `tbl_dr_so` SET `DR_Number_True`=? WHERE `DR_Number`=?');
	$stmt->bind_param('si', $drnum, $dr); 
	$stmt->execute();
	$stmt->close();
	$con->close();
?>

