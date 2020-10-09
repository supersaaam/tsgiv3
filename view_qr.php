<?php

include 'models/quotation_model.php';
include 'models/customer_model.php';
$cust     = new Quotation();
$c = new Customer();

if(isset($_GET['edit'])){
	$qrid = $_GET['edit'];
	
	$cust->set_request($qrid);
	
	$customer = $cust->qr_company;
	$cperson = $cust->qr_cperson;
	$date = $cust->qr_date;
	$content = $cust->qr_content;
	$cc_id = $cust->cc_id;
	$remarks = $cust->qr_remarks;
}
else{
	$qrid = "";
	$customer = "";
	$cperson = "";
	$date = "";
	$content = "";
	$cc_id = "";
	$remarks = "";
}	


?>

<style>
.loader {
  border: 4px solid #f3f3f3;
  border-radius: 50%;
  border-top: 4px solid #3498db;
  width: 12px;
  height: 12px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>


                    <form action='models/quote_aed.php' method='post'>  
               
                  <div class="form-group">
                      <label>Customer </label>
                      <input list="customer_list" value='<?php echo $customer; ?>' required name="customer" id='customer' class="form-control" placeholder="Please input customer name ...">
                    </div>

		  <div class="form-group" style='float: left; width: 48%; margin-right: 2%'>
                      <label>Contact Person</label>
                      <input list="cperson_list" value='<?php echo $customer; ?>' required name="cperson" id='cperson' class="form-control" placeholder="Please input contact person's name ...">
                    </div>
                    
                    <div class="form-group" style='float: left; width: 48%; margin-left: 2%'>
                      <label>Date</label>
                      <input name="date" type='date' value='<?php echo $date; ?>' id='dte' class="form-control" required>
                    </div>
                    
                    <div class="form-group" style='float: right; width: 100%'>
                      <label>Content</label>
                      <textarea name="content" maxlength='800' required class="form-control" required style='resize:none' rows='5'><?php echo $content; ?></textarea>
                    </div>
                    
                    <div class="form-group" style='float: right; width: 100%'>
                      <label>Remarks / Special Instructions</label>
                      <textarea name="remarks" maxlength='800' class="form-control" style='resize:none' rows='5'><?php echo $remarks; ?></textarea>
                    </div>
                    
                    <input type='hidden' name='qrid' value='<?php echo $qrid; ?>'>
                    
                    <?php
                    if($qrid == ''){
                    ?>
                    
                  <button type="submit" name='add_qr' id='submit' class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Details</button>
                   
                   <?php
                   }
                   else{
                   ?>
                  
                  <button type="submit" name='update_qr' id='submit' class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Update Changes</button>
                   
                   <?php
                   }
                   ?>
                   
                   </form>
                   
                   <datalist id="customer_list">
                          <?php
                            $c->show_data_dl();
                            ?>
                        </datalist>
                        
                        <datalist id="cperson_list">
                        </datalist>
                   
<script>

$("#customer").on('change', function () {
    //ajax to get all contact persons
    var customer = $(this).val();
    
    $.ajax({
    	url: 'models/ajax_contactperson.php',
    	type: 'post',
    	data: {
    		customer: customer
    	},
    	success:function(data){
    		$("#cperson_list").html(data);
    	}
    });
    
});

var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();

if(dd<10) {
    dd = '0'+dd
}

if(mm<10) {
    mm = '0'+mm
}

today = yyyy + '-' + mm + '-' + dd;
$("#dte").val(today);

   </script>

