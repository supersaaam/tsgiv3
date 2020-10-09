<?php
$productName = $_POST['productName'];
$brand = $_POST['brand'];

include 'connection.php';

$stmt = $con->prepare('SELECT `ProductID`, `PartNumber`, `Price`, `CurrentStock` FROM `tbl_tsgi_product` p JOIN tbl_supplier s ON s.SupplierID=p.SupplierID WHERE `ProductDescription`=? AND s.CompanyName=? ORDER BY Price DESC, `InventoryDate` ASC LIMIT 1');
$stmt->bind_param('ss', $productName, $brand);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($pid, $pnum, $price, $stock);
$stmt->fetch();
$stmt->close();
$con->close();

echo $pid.'#'.$pnum.'#'.$price.'#'.$stock;
?>