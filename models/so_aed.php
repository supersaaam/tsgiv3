<?php
if(isset($_POST['submit'])){
    $q_num = $_POST['q_num'];
    $customer = $_POST['customer'];
    $date = $_POST['date'];
    $po = $_POST['po'];
    $del_date= $_POST['del_date'];
    $total = str_replace(',', '', $_POST['total_price']);
    $terms= $_POST['terms'];
    
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


    //save to tbl_tsgi_so
    include 'connection.php';
    $stmt = $con->prepare('INSERT INTO `tbl_tsgi_so`(`QuoteID`, `PONumber`, `PODate`, `DeliveryDate`, `TotalAmount`, `Balance`, `CustomerID`, `TermsID`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('isssddii', $q_num, $po, $date, $del_date, $total, $total, $cust_id, $tid);
    $stmt->execute();
    $stmt->close();
    $con->close();
    
    $vat_type= $_POST['vat_type'];
    
    include 'connection.php';
    $stmt = $con->prepare('UPDATE tbl_quote SET Status="FOR PO", `VAT_Type`=? WHERE QuotationID=?');
    $stmt->bind_param('si', $vat_type, $q_num);
    $stmt->execute();
    $stmt->close();
    $con->close();

    //get tbl_tsgi_so SO_ID
    include 'connection.php';
    $stmt = $con->prepare('SELECT `SO_ID` FROM `tbl_tsgi_so` ORDER BY SO_ID DESC LIMIT 1');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($so_id);
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

            if($productID[$k] == ''){
                $productID[$k] = null;
            }

            include 'connection.php';
            $stmt = $con->prepare('INSERT INTO `tbl_tsgi_so_bd`(`SO_ID`, `Brand`, `ProductID`, `ProductDescription`, `OurPartNumber`, `YourPartNumber`, `UOM`, `Quantity`, `UnitPrice`, `Available`, `LineTotal`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            
            $p = str_replace(',', '', $price[$k]);
            $sub_ = str_replace(',', '', $sub[$k]);
            $q = str_replace(',', '', $quantity[$k]);
            
            $stmt->bind_param('iiissssidsd', $so_id, $supp_id, $productID[$k], $product[$k], $ourpartnum[$k], $yourpartnum[$k], $uom[$k], $q, $p, $avail[$k], $sub_);
            $stmt->execute();
            $stmt->close();
            $con->close();
            
            $con1 = new mysqli($server, $user, $pw, $db);
			$upd = $con1->prepare('UPDATE `tbl_tsgi_product` SET `CurrentStock`=CurrentStock-? WHERE `ProductID`=? AND `SupplierID`=?');
			$upd->bind_param('iii', $q, $productID[$k], $supp_id);
			$upd->execute();
			$upd->close();
			$con1->close();
            
        }
    }
    
    header('location: ../approved_quote?success_po');
}
elseif(isset($_POST['submit_dr'])){

	$so_id = $_POST['so_id'];
	
	date_default_timezone_set('Asia/Manila');
	$date = date('Y-m-d');
	
	include 'connection.php';
	
	$stmt = $con->prepare('INSERT INTO `tbl_dr_so`(`SO_Number`, `DateGenerated`) VALUES (?, ?)');
	$stmt->bind_param('is', $so_id, $date);
	$stmt->execute();
	$stmt->close();
	$con->close();

	//get DR Number
	include 'connection.php';
	$stmt = $con->prepare('SELECT `DR_Number` FROM `tbl_dr_so` ORDER BY DR_Number DESC');
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($drnum);
	$stmt->fetch();
	$stmt->close();
	$con->close();

	$productID = $_POST['productID']; //array
	$brandID = $_POST['brandID']; //array
	$qty_dr = $_POST['qty_dr']; //array
	
	foreach($productID as $i => $p){
		$b = $brandID[$i];
		$q = $qty_dr[$i];
		
		if($q != 0){
		
	include 'connection.php';
	
	$stmt = $con->prepare('INSERT INTO `tbl_dr_so_bd`(`DR_Number`, `BrandID`, `ProductID`, `QtyDelivered`) VALUES (?, ?, ?, ?)');
	$stmt->bind_param('iiii', $drnum, $b, $p, $q);
	$stmt->execute();
	$stmt->close();
	$con->close();
		}
	}
	
	header('location: ../po_details?dr&id='.$so_id);
}
elseif(isset($_POST['update_dr'])){

	$dr= $_POST['dr'];
	
	//delete
	include 'connection.php';
	
	$stmt = $con->prepare('DELETE FROM `tbl_dr_so_bd` WHERE `DR_Number`=?');
	$stmt->bind_param('i', $dr);
	$stmt->execute();
	$stmt->close();
	$con->close();
	
	//get SO_ID
	include 'connection.php';
	$stmt = $con->prepare('SELECT `SO_Number` FROM `tbl_dr_so` WHERE DR_Number=?');
	$stmt->bind_param('i', $dr);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($so_id);
	$stmt->fetch();
	$stmt->close();
	$con->close();
	
	$productID = $_POST['productID']; //array
	$brandID = $_POST['brandID']; //array
	$qty_dr = $_POST['qty_dr']; //array
	
	foreach($productID as $i => $p){
		$b = $brandID[$i];
		$q = $qty_dr[$i];
		
		if($q != 0){
		
	include 'connection.php';
	
	$stmt = $con->prepare('INSERT INTO `tbl_dr_so_bd`(`DR_Number`, `BrandID`, `ProductID`, `QtyDelivered`) VALUES (?, ?, ?, ?)');
	$stmt->bind_param('iiii', $dr, $b, $p, $q);
	$stmt->execute();
	$stmt->close();
	$con->close();

		}
	}
	
	header('location: ../po_details?dr_edit&id='.$so_id);
}
elseif(isset($_GET['delete'])){
	
	$dr= $_GET['delete'];
	
	//get SO_ID
	include 'connection.php';
	$stmt = $con->prepare('SELECT `SO_Number` FROM `tbl_dr_so` WHERE DR_Number=?');
	$stmt->bind_param('i', $dr);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($so_id);
	$stmt->fetch();
	$stmt->close();
	$con->close();
	
	//delete
	include 'connection.php';
	
	$stmt = $con->prepare('DELETE FROM `tbl_dr_so` WHERE `DR_Number`=?');
	$stmt->bind_param('i', $dr);
	$stmt->execute();
	$stmt->close();
	$con->close();
	
	header('location: ../po_details?dr_delete&id='.$so_id);
}
//
elseif(isset($_GET['dr_returned'])){
	
	$dr= $_GET['dr_returned'];
	
	date_default_timezone_set('Asia/Manila');
	$date = date('Y-m-d');
	
	//delete
	include 'connection.php';
	
	$stmt = $con->prepare('UPDATE `tbl_dr_so` SET `DateReturned`=? WHERE `DR_Number`=?');
	$stmt->bind_param('si', $date, $dr);
	$stmt->execute();
	$stmt->close();
	$con->close();
	
	//get SO_ID
	include 'connection.php';
	$stmt = $con->prepare('SELECT `SO_Number` FROM `tbl_dr_so` WHERE DR_Number=?');
	$stmt->bind_param('i', $dr);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($so_id);
	$stmt->fetch();
	$stmt->close();
	$con->close();
	
	header('location: ../po_details?dr_return&id='.$so_id);
}
elseif(isset($_POST['submit_pr'])){

	$so_id = $_POST['pr'];
	
	date_default_timezone_set('Asia/Manila');
	$date = date('Y-m-d');
	
	//get po ref and company using so_number;
	
include 'connection.php';
	
	$stmt = $con->prepare('SELECT sp.PONumber, c.CompanyName FROM tbl_tsgi_so sp JOIN tbl_quote q ON q.QuotationID=sp.QuoteID JOIN tbl_customers c ON c.CustomerID=q.CompanyID WHERE sp.SO_ID=?');
	$stmt->bind_param('i', $so_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($ponumber, $customer);
	$stmt->fetch();
	$stmt->close();
	$con->close();
	
	include 'connection.php';
	
	$stmt = $con->prepare('INSERT INTO `tbl_pr`(`SO_Number`, `DateGenerated`) VALUES (?, ?)');
	$stmt->bind_param('is', $so_id, $date);
	$stmt->execute();
	$stmt->close();
	$con->close();

	//get DR Number
	include 'connection.php';
	$stmt = $con->prepare('SELECT `PR_Number` FROM `tbl_pr` ORDER BY PR_Number DESC');
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($prnum);
	$stmt->fetch();
	$stmt->close();
	$con->close();
	
	$productID = $_POST['productID']; //array
	$brandID = $_POST['brandID']; //array
	$qty_pr = $_POST['qty_dr']; //array
	
	foreach($productID as $i => $p){
		$b = $brandID[$i];
		$q = $qty_pr[$i];
		
		if($q != 0){
		
	$purpose = "Order from $customer - PO#: $ponumber";	
		
	include 'connection.php';
	
	$stmt = $con->prepare('INSERT INTO `tbl_pr_bd`(`PR_Number`, `BrandID`, `ProductID`, `QtyRequested`, Purpose) VALUES (?, ?, ?, ?, ?)');
	$stmt->bind_param('iiiis', $prnum, $b, $p, $q, $purpose);
	$stmt->execute();
	$stmt->close();
	$con->close();
	
		}
	}
	
	header('location: ../po_details?pr&id='.$so_id);
}
elseif(isset($_GET['si_return'])){
	$so_id = $_GET['si_return'];
	date_default_timezone_set('Asia/Manila');
	$date = date('Y-m-d');
	
	//get due date from terms
	include 'connection.php';
	$stmt = $con->prepare('SELECT t.Days FROM tbl_tsgi_so so JOIN tbl_terms t ON t.Term_ID=so.TermsID WHERE so.SO_ID=?');
	$stmt->bind_param('i', $so_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($days);
	$stmt->fetch();
	$stmt->close();
	$con->close();
	
	$due = date('Y-m-d', strtotime($date. ' + '.$days.' days'));
	
	include 'connection.php';
	$stmt = $con->prepare('UPDATE `tbl_tsgi_so` SET `SI_Return`=?,`DueDate`=? WHERE `SO_ID`=?');
	$stmt->bind_param('ssi', $date, $due, $so_id);
	$stmt->execute();
	$stmt->close();
	$con->close();
	
	header('location: ../po_from_customer?success');
}
?>
