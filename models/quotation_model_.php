<?php
namespace Dompdf;

class Quotation{
    public $last_q;
    public $date;
    public $company;
    public $notes;
    public $terms;
    public $currency;
    public $revnum;
    public $total;
    public $cperson;
    public $intro;
    public $salutation;
    public $dept;
    public $deltime;	
    public $en;
	public $address;
	public $cc;
	public $qt_ref;
	public $shipping;
	public $shipping_cost;
	public $n;
	public $qb;
	 
    public function show_bd($id){
        include 'connection.php';
        $m = '';

        $stmt = $con->prepare('SELECT s.CompanyName, qbd.`ProductDescription`, qbd.`OurPartNumber`, qbd.`YourPartNumber`, qbd.`UOM`, qbd.`Quantity`, qbd.`Available`, `LineTotal`, qbd.`UnitPrice`, q.Currency, q.TotalAmount, qbd.ProductID, p.CurrentStock, q.Shipping, q.ShippingCost, q.Discount, q.VAT_Type FROM `tbl_quote_bd` qbd LEFT JOIN tbl_supplier s ON s.SupplierID=qbd.Brand JOIN tbl_quote q ON q.QuotationID=qbd.QuoteID RIGHT JOIN tbl_tsgi_product p ON p.ProductID=qbd.ProductID WHERE `QuoteID`=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($company, $desc, $our, $your, $uom, $qty, $avl, $sub, $price, $currency, $total, $pid, $stock, $shipping, $shipping_cost, $disc, $vattype);
        if($stmt->num_rows > 0){
            
            $m .= "<table border='1|0' cellpadding='5' style='border-collapse: collapse; width: 100%; font-family: Helvetica; font-size: 13px'>";
            $m .= "
                <thead>
                    <tr>
                        <th></th>
                        <th>Brand</th>
                        <th>Description</th>
                        <th>Our Part Number</th>
                        <th>Your Part Number</th>
                        <th>UOM</th>
                        <th>Availability</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Line Total</th>
                    </tr>
                </thead>
            ";

		$i = 1;
            while($stmt->fetch()){
                $price = number_format($price, 2);
                $qty = number_format($qty, 2);
                $sub = number_format($sub, 2);
                
                if($currency == 'PHP'){
                    $c = 'P';
                }
                elseif($currency == 'USD'){
                    $c = '$';
                }
                elseif($currency == 'EURO'){
                    $c = '&#128;';
                }
                else{
                    $c = $currency;
                }
                
                if($shipping == null){ //trade
                    //for availability
                    if($avl == 'Yes'){
                    	$avl = $stock.' Ex-Stock';
                    }
                    else{
                    	if($stock == 0){
                    		$avl = '8-10 weeks';
                    	}
                    	else{
                    		$avl = $stock.' Ex-Stock, 8-10 weeks';
                    	}
                    }
                }
                
                $m .= "
                    <tr>
                        <td>$i</td>
                        <td>$company</td>
                        <td>$desc</td>
                        <td>$our</td>
                        <td>$your</td>
                        <td>$uom</td>
                        <td>$avl</td>
                        <td>$qty</td>
                        <td>$c $price</td>
                        <td>$c $sub</td>
                    </tr>
                ";
                $i++;
            }
            
            if($shipping != null){
                
                $m .= "
                    <tr>
                        <td>$i</td>
                        <td></td>
                        <td>$shipping</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>1.00</td>
                        <td>$c ". number_format($shipping_cost,2) ."</td>
                        <td>$c ". number_format($shipping_cost,2) ."</td>
                    </tr>
                ";
                
            $total += $shipping_cost;
            }
            
            if($disc != null && $disc != 0.00 && $disc != ''){
                
                $m .= "
                    <tr>
                        <td>$i</td>
                        <td></td>
                        <td>Discount</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>1.00</td>
                        <td>$c ". number_format($disc,2) ."</td>
                        <td>$c ". number_format($disc,2) ."</td>
                    </tr>
                ";
                
            $total -= $disc;
            
            }
            
            $total_ = number_format($total, 2);
            
            if($shipping == null){ //trade
            
                $m .= "<tfoot>";
                
                if($vattype == 'VAT'){
                    $vat = number_format($total-($total/1.12), 2);
                    $net = number_format($total/1.12, 2);
                    
                    $m .= "
                    <tr>
                        <th colspan='9' style='text-align: right'>Amount Net of VAT</th>
                        <td>$c $net</td>
                    </tr>";
                    
                    $m .= "
                    <tr>
                        <th colspan='9' style='text-align: right'>Add: VAT</th>
                        <td>$c $vat</td>
                    </tr>";
                    
                }
                
                
                $m .= "
                <tr>
                    <th colspan='9' style='text-align: right'>Total Amount</th>
                    <td>$c $total_</td>
                </tr>";
                
                $m .= "</tfoot></table>";
            
            }
            else{
                
                $m .= "<tfoot>";
                $m .= "
                <tr>
                    <th colspan='9' style='text-align: right'>Total Amount</th>
                    <td>$c $total_</td>
                </tr>";
                
                $m .= "</tfoot></table>";
            }
            
            
            
        }

        return $m;
    }

    public function set_data($id){
      include 'connection.php';

      $stmt = $con->prepare('SELECT `Date`, c.CompanyName, c.CompanyAddress, cc.ContactPerson, `Notes`, DeliveryTime, t.DaysLabel, `Currency`, `RevisionNumber`, `TotalAmount`, Salutation, Introduction, cc.Department, Order_Company, Order_ContactPerson, CC, QTReferenceNumber, Shipping, ShippingCost, QuotedBy FROM `tbl_quote` q JOIN tbl_customers c ON c.CustomerID=q.CompanyID JOIN tbl_customers_contact cc ON q.ContactPerson=cc.CC_ID JOIN tbl_terms t ON t.Term_ID=q.Terms WHERE QuotationID=?');
      $stmt->bind_param('i', $id);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($date, $company, $address, $cperson, $notes, $deltime, $terms, $currency, $revnum, $total, $salutation, $intro, $dept, $order_company, $order_cp, $cc, $qt_ref, $shipping, $shipping_cost, $qb);
      $stmt->fetch();
      $stmt->close();
      $con->close();

        $this->qb = $qb;
      $this->date = $date;
      $this->company = $company;
      $this->notes = $notes;
      $this->terms = $terms;
      $this->currency = $currency;
      $this->revnum = $revnum;
      $this->total = $total;
      $this->cperson = $cperson;
      $this->salutation = $salutation;
      $this->intro = $intro;
      $this->dept = $dept;
        $this->address = $address;  		
	    $this->shipping = $shipping;
	    $this->shipping_cost = $shipping_cost;
	    
	    if($cc != null){
$this->cc =	"
<tr>
    <td>CC: </td>
    <td><b>".$cc."</b></td>
</tr>";
	    }
	    else{
        $this->cc = '';	        
	    }
	    
	    
	    if($qt_ref != null){
	        $this->qt_ref = "
<tr>
    <td style='text-align: right'><b>".$qt_ref."</b></td>
</tr>
	        ";
	    }
	    else{
	        $this->qt_ref = '';
	    }
	    
	if($deltime != null){
		$this->en = "<b>Delivery Time: </b> &nbsp;&nbsp;&nbsp; ".$deltime;
		$this->n = "
    <br> 
	<ul>
	<li>This quotation is valid for 30 days.
	<li>FREE delivery within Metro Manila.
	<li>All ex-stock items are subject to prior sales.
	</ul>
		";
	}
	else{
		$this->en = "<br><b>Place the order to... </b><br><br><span style='font-size: 92%'> &nbsp;&nbsp;&nbsp;Full Company Name: &nbsp;&nbsp;&nbsp; <b>".$order_company."</b><br>&nbsp;&nbsp;&nbsp;Contact Person for the Order: &nbsp;&nbsp;&nbsp;<b> ".$order_cp."</b></span>";
		$this->n = "&nbsp; This quotation is valid for 30 days.<br>";
	}
 
      
      if($dept == ''){
      	include 'connection.php';
      	$stmt = $con->prepare('SELECT `Department` FROM `tbl_customers_contact` WHERE `ContactPerson` LIKE ? AND `Deleted`!="YES"');
      	$stmt->bind_param('s', $cperson);
      	$stmt->execute();
      	$stmt->store_result();
      	$stmt->bind_result($dept_);
      	$stmt->fetch();
      	$stmt->close();
      	$con->close();
      	
      	$this->dept = $dept_;
      	
      }
      else{
      	$this->dept = $dept;
      }
    }

    public function get_last_q() {
        include 'connection.php';
    
        $stmt = $con->prepare('SELECT `QuotationID` FROM `tbl_quote` ORDER BY QuotationID DESC');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($q);
        $i = 0;
        if ($stmt->num_rows > 0) {
          while ($stmt->fetch()) {
            if ($i === 0) {
              $this->last_q = $q + 1;
              $i++;
            }
          }
        } else {
          $this->last_q = 1;
        }
      }

      public function show_data_pending(){
        include 'connection.php';

        $stmt = $con->prepare('SELECT `QuotationID`, `Date`, c.CompanyName, `TotalAmount` FROM `tbl_quote` q JOIN tbl_customers c ON q.CompanyID=c.CustomerID WHERE `Status`="PENDING"');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($qid, $date, $company, $amt);
        if($stmt->num_rows > 0){
          while($stmt->fetch()){
            $qid_fmtd = sprintf('%06d', $qid);
            $date = date_format(date_create($date), 'F j, Y');
            $amt = number_format($amt, 2);
            echo "
              <tr>
                <td>$qid_fmtd</td>
                <td>$date</td>
                <td>$company</td>
                <td>$amt</td>
                <td>
                <center>
                <a href='quote_pdf?id=$qid' target='_new'>
                <button class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i>&nbsp; View Quote</button>
                </a>
                <button class='btn btn-success btn-sm'><i class='fa fa-check'></i>&nbsp; Approve</button>
                <button class='btn btn-danger btn-sm'><i class='fa fa-times'></i>&nbsp; Disapprove</button>
                </center>
                </td>
              </tr>
            ";
          }
        }
      }
}
?>