<?php
if(isset($_POST['submit'])){
    $po_num= $_POST['po_num'];
    $date = $_POST['date'];
    $brand= $_POST['brand'];
    $supplier_id = $_POST['supplier_id'];
    $terms = $_POST['terms'];
    $total_price = str_replace(",", "", $_POST['total_price']);
    $currency= $_POST['currency'];
    
    //newly added fields
    $incoterms= $_POST['incoterms'];
    $shipment= $_POST['shipment'];
    $type = $_POST['type'];
    
    if($type == 'Local') {
        $del_address = $_POST['del_address'];
        $remaining_ar = NULL;
    }
    else {
        $del_address = NULL;
        if($_POST['remaining_ar'] == '' || !isset($_POST['remaining_ar'])){
        $remaining_ar= NULL;
        }
        else{
            $remaining_ar= $_POST['remaining_ar'];
        }    
    }
    
    if($_POST['note'] == '' || !isset($_POST['note'])){
        $note = NULL;
    }
    else{
        $note = $_POST['note']; //not required
    }
    
    //get Customer Contact Person ID or create new
    if($_POST['cperson'] == '' || !isset($_POST['cperson'])){
        $sc_id = NULL;
    }
    else{
        $cperson= $_POST['cperson'];
        
        include 'connection.php';
        $stmt_cust = $con->prepare('SELECT `SC_ID` FROM `tbl_supplier_contact` WHERE `SupplierID`=? AND `ContactPerson` LIKE ?');
        $stmt_cust->bind_param('is', $supplier_id, $cperson);
        $stmt_cust->execute();
        $stmt_cust->store_result();
        $stmt_cust->bind_result($sc_id);
        $stmt_cust->fetch();
        if ($stmt_cust->num_rows == 0) {
            //not saved in DB
            //not existing -> save to DB
            $con2 = new mysqli($server, $user, $pw, $db);
            $add = $con2->prepare('INSERT INTO `tbl_supplier_contact`(`SupplierID`, `ContactPerson`) VALUES (?, ?)');
            $add->bind_param('is', $supplier_id, $cperson);
            $add->execute();
            $add->close();
            $con2->close();
    
            //get ID
            $con3 = new mysqli($server, $user, $pw, $db);
            $id = $con3->prepare('SELECT `SC_ID` FROM `tbl_supplier_contact` WHERE `SupplierID`=? AND `ContactPerson` LIKE ?');
            $id->bind_param('is', $supplier_id, $cperson);
            $id->execute();
            $id->store_result();
            $id->bind_result($sc_id);
            $id->fetch();
            $id->close();
            $con3->close();
        }
        $stmt_cust->close();
        $con->close();
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
    
    include 'connection.php';
    $stmt = $con->prepare('INSERT INTO `tbl_tsgi_po`(`PONumber`, `Date`, `SupplierID`, `TotalAmount`, Currency, Terms, `ContactPersonID`, `Incoterms`, `Shipment`, `RemainingAR`, `Note`, `Type`, DeliveryAddress) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('isidsiissdsss', $po_num, $date, $supplier_id, $total_price, $currency, $tid, $sc_id, $incoterms, $shipment, $remaining_ar, $note, $type, $del_address);
    $stmt->execute();
    $stmt->close();
    $con->close();
    
    //arrays
    $pid= $_POST['pid'];
    $quantity = $_POST['quantity'];
    $price= $_POST['price'];
    $linetotal = $_POST['linetotal'];
    $disc = $_POST['disc']; 
    
    foreach($quantity as $k=>$q){
        $prod_id = $pid[$k];
        $p = $price[$k];
        $lt = str_replace(',', '', $linetotal[$k]);
        $d = $disc[$k];
        
        if($q > 0 && $q != null && $p != null && $lt != null){
            
            include 'connection.php';
            $stmt = $con->prepare('INSERT INTO `tbl_tsgi_po_bd`(`PONumber`, `ProductID`, `Quantity`, `PricePerUnit`, Discount, LineTotal) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('iiiddd', $po_num, $prod_id, $q, $p, $d, $lt);
            $stmt->execute();
            $stmt->close();
            $con->close();
            
        }
    }
    
            include 'connection.php';
            $stmt = $con->prepare('UPDATE `tbl_pr_bd` SET `Status`="SENT" WHERE `BrandID`=?');
            $stmt->bind_param('i', $brand);
            $stmt->execute();
            $stmt->close();
            $con->close();
    
    header('location: ../purchase_requests?sent');
}
elseif(isset($_POST['update'])){
    include 'connection.php';
    
    $po = $_POST['po'];
    $so_ref = $_POST['so_ref'];
    
    $stmt = $con->prepare('UPDATE `tbl_tsgi_po` SET `SOReferenceNumber`=?, Status="CONFIRMED" WHERE `PONumber`=?');
    $stmt->bind_param('si', $so_ref, $po);
    $stmt->execute();
    
    header('location: ../po_to_supplier?updated');
}
elseif(isset($_POST['costing'])){
    include 'connection.php';
    
    $po = $_POST['po'];
    
    if(isset($_POST['freight'])){
        $freight= $_POST['freight'];
    }
    else{
        $freight = 0;    
    }
    
    if(isset($_POST['insurance'])){
        $insurance = $_POST['insurance'];
    }
    else{
        $insurance = 0;    
    }
    
    if(isset($_POST['duties'])){
        $duties= $_POST['duties'];
    }
    else{
        $duties = 0;
    }
    
    if(isset($_POST['brokerage'])){
        $brokerage = $_POST['brokerage'];    
    }
    else{
        $brokerage = 0;
    }
    
    if(isset($_POST['bankcharge'])){
        $bankcharge = $_POST['bankcharge'];
    }
    else{
        $bankcharge = 0;
    }
    
    if(isset($_POST['phpvalue'])){
        $phpvalue= $_POST['phpvalue'];
    }
    else{
        $phpvalue = 0;
    }
    
    $amount= $_POST['amount'];
    
    if($bankcharge != null && $brokerage != null && $duties != null && $freight != null && $phpvalue != null && $insurance != null){
        
        //Conversion price = (freight + duties + brokerage + bank charge (58USD - editable) + cost of goods) / cost of goods (USD)
        
        $convprice = ($freight + $duties + $brokerage + $insurance + (($amount + $bankcharge)* $phpvalue))/$amount;
    }
    else{
        $convprice = null;
    }
    
    $stmt = $con->prepare('UPDATE `tbl_tsgi_po` SET `FreightCost`=? ,`DutiesCost`=?,`BrokerageCost`=?,`BankCharge`=?,`ConversionPrice`=?, ExchangeRate=?, Insurance=? WHERE `PONumber`=?');
    $stmt->bind_param('dddddddi', $freight, $duties, $brokerage, $bankcharge, $convprice, $phpvalue, $insurance, $po);
    $stmt->execute();
    
    header('location: ../confirmed_po?po='.$po.'&cost');
}
elseif(isset($_POST['payment'])){
    
    $po = $_POST['po']; //array
    
    $branch= $_POST['branch'];
    $accnum = $_POST['accnum'];
    $amount= $_POST['amount'];
    $currency = $_POST['currency'];
    $ftanumber = $_POST['ftanumber'];
    
    foreach($po as $key=>$p){
        //update PO to paid status
        include 'connection.php';
        $stmt = $con->prepare('UPDATE `tbl_tsgi_po` SET `Status`="PAID" WHERE `PONumber`=?');
        $stmt->bind_param('i', $p);
        $stmt->execute();
        $stmt->close();
        $con->close();
        
        include 'connection.php';
        $stmt = $con->prepare('INSERT INTO `tbl_tsgi_po_payment`(`PONumber`, `Branch`, `Amount`, `AccountNumber`, Currency, FTA_Number) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('isdsss', $p, $branch, $amount, $accnum, $currency, $ftanumber);
        $stmt->execute();
        $stmt->close();
        $con->close();
    }
    
    header('location: ../payments_to_supplier?payment');
    
}
elseif(isset($_POST['delivered'])){
    $po_num= $_POST['po_num'];
    $convprice = $_POST['convprice'];
    
    //arrays
    $productID= $_POST['productID'];
    $unitprice = $_POST['unitprice'];
    $q_received = $_POST['q_received'];
    
    foreach($productID as $k=>$p){
        $up = $unitprice[$k];
        $q = $q_received[$k];
        
        //updates for inventory: Current stocks(+)
        include 'connection.php';
        
        $stmt = $con->prepare('UPDATE `tbl_tsgi_product` SET `CurrentStock`=CurrentStock+? WHERE `ProductID`=?');
        $stmt->bind_param('ii', $q, $p);
        $stmt->execute();
        $stmt->close();
        $con->close();
        
        //updates for inventory: Current stocks(+)
        include 'connection.php';
        
        $stmt = $con->prepare('UPDATE `tbl_tsgi_po_bd` SET `QuantityDelivered`=QuantityDelivered + ? WHERE `PONumber`=? AND `ProductID`=?');
        $stmt->bind_param('iii', $q, $po_num, $p);
        $stmt->execute();
        $stmt->close();
        $con->close();
        
        
        //save record of shipments
        include 'connection.php';
        
        $stmt = $con->prepare('INSERT INTO `tbl_tsgi_po_del`(`PONumber`, `ProductID`, `QuantityDelivered`, `UnitPrice`, `LandedCost`) VALUES (?, ?, ?, ?, ?)');
        
        $lc = $convprice * $up;
        
        $stmt->bind_param('iiidd', $po_num, $p, $q, $up, $lc);
        $stmt->execute();
        $stmt->close();
        $con->close();
        
        header('location: ../shipment?po='.$po_num.'&received');
    
    }
}

elseif(isset($_POST['costing_multiple'])){
    include 'connection.php';
    
    $po = $_POST['po'];
    
    if(isset($_POST['freight'])){
        $freight= $_POST['freight'];
    }
    else{
        $freight = 0;    
    }
    
    if(isset($_POST['insurance'])){
        $insurance = $_POST['insurance'];
    }
    else{
        $insurance = 0;    
    }
    
    if(isset($_POST['duties'])){
        $duties= $_POST['duties'];
    }
    else{
        $duties = 0;
    }
    
    if(isset($_POST['brokerage'])){
        $brokerage = $_POST['brokerage'];    
    }
    else{
        $brokerage = 0;
    }
    
    if(isset($_POST['bankcharge'])){
        $bankcharge = $_POST['bankcharge'];
    }
    else{
        $bankcharge = 0;
    }
    
    if(isset($_POST['phpvalue'])){
        $phpvalue= $_POST['phpvalue'];
    }
    else{
        $phpvalue = 0;
    }
    
    //$amount= $_POST['amount'];
    
    $po_numbers = $_POST['po_numbers'];
    $po_array = explode(",", $po_numbers);
    $amount = 0;
    
    foreach($po_array as $p){
        $amt = get_total($p);
        
        $amount += $amt;
    }

    if($bankcharge != null && $brokerage != null && $duties != null && $freight != null && $phpvalue != null && $insurance != null){
        
        //Conversion price = (freight + duties + brokerage + bank charge (58USD - editable) + cost of goods) / cost of goods (USD)
        
        $convprice = ($freight + $duties + $brokerage + $insurance + (($amount + $bankcharge)* $phpvalue))/$amount;
    }
    else{
        $convprice = null;
    }
    
    foreach($po_array as $p){
        include 'connection.php';
        $stmt = $con->prepare('UPDATE `tbl_tsgi_po` SET `FreightCost`=? ,`DutiesCost`=?,`BrokerageCost`=?,`BankCharge`=?,`ConversionPrice`=?, ExchangeRate=?, Insurance=? WHERE `PONumber`=?');
        $stmt->bind_param('dddddddi', $freight, $duties, $brokerage, $bankcharge, $convprice, $phpvalue, $insurance, $p);
        $stmt->execute();
        $stmt->close();
        $con->close();
    }
    
    header('location: ../confirmed_po?po='.$po.'&cost');
}
elseif(isset($_POST['edit_submit'])){
    
    //delete existing PO 
    $po_num= $_POST['po_num'];
    include 'connection.php';
    $stmt = $con->prepare('DELETE FROM `tbl_tsgi_po` WHERE PONumber=?');
    $stmt->bind_param('i', $po_num);
    $stmt->execute();
    $stmt->close();
    $con->close();
    
    //then create another
    $date = $_POST['date'];
    $brand= $_POST['brand'];
    $supplier_id = $_POST['supplier_id'];
    $terms = $_POST['terms'];
    $total_price = str_replace(",", "", $_POST['total_price']);
    $currency= $_POST['currency'];
    
    //newly added fields
    $incoterms= $_POST['incoterms'];
    $shipment= $_POST['shipment'];
    $type = $_POST['type'];
    
    if($type == 'Local') {
        $del_address = $_POST['del_address'];
        $remaining_ar = NULL;
    }
    else {
        $del_address = NULL;
        if($_POST['remaining_ar'] == '' || !isset($_POST['remaining_ar'])){
        $remaining_ar= NULL;
        }
        else{
            $remaining_ar= $_POST['remaining_ar'];
        }    
    }
    
    if($_POST['note'] == '' || !isset($_POST['note'])){
        $note = NULL;
    }
    else{
        $note = $_POST['note']; //not required
    }
    
    //get Customer Contact Person ID or create new
    if($_POST['cperson'] == '' || !isset($_POST['cperson'])){
        $sc_id = NULL;
    }
    else{
        $cperson= $_POST['cperson'];
        
        include 'connection.php';
        $stmt_cust = $con->prepare('SELECT `SC_ID` FROM `tbl_supplier_contact` WHERE `SupplierID`=? AND `ContactPerson` LIKE ?');
        $stmt_cust->bind_param('is', $supplier_id, $cperson);
        $stmt_cust->execute();
        $stmt_cust->store_result();
        $stmt_cust->bind_result($sc_id);
        $stmt_cust->fetch();
        if ($stmt_cust->num_rows == 0) {
            //not saved in DB
            //not existing -> save to DB
            $con2 = new mysqli($server, $user, $pw, $db);
            $add = $con2->prepare('INSERT INTO `tbl_supplier_contact`(`SupplierID`, `ContactPerson`) VALUES (?, ?)');
            $add->bind_param('is', $supplier_id, $cperson);
            $add->execute();
            $add->close();
            $con2->close();
    
            //get ID
            $con3 = new mysqli($server, $user, $pw, $db);
            $id = $con3->prepare('SELECT `SC_ID` FROM `tbl_supplier_contact` WHERE `SupplierID`=? AND `ContactPerson` LIKE ?');
            $id->bind_param('is', $supplier_id, $cperson);
            $id->execute();
            $id->store_result();
            $id->bind_result($sc_id);
            $id->fetch();
            $id->close();
            $con3->close();
        }
        $stmt_cust->close();
        $con->close();
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
    
    include 'connection.php';
    $stmt = $con->prepare('INSERT INTO `tbl_tsgi_po`(`PONumber`, `Date`, `SupplierID`, `TotalAmount`, Currency, Terms, `ContactPersonID`, `Incoterms`, `Shipment`, `RemainingAR`, `Note`, `Type`, DeliveryAddress) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('isidsiissdsss', $po_num, $date, $supplier_id, $total_price, $currency, $tid, $sc_id, $incoterms, $shipment, $remaining_ar, $note, $type, $del_address);
    $stmt->execute();
    $stmt->close();
    $con->close();
    
    //arrays
    $pid= $_POST['pid'];
    $quantity = $_POST['quantity'];
    $price= $_POST['price'];
    $linetotal = $_POST['linetotal'];
    $disc = $_POST['disc']; 
    
    foreach($quantity as $k=>$q){
        $prod_id = $pid[$k];
        $p = $price[$k];
        $lt = str_replace(',', '', $linetotal[$k]);
        $d = $disc[$k];
        
        if($q > 0 && $q != null && $p != null && $lt != null){
            
            include 'connection.php';
            $stmt = $con->prepare('INSERT INTO `tbl_tsgi_po_bd`(`PONumber`, `ProductID`, `Quantity`, `PricePerUnit`, Discount, LineTotal) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('iiiddd', $po_num, $prod_id, $q, $p, $d, $lt);
            $stmt->execute();
            $stmt->close();
            $con->close();
            
        }
    }
    
    header('location: ../po_to_supplier?success');
}

function get_total($po){
          include 'connection.php';
          
          $stmt = $con->prepare('SELECT `PO_BD`, po.`PONumber`, p.ProductDescription, p.PartNumber, `Quantity`, `PricePerUnit`, po.Currency, po.TotalAmount, Discount FROM tbl_tsgi_po_bd pobd JOIN tbl_tsgi_product p ON p.ProductID=pobd.ProductID RIGHT JOIN tbl_tsgi_po po ON po.PONumber=pobd.PONumber WHERE po.PONumber=?');
          $stmt->bind_param('i', $po);
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($pobd, $po, $desc, $part, $q, $ppu, $currency, $amt, $disc);
          
          if($stmt->num_rows > 0){
              $total = 0;
                    while($stmt->fetch()){
                        
                        $discounted = $ppu - ($ppu*($disc/100));
                        $lt = $q * $discounted;
                        
                        $total += $lt;
                    }
                    
                    return $total;
          }
          
}
?>