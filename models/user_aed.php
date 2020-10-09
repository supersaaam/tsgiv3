<?php
if(isset($_POST['save'])){ //new record
    include 'connection.php';

    $lname = $_POST['lname'];
    $mname = $_POST['mname'];
    $fname = $_POST['fname'];
    $uname = $_POST['username'];
    $pw = $_POST['pw'];

    $stmt = $con->prepare('INSERT INTO `tbl_users`(`LastName`, `FirstName`, `MiddleName`, `Username`, `Password`) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $lname, $fname, $mname, $uname, $pw);
    if($stmt->execute()){
        header('location: ../user?success');
    }
}
elseif(isset($_POST['update'])){ //update record
    include 'connection.php';

    $uname = $_POST['username'];
    $lname = $_POST['lname'];
    $mname = $_POST['mname'];
    $fname = $_POST['fname'];
    $uname = $_POST['username'];
    $pw = $_POST['pw'];

    $stmt = $con->prepare('UPDATE `tbl_users` SET `LastName`=?, `FirstName`=?, `MiddleName`=?, `Password`=? WHERE `Username`=?');
    $stmt->bind_param('sssss', $lname, $fname, $mname, $pw, $uname);
    if($stmt->execute()){
        header('location: ../user?edited');
    }
}
elseif(isset($_GET['id_delete'])){
    include 'connection.php';

    $id = $_GET['id_delete'];
    $d = 'YES';
    $stmt = $con->prepare('UPDATE `tbl_users` SET `Deleted`=? WHERE `UserID`=?');
    $stmt->bind_param('si', $d, $id);
    if($stmt->execute()){
        header('location: ../user?deleted');
    }
}
?>