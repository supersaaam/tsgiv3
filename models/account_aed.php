<?php
if(isset($_POST['save'])){ //new record
    include 'connection.php';

    $account = $_POST['account'];
   
    $stmt = $con->prepare('INSERT INTO `tbl_account_title`(`AccountTitle`) VALUES (?)');
    $stmt->bind_param('s', $account);
    if($stmt->execute()){
        header('location: ../account_title?success');
    }
}
elseif(isset($_POST['update'])){ //update record
    include 'connection.php';

    $account = $_POST['account'];
    $id = $_GET['id'];

    $stmt = $con->prepare('UPDATE `tbl_account_title` SET `AccountTitle`=? WHERE `AT_ID`=?');
    $stmt->bind_param('si', $account, $id);
    if($stmt->execute()){
        header('location: ../account_title?edited');
    }
}
elseif(isset($_GET['id_delete'])){
    include 'connection.php';

    $id = $_GET['id_delete'];
    $d = 'YES';
    $stmt = $con->prepare('UPDATE `tbl_account_title` SET `Deleted`=? WHERE `AT_ID`=?');
    $stmt->bind_param('si', $d, $id);
    if($stmt->execute()){
        header('location: ../account_title?deleted');
    }
}
?>