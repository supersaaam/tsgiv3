<?php
include 'connection.php';
    
if(isset($_POST['code'])){
    $code = $_POST['code'];
    $stmt = $con->prepare('SELECT `ProductCode`, `ProductDesc`, `Packaging` FROM `tbl_actual_product` WHERE ProductCode=?');
    $stmt->bind_param('s', $code);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($pcode, $desc, $pack);
    $stmt->fetch();

    echo $pcode.';'.$desc.';'.$pack;
}
elseif(isset($_POST['orig']) && isset($_POST['codex'])){
    $code = $_POST['codex'];
    $orig = $_POST['orig'];
    $stmt = $con->prepare('SELECT `CurrentStock` FROM `tbl_product_depot` WHERE `WarehouseID`=? AND `ProductCode`=?');
    $stmt->bind_param('is', $orig, $code);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($stock);
    $stmt->fetch();
    if($stmt->num_rows == 0){
        echo 0;
    }
    else{
        echo $stock;
    }
}
elseif(isset($_POST['orig_y']) && isset($_POST['code_y'])){
    $orig = $_POST['orig_y'];
    $code = $_POST['code_y'];
    $stmt = $con->prepare('SELECT `CurrentStock` FROM `tbl_product_depot` WHERE `WarehouseID`=? AND `ProductCode`=?');
    $stmt->bind_param('is', $orig, $code);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($stock);
    $stmt->fetch();
    if($stmt->num_rows == 0){
        echo 0;
    }
    else{
        echo $stock;
    }
}
?>