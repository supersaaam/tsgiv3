<?php
if(isset($_POST['save'])){ //new record
    include 'connection.php';

    $name = $_POST['name'];
    $address = $_POST['address'];
    $acctname = $_POST['acctname'];
    $acctnumber = $_POST['acctnumber'];
    $bankname = $_POST['bankname'];
    $bankaddress = $_POST['bankaddress'];
    $swiftcode = $_POST['swiftcode'];
    $remark = $_POST['remark'];
    $subdealer = $_POST['subdealer'];
    
    if($subdealer == 'N/A'){
        $subdealer = NULL;
    }
  
    $stmt = $con->prepare('INSERT INTO `tbl_supplier`(`CompanyName`, `CompanyAddress`, `AccountName`, `AccountNumber`, `BankName`, `BankAddress`, `SwiftCode`, `Remarks`, `SubDealerOf`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssssssssi', $name, $address, $acctname, $acctnumber, $bankname, $bankaddress, $swiftcode, $remark, $subdealer);
    $stmt->execute();
    
    //get ID
    include 'connection.php';
    $stmt = $con->prepare('SELECT `SupplierID` FROM `tbl_supplier` ORDER BY SupplierID DESC LIMIT 1');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($sid);
    $stmt->fetch();
    $stmt->close();
    $con->close();
    
    //arrays
    $cname= $_POST['cname'];
    $cnumber = $_POST['cnumber'];
    
    foreach($cname as $k => $cname_){
    	if($cname_ != ''){
    	
    		$cnumber_ = $cnumber[$k];
    		
    		include 'connection.php';
    		$stmt = $con->prepare('INSERT INTO `tbl_supplier_contact`(`SupplierID`, `ContactPerson`, `ContactNumber`) VALUES (?, ?, ?)');
    		$stmt->bind_param('iss', $sid, $cname_, $cnumber_);
    		$stmt->execute();
    		$stmt->close();
    		$con->close();
    	}
    }

    header('location: ../supplier?success');
    
}
elseif(isset($_POST['update'])){ //update record
    include 'connection.php';

    $id = $_GET['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $acctname = $_POST['acctname'];
    $acctnumber = $_POST['acctnumber'];
    $bankname = $_POST['bankname'];
    $bankaddress = $_POST['bankaddress'];
    $swiftcode = $_POST['swiftcode'];
    $remark = $_POST['remark'];
    $subdealer = $_POST['subdealer'];
    
    if($subdealer == 'N/A'){
        $subdealer = NULL;
    }

    $stmt = $con->prepare('UPDATE `tbl_supplier` SET `CompanyName`=?,`CompanyAddress`=?, AccountName=?, AccountNumber=?, BankName=?, BankAddress=?, SwiftCode=?, Remarks=?, `SubDealerOf`=? WHERE `SupplierID`=?');
    $stmt->bind_param('ssssssssii', $name, $address, $acctname, $acctnumber, $bankname, $bankaddress, $swiftcode, $remark, $subdealer, $id);
    $stmt->execute();
    $stmt->close();
    $con->close();
    
    //delete previous
    include 'connection.php';
    $stmt = $con->prepare('DELETE FROM `tbl_supplier_contact` WHERE SupplierID=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $con->close();
    
    //insert
    //arrays
    $cname= $_POST['cname'];
    $cnumber = $_POST['cnumber'];
    
    foreach($cname as $k => $cname_){
    	if($cname_ != ''){
    	
    		$cnumber_ = $cnumber[$k];
    		
    		include 'connection.php';
    		$stmt = $con->prepare('INSERT INTO `tbl_supplier_contact`(`SupplierID`, `ContactPerson`, `ContactNumber`) VALUES (?, ?, ?)');
    		$stmt->bind_param('iss', $id, $cname_, $cnumber_);
    		$stmt->execute();
    		$stmt->close();
    		$con->close();
    	}
    }
    
    header('location: ../supplier?edited');
    
}
elseif(isset($_GET['id_delete'])){
    include 'connection.php';

    $id = $_GET['id_delete'];
    $d = 'YES';
    $stmt = $con->prepare('UPDATE `tbl_supplier` SET `Deleted`=? WHERE `SupplierID`=?');
    $stmt->bind_param('si', $d, $id);
    if($stmt->execute()){
        header('location: ../supplier?deleted');
    }
}
?>