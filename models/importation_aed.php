<?php
if(isset($_POST['save_imp'])){
    include 'connection.php';
    
    $con2 = new mysqli($server, $user, $pw, $db);
    $con3 = new mysqli($server, $user, $pw, $db);
    $con4 = new mysqli($server, $user, $pw, $db);
    $con5 = new mysqli($server, $user, $pw, $db);
    $con12 = new mysqli($server, $user, $pw, $db);
    $con13 = new mysqli($server, $user, $pw, $db);

    
    //get data from form
    $inv_num = $_POST['prof_inv_no'];
    $inv_date = $_POST['prof_inv_date'];
    $com_inv = $_POST['comm_inv_no'];
    $com_date = $_POST['comm_inv_date'];
    $term = $_POST['term'];
    $reminder = $_POST['reminder'];
    $origin = $_POST['origin'];
    $total_price = str_replace(',', '', $_POST['total_price']);

    $currency = $_POST['currency'];
    $supplier = $_POST['supplier'];
    
    $datecreate = date("Y-m-d");
    
        //check from database -> name
            //if existing -> get ID
            //if not -> save -> get ID

        //FOR SUPPLIER
        $stmt_supp = $con->prepare('SELECT SupplierID FROM tbl_supplier WHERE CompanyName=?');
        $stmt_supp->bind_param('s', $supplier);
        $stmt_supp->execute();
        $stmt_supp->store_result();
        $stmt_supp->bind_result($supp_id);
        $stmt_supp->fetch();
            if($stmt_supp->num_rows == 0){
                //not existing -> save to DB
                $add = $con2->prepare('INSERT INTO `tbl_supplier` (`CompanyName`) VALUES (?)');
                $add->bind_param('s', $supplier);
                $add->execute();

                //get ID
                $id = $con3->prepare('SELECT SupplierID FROM tbl_supplier WHERE CompanyName=?');
                $id->bind_param('s', $supplier);
                $id->execute();
                $id->store_result();
                $id->bind_result($supp_id);
                $id->fetch();
            }
            $con2->close();
            $con3->close();
            $con->close();

            //FOR TERMS
            $con = new mysqli($server, $user, $pw, $db);
            $con2 = new mysqli($server, $user, $pw, $db);
            $con3 = new mysqli($server, $user, $pw, $db);

            $stmt_term = $con->prepare('SELECT PT_ID FROM tbl_payment_terms WHERE PaymentTerms=?');
            $stmt_term->bind_param('s', $term);
            $stmt_term->execute();
            $stmt_term->store_result();
            $stmt_term->bind_result($pt_id);
            $stmt_term->fetch();
                if($stmt_term->num_rows == 0){
                    //not existing -> save to DB
                    $add = $con2->prepare('INSERT INTO `tbl_payment_terms` (`PaymentTerms`) VALUES (?)');
                    $add->bind_param('s', $term);
                    $add->execute();
    
                    //get ID
                    $id = $con3->prepare('SELECT PT_ID FROM tbl_payment_terms WHERE PaymentTerms=?');
                    $id->bind_param('s', $term);
                    $id->execute();
                    $id->store_result();
                    $id->bind_result($pt_id);
                    $id->fetch();
                }
                $con2->close();
                $con3->close();
                $con->close();


            //FOR ORIGIN
            $con = new mysqli($server, $user, $pw, $db);
            $con2 = new mysqli($server, $user, $pw, $db);
            $con3 = new mysqli($server, $user, $pw, $db);

            $stmt_or = $con->prepare('SELECT OriginID FROM tbl_origin WHERE Origin=?');
            $stmt_or->bind_param('s', $origin);
            $stmt_or->execute();
            $stmt_or->store_result();
            $stmt_or->bind_result($or_id);
            $stmt_or->fetch();
                if($stmt_or->num_rows == 0){
                    //not existing -> save to DB
                    $add = $con2->prepare('INSERT INTO `tbl_origin` (`Origin`) VALUES (?)');
                    $add->bind_param('s', $origin);
                    $add->execute();
    
                    //get ID
                    $id = $con3->prepare('SELECT OriginID FROM tbl_origin WHERE Origin=?');
                    $id->bind_param('s', $origin);
                    $id->execute();
                    $id->store_result();
                    $id->bind_result($or_id);
                    $id->fetch();
                }
                $con2->close();
                $con3->close();
                $con->close();
            
    $insert = $con4->prepare('INSERT INTO `tbl_importation`(`ProformaInvNo`, `ProformaInvDate`, `CommercialInvNo`, `CommInvDate`, `SupplierID`, `PaymentTerm`, `Currency`, `SpecialReminders`, `Origin`, `Total`, `Balance`, `DateCreated`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $insert->bind_param('ssssiissidds', $inv_num, $inv_date, $com_inv, $com_date, $supp_id, $pt_id, $currency, $reminder, $or_id, $total_price, $total_price, $datecreate);
    $insert->execute();

        //loop for products
        $product = $_POST['product']; //array
        $packaging = $_POST['packaging'];
        $quantity = str_replace(',', '', $_POST['quantity']);
        $unit = $_POST['unit'];
        $price = $_POST['price'];
        $total = $_POST['total'];
        foreach($product as $key => $prod){
            //validate if all 5 fields have value before inserting
            if(
                $prod != NULL &&
                $packaging[$key] != NULL &&
                $quantity[$key] != NULL &&
                $price[$key] != NULL &&
                $total[$key] != NULL
                ){

                    $con5 = new mysqli($server, $user, $pw, $db);
                    $con6 = new mysqli($server, $user, $pw, $db);
                    $con7 = new mysqli($server, $user, $pw, $db);
                    $con8 = new mysqli($server, $user, $pw, $db);
                    $con9 = new mysqli($server, $user, $pw, $db);
                    $con10 = new mysqli($server, $user, $pw, $db);
                    $con11 = new mysqli($server, $user, $pw, $db);

                    //check if prod exists
                    $stmt_prod = $con11->prepare('SELECT ProductID FROM tbl_product WHERE ProductName=?');
                    $stmt_prod->bind_param('s', $prod);
                    $stmt_prod->execute();
                    $stmt_prod->store_result();
                    $stmt_prod->bind_result($prod_id);
                    $stmt_prod->fetch();
                        if($stmt_prod->num_rows == 0){
                            //not existing -> save to DB
                            $add = $con5->prepare('INSERT INTO `tbl_product` (`ProductName`) VALUES (?)');
                            $add->bind_param('s', $prod);
                            $add->execute();
                            
                            //get ID
                            $id = $con6->prepare('SELECT ProductID FROM tbl_product WHERE ProductName=?');
                            $id->bind_param('s', $prod);
                            $id->execute();
                            $id->store_result();
                            $id->bind_result($prod_id);
                            $id->fetch();
                        }

                    $pck = $packaging[$key];

                    //check if packaging
                    $stmt_pack = $con7->prepare('SELECT PackagingID FROM tbl_packaging WHERE Packaging=?');
                    $stmt_pack->bind_param('s', $pck);
                    $stmt_pack->execute();
                    $stmt_pack->store_result();
                    $stmt_pack->bind_result($pack_id);
                    $stmt_pack->fetch();
                        if($stmt_pack->num_rows == 0){
                            //not existing -> save to DB
                            $add = $con8->prepare('INSERT INTO `tbl_packaging` (`Packaging`) VALUES (?)');
                            $add->bind_param('s', $pck);
                            $add->execute();

                            //get ID
                            $id = $con9->prepare('SELECT PackagingID FROM tbl_packaging WHERE Packaging=?');
                            $id->bind_param('s', $pck);
                            $id->execute();
                            $id->store_result();
                            $id->bind_result($pack_id);
                            $id->fetch();
                        }
                
                $q =  str_replace(',', '', $quantity[$key]);
                $p = str_replace(',', '', $price[$key]);
                $t = str_replace(',', '', $total[$key]);
                $u = $unit[$key];

                $ins_imp = $con10->prepare('INSERT INTO `tbl_imp_product`(`ProformaInvNo`, `ProductID`, `PackagingID`, `Quantity`, `Unit`, `Price`, `Total`) VALUES (?, ?, ?, ?, ?, ?, ?)');
                $ins_imp->bind_param('siiisdd', $inv_num, $prod_id, $pack_id, $q, $u, $p, $t);
                $ins_imp->execute();
            }
        }
    header('location: ../importation?success');
}
elseif(isset($_POST['edit_imp'])){
    include 'connection.php';
    
    $con2 = new mysqli($server, $user, $pw, $db);
    $con3 = new mysqli($server, $user, $pw, $db);
    $con4 = new mysqli($server, $user, $pw, $db);
    $con5 = new mysqli($server, $user, $pw, $db);
    $con12 = new mysqli($server, $user, $pw, $db);
    $con13 = new mysqli($server, $user, $pw, $db);

    //get data from form
    $inv_num = $_POST['prof_inv_no'];
    $inv_num_orig = $_POST['prof_inv_no_original'];
    $inv_date = $_POST['prof_inv_date'];
    $com_inv = $_POST['comm_inv_no'];
    $com_date = $_POST['comm_inv_date'];
    
    $term = $_POST['term'];
    $reminder = $_POST['reminder'];
    $origin = $_POST['origin'];
    $total_price = str_replace(',', '', $_POST['total_price']);
    $del_date = $_POST['del_date'];
    $del_stat = $_POST['status'];

    $currency = $_POST['currency'];
    $supplier = $_POST['supplier'];
    
    $datecreate = date("Y-m-d");
    
        //check from database -> name
            //if existing -> get ID
            //if not -> save -> get ID

        $stmt_supp = $con->prepare('SELECT SupplierID FROM tbl_supplier WHERE CompanyName=?');
        $stmt_supp->bind_param('s', $supplier);
        $stmt_supp->execute();
        $stmt_supp->store_result();
        $stmt_supp->bind_result($supp_id);
        $stmt_supp->fetch();
            if($stmt_supp->num_rows == 0){
                //not existing -> save to DB
                $add = $con2->prepare('INSERT INTO `tbl_supplier` (`CompanyName`) VALUES (?)');
                $add->bind_param('s', $supplier);
                $add->execute();

                //get ID
                $id = $con3->prepare('SELECT SupplierID FROM tbl_supplier WHERE CompanyName=?');
                $id->bind_param('s', $supplier);
                $id->execute();
                $id->store_result();
                $id->bind_result($supp_id);
                $id->fetch();
            }
            $con2->close();
            $con3->close();
            $con->close();

        //FOR TERMS
        $con = new mysqli($server, $user, $pw, $db);
        $con2 = new mysqli($server, $user, $pw, $db);
        $con3 = new mysqli($server, $user, $pw, $db);

        $stmt_term = $con->prepare('SELECT PT_ID FROM tbl_payment_terms WHERE PaymentTerms=?');
        $stmt_term->bind_param('s', $term);
        $stmt_term->execute();
        $stmt_term->store_result();
        $stmt_term->bind_result($pt_id);
        $stmt_term->fetch();
            if($stmt_term->num_rows == 0){
                //not existing -> save to DB
                $add = $con2->prepare('INSERT INTO `tbl_payment_terms` (`PaymentTerms`) VALUES (?)');
                $add->bind_param('s', $term);
                $add->execute();

                //get ID
                $id = $con3->prepare('SELECT PT_ID FROM tbl_payment_terms WHERE PaymentTerms=?');
                $id->bind_param('s', $term);
                $id->execute();
                $id->store_result();
                $id->bind_result($pt_id);
                $id->fetch();
            }
            $con2->close();
            $con3->close();
            $con->close();


        //FOR ORIGIN
        $con = new mysqli($server, $user, $pw, $db);
        $con2 = new mysqli($server, $user, $pw, $db);
        $con3 = new mysqli($server, $user, $pw, $db);

        $stmt_or = $con->prepare('SELECT OriginID FROM tbl_origin WHERE Origin=?');
        $stmt_or->bind_param('s', $origin);
        $stmt_or->execute();
        $stmt_or->store_result();
        $stmt_or->bind_result($or_id);
        $stmt_or->fetch();
            if($stmt_or->num_rows == 0){
                //not existing -> save to DB
                $add = $con2->prepare('INSERT INTO `tbl_origin` (`Origin`) VALUES (?)');
                $add->bind_param('s', $origin);
                $add->execute();

                //get ID
                $id = $con3->prepare('SELECT OriginID FROM tbl_origin WHERE Origin=?');
                $id->bind_param('s', $origin);
                $id->execute();
                $id->store_result();
                $id->bind_result($or_id);
                $id->fetch();
            }
            $con2->close();
            $con3->close();
            $con->close();

        //delete first all imp_prod
        $del = $con12->prepare('DELETE FROM `tbl_imp_product` WHERE ProformaInvNo=?');
        $del->bind_param('s', $inv_num_orig);
        $del->execute();
            
    $insert = $con4->prepare('UPDATE `tbl_importation` SET `ProformaInvNo`=?,`ProformaInvDate`=?,`CommercialInvNo`=?,`CommInvDate`=?,`SupplierID`=?,`PaymentTerm`=?,`Currency`=?,`SpecialReminders`=?,`DeliveryStatus`=?,`DeliveredDate`=?,`Origin`=?,`Total`=?,`DateCreated`=?, `Balance`=? WHERE `ProformaInvNo`=?');

    $insert->bind_param('ssssiissssidsds', $inv_num, $inv_date, $com_inv, $com_date, $supp_id, $pt_id, $currency, $reminder, $del_stat, $del_date, $or_id, $total_price, $datecreate, $total_price,$inv_num_orig);
    $insert->execute();

        //loop for products
        $product = $_POST['product']; //array
        $packaging = $_POST['packaging'];
        $quantity = str_replace(',', '', $_POST['quantity']);
        $unit = $_POST['unit'];
        $price = $_POST['price'];
        $total = $_POST['total'];
        foreach($product as $key => $prod){
            //validate if all 5 fields have value before inserting
            if(
                $prod != NULL &&
                $packaging[$key] != NULL &&
                $quantity[$key] != NULL &&
                $price[$key] != NULL &&
                $total[$key] != NULL
                ){

                    $con5 = new mysqli($server, $user, $pw, $db);
                    $con6 = new mysqli($server, $user, $pw, $db);
                    $con7 = new mysqli($server, $user, $pw, $db);
                    $con8 = new mysqli($server, $user, $pw, $db);
                    $con9 = new mysqli($server, $user, $pw, $db);
                    $con10 = new mysqli($server, $user, $pw, $db);
                    $con11 = new mysqli($server, $user, $pw, $db);

                    //check if prod exists
                    $stmt_prod = $con11->prepare('SELECT ProductID FROM tbl_product WHERE ProductName=?');
                    $stmt_prod->bind_param('s', $prod);
                    $stmt_prod->execute();
                    $stmt_prod->store_result();
                    $stmt_prod->bind_result($prod_id);
                    $stmt_prod->fetch();
                        if($stmt_prod->num_rows == 0){
                            //not existing -> save to DB
                            $add = $con5->prepare('INSERT INTO `tbl_product` (`ProductName`) VALUES (?)');
                            $add->bind_param('s', $prod);
                            $add->execute();
                            
                            //get ID
                            $id = $con6->prepare('SELECT ProductID FROM tbl_product WHERE ProductName=?');
                            $id->bind_param('s', $prod);
                            $id->execute();
                            $id->store_result();
                            $id->bind_result($prod_id);
                            $id->fetch();
                        }

                    $pck = $packaging[$key];

                    //check if packaging
                    $stmt_pack = $con7->prepare('SELECT PackagingID FROM tbl_packaging WHERE Packaging=?');
                    $stmt_pack->bind_param('s', $pck);
                    $stmt_pack->execute();
                    $stmt_pack->store_result();
                    $stmt_pack->bind_result($pack_id);
                    $stmt_pack->fetch();
                        if($stmt_pack->num_rows == 0){
                            //not existing -> save to DB
                            $add = $con8->prepare('INSERT INTO `tbl_packaging` (`Packaging`) VALUES (?)');
                            $add->bind_param('s', $pck);
                            $add->execute();

                            //get ID
                            $id = $con9->prepare('SELECT PackagingID FROM tbl_packaging WHERE Packaging=?');
                            $id->bind_param('s', $pck);
                            $id->execute();
                            $id->store_result();
                            $id->bind_result($pack_id);
                            $id->fetch();
                        }
                
                        $q =  str_replace(',', '', $quantity[$key]);
                        $p = str_replace(',', '', $price[$key]);
                        $t = str_replace(',', '', $total[$key]);
                        $u = $unit[$key];
           
                $ins_imp = $con10->prepare('INSERT INTO `tbl_imp_product`(`ProformaInvNo`, `ProductID`, `PackagingID`, `Quantity`, `Unit`, `Price`, `Total`) VALUES (?, ?, ?, ?, ?, ?, ?)');
                $ins_imp->bind_param('siiisdd', $inv_num, $prod_id, $pack_id, $q, $u, $p, $t);
                $ins_imp->execute();
            }
        }
    
    header('location: ../importation?edited');
}
elseif(isset($_GET['inv_comp'])){
    include 'connection.php';

    $inv = $_GET['inv_comp'];
    $stmt = $con->prepare('UPDATE `tbl_importation` SET `StatusComplete`=? WHERE ProformaInvNo=?');

    $stat = 'YES';

    $stmt->bind_param('ss', $stat, $inv);
    if($stmt->execute()){
        echo "
        <script>window.location.href='../attachment?complete&inv=$inv';</script>
        ";
    }
}
?>