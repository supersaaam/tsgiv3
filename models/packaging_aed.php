<?php
if(isset($_POST['save'])){ //new record
    include 'connection.php';

    $packaging = $_POST['packaging'];
    $divisor = $_POST['divisor'];

    $stmt = $con->prepare('INSERT INTO `tbl_packaging`(`Packaging`, `Divisor`) VALUES (?, ?)');
    $stmt->bind_param('si', $packaging, $divisor);
    if($stmt->execute()){
        header('location: ../packaging?success');
    }
}
elseif(isset($_POST['update'])){ //update record
    include 'connection.php';

    $packaging = $_POST['packaging'];
    $divisor = $_POST['divisor'];
    $id = $_GET['id'];

    $stmt = $con->prepare('UPDATE `tbl_packaging` SET `Packaging`=?,`Divisor`=? WHERE `PackagingID`=?');
    $stmt->bind_param('sii', $packaging, $divisor, $id);
    if($stmt->execute()){
        header('location: ../packaging?edited');
    }
}
elseif(isset($_GET['id_delete'])){
    include 'connection.php';

    $id = $_GET['id_delete'];
    $d = 'YES';
    $stmt = $con->prepare('UPDATE `tbl_packaging` SET `Deleted`=? WHERE `PackagingID`=?');
    $stmt->bind_param('si', $d, $id);
    if($stmt->execute()){
        header('location: ../packaging?deleted');
    }
}
?>