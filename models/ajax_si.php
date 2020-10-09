<?php
	$so = $_POST['so'];
	$sinum = $_POST['sinum'];
	
	include 'connection.php';
	
	$stmt = $con->prepare('UPDATE `tbl_tsgi_so` SET `SINumber`=? WHERE `SO_ID`=?');
	$stmt->bind_param('si', $sinum, $so); 
	$stmt->execute();
	$stmt->close();
	$con->close();
?>

