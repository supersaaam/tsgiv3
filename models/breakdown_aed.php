<?php
include 'connection.php';

if(isset($_POST['submit_bd'])){
    $product = $_POST['product']; //array
    $ip_id = $_POST['ip_id'];
    $p_id = $_POST['prod_id'];

    $con1 = new mysqli($server, $user, $pw, $db);

    //get product code by combining Prod + Packaging
    foreach($product as $k => $prod){
        $pack_bd = $_POST['packaging_bd'];
        $quan_bd = $_POST['quantity_bd'];
        $prod_id = $_POST['pq_prod'];
        foreach($pack_bd as $key => $pack){
            if(
                ($pack != NULL &&
                $quan_bd[$key] != NULL)
                && $quan_bd[$key] > 0
            ){
                if($p_id[$k] === $prod_id[$key]){

                    //check if packaging exists in DB
                    $chk_pkg = $con->prepare('SELECT `PackagingID` FROM `tbl_packaging` WHERE Packaging=?');
                    $chk_pkg->bind_param('s', $pack);
                    $chk_pkg->execute();
                    $chk_pkg->store_result();
                    $chk_pkg->bind_result($pkid);
                    $chk_pkg->fetch();
                    //if not existing
                    if($chk_pkg->num_rows == 0){
                        //save to tbl_actual_prod
                        $ins_pkg = $con->prepare('INSERT INTO `tbl_packaging`(`Packaging`) VALUES (?)');
                        $ins_pkg->bind_param('s', $pack);
                        $ins_pkg->execute(); 
                    }                    
                $con->close();
                $con1->close();

                $con = new mysqli($server, $user, $pw, $db);
                $con1 = new mysqli($server, $user, $pw, $db);

                    $prod_code = $prod.' '.$pack;
                    
                    //check tbl_actual_prod (prod code)
                    $chk_tap = $con->prepare('SELECT `ProductCode` FROM `tbl_actual_product` WHERE ProductCode=?');
                    $chk_tap->bind_param('s', $prod_code);
                    $chk_tap->execute();
                    $chk_tap->store_result();
                    $chk_tap->bind_result($pc);
                    $chk_tap->fetch();
                    //if not existing
                    if($chk_tap->num_rows == 0){
                        //save to tbl_actual_prod
                        $ins_tap = $con->prepare('INSERT INTO `tbl_actual_product`(`ProductCode`, `ProductDesc`, `Packaging`) VALUES (?, ?, ?)');
                        $ins_tap->bind_param('sss', $prod_code, $prod, $pack);
                        $ins_tap->execute(); 
                    }                    
                
                $con->close();
                $con1->close();

                $con = new mysqli($server, $user, $pw, $db);
                $con1 = new mysqli($server, $user, $pw, $db);
                
                //check prod_depot (prod code and Manila)
                $chk_tpd = $con->prepare('SELECT `ProdDepot_ID` FROM `tbl_product_depot` WHERE `WarehouseID`=? AND `ProductCode`=?');
                $wh_id = 1; //Manila = 1
                $stock = $quan_bd[$key];
                
                $chk_tpd->bind_param('is', $wh_id, $prod_code);
                $chk_tpd->execute();
                $chk_tpd->store_result();
                $chk_tpd->bind_result($pd_id);
                $chk_tpd->fetch();
                //if not existing
                if($chk_tpd->num_rows == 0){
                    //add new record in prod_depot tbl
                    $ins_tpd = $con1->prepare('INSERT INTO `tbl_product_depot`(`WarehouseID`, `ProductCode`, `CurrentStock`) VALUES (?, ?, ?)');

                    $ins_tpd->bind_param('isi', $wh_id, $prod_code, $stock);
                    $ins_tpd->execute();
                }
                else{
                    //add to quantity of Manila
                    $upd_tpd = $con1->prepare('UPDATE `tbl_product_depot` SET `CurrentStock`= `CurrentStock` + ? WHERE `ProdDepot_ID`=?');
                    $upd_tpd->bind_param('ii', $stock, $pd_id);
                    $upd_tpd->execute();
                }
                $con->close();
                $con1->close();
                
                $con = new mysqli($server, $user, $pw, $db);

                //update imp tbl -> status bd -> Yes
                $upd_imp = $con->prepare('UPDATE `tbl_importation` SET `StatusBreakdown`=? WHERE `ProformaInvNo`=?');
                $st = 'YES';
                $invnum = $_POST['invnum'];

                $upd_imp->bind_param('ss', $st, $invnum);
                $upd_imp->execute();
                $con->close();

                $con = new mysqli($server, $user, $pw, $db);

                //save to imp_bd tbl
                $ins_tib = $con->prepare('INSERT INTO `tbl_imp_breakdown`(`Imp_ProdID`, `ProductCode`, `Quantity`) VALUES (?, ?, ?)');

                $ip = $ip_id[$k];

                $ins_tib->bind_param('isi', $ip, $prod_code, $stock);
                $ins_tib->execute();
                }
            }
        }
    }
    
    header('location: ../inv_breakdown?success');
}
?>