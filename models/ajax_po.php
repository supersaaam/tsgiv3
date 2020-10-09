<?php
                            include 'connection.php';
                        	$brand = $_POST['sid'];
                        	
                        	$stmt = $con->prepare('SELECT `SC_ID`, `ContactPerson` FROM `tbl_supplier_contact` WHERE `SupplierID`=?');
                        	$stmt->bind_param('i', $brand);
                        	$stmt->execute();
                        	$stmt->store_result();
                        	$stmt->bind_result($scid, $cperson);
                        	$option = '';
                        	if($stmt->num_rows > 0){
                        		while($stmt->fetch()){
                        			$option .= "<option value='$cperson'></option>";	
                        		}
                        	}
                        	$stmt->close();
                        	$con->close();
                        	
                        	echo $option;
?>