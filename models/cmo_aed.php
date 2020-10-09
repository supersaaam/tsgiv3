<?php
if(isset($_POST['save'])){ //new record
    include 'connection.php';

    $name = $_POST['name'];
    $area = $_POST['area'];
   
    $stmt = $con->prepare('INSERT INTO `tbl_cmo`(`FullName`, `Location`) VALUES (?, ?)');
    $stmt->bind_param('ss', $name, $area);
    if($stmt->execute()){
        header('location: ../cmo?success');
    }
}
elseif(isset($_POST['update'])){ //update record
    include 'connection.php';

    $id = $_GET['id'];
    $name = $_POST['name'];
    $area = $_POST['area'];

    $stmt = $con->prepare('UPDATE `tbl_cmo` SET `FullName`=?,`Location`=? WHERE `CMO_ID`=?');
    $stmt->bind_param('ssi', $name, $area, $id);
    if($stmt->execute()){
        header('location: ../cmo?edited');
    }
}
elseif(isset($_GET['id_delete'])){
    include 'connection.php';

    $id = $_GET['id_delete'];
    $d = 'Inactive';
    $stmt = $con->prepare('UPDATE `tbl_cmo` SET `Status`=? WHERE `CMO_ID`=?');
    $stmt->bind_param('si', $d, $id);
    if($stmt->execute()){
        header('location: ../cmo?deleted');
    }
}
?>