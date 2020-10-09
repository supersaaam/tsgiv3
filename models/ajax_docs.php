<?php
include 'connection.php';

if(isset($_POST['si'])){
    $si = $_POST['si'];
    $stat = $_POST['stat'];

    $stmt = $con->prepare('UPDATE tbl_sales_order SET SI_Doc=? WHERE SI_Number=?');
    $stmt->bind_param('ss', $stat, $si);
    $stmt->execute();
}
elseif(isset($_POST['dr'])){
    $dr = $_POST['dr'];
    $stat = $_POST['stat'];

    $stmt = $con->prepare('UPDATE tbl_sales_order SET DR_Doc=? WHERE DR_Number=?');
    $stmt->bind_param('ss', $stat, $dr);
    $stmt->execute();
}

?>