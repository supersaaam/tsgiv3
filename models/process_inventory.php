<?php
	include 'connection.php';
	
	$stmt = $con->prepare('SELECT `PartNumber`, `Description`, `Quantity`, SellingPrice FROM `new_trico`');
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($part, $desc, $q, $sp);
	if($stmt->num_rows > 0){
		while($stmt->fetch()){
			
			$con1 = new mysqli($server, $user, $pw, $db);
			
			$stmt1 = $con1->prepare('INSERT INTO `tbl_tsgi_product`(`SupplierID`, `PartNumber`, `ProductDescription`, `CurrentStock`, `InventoryDate`, Price) VALUES (?, ?, ?, ?, ?, ?)');
			$suppID = 28;
			$invdate = '2019-01-03';
			$stmt1->bind_param('issisd', $suppID, $part, $desc, $q, $invdate, $sp);
			$stmt1->execute();	
			$stmt1->close();
			$con1->close();
			
		}
	}
	
	/*
	include 'connection.php';
	
	$stmt = $con->prepare('SELECT `PartNumber`, `Description`, `Quantity`, SellingPrice FROM `new_trico`');
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($part, $desc, $q, $sp);
	if($stmt->num_rows > 0){
		while($stmt->fetch()){
			
			//check if existing in tbl_tsgi_product
			$con1 = new mysqli($server, $user, $pw, $db);
			
			$stmt1 = $con1->prepare('SELECT `ProductID` FROM `tbl_tsgi_product` WHERE `SupplierID`=? AND `PartNumber`=?');
			$suppID = 28;
			$stmt1->bind_param('is', $suppID, $part);
			$stmt1->execute();	
			$stmt1->store_result();
			$stmt1->bind_result($pid);
			if($stmt1->num_rows > 0){ //if existing (add to quantity)
				while($stmt1->fetch()){
					
					$con2 = new mysqli($server, $user, $pw, $db);
			
					$stmt2 = $con2->prepare('UPDATE `tbl_tsgi_product` SET `CurrentStock`=CurrentStock+? WHERE `ProductID`=?');
					$stmt2->bind_param('ii', $q, $pid);
					$stmt2->execute();	
					$stmt2->close();
					$con2->close();
			
				}
			}
			else{ //if not insert as new record
			
					$con2 = new mysqli($server, $user, $pw, $db);
			
					$stmt2 = $con2->prepare('INSERT INTO `tbl_tsgi_product`(`SupplierID`, `PartNumber`, `ProductDescription`, `CurrentStock`, `InventoryDate`, Price) VALUES (?, ?, ?, ?, ?, ?)');
					$suppID = 28;
					$invdate = '2019-01-03';
					$stmt2->bind_param('issisd', $suppID, $part, $desc, $q, $invdate, $sp);
					$stmt2->execute();	
					$stmt2->close();
					$con2->close();
					
			}
			$stmt1->close();
			$con1->close();
		}
	}
	*/
?>