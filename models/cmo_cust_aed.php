<?php
include 'connection.php';

if(isset($_POST['update'])){ //edit only

    $id = $_GET['id']; //cust_id
    $cmo = $_POST['cmo']; //array;

    //delete cmo given ID of customer
    $stmt = $con->prepare('DELETE FROM `tbl_cmo_cust` WHERE `CustomerID`=?');
    $stmt->bind_param('i',$id); 
    $stmt->execute();
    $stmt->close();
    $con->close();

    //create new record
    foreach($cmo as $c){
        if($c != ''){
            //get CMO_ID given name
            include 'connection.php';
            $stmt = $con->prepare('SELECT `CMO_ID` FROM `tbl_cmo` WHERE `FullName` LIKE ?');
            $c = "%$c%";
            $stmt->bind_param('s', $c); 
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($cmo_id);
            $stmt->fetch();
            $stmt->close();
            $con->close();

            include 'connection.php';
            $stmt = $con->prepare('INSERT INTO `tbl_cmo_cust`(`CMO_ID`, `CustomerID`) VALUES (?, ?)');
            $stmt->bind_param('ii', $cmo_id, $id); 
            $stmt->execute();
            $stmt->close();
            $con->close();
        }
    }

    header('location: ../customer?cmo');
}
elseif(isset($_POST['save'])){ //new record

    $id = $_GET['id']; //cust_id
    $cmo = $_POST['cmo']; //array;
    
    //create new record
    foreach($cmo as $c){
        if($c != ''){
            //get CMO_ID given name
            include 'connection.php';
            $stmt = $con->prepare('SELECT `CMO_ID` FROM `tbl_cmo` WHERE `FullName` LIKE ?');
            $c = "%$c%";
            $stmt->bind_param('s', $c); 
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($cmo_id);
            $stmt->fetch();
            $stmt->close();
            $con->close();

            include 'connection.php';
            $stmt = $con->prepare('INSERT INTO `tbl_cmo_cust`(`CMO_ID`, `CustomerID`) VALUES (?, ?)');
            $stmt->bind_param('ii', $cmo_id, $id); 
            $stmt->execute();
            $stmt->close();
            $con->close();
        }
    }

    header('location: ../customer?cmo');
}
?>