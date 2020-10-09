<?php
if(isset($_POST['save'])){ //new record
    include 'connection.php';

    $origin = $_POST['origin'];

    $stmt = $con->prepare('INSERT INTO `tbl_origin`(`Origin`) VALUES (?)');
    $stmt->bind_param('s', $origin);
    if($stmt->execute()){
        header('location: ../origin?success');
    }
}
elseif(isset($_POST['update'])){ //update record
    include 'connection.php';

    $origin = $_POST['origin'];
    $id = $_GET['id'];

    $stmt = $con->prepare('UPDATE `tbl_origin` SET `Origin`=? WHERE `OriginID`=?');
    $stmt->bind_param('si', $origin, $id);
    if($stmt->execute()){
        header('location: ../origin?edited');
    }
}
elseif(isset($_GET['id_delete'])){
    include 'connection.php';

    $id = $_GET['id_delete'];
    $d = 'YES';
    $stmt = $con->prepare('UPDATE `tbl_origin` SET `Deleted`=? WHERE `OriginID`=?');
    $stmt->bind_param('si', $d, $id);
    if($stmt->execute()){
        header('location: ../origin?deleted');
    }
}
?>