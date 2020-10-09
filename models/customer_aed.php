<?php
if(isset($_POST['save'])){ //new record
    include 'connection.php';

    $name = $_POST['name'];
    $address = $_POST['address'];
    $credit = $_POST['credit'];
    $tin = $_POST['tin'];
    $style = $_POST['industry'];
    
    $stmt = $con->prepare('INSERT INTO `tbl_customers`(`CompanyName`, `Industry`, `CreditLimit`, `TIN`) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssds', $name, $style, $credit, $tin);
    $stmt->execute();
    $stmt->close();
    $con->close();
    
    //get ID
    include 'connection.php';
    $stmt = $con->prepare('SELECT `CustomerID` FROM `tbl_customers` ORDER BY CustomerID DESC LIMIT 1');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($cid);
    $stmt->fetch();
    $stmt->close();
    $con->close();
    
    //arrays
    $address = $_POST['address'];
    $cmo = $_POST['cmo'];
    $cname= $_POST['cname'];
    $cnumber = $_POST['cnumber'];
    $department = $_POST['department'];
    
    foreach($cname as $k => $cname_){
    	if($cname_ != ''){
    	
    		$cnumber_ = $cnumber[$k];
    		$dept_ = $department[$k];
    		
    		include 'connection.php';
    		$stmt = $con->prepare('INSERT INTO `tbl_customers_contact`(`CustomerID`, `ContactPerson`, `Department`, `ContactNumber`) VALUES (?, ?, ?, ?)');
    		$stmt->bind_param('isss', $cid, $cname_, $dept_, $cnumber_);
    		$stmt->execute();
    		$stmt->close();
    		$con->close();
    	}
    }
    
    foreach($address as $k => $a){
    	if($a != ''){
    	
    		$cmo_ = $cmo[$k];
    		
    		if($cmo_ != ''){
	    	
	    		//get CMO_ID given name
	            include 'connection.php';
	            $stmt = $con->prepare('SELECT `CMO_ID` FROM `tbl_cmo` WHERE `FullName` LIKE ?');
	            $c = "%$cmo_%";
	            $stmt->bind_param('s', $c); 
	            $stmt->execute();
	            $stmt->store_result();
	            $stmt->bind_result($cmo_id);
	            $stmt->fetch();
	            $stmt->close();
	            $con->close();
	            
    		}
    		else{
    			$cmo_id = NULL;
    		}
    		
    		include 'connection.php';
    		$stmt = $con->prepare('INSERT INTO `tbl_customers_address`(`CustomerID`, `AgentID`, Address) VALUES (?, ?, ?)');
    		$stmt->bind_param('iis', $cid, $cmo_id, $a);
    		$stmt->execute();
    		$stmt->close();
    		$con->close();
    	}
    }
    
    header('location: ../customer?success');
    
}
elseif(isset($_POST['update'])){ //update record
    include 'connection.php';

    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $credit = $_POST['credit'];
    $tin = $_POST['tin'];
    $ind = $_POST['industry'];
    
    $stmt = $con->prepare('UPDATE `tbl_customers` SET `CompanyName`=?,`CreditLimit`=?,`TIN`=?, Industry=? WHERE CustomerID=?');
    $stmt->bind_param('sdssi', $name, $credit, $tin, $ind, $id);
    $stmt->execute();
    $stmt->close();
    $con->close();
    
    //delete previous
    include 'connection.php';
    $stmt = $con->prepare('UPDATE `tbl_customers_contact` SET `Deleted`="YES" WHERE CustomerID=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $con->close();
    
    //insert
    //arrays
    $address = $_POST['address'];
    $cmo = $_POST['cmo'];
    $cname= $_POST['cname'];
    $cnumber = $_POST['cnumber'];
    $department = $_POST['department'];
    
    foreach($cname as $k => $cname_){
    	if($cname_ != ''){
    	
    		$cnumber_ = $cnumber[$k];
    		$dept_ = $department[$k];
    		
    		include 'connection.php';
    		$stmt = $con->prepare('INSERT INTO `tbl_customers_contact`(`CustomerID`, `ContactPerson`, `Department`, `ContactNumber`) VALUES (?, ?, ?, ?)');
    		$stmt->bind_param('isss', $id, $cname_, $dept_, $cnumber_);
    		$stmt->execute();
    		$stmt->close();
    		$con->close();
    	}
    }
    
    //delete previous
    include 'connection.php';
    $stmt = $con->prepare('UPDATE `tbl_customers_address` SET `Deleted`="YES" WHERE CustomerID=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $con->close();
    
    foreach($address as $k => $a){
    	if($a != ''){
    	
    		$cmo_ = $cmo[$k];
    		
    		if($cmo_ != ''){
	    	
	    		//get CMO_ID given name
	            include 'connection.php';
	            $stmt = $con->prepare('SELECT `CMO_ID` FROM `tbl_cmo` WHERE `FullName` LIKE ?');
	            $c = "%$cmo_%";
	            $stmt->bind_param('s', $c); 
	            $stmt->execute();
	            $stmt->store_result();
	            $stmt->bind_result($cmo_id);
	            $stmt->fetch();
	            $stmt->close();
	            $con->close();
	            
    		}
    		else{
    			$cmo_id = NULL;
    		}
    		
    		include 'connection.php';
    		$stmt = $con->prepare('INSERT INTO `tbl_customers_address`(`CustomerID`, `AgentID`, Address) VALUES (?, ?, ?)');
    		$stmt->bind_param('iis', $id, $cmo_id, $a);
    		$stmt->execute();
    		$stmt->close();
    		$con->close();
    	}
    }
    
    header('location: ../customer?edited');
    
}
elseif(isset($_GET['id_delete'])){
    include 'connection.php';

    $id = $_GET['id_delete'];
    $d = 'YES';
    $stmt = $con->prepare('UPDATE `tbl_customers` SET `Deleted`=? WHERE `CustomerID`=?');
    $stmt->bind_param('si', $d, $id);
    if($stmt->execute()){
        header('location: ../customer?deleted');
    }
}
?>