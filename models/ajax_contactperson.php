<?php
	$customer= $_POST['customer'];
	include 'connection.php';
	
	$stmt = $con->prepare('SELECT `ContactPerson`, CC_ID FROM tbl_customers_contact cc JOIN tbl_customers c ON c.CustomerID=cc.CustomerID WHERE c.CompanyName=?');
	$stmt->bind_param('s', $customer);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cperson, $ccid);
	if($stmt->num_rows > 0){
		while($stmt->fetch()){
			echo "
				<option value='$cperson'></option>
			";	
		}
	}
	$stmt->close();
	$con->close();
?>