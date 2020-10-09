<?php
if(isset($_POST['save'])){ //new record
    include 'connection.php';

    $payee = $_POST['payee'];
   
    $stmt = $con->prepare('INSERT INTO `tbl_payee`(`PayeeName`) VALUES (?)');
    $stmt->bind_param('s', $payee);
    if($stmt->execute()){
        header('location: ../payee?success');
    }
}
elseif(isset($_POST['update'])){ //update record
    include 'connection.php';

    $payee = $_POST['payee'];
    $id = $_GET['id'];

    $stmt = $con->prepare('UPDATE `tbl_payee` SET `PayeeName`=? WHERE `PayeeID`=?');
    $stmt->bind_param('si', $payee, $id);
    if($stmt->execute()){
        header('location: ../payee?edited');
    }
}
elseif(isset($_GET['id_delete'])){
    include 'connection.php';

    $id = $_GET['id_delete'];
    $d = 'YES';
    $stmt = $con->prepare('UPDATE `tbl_payee` SET `Deleted`=? WHERE `PayeeID`=?');
    $stmt->bind_param('si', $d, $id);
    if($stmt->execute()){
        header('location: ../payee?deleted');
    }
}
?>