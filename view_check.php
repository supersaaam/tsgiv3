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

<?php

include 'models/payee_model.php';
include 'models/check_model.php';
include 'models/company_model.php';
include 'models/account_title_model.php';

$py = new Payee();
$ck = new Check();
$cmp = new Company();
$acct = new Account_Title();

if(isset($_GET['apid'])){
  $apid= $_GET['apid'];
  
  $ck->set_data($apid);

  $sql = "SELECT AP_ID, `APRefNumber`, `CheckNumber`, `Date`, p.PayeeName, c.CompanyName, `BIR`, Total, EWT FROM tbl_ap ap JOIN tbl_payee p ON p.PayeeID=ap.Payee JOIN tbl_company c ON c.CompanyID=ap.Company WHERE AP_ID='$apid'";

  $ck->show_query($sql);
}
else{

  $ck->get_last_id();
$id = sprintf('%010d', $ck->nxt_cnum);
$idx = $ck->nxt_cnum;

date_default_timezone_set("Asia/Manila");

$ap_ref = date("Ymd").$idx; 
?>

        <!-- /.card-header -->
        <div class="card-body">
                <form role="form" action="models/check_model.php" method="post" id="form_imp">
                  <!-- text input -->
                  <div class="col-md-6" style="float:left; padding-right: 30px">
                 
                  <div class="form-group">
                    <label>Payee</label>
                    <input list="payee_list" required name="payee" class="form-control" maxlength="50" placeholder="Please input payee name ...">
                  </div>

                  <div class="form-group">
                    <label>Company</label>
                    <input list="company_list" required name="company" class="form-control" maxlength="50" placeholder="Please input company name ...">
                  </div>

                  </div>

 <div class="col-md-6" style="float:left; padding-right: 30px">
                 
                  <div class="form-group" style='float:left; margin-right: 2%; width: 48%'>
                    <label>AP Reference Number</label>
                    <input type="text" required readonly name="aprefnum" value='<?php echo $ap_ref; ?>' maxlength="20" class="form-control" id="inv_input">
                  </div>

                  <div class="form-group" style='float:left; margin-left: 2%; width: 48%'>
                    <label>Check Number</label>
                    <input type="text" required name="checknumber" placeholder='Please type here...' maxlength="20" class="form-control" id="">
                  </div>

                  <div class="form-group" style='float:left; margin-right: 2%; width: 48%'>
                    <label>Date</label>
                    <input type="date" id='dte' required name="date" class="form-control">
                  </div>
                  
                  <div class="form-group" style='float:left; margin-left: 2%; width: 23%'>
                    <label>EWT</label><br>
                    <input type="number" max='1000000' step='any' min='0' id='EWT' name="ewt" class="form-control">
                  </div>

                  <div class="form-group" style='float:left; margin-left: 2%; width: 23%'>
                    <br>
                    <input type='radio' id='bir' name='bir' checked value='BIR'> BIR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <br>
                    <input type='radio' id='bir' name='bir' value='Non-BIR'> Non-BIR
                  </div>

                  </div>
                  
                  <div class="col-md-6" style="float:left; padding-left: 30px">
                  
                  
                  </div>

                <div style="clear:both; height:15px;"></div>
                <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>

                <table id="modalTbl" style='width:100%' class="table table-bordered table-striped">
                 <thead>
                 <tr>
                      <th style='width:50%'>Description</th>
                      <th style='width:15%'>Amount</th>
                      <th style='width:30%'>Account Title</th>
                      <th style='width:5%'></th>
                    </tr>
                 </thead>
                  <tbody id="prod_table">
                  <tr>
                      <td>
                        <input type="text" maxlength='150' name="desc[]" id='desc1' style="background-color:transparent; border:transparent" required class="form-control" placeholder='Type input here ...'>
                      </td>
                      <td>
                        <input type="number" max='1000000' step='any' min='0' name="amt[]" id='amt1' style="background-color:transparent; border:transparent" required class="form-control tprice">
                      </td>
                      <td>
                        <input list='acct_list' required name='acct[]' style='background-color:transparent; border:transparent' class='form-control' maxlength='100' placeholder='Please input account title ...'>
                      </td>
                      <td> 
                        
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <th style="text-align:right">Total Price: </th>     
                    <th colspan="3" style="text-align:right" id=""><input type="text" name="total_price" id='total_price' style="text-align:left; background-color:transparent; border:transparent" class="form-control" readonly value='0.00'></th>               
                  </tfoot>
                </table>
                <button type="button" onclick="add_row()" class="btn btn-success btn-sm" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-plus'></i> &nbsp;Add New Row</button>
                <br><br>
                <button type="submit" id="" name="save_print" class="btn btn-primary" style="float:right; margin-top:2px; margin-bottom: 20px; margin-right:10px"><i class='fa fa-print'></i> &nbsp;Print and Save</button>
                <button type="submit" id="submit_new" name="save_only" class="btn btn-info" style="float:right; margin-top:2px; margin-bottom: 20px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Only</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                        <!-- DATALISTS -->
                        <datalist id="payee_list">
                          <?php
                          $py->show_data_dl();
                          ?>
                        </datalist>

                        <datalist id="company_list">
                          <?php
                          $cmp->show_data_dl();
                          ?>
                        </datalist>

                        <datalist id="acct_list">
                          <?php
                          $acct->show_data_dl();
                          ?>
                        </datalist>

<script>

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

  var last_id = 2;

  function add_row(){
    var newRow = "<tr id="+last_id+"><td><input type='text' maxlength='150' name='desc[]' id='desc1' style='background-color:transparent; border:transparent' class='form-control' placeholder='Type input here ...'></td><td><input  type='number' max='10000000' min='0' step='any' name='amt[]' id='amt"+last_id+"' style='background-color:transparent; border:transparent' class='form-control tprice'></td><td><input list='acct_list' name='acct[]' style='background-color:transparent; border:transparent' class='form-control' maxlength='100' placeholder='Please input account title ...'></td><td><center><button id='"+last_id+"' onclick='deleterow(this.id)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td></tr>";
    
    $("#prod_table").append(newRow);
   
      //Dynamically add functions from here

      add_function(last_id);

    last_id+=1;
  }
  
  var length = $("#modalTbl tr").length;
  length = parseInt(length) - 2;

$(document).ready(function() {
  for (i = 1; i <= length; i++){
      add_function(i);
    }
});

function deleterow(id){
  $("#"+id).remove();
  total();
}

function add_function(id){
      $('#apref'+id).keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
      });

      $('#ewt'+id).keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
        
      });

      $('#amt'+id).keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
        
      });

      $("#amt"+id).keyup(function (){
         total();
      });
}

$("#EWT").bind('keyup', function(){
 total();
});

function total(){
 var sum = 0;
  
  $( ".tprice" ).each(function() {

    if($(this).val() == ''){
      sum += 0;
    }
    else{
      var x = $(this).val().replace(/\,/g,'');
      sum += parseFloat(x);  
    }
  });

  var ewt = $("#EWT").val();

  if(ewt == ''){
    ewt = 0;
  }

  sum -= ewt;

  if(sum < 0){
    sum = 0;
  }

  $("#total_price").val(sum.toFixed(2));
}

</script>


<?php
}
?>