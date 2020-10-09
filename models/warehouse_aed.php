<?php
if(isset($_POST['save'])){ //new record
    include 'connection.php';

    $name = $_POST['name'];
    $location = $_POST['location'];
   
    $stmt = $con->prepare('INSERT INTO `tbl_warehouse`(`WarehouseName`, `Location`) VALUES (?, ?)');
    $stmt->bind_param('ss', $name, $location);
    if($stmt->execute()){
        header('location: ../warehouse?success');
    }
}
elseif(isset($_POST['update'])){ //update record
    include 'connection.php';

    $id = $_GET['id'];
    $name = $_POST['name'];
    $location = $_POST['location'];

    $stmt = $con->prepare('UPDATE `tbl_warehouse` SET `WarehouseName`=?,`Location`=? WHERE WarehouseID=?');
    $stmt->bind_param('ssi', $name, $location, $id);
    if($stmt->execute()){
        header('location: ../warehouse?edited');
    }
}
elseif(isset($_GET['id_delete'])){
    include 'connection.php';

    $id = $_GET['id_delete'];
    $d = 'YES';
    $stmt = $con->prepare('UPDATE `tbl_warehouse` SET `Deleted`=? WHERE WarehouseID=?');
    $stmt->bind_param('si', $d, $id);
    if($stmt->execute()){
        header('location: ../warehouse?deleted');
    }
}
?>