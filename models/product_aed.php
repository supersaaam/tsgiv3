<?php
if(isset($_POST['save'])){ //new record
    include 'connection.php';

    $name = $_POST['name'];
    $desc = $_POST['description'];
   
    $stmt = $con->prepare('INSERT INTO `tbl_product`(`ProductName`, `Description`) VALUES (?, ?)');
    $stmt->bind_param('ss', $name, $desc);
    if($stmt->execute()){
        header('location: ../product?success');
    }
}
elseif(isset($_POST['update'])){ //update record
    include 'connection.php';

    $name = $_POST['name'];
    $desc = $_POST['description'];
    $id = $_GET['id'];

    $stmt = $con->prepare('UPDATE `tbl_product` SET `ProductName`=?,`Description`=? WHERE `ProductID`=?');
    $stmt->bind_param('ssi', $name, $desc, $id);
    if($stmt->execute()){
        header('location: ../product?edited');
    }
}
elseif(isset($_GET['id_delete'])){
    include 'connection.php';

    $id = $_GET['id_delete'];
    $d = 'YES';
    $stmt = $con->prepare('UPDATE `tbl_product` SET `Deleted`=? WHERE `ProductID`=?');
    $stmt->bind_param('si', $d, $id);
    if($stmt->execute()){
        header('location: ../product?deleted');
    }
}
?>