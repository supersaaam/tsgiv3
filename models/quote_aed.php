<?php
if(isset($_POST['submit'])){
    session_start();
    
    $customer = $_POST['customer'];
    $date = $_POST['date'];
    $currency = $_POST['currency'];
    $salutation = $_POST['salutation'];
    $cperson= $_POST['cperson'];
    $intro = $_POST['intro'];
    $notes = nl2br(htmlentities($_POST['notes'], ENT_QUOTES, 'UTF-8'));
    $terms = $_POST['terms'];
    $total = str_replace(',', '', $_POST['total_price']);
	$type = $_POST['type'];
	
	
	if(isset($_POST['cc'])){
	    $cc = $_POST['cc'];
	}
	else{
	    $cc = null;
	}
	
	if(isset($_POST['qt_ref'])){
	    $qt_ref = $_POST['qt_ref'];
	}
	else{
	    $qt_ref = null;
	}
	
	if(isset($_POST['vat_type'])){
	    $vat_type = $_POST['vat_type'];
	}
	else{
	    $vat_type = 'VAT';
	}
	
	if($type == 'indent'){
		$delivery = NULL;
    		$order_company = $_POST['orderto'];
    		$order_cp = $_POST['orderto_cp'];
    		$shipping = $_POST['shipping'];
    		$shipping_cost = $_POST['shipping_cost'];
    		$discount = null;
	}
	else{
		$delivery = $_POST['delivery'];
		$discount = $_POST['discount'];
    		$order_company = NULL;
    		$order_cp = NULL;
    		$shipping = NULL;
    		$shipping_cost = NULL;
	}
	
    //get Customer ID or create new
    include 'connection.php';
    $stmt_cust = $con->prepare('SELECT CustomerID FROM tbl_customers WHERE CompanyName LIKE ?');
    $stmt_cust->bind_param('s', $customer);
    $stmt_cust->execute();
    $stmt_cust->store_result();
    $stmt_cust->bind_result($cust_id);
    $stmt_cust->fetch();
    if ($stmt_cust->num_rows == 0) {
        //not saved in DB
        //not existing -> save to DB
        $con2 = new mysqli($server, $user, $pw, $db);
        $add = $con2->prepare('INSERT INTO `tbl_customers`(`CompanyName`) VALUES (?)');
        $add->bind_param('s', $customer);
        $add->execute();
        $add->close();
        $con2->close();

        //get ID
        $con3 = new mysqli($server, $user, $pw, $db);
        $id = $con3->prepare('SELECT CustomerID FROM tbl_customers WHERE CompanyName=?');
        $id->bind_param('s', $customer);
        $id->execute();
        $id->store_result();
        $id->bind_result($cust_id);
        $id->fetch();
        $id->close();
        $con3->close();
    }
    $stmt_cust->close();
    $con->close();
    
    //get Customer Contact Person ID or create new
    include 'connection.php';
    $stmt_cust = $con->prepare('SELECT `CC_ID` FROM `tbl_customers_contact` WHERE `CustomerID`=? AND `ContactPerson` LIKE ?');
    $stmt_cust->bind_param('is', $cust_id, $cperson);
    $stmt_cust->execute();
    $stmt_cust->store_result();
    $stmt_cust->bind_result($cc_id);
    $stmt_cust->fetch();
    if ($stmt_cust->num_rows == 0) {
        //not saved in DB
        //not existing -> save to DB
        $con2 = new mysqli($server, $user, $pw, $db);
        $add = $con2->prepare('INSERT INTO `tbl_customers_contact`(`CustomerID`, `ContactPerson`) VALUES (?, ?)');
        $add->bind_param('is', $cust_id, $cperson);
        $add->execute();
        $add->close();
        $con2->close();

        //get ID
        $con3 = new mysqli($server, $user, $pw, $db);
        $id = $con3->prepare('SELECT `CC_ID` FROM `tbl_customers_contact` WHERE `CustomerID`=? AND `ContactPerson` LIKE ?');
        $id->bind_param('is', $cust_id, $cperson);
        $id->execute();
        $id->store_result();
        $id->bind_result($cc_id);
        $id->fetch();
        $id->close();
        $con3->close();
    }
    $stmt_cust->close();
    $con->close();
    
    include 'connection.php';
    $stmt_cust = $con->prepare('SELECT Term_ID FROM tbl_terms WHERE DaysLabel LIKE ?');
    $stmt_cust->bind_param('s', $terms);
    $stmt_cust->execute();
    $stmt_cust->store_result();
    $stmt_cust->bind_result($tid);
    $stmt_cust->fetch();
    if ($stmt_cust->num_rows == 0) {
        //not saved in DB
        //not existing -> save to DB
        $con2 = new mysqli($server, $user, $pw, $db);
        $add = $con2->prepare('INSERT INTO `tbl_terms`(`DaysLabel`) VALUES (?)');
        $add->bind_param('s', $terms);
        $add->execute();
        $add->close();
        $con2->close();

        //get ID
        $con3 = new mysqli($server, $user, $pw, $db);
        $id = $con3->prepare('SELECT Term_ID FROM tbl_terms WHERE DaysLabel=?');
        $id->bind_param('s', $terms);
        $id->execute();
        $id->store_result();
        $id->bind_result($tid);
        $id->fetch();
        $id->close();
        $con3->close();
    }
    $stmt_cust->close();
    $con->close();
    
    
    //get userID using username
    include 'connection.php';
    
    $stmt = $con->prepare('SELECT `UserID` FROM `tbl_users` WHERE `Username`=?');
    $stmt->bind_param('s', $_SESSION['user_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userid);
    $stmt->fetch();
    $stmt->close();
    $con->close();
    
    
            //TODO: divide 1.12 dep on vat type 
            if($vat_type != 'VAT'){
                $total = ($total + $discount) / 1.12;
            }
            
    //save to tbl_quote
    include 'connection.php';
    $stmt = $con->prepare('INSERT INTO `tbl_quote`(`Date`, `CompanyID`, Salutation, Introduction, `Notes`, DeliveryTime, Terms, `Currency`, TotalAmount, Discount, VAT_Type, ContactPerson, Order_Company, Order_ContactPerson, CC, QTReferenceNumber, Shipping, ShippingCost, QuotedBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('sissssisddsisssssdi', $date, $cust_id, $salutation, $intro, $notes, $delivery, $tid, $currency, $total, $discount, $vat_type, $cc_id, $order_company, $order_cp, $cc, $qt_ref, $shipping, $shipping_cost, $userid);
    $stmt->execute();
    $stmt->close();
    $con->close();
    
    include 'connection.php';
    $stmt = $con->prepare('SELECT `QuotationID` FROM `tbl_quote` ORDER BY QuotationID DESC LIMIT 1');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($q_num);
    $stmt->fetch();
    $stmt->close();
    $con->close();
  
    //save to tbl_quote_bd
    //array variables
    $brands = $_POST['brand'];
    $productID = $_POST['productID'];
    $yourpartnum = $_POST['yourpartnum'];
    $uom = $_POST['uom'];
    $avail = $_POST['avail'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $sub = $_POST['linetotal'];
    $product = $_POST['product'];
    $ourpartnum = $_POST['ourpartnum'];

    foreach($brands as $k => $brand){
        if(
            $product[$k] != '' &&
            $sub[$k] != ''
        ){

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

            $p = str_replace(',', '', $price[$k]);
            $sub_ = str_replace(',', '', $sub[$k]);
            $q = str_replace(',', '', $quantity[$k]);
            
            
            if($productID[$k] == '' || !isset($productID[$k])){
            
                    //check if indent
                    if($type == 'indent'){
                    
                        //not saved in DB
                        //not existing -> save to DB
                        $con2 = new mysqli($server, $user, $pw, $db);
                        $add = $con2->prepare('INSERT INTO `tbl_tsgi_product`(`SupplierID`, `PartNumber`, `ProductDescription`, `Price`, Indent) VALUES (?, ?, ?, ?, ?)');
                        $ind = 'YES';
                        
                        if(str_replace(" ", "", $ourpartnum[$k]) == ''){
                            $opn = null;
                        }
                        else{
                            $opn = $ourpartnum[$k];
                        }
                        
                        $add->bind_param('issds', $supp_id, $opn, $product[$k], $p, $ind);
                        $add->execute();
                        $add->close();
                        $con2->close();

                    }
                    else{
                        
                        //not saved in DB
                        //not existing -> save to DB
                        $con2 = new mysqli($server, $user, $pw, $db);
                        $add = $con2->prepare('INSERT INTO `tbl_tsgi_product`(`SupplierID`, `PartNumber`, `ProductDescription`, `Price`) VALUES (?, ?, ?, ?)');
                        
                        if(str_replace(" ", "", $ourpartnum[$k]) == ''){
                            $opn = null;
                        }
                        else{
                            $opn = $ourpartnum[$k];
                        }
                        
                        $add->bind_param('issd', $supp_id, $opn, $product[$k], $p);
                        $add->execute();
                        $add->close();
                        $con2->close();
                    }
            
            
            	    
                    //get ID
                    $con3 = new mysqli($server, $user, $pw, $db);
                    $id = $con3->prepare('SELECT ProductID FROM tbl_tsgi_product ORDER BY ProductID DESC LIMIT 1');
                    $id->execute();
                    $id->store_result();
                    $id->bind_result($productID_);
                    $id->fetch();
                    $id->close();
                    $con3->close();
                    
                    $productID[$k] = $productID_;
                    
            }

            //TODO: divide 1.12 dep on vat type 
            if($vat_type != 'VAT'){
                $p /= 1.12;
                $sub_ = $q * $p;
            }
            
            
            include 'connection.php';
            $stmt = $con->prepare('INSERT INTO `tbl_quote_bd`(`QuoteID`, `Brand`, `ProductID`, `ProductDescription`, `OurPartNumber`, `YourPartNumber`, `UOM`, `Quantity`, `UnitPrice`, `Available`, `LineTotal`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            
            $stmt->bind_param('iiissssidsd', $q_num, $supp_id, $productID[$k], $product[$k], $ourpartnum[$k], $yourpartnum[$k], $uom[$k], $q, $p, $avail[$k], $sub_);
            $stmt->execute();
            $stmt->close();
            $con->close();
            
        }
    }

    header("location: ../quote?success&qnum=$q_num"); 
}
elseif(isset($_POST['disapprove'])){
	$qid = $_POST['qid'];
	$revisions = nl2br(htmlentities($_POST['revisions'], ENT_QUOTES, 'UTF-8'));
	
	include 'connection.php';
	
	$stmt = $con->prepare('UPDATE `tbl_quote` SET `Status`="DISAPPROVED",`Remarks`=? WHERE `QuotationID`=?');
	$stmt->bind_param('si', $revisions, $qid);
	if($stmt->execute()){
		header('location: ../pending_quote?disapproved');
	}	
}
elseif(isset($_POST['upd_remarks'])){
	$qid = $_POST['qid'];
	$remarks = nl2br(htmlentities($_POST['remarks'], ENT_QUOTES, 'UTF-8'));
	
	include 'connection.php';
	
	$stmt = $con->prepare('UPDATE `tbl_quote` SET `NextInstructions`=? WHERE `QuotationID`=?');
	$stmt->bind_param('si', $remarks, $qid);
	if($stmt->execute()){
		header('location: ../approved_quote?remarks');
	}	
}

elseif(isset($_POST['upd_remarks_in'])){
	$qid = $_POST['qid'];
	$remarks = nl2br(htmlentities($_POST['remarks'], ENT_QUOTES, 'UTF-8'));
	
	include 'connection.php';
	
	$stmt = $con->prepare('UPDATE `tbl_quote` SET `NextInstructions`=? WHERE `QuotationID`=?');
	$stmt->bind_param('si', $remarks, $qid);
	if($stmt->execute()){
		header('location: ../approved_indent_quote?remarks');
	}	
}
//
elseif(isset($_POST['disapprove_app_tq'])){
	$qid = $_POST['qid'];
	$revisions = nl2br(htmlentities($_POST['revisions'], ENT_QUOTES, 'UTF-8'));
	
	include 'connection.php';
	
	$stmt = $con->prepare('UPDATE `tbl_quote` SET `Status`="DISAPPROVED",`Remarks`=? WHERE `QuotationID`=?');
	$stmt->bind_param('si', $revisions, $qid);
	if($stmt->execute()){
		header('location: ../approved_quote?disapproved');
	}	
}
elseif(isset($_POST['disapprove_app_tq_ind'])){
	$qid = $_POST['qid'];
	$revisions = nl2br(htmlentities($_POST['revisions'], ENT_QUOTES, 'UTF-8'));
	
	include 'connection.php';
	
	$stmt = $con->prepare('UPDATE `tbl_quote` SET `Status`="DISAPPROVED",`Remarks`=? WHERE `QuotationID`=?');
	$stmt->bind_param('si', $revisions, $qid);
	if($stmt->execute()){
		header('location: ../approved_indent_quote?disapproved');
	}	
}
elseif(isset($_GET['approve'])){
	$qid = $_GET['approve'];
	
	include 'connection.php';
	
	$stmt = $con->prepare('UPDATE `tbl_quote` SET `Status`="APPROVED" WHERE `QuotationID`=?');
	$stmt->bind_param('i', $qid);
	if($stmt->execute()){
		header('location: ../pending_quote?approved');
	}	
}
//
elseif(isset($_POST['rejected'])){
	$qid = $_POST['qid'];
	$revisions= nl2br(htmlentities($_POST['revisions'], ENT_QUOTES, 'UTF-8'));
	
	include 'connection.php';
	
	$stmt = $con->prepare('UPDATE `tbl_quote` SET `Status`="REJECTED",`ReasonForRejection`=? WHERE `QuotationID`=?');
	$stmt->bind_param('si', $revisions, $qid);
	if($stmt->execute()){
		header('location: ../approved_quote?rejected');
	}	
}


elseif(isset($_POST['rejected_in'])){
	$qid = $_POST['qid'];
	$revisions= nl2br(htmlentities($_POST['revisions'], ENT_QUOTES, 'UTF-8'));
	
	include 'connection.php';
	
	$stmt = $con->prepare('UPDATE `tbl_quote` SET `Status`="REJECTED",`ReasonForRejection`=? WHERE `QuotationID`=?');
	$stmt->bind_param('si', $revisions, $qid);
	if($stmt->execute()){
		header('location: ../approved_indent_quote?rejected');
	}	
}

//
elseif(isset($_GET['approved_in'])){
	$qid = $_GET['id'];
	
	include 'connection.php';
	
	$stmt = $con->prepare('UPDATE `tbl_quote` SET `Status`="ACCEPTED" WHERE `QuotationID`=?');
	$stmt->bind_param('i', $qid);
	if($stmt->execute()){
		header('location: ../approved_indent_quote?accepted');
	}	
}

elseif(isset($_POST['update'])){
    $q_num = $_POST['q_num'];
    $date = $_POST['date'];
    $salutation = $_POST['salutation'];
    $intro = $_POST['intro'];
    $notes = nl2br(htmlentities($_POST['notes'], ENT_QUOTES, 'UTF-8'));
    $terms = $_POST['terms'];
    $total = str_replace(',', '', $_POST['total_price']);
	
	$type = $_POST['type'];
	$currency = $_POST['currency'];
	
	if(isset($_POST['cc'])){
	    $cc = $_POST['cc'];
	}
	else{
	    $cc = null;
	}
	
	if(isset($_POST['qt_ref'])){
	    $qt_ref = $_POST['qt_ref'];
	}
	else{
	    $qt_ref = null;
	}
	
	if($type == 'indent'){
		    $delivery = NULL;
    		$order_company = $_POST['orderto'];
    		$discount = NULL;
    		$order_cp = $_POST['orderto_cp'];
    		$shipping = $_POST['shipping'];
    		$shipping_cost = $_POST['shipping_cost'];
    		$vattype = 'VAT';
	}
	else{
		    $delivery = $_POST['delivery'];
    		$order_company = NULL;
    		$order_cp = NULL;
    		$shipping = NULL;
    		$shipping_cost = NULL;
    		$vattype = $_POST['vat_type'];
    		$discount = $_POST['discount'];
	}
	
	
    include 'connection.php';
    $stmt_cust = $con->prepare('SELECT Term_ID FROM tbl_terms WHERE DaysLabel LIKE ?');
    $stmt_cust->bind_param('s', $terms);
    $stmt_cust->execute();
    $stmt_cust->store_result();
    $stmt_cust->bind_result($tid);
    $stmt_cust->fetch();
    if ($stmt_cust->num_rows == 0) {
        //not saved in DB
        //not existing -> save to DB
        $con2 = new mysqli($server, $user, $pw, $db);
        $add = $con2->prepare('INSERT INTO `tbl_terms`(`DaysLabel`) VALUES (?)');
        $add->bind_param('s', $terms);
        $add->execute();
        $add->close();
        $con2->close();

        //get ID
        $con3 = new mysqli($server, $user, $pw, $db);
        $id = $con3->prepare('SELECT Term_ID FROM tbl_terms WHERE DaysLabel=?');
        $id->bind_param('s', $terms);
        $id->execute();
        $id->store_result();
        $id->bind_result($tid);
        $id->fetch();
        $id->close();
        $con3->close();
    }
    $stmt_cust->close();
    $con->close();
    
    //update tbl_quote
    /*
    	date
    	total
    	salutation
    	intro
    	terms
    	notes
    	status = PENDING
    */
    
    //get original vat type
    include 'connection.php';
    
    $stmt = $con->prepare('SELECT `VAT_Type` FROM `tbl_quote` WHERE QuotationID=?');
    $stmt->bind_param('i', $q_num);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($prev_vt);
    $stmt->fetch();
    $stmt->Close();
    $con->close();
    
    //if previously non vat/zero rated -> VAT:
    if(($prev_vt == 'Non-VAT' || $prev_vt == 'Zero-Rated') && $vattype == 'VAT'){
        
        //(total + discount) * 1.12
        $total = ($total + $discount) * 1.12;
    
    }
    //if VAT -> non vat/zero rated
    elseif($prev_vt == 'VAT' && ($vattype == 'Non-VAT' || $vattype == 'Zero-Rated')){
        
        //(total + discount) / 1.12
        $total = ($total + $discount) /1.12;
    }
    
    $customer = $_POST['customer'];
    
    //get Customer ID or create new
    include 'connection.php';
    $stmt_cust = $con->prepare('SELECT CustomerID FROM tbl_customers WHERE CompanyName LIKE ?');
    $stmt_cust->bind_param('s', $customer);
    $stmt_cust->execute();
    $stmt_cust->store_result();
    $stmt_cust->bind_result($cust_id);
    $stmt_cust->fetch();
    if ($stmt_cust->num_rows == 0) {
        //not saved in DB
        //not existing -> save to DB
        $con2 = new mysqli($server, $user, $pw, $db);
        $add = $con2->prepare('INSERT INTO `tbl_customers`(`CompanyName`) VALUES (?)');
        $add->bind_param('s', $customer);
        $add->execute();
        $add->close();
        $con2->close();

        //get ID
        $con3 = new mysqli($server, $user, $pw, $db);
        $id = $con3->prepare('SELECT CustomerID FROM tbl_customers WHERE CompanyName=?');
        $id->bind_param('s', $customer);
        $id->execute();
        $id->store_result();
        $id->bind_result($cust_id);
        $id->fetch();
        $id->close();
        $con3->close();
    }
    $stmt_cust->close();
    $con->close();
    
    $cperson= $_POST['cperson'];
    
    //get Customer Contact Person ID or create new
    include 'connection.php';
    $stmt_cust = $con->prepare('SELECT `CC_ID` FROM `tbl_customers_contact` WHERE `CustomerID`=? AND `ContactPerson` LIKE ?');
    $stmt_cust->bind_param('is', $cust_id, $cperson);
    $stmt_cust->execute();
    $stmt_cust->store_result();
    $stmt_cust->bind_result($cc_id);
    $stmt_cust->fetch();
    if ($stmt_cust->num_rows == 0) {
        //not saved in DB
        //not existing -> save to DB
        $con2 = new mysqli($server, $user, $pw, $db);
        $add = $con2->prepare('INSERT INTO `tbl_customers_contact`(`CustomerID`, `ContactPerson`) VALUES (?, ?)');
        $add->bind_param('is', $cust_id, $cperson);
        $add->execute();
        $add->close();
        $con2->close();

        //get ID
        $con3 = new mysqli($server, $user, $pw, $db);
        $id = $con3->prepare('SELECT `CC_ID` FROM `tbl_customers_contact` WHERE `CustomerID`=? AND `ContactPerson` LIKE ?');
        $id->bind_param('is', $cust_id, $cperson);
        $id->execute();
        $id->store_result();
        $id->bind_result($cc_id);
        $id->fetch();
        $id->close();
        $con3->close();
    }
    $stmt_cust->close();
    $con->close();
    
    include 'connection.php';
    $stmt = $con->prepare('UPDATE `tbl_quote` SET `Date`=?,`Salutation`=?,`Introduction`=?,`Notes`=?,`Terms`=?, DeliveryTime=?, `RevisionNumber`=`RevisionNumber`+1,`TotalAmount`=?,`Status`=?, Order_Company=?, Order_ContactPerson=?, CC=?, QTReferenceNumber=?, Shipping=?, ShippingCost=?, Discount=?, VAT_Type=?, `Currency`=?, ContactPerson=? WHERE QuotationID=?');
    $stat = 'PENDING';
    $stmt->bind_param('ssssisdssssssddssii', $date, $salutation, $intro, $notes, $tid, $delivery, $total, $stat, $order_company, $order_cp, $cc, $qt_ref, $shipping, $shipping_cost, $discount, $vattype, $currency, $cc_id, $q_num);
    $stmt->execute();
    $stmt->close();
    $con->close();

    //delete tbl_quote_bd
    include 'connection.php';
    $stmt = $con->prepare('DELETE FROM `tbl_quote_bd` WHERE `QuoteID`=?');
    $stmt->bind_param('i', $q_num);
    $stmt->execute();
    $stmt->close();
    $con->close();
    
    //save to tbl_quote_bd
    //array variables
    $brands = $_POST['brand'];
    $productID = $_POST['productID'];
    $yourpartnum = $_POST['yourpartnum'];
    $uom = $_POST['uom'];
    $avail = $_POST['avail'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $sub = $_POST['linetotal'];
    $product = $_POST['product'];
    $ourpartnum = $_POST['ourpartnum'];

    foreach($brands as $k => $brand){
        if($product[$k] != '' && $sub[$k] != ''){
		
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

		
            $p = str_replace(',', '', $price[$k]);
            $sub_ = str_replace(',', '', $sub[$k]);
            $q = str_replace(',', '', $quantity[$k]);
            
            if($productID[$k] == ''){
            
                    //check if indent
                    if($type == 'indent'){
                    
                        //not saved in DB
                        //not existing -> save to DB
                        $con2 = new mysqli($server, $user, $pw, $db);
                        $add = $con2->prepare('INSERT INTO `tbl_tsgi_product`(`SupplierID`, `PartNumber`, `ProductDescription`, `Price`, Indent) VALUES (?, ?, ?, ?, ?)');
                        $ind = 'YES';
                        
                        if(str_replace(" ", "", $ourpartnum[$k]) == ''){
                            $opn = null;
                        }
                        else{
                            $opn = $ourpartnum[$k];
                        }
                        
                        
                        $add->bind_param('issds', $supp_id, $opn, $product[$k], $p, $ind);
                        $add->execute();
                        $add->close();
                        $con2->close();

                    }
                    else{
                        
                        //not saved in DB
                        //not existing -> save to DB
                        $con2 = new mysqli($server, $user, $pw, $db);
                        $add = $con2->prepare('INSERT INTO `tbl_tsgi_product`(`SupplierID`, `PartNumber`, `ProductDescription`, `Price`) VALUES (?, ?, ?, ?)');
                        
                        if(str_replace(" ", "", $ourpartnum[$k]) == ''){
                            $opn = null;
                        }
                        else{
                            $opn = $ourpartnum[$k];
                        }
                        
                        $add->bind_param('issd', $supp_id, $opn, $product[$k], $p);
                        $add->execute();
                        $add->close();
                        $con2->close();
                    }
                    
                    //get ID
                    $con3 = new mysqli($server, $user, $pw, $db);
                    $id = $con3->prepare('SELECT ProductID FROM tbl_tsgi_product ORDER BY ProductID DESC LIMIT 1');
                    $id->execute();
                    $id->store_result();
                    $id->bind_result($productID_);
                    $id->fetch();
                    $id->close();
                    $con3->close();
                    
                    $productID[$k] = $productID_;
            }


            //if previously non vat/zero rated -> VAT:
            if(($prev_vt == 'Non-VAT' || $prev_vt == 'Zero-Rated') && $vattype == 'VAT'){
                
                $p = $p * 1.12;
                $sub_ = $p * $q;
            
            }
            //if VAT -> non vat/zero rated
            elseif($prev_vt == 'VAT' && ($vattype == 'Non-VAT' || $vattype == 'Zero-Rated')){
                
                $p = $p / 1.12;
                $sub_ = $p * $q;
            }
            
            include 'connection.php';
            $stmt = $con->prepare('INSERT INTO `tbl_quote_bd`(`QuoteID`, `Brand`, `ProductID`, `ProductDescription`, `OurPartNumber`, `YourPartNumber`, `UOM`, `Quantity`, `UnitPrice`, `Available`, `LineTotal`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            
            $stmt->bind_param('iiissssidsd', $q_num, $supp_id, $productID[$k], $product[$k], $ourpartnum[$k], $yourpartnum[$k], $uom[$k], $q, $p, $avail[$k], $sub_);
            $stmt->execute();
            $stmt->close();
            $con->close();       
        }
       }
       
    header('location: ../revision_quote?success');
}
elseif(isset($_POST['add_qr'])){
	$customer = $_POST['customer'];
	$cperson = $_POST['cperson'];
	$date = $_POST['date'];
	$content= $_POST['content'];
	$remarks = $_POST['remarks'];
	
	if($remarks == ''){
		$remarks = null;
	}
	
	//get Customer ID or create new
    include 'connection.php';
    $stmt_cust = $con->prepare('SELECT CustomerID FROM tbl_customers WHERE CompanyName LIKE ?');
    $stmt_cust->bind_param('s', $customer);
    $stmt_cust->execute();
    $stmt_cust->store_result();
    $stmt_cust->bind_result($cust_id);
    $stmt_cust->fetch();
    if ($stmt_cust->num_rows == 0) {
        //not saved in DB
        //not existing -> save to DB
        $con2 = new mysqli($server, $user, $pw, $db);
        $add = $con2->prepare('INSERT INTO `tbl_customers`(`CompanyName`) VALUES (?)');
        $add->bind_param('s', $customer);
        $add->execute();
        $add->close();
        $con2->close();

        //get ID
        $con3 = new mysqli($server, $user, $pw, $db);
        $id = $con3->prepare('SELECT CustomerID FROM tbl_customers WHERE CompanyName=?');
        $id->bind_param('s', $customer);
        $id->execute();
        $id->store_result();
        $id->bind_result($cust_id);
        $id->fetch();
        $id->close();
        $con3->close();
    }
    $stmt_cust->close();
    $con->close();
    
    //get Customer ID or create new
    include 'connection.php';
    $stmt_cust = $con->prepare('SELECT CustomerID FROM tbl_customers WHERE CompanyName LIKE ?');
    $stmt_cust->bind_param('s', $customer);
    $stmt_cust->execute();
    $stmt_cust->store_result();
    $stmt_cust->bind_result($cust_id);
    $stmt_cust->fetch();
    if ($stmt_cust->num_rows == 0) {
        //not saved in DB
        //not existing -> save to DB
        $con2 = new mysqli($server, $user, $pw, $db);
        $add = $con2->prepare('INSERT INTO `tbl_customers`(`CompanyName`) VALUES (?)');
        $add->bind_param('s', $customer);
        $add->execute();
        $add->close();
        $con2->close();

        //get ID
        $con3 = new mysqli($server, $user, $pw, $db);
        $id = $con3->prepare('SELECT CustomerID FROM tbl_customers WHERE CompanyName=?');
        $id->bind_param('s', $customer);
        $id->execute();
        $id->store_result();
        $id->bind_result($cust_id);
        $id->fetch();
        $id->close();
        $con3->close();
    }
    $stmt_cust->close();
    $con->close();
    
    //get Customer Contact Person ID or create new
    include 'connection.php';
    $stmt_cust = $con->prepare('SELECT `CC_ID` FROM `tbl_customers_contact` WHERE `CustomerID`=? AND `ContactPerson` LIKE ?');
    $stmt_cust->bind_param('is', $cust_id, $cperson);
    $stmt_cust->execute();
    $stmt_cust->store_result();
    $stmt_cust->bind_result($cc_id);
    $stmt_cust->fetch();
    if ($stmt_cust->num_rows == 0) {
        //not saved in DB
        //not existing -> save to DB
        $con2 = new mysqli($server, $user, $pw, $db);
        $add = $con2->prepare('INSERT INTO `tbl_customers_contact`(`CustomerID`, `ContactPerson`) VALUES (?, ?)');
        $add->bind_param('is', $cust_id, $cperson);
        $add->execute();
        $add->close();
        $con2->close();

        //get ID
        $con3 = new mysqli($server, $user, $pw, $db);
        $id = $con3->prepare('SELECT `CC_ID` FROM `tbl_customers_contact` WHERE `CustomerID`=? AND `ContactPerson` LIKE ?');
        $id->bind_param('is', $cust_id, $cperson);
        $id->execute();
        $id->store_result();
        $id->bind_result($cc_id);
        $id->fetch();
        $id->close();
        $con3->close();
    }
    $stmt_cust->close();
    $con->close();
    
	include 'connection.php';
	
	$stmt = $con->prepare('INSERT INTO `tbl_quote_request`(`CustomerID`, `ContactPerson`, `DateRequested`, `Content`, Remarks) VALUES (?, ?, ?, ?, ?)');
	$stmt->bind_param('iisss', $cust_id, $cc_id, $date , $content, $remarks);
	if($stmt->execute()){
		header('location: ../quote_request?success');
	}
}
elseif(isset($_POST['update_qr'])){
	$customer = $_POST['customer'];
	$cperson = $_POST['cperson'];
	$date = $_POST['date'];
	$content= $_POST['content'];
	$remarks = $_POST['remarks'];
	$qrid = $_POST['qrid'];
	
	if($remarks == ''){
		$remarks = null;
	}
	
	//get Customer ID or create new
    include 'connection.php';
    $stmt_cust = $con->prepare('SELECT CustomerID FROM tbl_customers WHERE CompanyName LIKE ?');
    $stmt_cust->bind_param('s', $customer);
    $stmt_cust->execute();
    $stmt_cust->store_result();
    $stmt_cust->bind_result($cust_id);
    $stmt_cust->fetch();
    if ($stmt_cust->num_rows == 0) {
        //not saved in DB
        //not existing -> save to DB
        $con2 = new mysqli($server, $user, $pw, $db);
        $add = $con2->prepare('INSERT INTO `tbl_customers`(`CompanyName`) VALUES (?)');
        $add->bind_param('s', $customer);
        $add->execute();
        $add->close();
        $con2->close();

        //get ID
        $con3 = new mysqli($server, $user, $pw, $db);
        $id = $con3->prepare('SELECT CustomerID FROM tbl_customers WHERE CompanyName=?');
        $id->bind_param('s', $customer);
        $id->execute();
        $id->store_result();
        $id->bind_result($cust_id);
        $id->fetch();
        $id->close();
        $con3->close();
    }
    $stmt_cust->close();
    $con->close();
    
    //get Customer ID or create new
    include 'connection.php';
    $stmt_cust = $con->prepare('SELECT CustomerID FROM tbl_customers WHERE CompanyName LIKE ?');
    $stmt_cust->bind_param('s', $customer);
    $stmt_cust->execute();
    $stmt_cust->store_result();
    $stmt_cust->bind_result($cust_id);
    $stmt_cust->fetch();
    if ($stmt_cust->num_rows == 0) {
        //not saved in DB
        //not existing -> save to DB
        $con2 = new mysqli($server, $user, $pw, $db);
        $add = $con2->prepare('INSERT INTO `tbl_customers`(`CompanyName`) VALUES (?)');
        $add->bind_param('s', $customer);
        $add->execute();
        $add->close();
        $con2->close();

        //get ID
        $con3 = new mysqli($server, $user, $pw, $db);
        $id = $con3->prepare('SELECT CustomerID FROM tbl_customers WHERE CompanyName=?');
        $id->bind_param('s', $customer);
        $id->execute();
        $id->store_result();
        $id->bind_result($cust_id);
        $id->fetch();
        $id->close();
        $con3->close();
    }
    $stmt_cust->close();
    $con->close();
    
    //get Customer Contact Person ID or create new
    include 'connection.php';
    $stmt_cust = $con->prepare('SELECT `CC_ID` FROM `tbl_customers_contact` WHERE `CustomerID`=? AND `ContactPerson` LIKE ?');
    $stmt_cust->bind_param('is', $cust_id, $cperson);
    $stmt_cust->execute();
    $stmt_cust->store_result();
    $stmt_cust->bind_result($cc_id);
    $stmt_cust->fetch();
    if ($stmt_cust->num_rows == 0) {
        //not saved in DB
        //not existing -> save to DB
        $con2 = new mysqli($server, $user, $pw, $db);
        $add = $con2->prepare('INSERT INTO `tbl_customers_contact`(`CustomerID`, `ContactPerson`) VALUES (?, ?)');
        $add->bind_param('is', $cust_id, $cperson);
        $add->execute();
        $add->close();
        $con2->close();

        //get ID
        $con3 = new mysqli($server, $user, $pw, $db);
        $id = $con3->prepare('SELECT `CC_ID` FROM `tbl_customers_contact` WHERE `CustomerID`=? AND `ContactPerson` LIKE ?');
        $id->bind_param('is', $cust_id, $cperson);
        $id->execute();
        $id->store_result();
        $id->bind_result($cc_id);
        $id->fetch();
        $id->close();
        $con3->close();
    }
    $stmt_cust->close();
    $con->close();
    
	include 'connection.php';
	
	$stmt = $con->prepare('UPDATE `tbl_quote_request` SET `CustomerID`=?,`ContactPerson`=?,`DateRequested`=?,`Content`=?,`Remarks`=? WHERE `QR_ID`=?');
	$stmt->bind_param('iisssi', $cust_id, $cc_id, $date , $content, $remarks, $qrid);
	if($stmt->execute()){
		header('location: ../quote_request?edited');
	}
}
elseif(isset($_POST['quoted'])){
	$qrid = $_POST['qrid'];
	$qid = $_POST['quotationID'];
	
	date_default_timezone_set('Asia/Manila');
	$date = date('Y-m-d');
	
	include 'connection.php';
	
	$stat = 'QUOTED';
	$stmt = $con->prepare('UPDATE `tbl_quote_request` SET `Status`=?,`DateQuoted`=?,QuoteID=?  WHERE `QR_ID`=?');
	$stmt->bind_param('ssii', $stat, $date, $qid, $qrid);
	if($stmt->execute()){
		header('location: ../quote_request?quoted');
	}
	
}
elseif(isset($_POST['delete_qr'])){
	
	$qrid = $_POST['qrid'];
	$remarks = $_POST['remarks'];
	
	include 'connection.php';
	
	$stmt = $con->prepare('UPDATE `tbl_quote_request` SET `Status`="ARCHIVED", Remarks=? WHERE `QR_ID`=?');
	$stmt->bind_param('si', $remarks, $qrid);
	if($stmt->execute()){
		header('location: ../quote_request?deleted');
	}
	
}
//
?>