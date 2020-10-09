<?php
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
    public $qr_company;
    public $qr_cperson;
    public $qr_date;
    public $cc_id;
    public $qr_remarks;
    public $qr_content;
    public $deltime;
    public $order_cp;
    public $order_company;
    public $cc;
    public $qt_ref;
    public $shipping;
    public $shipping_cost;
    public $vattype;
    public $disc;
    public $ctr; 
    
    public function set_data($id){
      include 'connection.php';

      $stmt = $con->prepare('SELECT `Date`, c.CompanyName,cc.ContactPerson, `Notes`, DeliveryTime, t.DaysLabel, `Currency`, `RevisionNumber`, `TotalAmount`, Salutation, Introduction, cc.Department, Order_Company, Order_ContactPerson, CC, QTReferenceNumber, Shipping, ShippingCost, VAT_Type, Discount FROM `tbl_quote` q JOIN tbl_customers c ON c.CustomerID=q.CompanyID JOIN tbl_customers_contact cc ON cc.CC_ID=q.ContactPerson JOIN tbl_terms t ON t.Term_ID=q.Terms WHERE QuotationID=?');
      $stmt->bind_param('i', $id);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($date, $company, $cperson, $notes, $deltime, $terms, $currency, $revnum, $total, $salutation, $intro, $dept, $order_company, $order_cp, $cc, $qt_ref, $shipping, $shipping_cost, $vattype, $disc);
      $stmt->fetch();
      $stmt->close();
      $con->close();

        $this->disc = $disc;
      $this->vattype = $vattype;
      $this->date = $date;
      $this->company = $company;
      $this->notes = html_entity_decode($notes);
      $this->cc = $cc;
      $this->qt_ref = $qt_ref;
      $this->shipping = $shipping;
      $this->shipping_cost = $shipping_cost;
      $this->terms = $terms;
      $this->deltime = $deltime;
      $this->currency = $currency;
      $this->revnum = $revnum;
      $this->total = $total;
      $this->cperson = $cperson;
      $this->salutation = $salutation;
      $this->intro = $intro;
      $this->order_company = $order_company;
      $this->order_cp = $order_cp;
      $this->dept = $dept;
    }
    
    public function set_request($id){
    	include 'connection.php';
    	
      $stmt = $con->prepare('SELECT c.CompanyName, cc.CC_ID, cc.ContactPerson, `DateRequested`, `Content`, Remarks FROM `tbl_quote_request` qr JOIN tbl_customers c ON c.CustomerID=qr.CustomerID JOIN tbl_customers_contact cc ON cc.CC_ID=qr.ContactPerson WHERE QR_ID=?');
      $stmt->bind_param('i', $id);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($company, $cc_id, $cperson, $date, $content, $remarks);
      $stmt->fetch();
      $stmt->close();
      $con->close();
	
      $this->qr_company = $company;
      $this->qr_cperson = $cperson;
      $this->qr_date = $date;
      $this->qr_content = $content;
      $this->cc_id = $cc_id;
	$this->qr_remarks = $remarks;
    }
    
    public function show_request(){
    	include 'connection.php';
    	
    	$stmt = $con->prepare('SELECT `QR_ID`, c.CompanyName, cc.ContactPerson, cc.ContactNumber, `DateRequested`, `Content`, `Status`, `DateQuoted`, Remarks, QuoteID FROM `tbl_quote_request` qr JOIN tbl_customers c ON c.CustomerID=qr.CustomerID JOIN tbl_customers_contact cc ON cc.CC_ID=qr.ContactPerson WHERE Status="PENDING"');
    	$stmt->execute();
    	$stmt->store_result();
    	$stmt->bind_result($qrid, $company, $cperson, $cnumber, $date, $content, $status, $dq, $remarks, $qid);
    	if($stmt->num_rows > 0){
    		while($stmt->fetch()){
    			$qridx = sprintf('%06d', $qrid);
    			$date = date_format(date_create($date), 'M j, y');
    			
    			echo "
    			<tr>
    				<td>$qridx</td>
    				<td>$company</td>
    				<td>$cperson - $cnumber</td>
    				<td>$content</td>
    				<td>$remarks</td>
    				<td>";
    				
    				if($dq == NULL){
    				
    				/*
    				echo "
    				<center>
    					<a href='models/quote_aed.php?quoted=$qrid'>
    					<button type='button' class='btn btn-success btn-sm'><i class='fa fa-check'></i> &nbsp;Mark as Quoted</button>
    					</a>
    				</center>";
    				*/
    				
    				echo "
    				<center>
    					<a href='javascript:void(0);'>
    					<button type='button' data-href='view_quoted.php?q=$qrid' class='btn btn-success btn-sm quoted'><i class='fa fa-check'></i> &nbsp;Mark as Quoted</button>
    					</a>
    				</center>";
    				
    				}
    				else{
    				
    				$dq= date_format(date_create($dq), 'M j, Y');
    				echo $dq;
    				echo "
		    		<a href='quote_pdf?id=$qid' target='_new'>
		                <button class='btn btn-success btn-xs' style='margin-top:2px'><i class='fa fa-file-pdf-o'></i>&nbsp; View Quote</button>
		                </a>
		                
    				";
    				}
    				
    				echo "
    				</td>
    				<td>
    					<center>
    					<a href='javascript:void(0);'><button data-href='view_qr.php?edit=$qrid' class='btn btn-primary btn-sm editQR'><i class='fa fa-edit'></i>&nbsp; View Details</button></a>
    					<button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#delete$qrid'><i class='fa fa-trash'></i>&nbsp; Delete</button>
    					</center></a>
    				</td>
    			</tr>	
    			";
    			
                echo "
    			<div id='delete$qrid' class='modal fade' role='dialog'>
		  <div class='modal-dialog'>
	     	    <form action='models/quote_aed.php' method='post'>
		    <!-- Modal content-->
		    <div class='modal-content'>
		      <div class='modal-header'>
		        <button type='button' class='close' data-dismiss='modal'>&times;</button>
		        <h4 class='modal-title'>Delete Request</h4>
		      </div>
		      <div class='modal-body'>
		      	<div class='form-group'>
	                    <label>Remarks for Deletion</label>
	                    <input type='hidden' name='qrid' value='$qrid'>
	                    <textarea name='remarks' required class='form-control' rows='6' style='resize:none'></textarea>
	                  </div>		      
		      </div>
		      <div class='modal-footer'>
		        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
		        <button type='submit' name='delete_qr' class='btn btn-primary'>Submit</button>
		      </div>
		    </div>
		    </form>
		  </div>
		</div>
            ";
            
    		}
    	}
    }
    
    public function show_request_archive(){
    	include 'connection.php';
    	
    	$stmt = $con->prepare('SELECT `QR_ID`, c.CompanyName, cc.ContactPerson, cc.ContactNumber, `DateRequested`, `Content`, `Status`, `DateQuoted`, Remarks, QuoteID FROM `tbl_quote_request` qr JOIN tbl_customers c ON c.CustomerID=qr.CustomerID JOIN tbl_customers_contact cc ON cc.CC_ID=qr.ContactPerson WHERE Status="ARCHIVED"');
    	$stmt->execute();
    	$stmt->store_result();
    	$stmt->bind_result($qrid, $company, $cperson, $cnumber, $date, $content, $status, $dq, $remarks, $qid);
    	if($stmt->num_rows > 0){
    		while($stmt->fetch()){
    			$qridx = sprintf('%06d', $qrid);
    			$date = date_format(date_create($date), 'M j, y');
    			
    			echo "
    			<tr>
    				<td>$qridx</td>
    				<td>$company</td>
    				<td>$cperson - $cnumber</td>
    				<td>$content</td>
    				<td>$remarks</td>
    			</tr>	
    			";
    		}
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

        $stmt = $con->prepare('SELECT `QuotationID`, `Date`, c.CompanyName, `TotalAmount`, ShippingCost, Discount, QTReferenceNumber, CONCAT(u.FirstName," ",u.LastName) as fullname, Currency FROM `tbl_quote` q JOIN tbl_customers c ON q.CompanyID=c.CustomerID LEFT JOIN tbl_users u ON u.UserID=q.QuotedBy WHERE `Status`="PENDING"');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($qid, $date, $company, $amt, $sc, $disc, $qt, $agent, $c);
        if($stmt->num_rows > 0){
          while($stmt->fetch()){
            $qid_fmtd = sprintf('%06d', $qid);
            $date = date_format(date_create($date), 'F j, Y');
            $amt = number_format($amt+$sc-$disc, 2);
            echo "
              <tr>
                <td>$qid_fmtd</td>
                <td>$qt</td>
                <td>$date</td>
                <td>$company</td>
                <td>$c $amt</td>
                <td>$agent</td>
                <td>
                <center>
                <a href='quote_pdf?id=$qid' target='_new'>
                <button class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i>&nbsp; View Quote</button>
                </a>
                <a href='models/quote_aed.php?approve=$qid'><button class='btn btn-success btn-sm'><i class='fa fa-check'></i>&nbsp; Approve</button></a>
                <button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#disapprove$qid'><i class='fa fa-times'></i>&nbsp; Disapprove</button>
                </center>
                </td>
              </tr>
              
              
              <div id='disapprove$qid' class='modal fade' role='dialog'>
		  <div class='modal-dialog'>
	     	    <form action='models/quote_aed.php' method='post'>
		    <!-- Modal content-->
		    <div class='modal-content'>
		      <div class='modal-header'>
		        <button type='button' class='close' data-dismiss='modal'>&times;</button>
		        <h4 class='modal-title'>Disapprove Quotation</h4>
		      </div>
		      <div class='modal-body'>
		      	<div class='form-group'>
	                    <label>Revisions</label>
	                    <input type='hidden' name='qid' value='$qid'>
	                    <textarea name='revisions' required class='form-control' rows='6' style='resize:none'></textarea>
	                  </div>		      
		      </div>
		      <div class='modal-footer'>
		        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
		        <button type='submit' name='disapprove' class='btn btn-primary'>Submit</button>
		      </div>
		    </div>
		    </form>
		  </div>
		</div>
            ";
          }
        }
      }
      
      public function show_data_approved(){
        include 'connection.php';

        $stmt = $con->prepare('SELECT `QuotationID`, `Date`, c.CompanyName, `TotalAmount`, ShippingCost, Discount, QTReferenceNumber, CONCAT(u.FirstName," ",u.LastName) as fullname, NextInstructions, Currency FROM `tbl_quote` q JOIN tbl_customers c ON q.CompanyID=c.CustomerID LEFT JOIN tbl_users u ON u.UserID=q.QuotedBy WHERE `Status`="APPROVED" AND DeliveryTime IS NOT NULL');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($qid, $date, $company, $amt, $sc, $disc, $qt, $agent, $remarks, $c);
        if($stmt->num_rows > 0){
          while($stmt->fetch()){
            $qid_fmtd = sprintf('%06d', $qid);
            $date = date_format(date_create($date), 'F j, Y');
            $amt = number_format($amt+$sc-$disc, 2);
            $remarks = html_entity_decode($remarks);
            echo "
              <tr>
                <td>$qid_fmtd</td>
                <td>$qt</td>
                <td>$date</td>
                <td>$company</td>
                <td>$agent</td>
                <td>$c</td>
                <td>$amt</td>
                <td>
                $remarks
                </td>
                <td>
                <center>
                
                
                <div class='btn-group'>
                      <button type='button' class='btn btn-primary btn-sm'>Action</button>
                      <button type='button' class='btn btn-primary btn-sm dropdown-toggle' data-toggle='dropdown' aria-expanded='true'>
                        <span class='caret'></span>
                        <span class='sr-only'>Toggle Dropdown</span>
                      </button>
                      <ul class='dropdown-menu' role='menu'>
                        <li><a href='quote_pdf?id=$qid' target='_new'>View Quote</a></li>
                        <li><a href='quote_po?id=$qid'>Accepted</a></li>
                        <li><a href='copy_quote?id=$qid' target='_new'>Copy Quote</a></li>
                        <li><a data-toggle='modal' data-target='#revise$qid'>Revise</a></li>
                        <li><a data-toggle='modal' data-target='#disapprove$qid'>Rejected</a></li>
                        <li><a data-toggle='modal' data-target='#remarks$qid'>Remarks</a></li>
                      </ul>
                    </div>
                </center>
                
                <div id='remarks$qid' class='modal fade' role='dialog'>
        		  <div class='modal-dialog'>
        	     	    <form action='models/quote_aed.php' method='post'>
        		    <!-- Modal content-->
        		    <div class='modal-content'>
        		      <div class='modal-header'>
        		        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        		        <h4 class='modal-title'>Remarks</h4>
        		      </div>
        		      <div class='modal-body'>
        	                    <label>Next Instructions</label>
        	                    <input type='hidden' name='qid' value='$qid'>
        	                    <br>
        	                    <textarea name='remarks' required class='form-control' rows='6' style='width: 100%; resize:none'>$remarks</textarea>
        	                  </div>		     
        		      <div class='modal-footer'>
        		        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
        		        <button type='submit' name='upd_remarks' class='btn btn-primary'>Submit</button>
        		      </div>
        		    </div>
        		    </form>
        		  </div>
        		</div>
        		
                </td>
              </tr>
              
              <div id='revise$qid' class='modal fade' role='dialog'>
		  <div class='modal-dialog'>
	     	    <form action='models/quote_aed.php' method='post'>
		    <!-- Modal content-->
		    <div class='modal-content'>
		      <div class='modal-header'>
		        <button type='button' class='close' data-dismiss='modal'>&times;</button>
		        <h4 class='modal-title'>Disapprove Quotation</h4>
		      </div>
		      <div class='modal-body'>
		      	<div class='form-group'>
	                    <label>Revisions</label>
	                    <input type='hidden' name='qid' value='$qid'>
	                    <textarea name='revisions' required class='form-control' rows='6' style='resize:none'></textarea>
	                  </div>		      
		      </div>
		      <div class='modal-footer'>
		        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
		        <button type='submit' name='disapprove_app_tq' class='btn btn-primary'>Submit</button>
		      </div>
		    </div>
		    </form>
		  </div>
		</div>
              
              <div id='disapprove$qid' class='modal fade' role='dialog'>
		  <div class='modal-dialog'>
	     	    <form action='models/quote_aed.php' method='post'>
		    <!-- Modal content-->
		    <div class='modal-content'>
		      <div class='modal-header'>
		        <button type='button' class='close' data-dismiss='modal'>&times;</button>
		        <h4 class='modal-title'>Rejected Quotation</h4>
		      </div>
		      <div class='modal-body'>
		      	<div class='form-group'>
	                    <label>Reason for Non-Acceptance</label>
	                    <input type='hidden' name='qid' value='$qid'>
	                    <textarea name='revisions' required class='form-control' rows='6' style='resize:none'></textarea>
	                  </div>		      
		      </div>
		      <div class='modal-footer'>
		        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
		        <button type='submit' name='rejected' class='btn btn-primary'>Submit</button>
		      </div>
		    </div>
		    </form>
		  </div>
		</div>
            ";
          }
        }
      }
      
      public function show_data_approved_in(){
        include 'connection.php';

        $stmt = $con->prepare('SELECT `QuotationID`, `Date`, c.CompanyName, `TotalAmount`, ShippingCost, Discount, CONCAT(u.FirstName," ",u.LastName) as fullname, QTReferenceNumber, NextInstructions, Currency FROM `tbl_quote` q JOIN tbl_customers c ON q.CompanyID=c.CustomerID LEFT JOIN tbl_users u ON u.UserID=q.QuotedBy WHERE `Status`="APPROVED" AND DeliveryTime IS NULL');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($qid, $date, $company, $amt, $sc, $disc, $agent, $qt, $remarks, $c);
        if($stmt->num_rows > 0){
          while($stmt->fetch()){
            $qid_fmtd = sprintf('%06d', $qid);
            $date = date_format(date_create($date), 'F j, Y');
            $amt = number_format($amt+$sc-$disc, 2);
            $remarks = html_entity_decode($remarks);
            echo "
              <tr>
                <td>$qid_fmtd</td>
                <td>$qt</td>
                <td>$date</td>
                <td>$company</td>
                <td>$agent</td>
                <td>$c</td>
                <td>$amt</td>
                <td>
                $remarks
                </td>
                <td>
                <center>
                
                <div class='btn-group'>
                      <button type='button' class='btn btn-primary btn-sm'>Action</button>
                      <button type='button' class='btn btn-primary btn-sm dropdown-toggle' data-toggle='dropdown' aria-expanded='true'>
                        <span class='caret'></span>
                        <span class='sr-only'>Toggle Dropdown</span>
                      </button>
                      <ul class='dropdown-menu' role='menu'>
                        <li><a href='quote_pdf?id=$qid' target='_new'>View Quote</a></li>
                        <li><a href='copy_quote?id=$qid' target='_new'>Copy Quote</a></li>
                        <li><a href='models/quote_aed.php?approved_in&id=$qid'>Accepted</a></li>
                        <li><a data-toggle='modal' data-target='#revise$qid'>Revise</a></li>
                        <li><a data-toggle='modal' data-target='#disapprove$qid'>Rejected</a></li>
                        <li><a data-toggle='modal' data-target='#remarks$qid'>Remarks</a></li>
                      </ul>
                    </div>
                </center>
                
                <div id='remarks$qid' class='modal fade' role='dialog'>
        		  <div class='modal-dialog'>
        	     	    <form action='models/quote_aed.php' method='post'>
        		    <!-- Modal content-->
        		    <div class='modal-content'>
        		      <div class='modal-header'>
        		        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        		        <h4 class='modal-title'>Remarks</h4>
        		      </div>
        		      <div class='modal-body'>
        	                    <label>Next Instructions</label>
        	                    <input type='hidden' name='qid' value='$qid'>
        	                    <br>
        	                    <textarea name='remarks' required class='form-control' rows='6' style='width: 100%; resize:none'>$remarks</textarea>
        	                  </div>		     
        		      <div class='modal-footer'>
        		        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
        		        <button type='submit' name='upd_remarks_in' class='btn btn-primary'>Submit</button>
        		      </div>
        		    </div>
        		    </form>
        		  </div>
        		</div>
                </td>
              </tr>
              
              <div id='revise$qid' class='modal fade' role='dialog'>
		  <div class='modal-dialog'>
	     	    <form action='models/quote_aed.php' method='post'>
		    <!-- Modal content-->
		    <div class='modal-content'>
		      <div class='modal-header'>
		        <button type='button' class='close' data-dismiss='modal'>&times;</button>
		        <h4 class='modal-title'>Disapprove Quotation</h4>
		      </div>
		      <div class='modal-body'>
		      	<div class='form-group'>
	                    <label>Revisions</label>
	                    <input type='hidden' name='qid' value='$qid'>
	                    <textarea name='revisions' required class='form-control' rows='6' style='resize:none'></textarea>
	                  </div>		      
		      </div>
		      <div class='modal-footer'>
		        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
		        <button type='submit' name='disapprove_app_tq_ind' class='btn btn-primary'>Submit</button>
		      </div>
		    </div>
		    </form>
		  </div>
		</div>
              
              
              <div id='disapprove$qid' class='modal fade' role='dialog'>
		  <div class='modal-dialog'>
	     	    <form action='models/quote_aed.php' method='post'>
		    <!-- Modal content-->
		    <div class='modal-content'>
		      <div class='modal-header'>
		        <button type='button' class='close' data-dismiss='modal'>&times;</button>
		        <h4 class='modal-title'>Rejected Quotation</h4>
		      </div>
		      <div class='modal-body'>
		      	<div class='form-group'>
	                    <label>Reason for Non-Acceptance</label>
	                    <input type='hidden' name='qid' value='$qid'>
	                    <textarea name='revisions' required class='form-control' rows='6' style='resize:none'></textarea>
	                  </div>		      
		      </div>
		      <div class='modal-footer'>
		        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
		        <button type='submit' name='rejected_in' class='btn btn-primary'>Submit</button>
		      </div>
		    </div>
		    </form>
		  </div>
		</div>
            ";
          }
        }
      }
      
       public function show_data_revisions(){
        include 'connection.php';

        $stmt = $con->prepare('SELECT `QuotationID`, `Date`, c.CompanyName, `TotalAmount`, Remarks, ShippingCost, Discount, QTReferenceNumber, CONCAT(u.FirstName," ",u.LastName) as fullname, Currency FROM `tbl_quote` q JOIN tbl_customers c ON q.CompanyID=c.CustomerID LEFT JOIN tbl_users u ON u.UserID=q.QuotedBy WHERE `Status`="DISAPPROVED"');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($qid, $date, $company, $amt, $remarks, $sc, $disc, $qt, $agent, $c);
        if($stmt->num_rows > 0){
          while($stmt->fetch()){
            $qid_fmtd = sprintf('%06d', $qid);
            $date = date_format(date_create($date), 'F j, Y');
            $amt = number_format($amt+$sc-$disc, 2);
            echo "
              <tr>
                <td>$qid_fmtd</td>
                <td>$qt</td>
                <td>$date</td>
                <td>$company</td>
                <td>$c $amt</td>
                <td>$remarks</td>
                <td>$agent</td>
                <td>
                <center>
                <a href='quote_pdf?id=$qid' target='_new'>
                <button class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i>&nbsp; View Quote</button>
                </a>
                <a href='revise_quote?id=$qid' target='_new'>
                <button class='btn btn-success btn-sm'><i class='fa fa-edit'></i>&nbsp; Edit Quote</button>
                </a>
                </center>
                </td>
              </tr>
            ";
          }
        }
      }
      
      public function show_data_rejected(){
        include 'connection.php';

        $stmt = $con->prepare('SELECT `QuotationID`, `Date`, c.CompanyName, `TotalAmount`, ReasonForRejection, ShippingCost, Discount,QTReferenceNumber, CONCAT(u.FirstName," ",u.LastName) as fullname, Currency FROM `tbl_quote` q JOIN tbl_customers c ON q.CompanyID=c.CustomerID LEFT JOIN tbl_users u ON u.UserID=q.QuotedBy WHERE `Status`="REJECTED"');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($qid, $date, $company, $amt, $reason, $sc, $disc, $qt, $agent, $c);
        if($stmt->num_rows > 0){
          while($stmt->fetch()){
            $qid_fmtd = sprintf('%06d', $qid);
            $date = date_format(date_create($date), 'F j, Y');
            $amt = number_format($amt+$sc-$disc, 2);
            echo "
              <tr>
                <td>$qid_fmtd</td>
                <td>$qt</td>
                <td>$date</td>
                <td>$company</td>
                <td>$c $amt</td>
                <td>$reason</td>
                <td>$agent</td>
                <td>
                <center>
                <a href='quote_pdf?id=$qid' target='_new'>
                <button class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i>&nbsp; View Quote</button>
                </a>
                </center>
                </td>
              </tr>
            ";
          }
        }
      }
      
      public function show_data_indent_rejected(){
        include 'connection.php';

        $stmt = $con->prepare('SELECT `QuotationID`, `Date`, c.CompanyName, `TotalAmount`, ReasonForRejection, ShippingCost, Discount,QTReferenceNumber, CONCAT(u.FirstName," ",u.LastName) as fullname, Currency FROM `tbl_quote` q JOIN tbl_customers c ON q.CompanyID=c.CustomerID LEFT JOIN tbl_users u ON u.UserID=q.QuotedBy WHERE `Status`="REJECTED" AND DeliveryTime IS NULL');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($qid, $date, $company, $amt, $reason, $sc, $disc, $qt, $agent, $c);
        if($stmt->num_rows > 0){
          while($stmt->fetch()){
            $qid_fmtd = sprintf('%06d', $qid);
            $date = date_format(date_create($date), 'F j, Y');
            $amt = number_format($amt+$sc-$disc, 2);
            echo "
              <tr>
                <td>$qid_fmtd</td>
                <td>$qt</td>
                <td>$date</td>
                <td>$company</td>
                <td>$c $amt</td>
                <td>$reason</td>
                <td>$agent</td>
                <td>
                <center>
                <a href='quote_pdf?id=$qid' target='_new'>
                <button class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i>&nbsp; View Quote</button>
                </a>
                </center>
                </td>
              </tr>
            ";
          }
        }
      }
      
      public function show_data_indent_accepted(){
        include 'connection.php';

        $stmt = $con->prepare('SELECT `QuotationID`, `Date`, c.CompanyName, `TotalAmount`, ReasonForRejection, ShippingCost, Discount,QTReferenceNumber, CONCAT(u.FirstName," ",u.LastName) as fullname, Currency FROM `tbl_quote` q JOIN tbl_customers c ON q.CompanyID=c.CustomerID LEFT JOIN tbl_users u ON u.UserID=q.QuotedBy WHERE `Status`="ACCEPTED" AND DeliveryTime IS NULL');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($qid, $date, $company, $amt, $reason, $sc, $disc, $qt, $agent, $c);
        if($stmt->num_rows > 0){
          while($stmt->fetch()){
            $qid_fmtd = sprintf('%06d', $qid);
            $date = date_format(date_create($date), 'F j, Y');
            $amt = number_format($amt+$sc-$disc, 2);
            echo "
              <tr>
                <td>$qid_fmtd</td>
                <td>$qt</td>
                <td>$date</td>
                <td>$company</td>
                <td>$c</td>
                <td>$amt</td>
                <td>$agent</td>
                <td>
                <center>
                <a href='quote_pdf?id=$qid' target='_new'>
                <button class='btn btn-primary btn-sm'><i class='fa fa-file-pdf-o'></i>&nbsp; View Quote</button>
                </a>
                </center>
                </td>
              </tr>
            ";
          }
        }
      }
      
      public function show_q_bd($id){
      	include 'connection.php';

        $stmt = $con->prepare('SELECT `Brand`, s.CompanyName, `ProductID`, `ProductDescription`, `OurPartNumber`, `YourPartNumber`, `UOM`, `Quantity`, `UnitPrice`, `Available`, `LineTotal`, q.DeliveryTime, q.Discount FROM `tbl_quote_bd` qbd LEFT JOIN tbl_supplier s ON s.SupplierID=qbd.Brand JOIN tbl_quote q ON q.QuotationID=qbd.QuoteID WHERE qbd.QuoteID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($brandid, $brand, $prodid, $proddesc, $opn, $ypn, $uom, $q, $up, $a, $linetotal, $deltime, $discount);
        if($stmt->num_rows > 0){
          $i = 1;
          while($stmt->fetch()){
            echo "
              <tr id='tr$i'>
                      <td>
                          <input class='counter' id='$i' type='hidden'>
                          <input type='hidden' name='brand[]' value='$brand' id='brand_$i'>
                          <input list='brand_list' id='brand$i' value='$brand' maxlength='50' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...'>
                        </td>
                        <td>
                          <input type='hidden' name='productID[]' id='productID$i' value='$prodid'>
                          <input id='product$i' name='product[]' readonly maxlength='200' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...' value='$proddesc'>
                        </td>
                        <td>
                          <input id='ourpartnum$i' name='ourpartnum[]' readonly maxlength='200' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...' value='$opn'>
                        </td>
                        <td>
                          <input type='text' name='yourpartnum[]' value='$ypn' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control'>
                        </td>
                        <td>
                          <input type='text' name='uom[]' value='$uom' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control'>
                        </td>";
                        
                        if($deltime != null){
                        
                        echo "
                        <td>
                          <input type='text' name='avail[]' id='avail$i' value='$a' style='text-align:right; background-color:transparent; border:transparent; width:100%' required readonly class='form-control'>
                        </td>
                        ";
                        
                        }
                        else{
                          
                        echo "
                        <td>
                          <input type='text' name='avail[]' id='avail$i' value='$a' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        ";
                        
                        }
                        
                        echo "
                        <td>
                          <input type='number' name='quantity[]' id='quan$i' value='$q' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        <td>
                          <input type='number' step='any' id='unitprice$i' value='$up' name='price[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                      <td>
                          <input name='linetotal[]' id='linetotal$i' value='$linetotal' step='any' style='text-align:right;background-color:transparent; border:transparent' min='0' class='form-control tprice' readonly required type='text'>
                        </td>
                        <td><center><button onclick='deleterow($i)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td>
                      </tr>
            ";
            
            $i++;
          }
          
          $this->ctr = $i;
        }
      }
      
      public function show_q_bd_copy($id){
      	include 'connection.php';

        $stmt = $con->prepare('SELECT `Brand`, s.CompanyName, `ProductID`, `ProductDescription`, `OurPartNumber`, `YourPartNumber`, `UOM`, `Quantity`, `UnitPrice`, `Available`, `LineTotal`, q.DeliveryTime, q.Discount, q.VAT_Type FROM `tbl_quote_bd` qbd LEFT JOIN tbl_supplier s ON s.SupplierID=qbd.Brand JOIN tbl_quote q ON q.QuotationID=qbd.QuoteID WHERE qbd.QuoteID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($brandid, $brand, $prodid, $proddesc, $opn, $ypn, $uom, $q, $up, $a, $linetotal, $deltime, $discount, $vattype);
        if($stmt->num_rows > 0){
          $i = 1;
          while($stmt->fetch()){
              
              if($vattype == 'Non-VAT' || $vattype == 'Zero-Rated'){
                  $up = round($up * 1.12, 2);
                  $linetotal = round($up * $q, 2);
              }
              
              
            echo "
              <tr id='tr$i'>
                      <td>
                          <input class='counter' id='$i' type='hidden'>
                          <input type='hidden' name='brand[]' value='$brand' id='brand_$i'>
                          <input list='brand_list' id='brand$i' value='$brand' maxlength='50' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...'>
                        </td>
                        <td>
                          <input type='hidden' name='productID[]' id='productID$i' value='$prodid'>
                          <input id='product$i' name='product[]' readonly maxlength='200' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...' value='$proddesc'>
                        </td>
                        <td>
                          <input type='text' name='ourpartnum[]' id='ourpartnum$i' value='$opn' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control'>
                        </td>
                        <td>
                          <input type='text' name='yourpartnum[]' value='$ypn' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control'>
                        </td>
                        <td>
                          <input type='text' name='uom[]' value='$uom' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control'>
                        </td>";
                        
                        if($deltime != null){
                        
                        echo "
                        <td>
                          <input type='text' name='avail[]' id='avail$i' value='$a' style='text-align:right; background-color:transparent; border:transparent; width:100%' required readonly class='form-control'>
                        </td>
                        ";
                        
                        }
                        else{
                          
                        echo "
                        <td>
                          <input type='text' name='avail[]' id='avail$i' value='$a' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        ";
                        
                        }
                        
                        echo "
                        <td>
                          <input type='number' name='quantity[]' id='quan$i' value='$q' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        <td>
                          <input type='number' step='any' id='unitprice$i' value='$up' name='price[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                      <td>
                          <input name='linetotal[]' id='linetotal$i' value='$linetotal' step='any' style='text-align:right;background-color:transparent; border:transparent' min='0' class='form-control tprice' readonly required type='text'>
                        </td>
                        <td><center><button onclick='deleterow($i)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td>
                      </tr>
            ";
            
            $i++;
          }
          
          $this->ctr = $i;
        }
      }
}
?>