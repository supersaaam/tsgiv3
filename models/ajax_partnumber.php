<?php
$opn = $_POST['opn'];

include 'connection.php';

$stmt = $con->prepare('SELECT `ProductID` FROM `tbl_tsgi_product` WHERE PartNumber=?');
$stmt->bind_param('s', $opn);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($pid);
if($stmt->num_rows > 0){ //existing
    echo 'existing';
}
?>