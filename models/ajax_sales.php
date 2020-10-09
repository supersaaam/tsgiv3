<?php
include 'connection.php';

if(isset($_POST['cust'])){
    $cust = '%'.$_POST['cust'].'%';
    $res = '';

    $stmt = $con->prepare('SELECT `CompanyAddress`, CustomerID  FROM `tbl_customers` WHERE CompanyName LIKE ?');
    $stmt->bind_param('s', $cust);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($add, $id);
    $stmt->fetch();

    $add = strtoupper(str_replace('"','', $add));
    $res .= $add;
    $con->close();

    //get CMO
    $con = new mysqli($server, $user, $pw, $db);
    $cmo = $con->prepare('SELECT `FullName` FROM `tbl_cmo_cust` JOIN tbl_cmo ON tbl_cmo.CMO_ID=tbl_cmo_cust.CMO_ID WHERE `CustomerID`=?');
    $cmo->bind_param('i', $id);
    $cmo->execute();
    $cmo->store_result();
    $cmo->bind_result($name);

    $res .= ';';

    if($cmo->num_rows > 0){
        while($cmo->fetch()){
            $res .= $name.'*';
        }
        $res = rtrim($res, '*');
    }
    else{
        $res .= $name;
    }

    echo $res;
}
elseif(isset($_POST['code'])){
    $code = $_POST['code'];
    $wh_id = $_POST['wh_id'];
    $res = '';

    $stmt = $con->prepare('SELECT `Price` FROM `tbl_actual_product` WHERE ProductCode=?');
    $stmt->bind_param('s', $code);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($price);
    $stmt->fetch();
    $con->close();

    if($price == NULL){
        $price = 0.00;
    }

    $res .= $price.';';

    $con = new mysqli($server, $user, $pw, $db);
    $wh = $con->prepare('SELECT `CurrentStock` FROM `tbl_product_depot` WHERE `WarehouseID`=? AND `ProductCode`=?');
    $wh->bind_param('is', $wh_id, $code);
    $wh->execute();
    $wh->store_result();
    $wh->bind_result($stock);
    $wh->fetch();

    if($stock == NULL){
        $stock = 0;
    }
    
    $res .= $stock;

    echo $res;
}
elseif(isset($_POST['orig']) && isset($_POST['prod_code'])){
    $orig = $_POST['orig'];
    $code = $_POST['prod_code'];

    $stmt = $con->prepare('SELECT `CurrentStock` FROM `tbl_product_depot` WHERE `WarehouseID`=? AND `ProductCode`=?');
    $stmt->bind_param('is', $orig, $code);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($stock);
    $stmt->fetch();

    if($stock == NULL){
        echo 0;
    }
    else{
        echo $stock;   
    }
}
?>