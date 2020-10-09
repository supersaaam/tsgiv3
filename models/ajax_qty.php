<?php
$productID = $_POST['productID'];
$quan = $_POST['quan'];

include 'connection.php';

$stmt = $con->prepare('SELECT `CurrentStock` FROM `tbl_tsgi_product` WHERE ProductID=?');
$stmt->bind_param('i', $productID);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($stock);
$stmt->fetch();
$stmt->close();
$con->close();

if($stock >= $quan){
    echo 'Yes';
}
else{
    echo 'No';
}
?>