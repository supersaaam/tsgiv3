<?php
if(isset($_POST['or'])){
    $or = $_POST['or'];
    $cr = $_POST['cr'];
    
    include 'connection.php';
    
    $stmt = $con->prepare('UPDATE `tbl_tsgi_payment` SET `CRNumber`=? WHERE `PaymentID`=?');
    $stmt->bind_param('si', $or, $cr);
    $stmt->execute();
    
    echo 'success';
}
?>