<?php
    if(isset($_POST['submit'])){
        $brands = $_POST['brand']; //array
        $productID = $_POST['productID']; //array
        $product = $_POST['product']; //array
        $quantity = $_POST['quantity']; //array
        $ourpartnum = $_POST['ourpartnum']; //array
        
        $purpose = $_POST['purpose'];
        
            include 'connection.php';
            $stmt = $con->prepare('INSERT INTO `tbl_pr`(`DateGenerated`) VALUES (?)');
            
            date_default_timezone_set('Asia/Manila');
            $date = date('Y-m-d');
            
            $stmt->bind_param('s', $date);
            $stmt->execute();
            $stmt->close();
            $con->close();
            
            include 'connection.php';
            $stmt = $con->prepare('SELECT PR_Number FROM tbl_pr ORDER BY PR_Number DESC LIMIT 1');
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($prnum);
            $stmt->fetch();
            $stmt->close();
            $con->close();
          
        foreach($brands as $k => $brand){
        if($product[$k] != ''){
        
            if($brand == 'N/A'){
                $supp_id = null;
            }
            else{
                //get ID of supplier
                include 'connection.php';
                $stmt_cust = $con->prepare('SELECT SupplierID FROM tbl_supplier WHERE CompanyName LIKE ?');
                $stmt_cust->bind_param('s', $brand);
                $stmt_cust->execute();
                $stmt_cust->store_result();
                $stmt_cust->bind_result($supp_id);
                $stmt_cust->fetch();
                if ($stmt_cust->num_rows == 0) {
                    //not saved in DB
                    //not existing -> save to DB
                    $con2 = new mysqli($server, $user, $pw, $db);
                    $add = $con2->prepare('INSERT INTO `tbl_supplier`(`CompanyName`) VALUES (?)');
                    $add->bind_param('s', $brand);
                    $add->execute();
                    $add->close();
                    $con2->close();

                    //get ID
                    $con3 = new mysqli($server, $user, $pw, $db);
                    $id = $con3->prepare('SELECT SupplierID FROM tbl_supplier WHERE CompanyName=?');
                    $id->bind_param('s', $brand);
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
                    $add = $con2->prepare('INSERT INTO `tbl_tsgi_product`(`SupplierID`, `PartNumber`, `ProductDescription`) VALUES (?, ?, ?)');
                    
                    if(str_replace(" ", "", $ourpartnum[$k]) == ''){
                        $opn = null;
                    }
                    else{
                        $opn = $ourpartnum[$k];
                    }
                    
                    session_start();
                        
                    $_SESSION['used_pnum'] = '';
                    
                    $add->bind_param('iss', $supp_id, $opn, $product[$k]);
                    if($add->execute()){
                        $add->close();
                        $con2->close();
    
                        //get IDpr
                        $con3 = new mysqli($server, $user, $pw, $db);
                        $id = $con3->prepare('SELECT ProductID FROM tbl_tsgi_product ORDER BY ProductID DESC LIMIT 1');
                        $id->execute();
                        $id->store_result();
                        $id->bind_result($productID_);
                        $id->fetch();
                        $id->close();
                        $con3->close();
                        
                        $productID[$k] = $productID_;
                        
                        include 'connection.php';
                        $stmt = $con->prepare('INSERT INTO `tbl_pr_bd`(`PR_Number`, `BrandID`, `ProductID`, `QtyRequested`, Purpose) VALUES (?, ?, ?, ?, ?)');
                        
                        $stmt->bind_param('iiiis', $prnum, $supp_id, $productID[$k], $quantity[$k], $purpose);
                        $stmt->execute();
                        $stmt->close();
                        $con->close();
                    }
                    else{
                        $add->close();
                        $con2->close();
                        
                        $_SESSION['used_pnum'] .= $opn.', ';
                    }
            }
            else{
                
                        include 'connection.php';
                        $stmt = $con->prepare('INSERT INTO `tbl_pr_bd`(`PR_Number`, `BrandID`, `ProductID`, `QtyRequested`, Purpose) VALUES (?, ?, ?, ?, ?)');
                        
                        $stmt->bind_param('iiiis', $prnum, $supp_id, $productID[$k], $quantity[$k], $purpose);
                        $stmt->execute();
                        $stmt->close();
                        $con->close();
            }
        }
    }
        
        header('location: ../actual_product?pr_sent');
    }
    elseif(isset($_GET['brand'])){
        $brand = $_GET['brand'];
        
        include 'connection.php';
        
        $stmt = $con->prepare('UPDATE `tbl_pr_bd` SET `Status`="APPROVED" WHERE `BrandID`=? AND Status="PENDING"');
        $stmt->bind_param('i', $brand);
        if($stmt->execute()){
            header('location: ../purchase_requests?approved');
        }
    }
    elseif(isset($_POST['revise'])){
        $brand = $_POST['brand'];
        $remarks = $_POST['remarks'];
        
        include 'connection.php';
        
        $stmt = $con->prepare('UPDATE `tbl_supplier` SET `Revision`=? WHERE `SupplierID`=?');
        $stmt->bind_param('si', $remarks, $brand);
        if($stmt->execute()){
            header('location: ../purchase_requests?revise');
        }
    }
    elseif(isset($_POST['revise_submit'])){
        
        $prnums= $_POST['prnums'];
        
        include 'connection.php';
        
        $stmt = $con->prepare("DELETE FROM `tbl_pr_bd` WHERE PR_BD IN ($prnums)");
        $stmt->execute();
        $stmt->close();
        $con->close();
        
        include 'connection.php';
        
        $brandx = $_POST['brandx'];
        
        $stmt = $con->prepare("UPDATE `tbl_supplier` SET `Revision`=NULL WHERE `SupplierID`=?");
        $stmt->bind_param('i', $brandx);
        $stmt->execute();
        $stmt->close();
        $con->close();
        
        $brands = $_POST['brand']; //array
        $productID = $_POST['productID']; //array
        $product = $_POST['product']; //array
        $quantity = $_POST['quantity']; //array
        $ourpartnum = $_POST['ourpartnum']; //array
        
            include 'connection.php';
            $stmt = $con->prepare('INSERT INTO `tbl_pr`(`DateGenerated`) VALUES (?)');
            
            date_default_timezone_set('Asia/Manila');
            $date = date('Y-m-d');
            
            $stmt->bind_param('s', $date);
            $stmt->execute();
            $stmt->close();
            $con->close();
            
            include 'connection.php';
            $stmt = $con->prepare('SELECT PR_Number FROM tbl_pr ORDER BY PR_Number DESC LIMIT 1');
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($prnum);
            $stmt->fetch();
            $stmt->close();
            $con->close();
          
        foreach($brands as $k => $brand){
        if($product[$k] != ''){
        
            if($brand == 'N/A'){
                $supp_id = null;
            }
            else{
                //get ID of supplier
                include 'connection.php';
                $stmt_cust = $con->prepare('SELECT SupplierID FROM tbl_supplier WHERE CompanyName LIKE ?');
                $stmt_cust->bind_param('s', $brand);
                $stmt_cust->execute();
                $stmt_cust->store_result();
                $stmt_cust->bind_result($supp_id);
                $stmt_cust->fetch();
                if ($stmt_cust->num_rows == 0) {
                    //not saved in DB
                    //not existing -> save to DB
                    $con2 = new mysqli($server, $user, $pw, $db);
                    $add = $con2->prepare('INSERT INTO `tbl_supplier`(`CompanyName`) VALUES (?)');
                    $add->bind_param('s', $brand);
                    $add->execute();
                    $add->close();
                    $con2->close();

                    //get ID
                    $con3 = new mysqli($server, $user, $pw, $db);
                    $id = $con3->prepare('SELECT SupplierID FROM tbl_supplier WHERE CompanyName=?');
                    $id->bind_param('s', $brand);
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
                    $add = $con2->prepare('INSERT INTO `tbl_tsgi_product`(`SupplierID`, `PartNumber`, `ProductDescription`) VALUES (?, ?, ?)');
                    
                    if(str_replace(" ", "", $ourpartnum[$k]) == ''){
                        $opn = null;
                    }
                    else{
                        $opn = $ourpartnum[$k];
                    }
                    
                    session_start();
                        
                    $_SESSION['used_pnum'] = '';
                    
                    $add->bind_param('iss', $supp_id, $opn, $product[$k]);
                    if($add->execute()){
                        $add->close();
                        $con2->close();
    
                        //get IDpr
                        $con3 = new mysqli($server, $user, $pw, $db);
                        $id = $con3->prepare('SELECT ProductID FROM tbl_tsgi_product ORDER BY ProductID DESC LIMIT 1');
                        $id->execute();
                        $id->store_result();
                        $id->bind_result($productID_);
                        $id->fetch();
                        $id->close();
                        $con3->close();
                        
                        $productID[$k] = $productID_;
                        
                        include 'connection.php';
                        $stmt = $con->prepare('INSERT INTO `tbl_pr_bd`(`PR_Number`, `BrandID`, `ProductID`, `QtyRequested`) VALUES (?, ?, ?, ?)');
                        
                        $stmt->bind_param('iiii', $prnum, $supp_id, $productID[$k], $quantity[$k]);
                        $stmt->execute();
                        $stmt->close();
                        $con->close();
                    }
                    else{
                        $add->close();
                        $con2->close();
                        
                        $_SESSION['used_pnum'] .= $opn.', ';
                    }
            }
            else{
                
                        include 'connection.php';
                        $stmt = $con->prepare('INSERT INTO `tbl_pr_bd`(`PR_Number`, `BrandID`, `ProductID`, `QtyRequested`) VALUES (?, ?, ?, ?)');
                        
                        $stmt->bind_param('iiii', $prnum, $supp_id, $productID[$k], $quantity[$k]);
                        $stmt->execute();
                        $stmt->close();
                        $con->close();
            }
        }
    }
        
        header('location: ../purchase_requests_revise?pending');
    }
?>