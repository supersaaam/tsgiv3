<?php
include 'connection.php';

date_default_timezone_set('Asia/Manila');
if(date('d') == '01'){
    $m_y = date('F Y');

    //check if m_y exists in the datatable
    $stmt = $con->prepare('SELECT COUNT(*) FROM tbl_actual_prod_beg_inv WHERE AsOfMonth=?');
    $stmt->bind_param('s', $m_y);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($cnt);
    $stmt->fetch();
    $stmt->close();
    $con->close();

    if($cnt == 0){ //not yet
        include 'connection.php';

        $stmt = $con->prepare('SELECT `WarehouseID`, `ProductCode`, `CurrentStock` FROM `tbl_product_depot`');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($whid, $prodcode, $stock);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                
                $con1 = new mysqli($server, $user, $pw, $db);                
                $stmt1 = $con1->prepare('INSERT INTO `tbl_actual_prod_beg_inv`(`WarehouseID`, `ProductCode`, `CurrentStock`, `AsOfMonth`) VALUES (?, ?, ?, ?)');
                $stmt1->bind_param('isis', $whid, $prodcode, $stock, $m_y);
                $stmt1->execute();
                $stmt1->close();
                $con1->close();
            }
        }
        $stmt->close();
        $con->close();
    }
}
?>