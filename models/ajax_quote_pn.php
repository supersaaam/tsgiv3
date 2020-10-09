<?php
$pn = $_POST['pn'];
$brand = $_POST['brand'];

include 'connection.php';

$stmt = $con->prepare('SELECT `ProductID`, `ProductDescription`, `Price`, `CurrentStock` FROM `tbl_tsgi_product` p JOIN tbl_supplier s ON s.SupplierID=p.SupplierID WHERE `PartNumber`=? AND s.CompanyName=? ORDER BY Price DESC, `InventoryDate` ASC LIMIT 1');
$stmt->bind_param('ss', $pn, $brand);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($pid, $desc, $price, $stock);
$stmt->fetch();
$stmt->close();
$con->close();

echo $pid.'#'.$desc.'#'.$price.'#'.$stock;
?>