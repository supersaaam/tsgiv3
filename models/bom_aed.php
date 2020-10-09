<?php
if(isset($_POST['foreign'])){
    $bom = $_POST['bom'];
    $total_price = $_POST['total_price'];
                
                include 'connection.php';
                $stmt = $con->prepare('UPDATE `tbl_tsgi_bom` SET `ForeignComp`=? WHERE `BOM_ID`=?');
                $tp = str_replace(',', '', $total_price);
                $stmt->bind_param('di',$tp,$bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
        
                //delete existing in bom_foreign
                include 'connection.php';
                $stmt = $con->prepare('DELETE FROM `tbl_tsgi_bom_foreign` WHERE BOM_ID=?');
                $stmt->bind_param('i', $bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
                
    //arrays
    $brand= $_POST['brand'];
    $productID = $_POST['productID'];
    $product = $_POST['product'];
    $ourpartnum= $_POST['ourpartnum'];
    $quantity= $_POST['quantity'];
    $mu_price= $_POST['mu_price'];
    $price = $_POST['price'];
    $linetotal = $_POST['linetotal'];
    
    foreach($brand as $k=>$b){
        if($b != '' && $product[$k] != '' && $quantity[$k] != '' && $mu_price[$k] != '')
            {
                
                if($brand == 'N/A'){
                    $supp_id = null;
                }
                else{
                    //get ID of supplier
                    include 'connection.php';
                    $stmt_cust = $con->prepare('SELECT SupplierID FROM tbl_supplier WHERE CompanyName LIKE ?');
                    $stmt_cust->bind_param('s', $b);
                    $stmt_cust->execute();
                    $stmt_cust->store_result();
                    $stmt_cust->bind_result($supp_id);
                    $stmt_cust->fetch();
                    if ($stmt_cust->num_rows == 0) {
                        //not saved in DB
                        //not existing -> save to DB
                        $con2 = new mysqli($server, $user, $pw, $db);
                        $add = $con2->prepare('INSERT INTO `tbl_supplier`(`CompanyName`) VALUES (?)');
                        $add->bind_param('s', $b);
                        $add->execute();
                        $add->close();
                        $con2->close();
    
                        //get ID
                        $con3 = new mysqli($server, $user, $pw, $db);
                        $id = $con3->prepare('SELECT SupplierID FROM tbl_supplier WHERE CompanyName=?');
                        $id->bind_param('s', $b);
                        $id->execute();
                        $id->store_result();
                        $id->bind_result($supp_id);
                        $id->fetch();
                        $id->close();
                        $con3->close();
                        
                    }
                    $con->close();
                    $stmt_cust->close();
                }
                
                if($productID[$k] == '' || !isset($productID[$k])){
            
            	    //not saved in DB
                    //not existing -> save to DB
                    $con2 = new mysqli($server, $user, $pw, $db);
                    $add = $con2->prepare('INSERT INTO `tbl_tsgi_product`(`SupplierID`, `PartNumber`, `ProductDescription`, `Price`) VALUES (?, ?, ?, ?)');
                    $add->bind_param('issd', $supp_id, $ourpartnum[$k], $product[$k], $price[$k]);
                    $add->execute();
                    $add->close();
                    $con2->close();

                    //get ID
                    $con3 = new mysqli($server, $user, $pw, $db);
                    $id = $con3->prepare('SELECT ProductID FROM tbl_tsgi_product WHERE PartNumber=?');
                    $id->bind_param('s', $ourpartnum[$k]);
                    $id->execute();
                    $id->store_result();
                    $id->bind_result($productID_);
                    $id->fetch();
                    $id->close();
                    $con3->close();
                    
                    $productID[$k] = $productID_;
                }
             
                include 'connection.php';
                $stmt = $con->prepare('INSERT INTO `tbl_tsgi_bom_foreign`(`BrandID`, `ProductID`, `Quantity`, `MarkedupPrice`, `TotalPrice`, `BOM_ID`) VALUES (?, ?, ?, ?, ?, ?)');
                
                $lt = str_replace(',', '', $linetotal[$k]);
                
                $stmt->bind_param('iiiddi', $supp_id, $productID[$k], $quantity[$k], $mu_price[$k], $lt, $bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
            }
        }
        
        header('location: ../foreign?success_foreign&bom='.$bom); 
}
elseif(isset($_GET['add_bom'])){
                include 'connection.php';
                $stmt = $con->prepare('INSERT INTO `tbl_tsgi_bom`(`BOM_ID`) VALUES (?)');
                $bom = $_GET['add_bom'];
                $stmt->bind_param('i', $bom);
                $stmt->execute();
                $stmt->close();
                $con->close();   
                
           header('location: ../generate_bom');      
                
}
elseif(isset($_POST['local'])){
    $bom = $_POST['bom'];
    $total_price = $_POST['total_price'];   

                include 'connection.php';
                $stmt = $con->prepare('UPDATE `tbl_tsgi_bom` SET `LocalComp`=? WHERE `BOM_ID`=?');
                $tp = str_replace(',', '', $total_price);
                $stmt->bind_param('di',$tp,$bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
        
                //delete existing in bom_foreign
                include 'connection.php';
                $stmt = $con->prepare('DELETE FROM `tbl_tsgi_bom_local` WHERE BOM_ID=?');
                $stmt->bind_param('i', $bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
                
    //arrays
    $productID = $_POST['productID'];
    $product = $_POST['product'];
    $ourpartnum= $_POST['ourpartnum'];
    $quantity= $_POST['quantity'];
    $mu_price= $_POST['mu_price'];
    $price = $_POST['price'];
    $net_price = $_POST['net_price'];
    $linetotal = $_POST['linetotal'];
    
    foreach($product as $k=>$p){
        if($p != '' && $quantity[$k] != '' && $net_price[$k] != '')
            {
                $supp_id = 36;
                
                if($productID[$k] == '' || !isset($productID[$k])){
            
            	    //not saved in DB
                    //not existing -> save to DB
                    $con2 = new mysqli($server, $user, $pw, $db);
                    $add = $con2->prepare('INSERT INTO `tbl_tsgi_product`(`SupplierID`, `PartNumber`, `ProductDescription`, `Price`,`USDPrice`, `Currency`) VALUES (?, ?, ?, ?, ?,?)');
                    $currency = "PHP";
                    $add->bind_param('issdds', $supp_id, $ourpartnum[$k], $p, $price[$k], $net_price[$k], $currency);
                    $add->execute();
                    $add->close();
                    $con2->close();

                    //get ID
                    $con3 = new mysqli($server, $user, $pw, $db);
                    $id = $con3->prepare('SELECT ProductID FROM tbl_tsgi_product WHERE ProductDescription=? AND SupplierID=?');
                    $id->bind_param('si', $p, $supp_id);
                    $id->execute();
                    $id->store_result();
                    $id->bind_result($productID_);
                    $id->fetch();
                    $id->close();
                    $con3->close();
                    
                    $productID[$k] = $productID_;
                }
             
                include 'connection.php';
                $stmt = $con->prepare('INSERT INTO `tbl_tsgi_bom_local`(`BrandID`, `ProductID`, `Quantity`, `MarkedupPrice`, `PriceVAT`, `TotalPrice`, `BOM_ID`) VALUES (?, ?, ?, ?,?,?,?)');
                
                $lt = str_replace(',', '', $linetotal[$k]);
                
                $stmt->bind_param('iiidddi', $supp_id, $productID[$k], $quantity[$k], $mu_price[$k], $price[$k], $lt, $bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
            }
        }
        
        header('location: ../local?success&bom='.$bom);
}
elseif(isset($_POST['labor'])){
     $bom = $_POST['bom'];
    $total_price = $_POST['total_price'];   

                include 'connection.php';
                $stmt = $con->prepare('UPDATE `tbl_tsgi_bom` SET `Labor`=? WHERE `BOM_ID`=?');
                $tp = str_replace(',', '', $total_price);
                $stmt->bind_param('di',$tp,$bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
        
                //delete existing in bom_foreign
                include 'connection.php';
                $stmt = $con->prepare('DELETE FROM `tbl_tsgi_bom_labor` WHERE BOM_ID=?');
                $stmt->bind_param('i', $bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
                
    //arrays
    $desc = $_POST['desc'];
    $quantity= $_POST['quantity'];
    $days= $_POST['days'];
    $rate = $_POST['rate'];
    $linetotal = $_POST['linetotal'];
    
    foreach($desc as $k=>$d){
                include 'connection.php';
                $stmt = $con->prepare('INSERT INTO `tbl_tsgi_bom_labor`(`Manpower`, `Quantity`, `Days`, `DailyRate`, `LineTotal`, `BOM_ID`) VALUES (?, ?, ?, ?, ?, ?)');
                
                $lt = str_replace(',', '', $linetotal[$k]);
                $stmt->bind_param('siiddi', $d, $quantity[$k], $days[$k], $rate[$k], $lt, $bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
    }
        
    header('location: ../labor?success&bom='.$bom);
}
elseif(isset($_POST['permit'])){
    $bom = $_POST['bom'];
    $total_price = $_POST['total_price'];   

                include 'connection.php';
                $stmt = $con->prepare('UPDATE `tbl_tsgi_bom` SET `StructurePermits`=? WHERE `BOM_ID`=?');
                $tp = str_replace(',', '', $total_price);
                $stmt->bind_param('di',$tp,$bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
        
                //delete existing in bom_foreign
                include 'connection.php';
                $stmt = $con->prepare('DELETE FROM `tbl_tsgi_bom_permit` WHERE BOM_ID=?');
                $stmt->bind_param('i', $bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
                
    //arrays
    $desc = $_POST['desc'];
    $quantity= $_POST['quantity'];
    $price= $_POST['price'];
    $linetotal = $_POST['linetotal'];
    
    foreach($desc as $k=>$d){
                include 'connection.php';
                $stmt = $con->prepare('INSERT INTO `tbl_tsgi_bom_permit`(`Quantity`, `Description`, `Price`, `LineTotal`, `BOM_ID`) VALUES (?, ?, ?, ?, ?)');
                
                $lt = str_replace(',', '', $linetotal[$k]);
                $stmt->bind_param('isddi', $quantity[$k], $d, $price[$k], $lt, $bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
    }
        
    header('location: ../permit?success&bom='.$bom);
}
elseif(isset($_POST['subcon'])){
    $bom = $_POST['bom'];
    $total_price = $_POST['total_price'];   

                include 'connection.php';
                $stmt = $con->prepare('UPDATE `tbl_tsgi_bom` SET `SubCon`=? WHERE `BOM_ID`=?');
                $tp = str_replace(',', '', $total_price);
                $stmt->bind_param('di',$tp,$bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
        
                //delete existing in bom_foreign
                include 'connection.php';
                $stmt = $con->prepare('DELETE FROM `tbl_tsgi_bom_subcon` WHERE BOM_ID=?');
                $stmt->bind_param('i', $bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
                
    //arrays
    $desc = $_POST['desc'];
    $quantity= $_POST['quantity'];
    $price= $_POST['price'];
    $comp_price = $_POST['comp_price'];
    $mu_price = $_POST['mu_price'];
    $linetotal = $_POST['linetotal'];
    
    foreach($desc as $k=>$d){
                include 'connection.php';
                $stmt = $con->prepare('INSERT INTO `tbl_tsgi_bom_subcon`(`Quantity`, `Description`, `Price`, `ComputedPrice`, `MarkedupPrice`, `LineTotal`, `BOM_ID`) VALUES (?,?,?,?,?,?,?)');
                
                $lt = str_replace(',', '', $linetotal[$k]);
                $stmt->bind_param('isddddi', $quantity[$k], $d, $price[$k], $comp_price[$k], $mu_price[$k], $lt, $bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
    }
        
    header('location: ../subcon?success&bom='.$bom);
}
elseif(isset($_GET['insurance'])){
    $bom = $_GET['bom'];
    
    //get sum of all fields from bom exc insurance / 0.95 - sum of all
    include 'connection.php';
    
    $stmt=$con->prepare('SELECT `ForeignComp`, `LocalComp`, `Labor`, `SubCon`, `StructurePermits`, `InsuranceRep`, `ActualBOM`, `POAmount`, `Variance` FROM `tbl_tsgi_bom` WHERE BOM_ID=?');
    $stmt->bind_param('i', $bom);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($foreign, $local, $labor, $subcon, $permit, $insurance, $actual, $po, $variance);
    $stmt->fetch();
    $stmt->close();
    $con->close();
    
    $insu = $actual * 0.01;
    
                include 'connection.php';
                $stmt = $con->prepare('UPDATE `tbl_tsgi_bom` SET `InsuranceRep`=? WHERE `BOM_ID`=?');
                $stmt->bind_param('di',$insu,$bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
    
    header('location: ../generate_bom');
}

elseif(isset($_GET['delete'])){
    $bom = $_GET['bom'];
    
                include 'connection.php';
                $stmt = $con->prepare('UPDATE `tbl_tsgi_bom` SET `Deleted`="YES" WHERE `BOM_ID`=?');
                $stmt->bind_param('i',$bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
    
    header('location: ../generate_bom?deleted');
}
elseif(isset($_GET['actual'])){
    $bom = $_GET['bom'];
    
    //get sum of all fields from bom exc insurance / 0.95 - sum of all
    include 'connection.php';
    
    $stmt=$con->prepare('SELECT `ForeignComp`, `LocalComp`, `Labor`, `SubCon`, `StructurePermits`, `InsuranceRep`, `ActualBOM`, `POAmount`, `Variance` FROM `tbl_tsgi_bom` WHERE BOM_ID=?');
    $stmt->bind_param('i', $bom);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($foreign, $local, $labor, $subcon, $permit, $insurance, $actual, $po, $variance);
    $stmt->fetch();
    $stmt->close();
    $con->close();
    
    $actualx = $foreign + $local + $labor + $subcon + $permit + $insurance;
    
                include 'connection.php';
                $stmt = $con->prepare('UPDATE `tbl_tsgi_bom` SET `ActualBOM`=? WHERE `BOM_ID`=?');
                $stmt->bind_param('di',$actualx,$bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
    
    header('location: ../generate_bom');
}
elseif(isset($_POST['submit_po'])){
    $po= $_POST['po'];
    $bom= $_POST['bom'];
    
                include 'connection.php';
                $stmt = $con->prepare('UPDATE `tbl_tsgi_bom` SET `POAmount`=? WHERE `BOM_ID`=?');
                $stmt->bind_param('di',$po,$bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
    
    header('location: ../generate_bom');
}
elseif(isset($_GET['variance'])){
    $bom = $_GET['bom'];
    
    //get sum of all fields from bom exc insurance / 0.95 - sum of all
    include 'connection.php';
    
    $stmt=$con->prepare('SELECT `ForeignComp`, `LocalComp`, `Labor`, `SubCon`, `StructurePermits`, `InsuranceRep`, `ActualBOM`, `POAmount`, `Variance` FROM `tbl_tsgi_bom` WHERE BOM_ID=?');
    $stmt->bind_param('i', $bom);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($foreign, $local, $labor, $subcon, $permit, $insurance, $actual, $po, $variance);
    $stmt->fetch();
    $stmt->close();
    $con->close();
    
    $variance_ = $po - $actual; 
    
                include 'connection.php';
                $stmt = $con->prepare('UPDATE `tbl_tsgi_bom` SET `Variance`=? WHERE `BOM_ID`=?');
                $stmt->bind_param('di',$variance_,$bom);
                $stmt->execute();
                $stmt->close();
                $con->close();
    
    header('location: ../generate_bom');
}
elseif(isset($_POST['proj_submit'])){
    $bom_id = $_POST['bom_id'];
    $proj_name = $_POST['proj_name'];
    
    include 'connection.php';
    
    $stmt = $con->prepare('UPDATE `tbl_tsgi_bom` SET `ProjectName`=? WHERE `BOM_ID`=?');
    $stmt->bind_param('si', $proj_name, $bom_id);
    $stmt->execute();
    $stmt->close();
    $con->close();
    
    header('location: ../generate_bom?success_name');
}

?>