<?php
class SO{
	public $qid;
	public $ponum;
	public $podate;
	public $deldate;
	public $ta;
	public $bal;
	public $company;
	public $c_address;
	public $c_industry;
	public $terms;
	public $c_tin;
	public $disc;
	public $si_return;
	public $delivered_all; 
	public $vattype;
	public $si_number;

	public function set_data($id){
		include 'connection.php';
		
		$stmt = $con->prepare('SELECT `QuoteID`, `PONumber`, `PODate`, `DeliveryDate`, so.`TotalAmount`, `Balance`, c.CompanyName, t.DaysLabel, c.CompanyAddress, c.Industry, c.TIN, so.SI_Return, so.SINumber, q.VAT_Type, q.Discount FROM `tbl_tsgi_so` so JOIN tbl_customers c ON c.CustomerID=so.CustomerID JOIN tbl_terms t ON t.Term_ID=so.TermsID JOIN tbl_quote q ON q.QuotationID=so.QuoteID WHERE SO_ID=?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($qid, $ponum, $podate, $deldate, $ta, $bal, $company, $terms, $c_address, $c_industry, $c_tin, $si_return, $si_number, $vattype, $disc);
		$stmt->fetch();
		
		$this->disc = $disc;
		$this->qid = $qid;
		$this->ponum = $ponum;
		$this->podate = $podate;
		$this->si_return = $si_return;
		$this->deldate = $deldate;
		$this->ta = $ta;
		$this->bal = $bal;
		$this->company = $company;
		$this->terms = $terms;
		$this->c_address = $c_address;
		$this->c_industry = $c_industry;
		$this->c_tin = $c_tin;
		$this->si_number = $si_number;
		$this->vattype = $vattype;
	}

	public function show_so_records(){
		include 'connection.php';
		
		$stmt = $con->prepare('SELECT `SO_ID`, `QuoteID`, `PONumber`, `PODate`, `DeliveryDate`, `TotalAmount`, `Balance`, c.CompanyName, t.DaysLabel, SI_Return, DueDate FROM `tbl_tsgi_so` so JOIN tbl_customers c ON c.CustomerID=so.CustomerID JOIN tbl_terms t ON t.Term_ID=so.TermsID');
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($so_id, $qid, $ponum, $podate, $deldate, $ta, $bal, $company, $terms, $sireturn, $due);
		if($stmt->num_rows > 0){
			while($stmt->fetch()){
				$podate = date_format(date_create($podate), 'M j, y');
				$deldate= date_format(date_create($deldate), 'M j, y');
				$so = sprintf('%06d', $so_id);
				if($bal < 0){
				    $bal = 0;
				}
				
				$ta_ = number_format($ta, 2);
				$bal_ = number_format($bal, 2);
				
				echo "
					<tr>
						<td>$so</td>
						<td>$ponum</td>
						<td>$company</td>
						<td>$podate</td>
						<td>$deldate</td>
						<td>$ta_</td>
						<td>$bal_</td>";
						
						if($sireturn != NULL){
							$sireturn= date_format(date_create($sireturn), 'M j, y');
							echo "<td>$sireturn</td>";
						}
						else{
							echo "<td><center><a href='models/so_aed.php?si_return=$so_id'><button class='btn btn-success btn-sm'><i class='fa fa-calendar'></i>&nbsp; Set Date</button></a></center></td>";
						}
						
						if($due != NULL){
							$due= date_format(date_create($due), 'M j, y');
							echo "<td>$due</td>";
						}
						else{
							echo "<td> --- </td>";
						}
						
						echo "
						<td>
							<center>
								<a href='po_details?id=$so_id'><button class='btn btn-primary btn-sm'><i class='fa fa-list'></i>&nbsp;&nbsp;View Details</button></a>
							</center>
						</td>
					</tr>
				";
			}
		}
	}
	
	public function show_q_bd($id){
      	include 'connection.php';

        $stmt = $con->prepare('SELECT `Brand`, s.CompanyName, `ProductID`, `ProductDescription`, `OurPartNumber`, `YourPartNumber`, `UOM`, `Quantity`, `UnitPrice`, `Available`, `LineTotal` FROM `tbl_tsgi_so_bd` so_bd LEFT JOIN tbl_supplier s ON s.SupplierID=so_bd.Brand WHERE SO_ID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($brandid, $brand, $prodid, $proddesc, $opn, $ypn, $uom, $q, $up, $a, $linetotal);
        if($stmt->num_rows > 0){
          $i = 1;
          $match_ctr = 0;
          while($stmt->fetch()){
          
          
          	//get count of delivered per brandid, prodid, so_id
          	$con1 = new mysqli($server, $user, $pw, $db);
          	
          	$dr = $con1->prepare('SELECT SUM(`QtyDelivered`) FROM tbl_dr_so_bd drsobd JOIN tbl_dr_so drso ON drso.DR_Number=drsobd.DR_Number WHERE BrandID=? AND ProductID=? AND drso.SO_Number=?');
          	$dr->bind_param('iii', $brandid, $prodid, $id);
          	$dr->execute();
          	$dr->store_result();
          	$dr->bind_result($qd);
          	$dr->fetch();
          	$dr->close();
          	$con1->close();
          	
          	if($brand == NULL){
          		$qd = 0;
          	}
          	
          	if($qd == NULL){
          		$qd = 0;
          	}
          	
          	if($qd == $q){
          	    $match_ctr++;
          	}
          	
            echo "
              <tr id='tr$i'>
                      <td>
                          <input type='hidden' name='productID[]' id='productID$i' value='$prodid'>
                          <input id='product$i' name='product[]' readonly maxlength='200' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...' value='$brand - $proddesc'>
                        </td>
                        <td>
                          <input type='text' name='ourpartnum[]' readonly id='ourpartnum$i' value='$opn' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control'>
                        </td>
                        <td>
                          <input type='text' name='uom[]' readonly value='$uom' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control'>
                        </td>
                        <td>
                          <input type='text' name='avail[]' id='avail$i' value='$a' readonly style='text-align:right; background-color:transparent; border:transparent; width:100%' required value='No' class='form-control'>
                        </td>
                        <td>
                          <input type='number' name='quantity[]' readonly id='quan$i' value='$q' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        <td>
                          <input type='number' name='quantity[]' readonly id='' value='$qd' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        <td>
                          <input type='text' id='unitprice$i' readonly value='$up' name='price[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                      <td>
                          <input name='linetotal[]' id='linetotal$i' value='$linetotal' step='any' style='text-align:right;background-color:transparent; border:transparent' min='0' class='form-control tprice' readonly required type='text'>
                        </td>
                      </tr>
            ";
            
            $i++;
          }
          
        }
        
        if(($i - 1) == $match_ctr){
              $this->delivered_all = 'YES';
          }
        else{
              $this->delivered_all = 'NO';
        }
      }
      
      public function show_q_bd_dr($id){
      	include 'connection.php';

        $stmt = $con->prepare('SELECT p.ProductDescription, p.PartNumber, s.CompanyName, drso.DR_Number, sobd.Quantity, sobd.ProductID, sobd.Brand, p.CurrentStock, drsobd.QtyDelivered FROM tbl_tsgi_so so JOIN tbl_tsgi_so_bd sobd ON so.SO_ID=sobd.SO_ID JOIN tbl_supplier s ON s.SupplierID=sobd.Brand JOIN tbl_tsgi_product p ON p.ProductID=sobd.ProductID LEFT JOIN tbl_dr_so drso ON drso.SO_Number=so.SO_ID LEFT JOIN tbl_dr_so_bd drsobd ON drsobd.ProductID=sobd.ProductID WHERE so.SO_ID=? GROUP BY p.PartNumber');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($desc, $pnum, $comp, $drnum, $qo, $prodid, $brandid, $stock, $qd);
        if($stmt->num_rows > 0){
          $i = 1;
          while($stmt->fetch()){
              
              $qr = $qo - $qd;
              $max = $stock;
            echo "
              <tr id='tr$i'>
                      <td>
                          <input type='hidden' name='productID[]' id='productID$i' value='$prodid'>
                          <input type='hidden' name='brandID[]' id='brandid$i' value='$brandid'>
                          <input id='product$i' name='product[]' readonly maxlength='200' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...' value='$pnum - $comp - $desc'>
                        </td>
                        <td>
                          <input type='number' readonly value='$stock' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        
                        <td>
                          <input type='number' name='quantity[]' readonly id='quan$i' value='$qo' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        <td>
                          <input type='number' readonly value='$qr' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        
                        <td>
                          <input type='number' name='qty_dr[]' id='' value='' min='0' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        
                      </tr>
            ";
            
            $i++;
          }
        }
      }
      
      public function show_q_bd_pr($id){
      	include 'connection.php';

        $stmt = $con->prepare('SELECT p.ProductDescription, p.PartNumber, s.CompanyName, drso.DR_Number, sobd.Quantity, sobd.ProductID, sobd.Brand, p.CurrentStock FROM tbl_tsgi_so so JOIN tbl_tsgi_so_bd sobd ON so.SO_ID=sobd.SO_ID JOIN tbl_supplier s ON s.SupplierID=sobd.Brand JOIN tbl_tsgi_product p ON p.ProductID=sobd.ProductID LEFT JOIN tbl_dr_so drso ON drso.SO_Number=so.SO_ID WHERE so.SO_ID=? GROUP BY p.PartNumber');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($desc, $pnum, $comp, $drnum, $qo, $prodid, $brandid, $stock);
        if($stmt->num_rows > 0){
          $i = 1;
          while($stmt->fetch()){
              
              //get delivered base on brand, product, dr number
              	$con1 = new mysqli($server, $user, $pw, $db);
              	$stmt1 = $con1->prepare('SELECT `QtyDelivered` FROM `tbl_dr_so_bd` WHERE `DR_Number`=? AND `BrandID`=? AND `ProductID`=?');
              	$stmt1->bind_param('iii', $drnum, $brandid, $prodid);
              	$stmt1->execute();
              	$stmt1->store_result();
              	$stmt1->bind_result($qd);
              	$stmt1->fetch();
              	$stmt1->close();
              	$con1->close();
              	
              $qr = $qo - $qd;
            
            echo "
              <tr id='tr$i'>
                      <td>
                          <input type='hidden' name='productID[]' id='productID$i' value='$prodid'>
                          <input type='hidden' name='brandID[]' id='brandid$i' value='$brandid'>
                          <input id='product$i' name='product[]' readonly maxlength='200' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...' value='$pnum - $comp - $desc'>
                        </td>
                        <td>
                          <input type='number' readonly value='$stock' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        
                        <td>
                          <input type='number' name='quantity[]' readonly id='quan$i' value='$qo' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        <td>
                          <input type='number' readonly value='$qr' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        
                        <td>
                          <input type='number' name='qty_dr[]' id='' value='' min='0' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        
                      </tr>
            ";
            
            $i++;
          }
        }
      }
      
      public function show_q_bd_dr_($id){
      	include 'connection.php';

        $stmt = $con->prepare('SELECT p.ProductDescription, p.PartNumber, s.CompanyName, drsobd.QtyDelivered, sobd.Quantity, drsobd.ProductID, drsobd.BrandID, p.CurrentStock FROM tbl_dr_so drso JOIN tbl_dr_so_bd drsobd ON drso.DR_Number=drsobd.DR_Number LEFT JOIN tbl_tsgi_so so ON so.SO_ID=drso.SO_Number JOIN tbl_supplier s ON drsobd.BrandID=s.SupplierID JOIN tbl_tsgi_product p ON p.ProductID=drsobd.ProductID JOIN tbl_tsgi_so_bd sobd ON sobd.SO_ID=so.SO_ID WHERE drso.DR_Number=? GROUP BY p.PartNumber');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($desc, $pnum, $comp, $qd, $qo, $prodid, $brandid, $stock);
        if($stmt->num_rows > 0){
          $i = 1;
          while($stmt->fetch()){
              
              $qr = $qo - $qd;
              $max = $stock - $qd;
            echo "
              <tr id='tr$i'>
                      <td>
                          <input type='hidden' name='productID[]' id='productID$i' value='$prodid'>
                          <input type='hidden' name='brandID[]' id='brandid$i' value='$brandid'>
                          <input id='product$i' name='product[]' readonly maxlength='200' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...' value='$pnum - $comp - $desc'>
                        </td>
                        <td>
                          <input type='number' readonly value='$stock' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        
                        <td>
                          <input type='number' name='quantity[]' readonly id='quan$i' value='$qo' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        <td>
                          <input type='number' readonly value='$qr' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        
                        <td>
                          <input type='number' name='qty_dr[]' id='' value='$qd' max='$max' min='0' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        
                      </tr>
            ";
            
            $i++;
          }
        }
      }
      
      public function print_dr($dr){
      	include 'connection.php';
      	
      	$stmt = $con->prepare('SELECT `QtyDelivered`, qbd.UOM, p.PartNumber, p.ProductDescription FROM tbl_dr_so_bd drsobd JOIN tbl_tsgi_product p ON p.ProductID=drsobd.ProductID JOIN tbl_dr_so drso ON drso.DR_Number=drsobd.DR_Number JOIN tbl_tsgi_so so ON so.SO_ID=drso.SO_Number JOIN tbl_quote q ON q.QuotationID=so.QuoteID JOIN tbl_quote_bd qbd ON qbd.OurPartNumber=p.PartNumber WHERE drso.DR_Number=? GROUP BY p.PartNumber');
      	$stmt->bind_param('i', $dr);
      	$stmt->execute();
      	$stmt->store_result();
      	$stmt->bind_result($qty, $uom, $part, $desc);
      	if($stmt->num_rows > 0){
      		while($stmt->fetch()){
      			echo "
      			<tr>
      				<td style='width:10%'>$qty</td>
      				<td style='width:10%'>$uom</td>
      				<td style='width:30%'>$part</td>
      				<td style='width:50%'>$desc</td>
      			</tr>
      			";
      		}
      	}	
      }
      
      public function print_si($so){
      	include 'connection.php';
      	
      	$stmt = $con->prepare('SELECT `ProductDescription`, OurPartNumber, `UOM`, `Quantity`, `UnitPrice`, `LineTotal` FROM `tbl_tsgi_so_bd` WHERE SO_ID=?');
      	$stmt->bind_param('i', $so);
      	$stmt->execute();
      	$stmt->store_result();
      	$stmt->bind_result($desc, $pnum, $uom, $q, $up, $lt);
      	if($stmt->num_rows > 0){
      		while($stmt->fetch()){
      			echo "
      			<tr>
      				<td style='width:12%; font-size: 80%'>$q</td>
      				<td style='width:11%; font-size: 80%'>$uom</td>
      				<td style='width:50%; font-size: 80%'>$pnum - $desc</td>
      				<td style='width:13%; font-size: 80%'>$up</td>
      				<td style='width:14%; font-size: 80%'>$lt</td>
      			</tr>
      			";
      		}
      	}	
      }
      
      public function show_cr($id){
        include 'connection.php';
      	
      	$stmt = $con->prepare('SELECT `PaymentID`, `CRNumber`, `Amount`, `ModePayment`, `Bank`, `Branch`, `CheckNumber`, `CheckDate`, `Status` FROM `tbl_tsgi_payment` WHERE `SONumber`=? ');
      	$stmt->bind_param('i', $id);
      	$stmt->execute();
      	$stmt->store_result();
      	$stmt->bind_result($pid, $crnum, $amount, $mode, $bank, $branch, $checknumber, $checkdate, $status);
      	if($stmt->num_rows > 0){
      	    while($stmt->fetch()){
      	        $checkdate = date_format(date_create($checkdate), 'F j, Y');
      	        
      	        echo "
      	        <tr>
      	            <td>$crnum</td>
      	            <td>$checkdate</td>
      	            <td>$amount</td>
      	            <td>$bank</td>
      	            <td>$checknumber</td>
      	            <td>
      	            <a href='print_cr.php?so=$id&cr=$pid' target='_new'><button class='btn btn-default btn-sm'><i class='fa fa-print'></i>&nbsp; Print</button></a>";
      	            
      	            if($status == 'PENDING'){
      	                
      	            echo "
      	            <a href='models/cr_aed.php?pid=$pid&so=$id'><button class='btn btn-primary btn-sm'><i class='fa fa-print'></i>&nbsp; Mark as Cleared</button></a>";
      	            
      	            }
      	            else{
      	                
      	            echo "
      	            <button class='btn btn-primary btn-sm' disabled><i class='fa fa-print'></i>&nbsp; Mark as Cleared</button>";
      	            
      	            }
      	            
      	            echo "
      	            </td>
      	        </tr>
      	        ";
      	    }
      	}
      	else{
      	    echo "
      	    <tr>
      	        <td colspan='6'><center>No data to show...</center></td>
      	    </tr>
      	    ";
      	}
      }
      
      public function show_dr($id){
      	include 'connection.php';
      	
      	$stmt = $con->prepare('SELECT `DR_Number`, `DateGenerated`, `DateReturned`, DR_Number_True FROM `tbl_dr_so` WHERE `SO_Number`=?');
      	$stmt->bind_param('i', $id);
      	$stmt->execute();
      	$stmt->store_result();
      	$stmt->bind_result($dr, $dg, $dr_, $drt);
      	if($stmt->num_rows > 0){
      		while($stmt->fetch()){
      			$drx = sprintf('%06d', $dr);
      			$dg = date_format(date_create($dg), "F j, Y");
      		
      			echo "
      				<tr>
      					<td>$drx</td>
      					<td>$drt</td>
      					<td>$dg</td>";
      					
      						if($dr_ != NULL){
							$dr_= date_format(date_create($dr_), 'F j, y');
							echo "<td>$dr_</td>";
							
							echo "<td>
      					
      					<center>
      						<button data-href='view_dr.php?dr=$dr' disabled class='btn btn-primary btn-sm editDR'><i class='fa fa-edit'></i>&nbsp; Edit Details</button>
      						<button disabled class='btn btn-danger btn-sm'><i class='fa fa-trash'></i>&nbsp; Delete</button>
      						<button disabled class='btn btn-default btn-sm'><i class='fa fa-print'></i>&nbsp; Print</button>
      					</center>";
      					
						}
						else{
							echo "<td><center><a href='models/so_aed.php?dr_returned=$dr'><button class='btn btn-success btn-sm'><i class='fa fa-calendar'></i>&nbsp; Set Date</button></a></center></td>";
							
							echo "<td>
      					
      					<center>
      						<a href='javascript:void(0);'><button data-href='view_dr.php?dr=$dr' class='btn btn-primary btn-sm editDR'><i class='fa fa-edit'></i>&nbsp; Edit Details</button></a>
      						<a href='models/so_aed.php?delete=$dr'><button class='btn btn-danger btn-sm'><i class='fa fa-trash'></i>&nbsp; Delete</button></a>
      						<a href='print_dr.php?so=$id&dr=$dr' target='_new'><button class='btn btn-default btn-sm'><i class='fa fa-print'></i>&nbsp; Print</button></a>
      					</center>";
      					
						}
					
      					echo "
      					</td>
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
      }
}

?>