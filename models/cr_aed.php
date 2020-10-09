<?php
if(isset($_POST['submit'])){
    $so = $_POST['so'];
    $amount = $_POST['amount'];
    $mode = $_POST['mode'];
    
    if($mode == 'Cash'){
        $bank = NULL;
        $branch= NULL;
        $checknumber = NULL;
        $date = NULL;
    }
    else{
        $bank = $_POST['bank'];
        $branch= $_POST['branch'];
        $checknumber = $_POST['checknumber'];
        $date = $_POST['date'];
    }
    
    include 'connection.php';
    
    $stmt = $con->prepare('INSERT INTO `tbl_tsgi_payment`(`SONumber`, `Amount`, `ModePayment`, `Bank`, `Branch`, `CheckNumber`, `CheckDate`) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('idsssss', $so, $amount, $mode, $bank, $branch, $checknumber, $date);
    $stmt->execute();
    header('location: ../po_details?id='.$so.'&payment');
}
elseif(isset($_GET['pid'])){
    $pid = $_GET['pid'];
    $so_ = $_GET['so'];
    
    include 'connection.php';
    
    $stmt = $con->prepare('SELECT `SONumber`, Amount FROM `tbl_tsgi_payment` WHERE `PaymentID`=?');
    $stmt->bind_param('i', $pid);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($so, $amt);
    $stmt->fetch();
    $con->close();
    $stmt->close();
    
    include 'connection.php';
    
    $stmt = $con->prepare('UPDATE `tbl_tsgi_payment` SET `Status`="PAID" WHERE `PaymentID`=?');
    $stmt->bind_param('i', $pid);
    $stmt->execute();
    $stmt->close();
    $con->close();
    
    include 'connection.php';
    
    $stmt = $con->prepare('UPDATE `tbl_tsgi_so` SET `Balance`=Balance-? WHERE `SO_ID`=?');
    $stmt->bind_param('di', $amt, $so);
    $stmt->execute();
    $stmt->close();
    $con->close();

    header('location: ../po_details?id='.$so_.'&paid');

}
?>