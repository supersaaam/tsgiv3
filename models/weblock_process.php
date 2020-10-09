<?php
if(isset($_SESSION['user_id'])){
    $userx = $_SESSION['user_id'];

    include 'models/connection.php';

    $stmt = $con->prepare('SELECT Username FROM tbl_users WHERE Username=?');
    $stmt->bind_param('i', $userx);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($uname);
    $stmt->fetch();
    if($uname == ''){
        header('location: models/logout_process.php');
    }
}
else{
    header('location: models/logout_process.php');
}
?>