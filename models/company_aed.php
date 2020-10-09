<?php
if(isset($_POST['save'])){ //new record
    include 'connection.php';

    $company = $_POST['company'];
   
    $stmt = $con->prepare('INSERT INTO `tbl_company`(`CompanyName`) VALUES (?)');
    $stmt->bind_param('s', $company);
    if($stmt->execute()){
        header('location: ../company?success');
    }
}
elseif(isset($_POST['update'])){ //update record
    include 'connection.php';

    $company = $_POST['company'];
    $id = $_GET['id'];

    $stmt = $con->prepare('UPDATE `tbl_company` SET `CompanyName`=? WHERE `CompanyID`=?');
    $stmt->bind_param('si', $company, $id);
    if($stmt->execute()){
        header('location: ../company?edited');
    }
}
elseif(isset($_GET['id_delete'])){
    include 'connection.php';

    $id = $_GET['id_delete'];
    $d = 'YES';
    $stmt = $con->prepare('UPDATE `tbl_company` SET `Deleted`=? WHERE `CompanyID`=?');
    $stmt->bind_param('si', $d, $id);
    if($stmt->execute()){
        header('location: ../company?deleted');
    }
}
?>