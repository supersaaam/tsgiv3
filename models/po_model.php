<?php
class PO{
    public $last_po;
    public $so_ref;
    public $date;
    public $brand;
    public $amount;
    public $currency;
    public $status;
    public $terms;
    public $freight;
    public $duties;
    public $brokerage;
    public $bank;
    public $done;
    public $convprice;
    public $cperson;
    public $shipment;
    public $incoterms;
    public $c;
    public $note;
    public $ar;
    public $type;
    public $total_amount; 
    public $s_id;
    public $insurance;
    public $del_add;
    
    
    public function set_data($po){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT `SOReferenceNumber`, `Date`, s.CompanyName, `TotalAmount`, `Currency`, `Status`, t.DaysLabel, `FreightCost`, `DutiesCost`, `BrokerageCost`, `BankCharge`, `ConversionPrice`, Insurance, sc.ContactPerson, po.Shipment, po.Incoterms, po.Note, po.RemainingAR, s.SupplierID, `Type`, `DeliveryAddress` FROM tbl_tsgi_po po JOIN tbl_supplier s ON s.SupplierID=po.SupplierID JOIN tbl_terms t ON t.Term_ID=po.Terms LEFT JOIN tbl_supplier_contact sc ON sc.SC_ID=po.ContactPersonID WHERE `PONumber`=?');
        $stmt->bind_param('i', $po);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($so_ref, $date, $brand, $amount, $currency, $status, $terms, $freight, $duties, $brokerage, $bank, $convprice, $insurance, $cperson, $shipment, $incoterms, $note, $ar, $s_id, $type, $del_add);
        $stmt->fetch();
        $stmt->close();
        $con->close();
        
        $this->del_add = $del_add;
        $this->so_ref = $so_ref;
        $this->date = $date;
        $this->brand = $brand;
        $this->amount = $amount;
        $this->s_id = $s_id;
        $this->c = $currency;
        
                if($type == NULL) {
                    $type = 'Foreign';    
                }
                
        $this->type = $type;
        
                        if($currency == 'USD'){
                            $this->currency = '$';    
                        }
                        elseif($currency == 'EURO'){
                            $this->currency = '&euro;';
                        }
                        elseif($currency == 'PHP'){
                            $this->currency = 'P';
                        }
                        
        $this->status= $status;
        $this->terms = $terms;
        $this->freight = $freight;
        $this->duties = $duties;
        $this->brokerage = $brokerage;
        $this->bank = $bank;
        $this->convprice = $convprice;
        $this->insurance = $insurance;
        
        $this->cperson = $cperson;
        $this->shipment = $shipment;
        $this->incoterms = $incoterms;
        $this->note = $note;
        
        $this->ar = $ar;
    }
    
    public function show_delivered($po, $lc){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT p.PartNumber, p.ProductDescription, SUM(pod.QuantityDelivered), pod.UnitPrice, po.Currency FROM tbl_tsgi_po_del pod JOIN tbl_tsgi_product p ON p.ProductID=pod.ProductID JOIN tbl_tsgi_po po ON po.PONumber=pod.PONumber WHERE pod.PONumber=? GROUP BY p.PartNumber');
        $stmt->bind_param('i', $po);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($pnum, $pdesc, $q, $up, $currency);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                
                        if($currency == 'USD'){
                            $c = '$';    
                        }
                        elseif($currency == 'EURO'){
                            $c = '&euro;';
                        }
                        elseif($currency == 'PHP'){
                            $c = 'P';
                        }
                
                $lc_ = number_format($lc * $up,2);
                echo "
                <tr>
                    <td>$pnum</td>
                    <td>$pdesc</td>
                    <td>$q</td>
                    <td>$c $up</td>
                    <td>Php $lc_</td>
                </tr>
                ";
            }
        }
        else{
            echo "
            <tr>
                <td colspan='5'><center>No data to show...</center></td>
            </tr>
            ";
        }
        
        $stmt->close();
        $con->close();
    }
    
    public function show_product($po){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT p.PartNumber, p.ProductDescription, pobd.Quantity, pobd.ProductID, pobd.PricePerUnit, pobd.QuantityDelivered FROM tbl_tsgi_po_bd pobd JOIN tbl_tsgi_product p ON p.ProductID=pobd.ProductID WHERE pobd.PONumber=? AND (pobd.Quantity - pobd.QuantityDelivered > 0) GROUP BY p.PartNumber');
        $stmt->bind_param('i', $po);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($pnum, $pdesc, $q, $pid, $up, $qd);
        $done = 1;
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $rem = $q - $qd;
                
                if($rem > 0){
                    $done = 0;    
                }
                
                echo "
                <tr>
                    <td>$pnum</td>
                    <td>$pdesc</td>
                    <td>$q ($rem)</td>
                    <td>
                        <input type='hidden' name='productID[]' value='$pid'>
                        <input type='hidden' name='unitprice[]' value='$up'>
                        <input type='number' style='text-align:left; background-color:transparent; border:transparent' name='q_received[]' min='0' required>
                    </td>
                </tr>
                ";
            }
        }
        
        $this->done = $done; 
        
        $stmt->close();
        $con->close();
    }
    
    public function get_last_po() {
        include 'connection.php';
    
        $stmt = $con->prepare('SELECT `PONumber` FROM `tbl_tsgi_po` ORDER BY PONumber DESC');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($po);
        $i = 0;
        if ($stmt->num_rows > 0) {
          while ($stmt->fetch()) {
            if ($i === 0) {
              $this->last_po = $po + 1;
              $i++;
            }
          }
        } else {
          $this->last_po = 1;
        }
      }
      
      public function show_pending(){
          include 'connection.php';
          
          $stmt = $con->prepare('SELECT `PONumber`, `SOReferenceNumber`, `Date`, s.CompanyName, `TotalAmount`, Currency, `Type` FROM tbl_tsgi_po po JOIN tbl_supplier s ON s.SupplierID=po.SupplierID WHERE `Status`="PENDING"');
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($ponum, $soref, $date, $company, $amt, $currency, $type);
          if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $ponum = sprintf("%06d", $ponum);
                $date = date_format(date_create($date), "F j, Y");
                
                        if($currency == 'USD'){
                            $c = '$';    
                        }
                        elseif($currency == 'EURO'){
                            $c = '&euro;';
                        }
                        elseif($currency == 'PHP'){
                            $c = 'P';
                        }
                
                if($type == NULL) {
                    $type = 'Foreign';    
                }
                
                $amt_ = number_format($this->get_total($ponum),2);
                echo "
                <tr>
                    <td>$ponum</td>
                    <td>$date</td>
                    <td>$company</td>
                    <td>$c $amt_</td>
                    <td>$type</td>
                    <td><a href='po_pdf.php?po=$ponum' target='_new'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i>&nbsp;&nbsp;&nbsp;View PDF</button></a>
                       <a href='javascript:void(0);'><button data-href='view_po.php?po=$ponum' class='btn btn-success btn-sm confirm'><i class='fa fa-edit'></i>&nbsp; Mark as Confirmed</button></a>
                       <a href='edit_po?po=$ponum' target='_new'><button type='button' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i>&nbsp;&nbsp;&nbsp;Edit PO</button></a>
                    </td>
                </tr>
                ";
            }
          }
      }
      
      public function show_confirmed(){
          include 'connection.php';
          
          $stmt = $con->prepare('SELECT `PONumber`, `SOReferenceNumber`, `Date`, s.CompanyName, `TotalAmount`, Currency, Status, `Type` FROM tbl_tsgi_po po JOIN tbl_supplier s ON s.SupplierID=po.SupplierID WHERE `Status`="CONFIRMED" OR Status="PAID"');
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($ponum, $soref, $date, $company, $amt, $currency, $status, $type);
          if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $uf_ponum = $ponum;
                $ponum = sprintf("%06d", $ponum);
                $date = date_format(date_create($date), "F j, Y");
                
                        if($currency == 'USD'){
                            $c = '$';    
                        }
                        elseif($currency == 'EURO'){
                            $c = '&euro;';
                        }
                        elseif($currency == 'PHP'){
                            $c = 'P';
                        }
                        
                        if($type == NULL){
                            $type = 'Foreign';
                        }
                
                if($status == 'CONFIRMED'){
                    $s = '<span style="color:red; font-weight: bold">Unpaid</span>';
                }
                else{
                    $s = '<span style="color: green; font-weight: bold">Paid</span>';
                }
                
                
                $amt_ = number_format($this->get_total($ponum),2);
                
                echo "
                <tr>
                    <td>$ponum</td>
                    <td>$soref</td>
                    <td>$date</td>
                    <td>$company</td>
                    <td>$c $amt_</td>
                    <td>$s</td>
                    <td>$type</td>
                    <td><center><input type='checkbox' class='checkbox' name='compute' value='$uf_ponum'></center></td>
                    <td><a href='po_pdf.php?po=$ponum' target='_new'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i>&nbsp;&nbsp;&nbsp;View PDF</button></a>
                    <a href='confirmed_po?po=$ponum'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-list'></i>&nbsp;&nbsp;&nbsp;View Details</button></a>
                    <a href='shipment?po=$ponum' target='_new'><button type='button' class='btn btn-default btn-sm'><i class='fa fa-truck'></i>&nbsp;&nbsp;&nbsp;Shipment Details</button></a>
                    </td>
                </tr>
                ";
            }
          }
      }
      
      public function show_bd($brand){
          include 'connection.php';
          
          $stmt = $con->prepare('SELECT `PR_BD`, s.CompanyName, p.ProductDescription, p.ProductID, p.USDPrice, SUM(bd.QtyRequested), p.PartNumber FROM tbl_pr_bd bd JOIN tbl_supplier s ON s.SupplierID=bd.BrandID JOIN tbl_tsgi_product p ON p.ProductID=bd.ProductID JOIN tbl_pr pr ON pr.PR_Number=bd.PR_Number WHERE bd.Status="PENDING" AND bd.BrandID=? GROUP BY p.ProductID');
          $stmt->bind_param('i', $brand);
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($prbd, $company, $prod, $pid, $p, $q, $pnum);
          if($stmt->num_rows > 0){
                    $i = 1;
                    while($stmt->fetch()){
                        $lt = $q * $p;
                        echo "
                        <tr>
                            <td>$i</td>
                            <td>$pnum - $prod
                            <input type='hidden' name='pid[]' required value='$pid' class='form-control'>
                            </td>
                            <td><input type='number' name='quantity[]' id='quan$i' style='text-align:right; background-color:transparent; border:transparent; width:100%' required value='$q' min='0' class='form-control'></td>
                            <td><input type='text' id='unitprice$i' name='price[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' required value='$p' min='0' class='form-control'></td>
                            <td><input type='number' max='100' min='0' step='any' value='0' required id='discount$i' name='disc[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control'></td>
                            <td><input name='linetotal[]' id='linetotal$i' step='any' style='text-align:right;background-color:transparent; border:transparent' min='0' class='form-control tprice' value='$lt' readonly required type='text'></td>
                        </tr>
                        ";
                        
                        $i++;
                    }
          }
          
      }
      
       public function show_bd_approved($brand){
          include 'connection.php';
          
          $stmt = $con->prepare('SELECT `PR_BD`, s.CompanyName, p.ProductDescription, p.ProductID, p.USDPrice, SUM(bd.QtyRequested), p.PartNumber FROM tbl_pr_bd bd JOIN tbl_supplier s ON s.SupplierID=bd.BrandID JOIN tbl_tsgi_product p ON p.ProductID=bd.ProductID JOIN tbl_pr pr ON pr.PR_Number=bd.PR_Number WHERE bd.Status="APPROVED" AND bd.BrandID=? GROUP BY p.ProductID');
          $stmt->bind_param('i', $brand);
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($prbd, $company, $prod, $pid, $p, $q, $pnum);
          if($stmt->num_rows > 0){
                    $i = 1;
                    while($stmt->fetch()){
                        $lt = $q * $p;
                        echo "
                        <tr>
                            <td>$i</td>
                            <td>$pnum</td>
                            <td>$prod
                            <input type='hidden' name='pid[]' required value='$pid' class='form-control'>
                            </td>
                            <td><input type='number' name='quantity[]' id='quan$i' style='text-align:right; background-color:transparent; border:transparent; width:100%' required value='$q' min='0' class='form-control'></td>
                            <td><input type='text' id='unitprice$i' name='price[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' required value='$p' min='0' class='form-control'></td>
                            <td><input type='number' max='100' min='0' step='any' value='0' required id='discount$i' name='disc[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control'></td>
                            <td><input name='linetotal[]' id='linetotal$i' step='any' style='text-align:right;background-color:transparent; border:transparent' min='0' class='form-control tprice' value='$lt' readonly required type='text'></td>
                        </tr>
                        ";
                        
                        $i++;
                    }
          }
          
      }
      
      
       public function show_bd_po_edit($po){
          include 'connection.php';
          
          $stmt = $con->prepare('SELECT p.ProductDescription, p.ProductID, bd.Quantity, bd.PricePerUnit, bd.Discount, bd.LineTotal, p.PartNumber FROM tbl_tsgi_po_bd bd JOIN tbl_tsgi_product p ON bd.ProductID=p.ProductID WHERE bd.PONumber=?');
          $stmt->bind_param('i', $po);
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($desc, $pid, $q, $price, $disc, $total, $pn);
          if($stmt->num_rows > 0){
                    $i = 1;
                    while($stmt->fetch()){
                        $lt = $q * $p;
                        echo "
                        <tr>
                            <td>$i</td>
                            <td>
                            $pn
                            </td>
                            <td>
                            $desc
                            <input type='hidden' name='pid[]' required value='$pid' class='form-control'>
                            </td>
                            <td><input type='number' name='quantity[]' id='quan$i' style='text-align:right; background-color:transparent; border:transparent; width:100%' required value='$q' min='0' class='form-control'></td>
                            <td><input type='text' id='unitprice$i' name='price[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' required value='$price' min='0' class='form-control'></td>
                            <td><input type='number' max='100' min='0' step='any' value='0' required id='discount$i' name='disc[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' value='$disc' class='form-control'></td>
                            <td><input name='linetotal[]' id='linetotal$i' step='any' style='text-align:right;background-color:transparent; border:transparent' min='0' class='form-control tprice' value='$total' readonly required type='text'></td>
                        </tr>
                        ";
                        
                        $i++;
                    }
          }
          
      }
      
      public function show_bd_po($po){
          include 'connection.php';
          
          $stmt = $con->prepare('SELECT `PO_BD`, po.`PONumber`, p.ProductDescription, p.PartNumber, `Quantity`, `PricePerUnit`, po.Currency, po.TotalAmount, Discount FROM tbl_tsgi_po_bd pobd JOIN tbl_tsgi_product p ON p.ProductID=pobd.ProductID RIGHT JOIN tbl_tsgi_po po ON po.PONumber=pobd.PONumber WHERE po.PONumber=?');
          $stmt->bind_param('i', $po);
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($pobd, $po, $desc, $part, $q, $ppu, $currency, $amt, $disc);
          
          if($stmt->num_rows > 0){
              $total = 0;
                    while($stmt->fetch()){
                        
                        if($currency == 'USD'){
                            $c = '$';    
                        }
                        elseif($currency == 'EURO'){
                            $c = '&euro;';
                        }
                        elseif($currency == 'PHP'){
                            $c = 'P';
                        }
                        
                        $discounted = $ppu - ($ppu*($disc/100));
                        $lt = $q * $discounted;
                        echo "
                        <tr>
                            <td>$desc</td>
                            <td>$q</td>
                            <td>$c $ppu</td>
                            <td>$disc</td>
                            <td>$c $lt</td>
                        </tr>
                        ";
                        
                        $total += ($lt);
                        $this->total_amount = $total;
                    }
          }
          
      }
      
      public function get_total($po){
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
      
      
      public function show_payment(){
          include 'connection.php';
          
          $stmt = $con->prepare('SELECT `PaymentID`, `FTA_Number`, `PONumber`, `Branch`, `Amount`, `AccountNumber`, `Currency` FROM `tbl_tsgi_po_payment` GROUP BY FTA_Number');
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($pid, $fta, $po, $branch, $amt, $accnum, $currency);
          if($stmt->num_rows > 0){
            while($stmt->fetch()){
                
                        if($currency == 'USD'){
                            $c = '$';    
                        }
                        elseif($currency == 'EURO'){
                            $c = '&euro;';
                        }
                        elseif($currency == 'PHP'){
                            $c = 'P';
                        }
                
                //get PO references        
                $con1 = new mysqli($server, $user, $pw, $db);
                $stmt1 = $con1->prepare('SELECT `PONumber` FROM `tbl_tsgi_po_payment` WHERE FTA_Number=?');
                $stmt1->bind_param('s', $fta);
                $stmt1->execute();
                $stmt1->store_result();
                $stmt1->bind_result($po_);
                
                $poref = '';
                if($stmt1->num_rows > 0){
                    while($stmt1->fetch()){
                        $po_ = sprintf('%06d', $po_);
                        
                        $poref .= $po_.', ';
                    }
                }
                
                $stmt1->close();
                $con1->close();
                        
                $poref = substr($poref, 0, -2);
                
                echo "
                <tr>
                    <td>$fta</td>
                    <td>$branch</td>
                    <td>$accnum</td>
                    <td>$poref</td>
                    <td>$c $amt</td>
                    <td><a href='print_fta.php?fta=$fta' target='_new'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-print'></i>&nbsp;&nbsp;Print Form</button></a></td>
                </tr>
                ";
            }
          }
      }
}
?>