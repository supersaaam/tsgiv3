<?php
//if so has already dr record redirect to print dr
if(isset($_GET['c_so'])){

$so = $_GET['c_so'];

include 'models/sales_order_model.php';
include 'models/credit_model.php';

$som = new Sales_Order();
$som->set_data($so);

$si = $som->invoice;
$dr = $som->dr;
$comp = $som->name;
$address = $som->address;
$custid = $som->custid;

$c = new Credit();
$c->get_last_id();

$mnum = $c->nxt_mnum;
$f_mnum = sprintf('%05d', $mnum);

$mn = $mnum - 1;

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
                <!-- /.card-header -->
        <div class="card-body">
                <form role="form" action="models/credit_model.php?so=<?php echo $so; ?>" method="post" id="form_imp">
                  <!-- text input -->
                  <div class="col-md-6" style="float:left; padding-right: 30px">
                 
                  <div class="col-md-6" style="float:left">
                  <div class="form-group">
                    <label>Memo Number</label>
                    <input type='hidden' name='memonumber' value='<?php echo $mnum; ?>'>
                    <input type='hidden' name='custid' value='<?php echo $custid; ?>'>
                    <input type="text" required readonly name="" value='<?php echo $f_mnum; ?>' maxlength="20" class="form-control" id="inv_input">
                  </div>
                  </div>
                  <div class="col-md-6" style="float:left">
                  <div class="form-group">
                    <label>Date</label>
                    <input type="date" id='dte' required name="date" class="form-control">
                  </div>
                  </div>

                    <div class="col-md-6" style="float:left">
                  <div class="form-group">
                    <label>Invoice Number</label>
                    <input type="text" required readonly name="" value='<?php echo $si; ?>' maxlength="20" class="form-control" id="inv_input">
                  </div>
                  </div>
                  <div class="col-md-6" style="float:left">
                  <div class="form-group">
                    <label>DR Number</label>
                    <input type="text" required readonly name="" value='<?php echo $dr; ?>' maxlength="20" class="form-control" id="inv_input">
                  </div>
                  </div>

                  </div>
                  
                  <div class="col-md-6" style="float:left; padding-left: 30px">
                  
                  <div class="form-group">
                    <label>Debit To</label>
                    <input list="payee_list" name="" readonly value='<?php echo $comp; ?>' class="form-control" maxlength="50">
                  </div>

                  <div class="form-group">
                    <label>Address</label>
                    <input list="payee_list" name="" readonly value='<?php echo $address; ?>' class="form-control" maxlength="50">
                  </div>

                  </div>

                <div style="clear:both; height:15px;"></div>
                <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>

                <table id="modalTbl" style='width:100%' class="table table-bordered table-striped">
                 <thead>
                 <tr>
                      <th style='width:15%'>Quantity</th>
                      <th style='width:50%'>Description</th>
                      <th style='width:15%'>Unit Price</th>
                      <th style='width:15%'>Amount</th
                      <th style='width:5%'></th>
                    </tr>
                 </thead>
                  <tbody id="prod_table">
                  <tr>
                        <td>
                        <input type="text" maxlength='8' name="q[]" id='q1' style=" background-color:transparent; border:transparent" class="form-control" placeholder='Type input here ...'>
                      </td>
                      <td>
                        <input type="text" maxlength='150' name="desc[]" id='desc1' style="background-color:transparent; border:transparent" required class="form-control" placeholder='Type input here ...'>
                      </td>
                      <td>
                        <input type="number" max='1000000' step='any' min='0' name="price[]" id='price1' style="background-color:transparent; border:transparent" class="form-control">
                      </td>
                      <td>
                        <input type="number" max='1000000' step='any' min='0' name="amt[]" id='amt1' style="background-color:transparent; border:transparent" class="form-control tprice">
                      </td>
                      <td> 
                        
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <th colspan="3" style="text-align:right">Total Price: </th>     
                    <th colspan="2" style="text-align:right" id=""><input type="text" name="total_price" id='total_price' style="text-align:right; background-color:transparent; border:transparent" class="form-control" readonly value='0.00'></th>               
                  </tfoot>
                </table>
                <button type="button" onclick="add_row()" class="btn btn-success btn-sm" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-plus'></i> &nbsp;Add New Row</button>
                <br><br>
                <button type="submit" id="" name="save_print" class="btn btn-primary" style="float:right; margin-top:2px; margin-bottom: 20px; margin-right:10px"><i class='fa fa-print'></i> &nbsp;Print and Save</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

<Script>
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
  var newRow = "<tr id="+last_id+"><td><input type='text' maxlength='8' name='q[]' id='q"+last_id+"' style=' background-color:transparent; border:transparent' class='form-control' placeholder='Type input here ...'></td><td><input type='text' maxlength='150' name='desc[]' id='desc1' style='background-color:transparent; border:transparent' class='form-control' placeholder='Type input here ...'></td><td><input type='number' max='10000000' min='0' step='any' name='price[]' id='price"+last_id+"' style='background-color:transparent; border:transparent'  class='form-control'></td><td><input  type='number' max='10000000' min='0' step='any' name='amt[]' id='amt"+last_id+"' style='background-color:transparent; border:transparent' class='form-control tprice'></td><td><center><button id='"+last_id+"' onclick='deleterow(this.id)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td></tr>";
  
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
    $('#q'+id).keydown(function (e) {
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

    $('#price'+id).keydown(function (e) {
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

function total(){
var sum = 0;

$( ".tprice" ).each(function() {
  var x = $(this).val().replace(/\,/g,'');
    if(x == ''){
        x = 0;
    }

  sum += parseFloat(x);;
});

$("#total_price").val(sum.toFixed(2));
}

</script>

<?php
}
elseif(isset($_GET['d_so'])){
//if so has already dr record redirect to print dr

$so = $_GET['d_so'];

include 'models/sales_order_model.php';
include 'models/debit_model.php';

$som = new Sales_Order();
$som->set_data($so);

$si = $som->invoice;
$dr = $som->dr;
$comp = $som->name;
$address = $som->address;
$custid = $som->custid;

$c = new Debit();
$c->get_last_id();

$mnum = $c->nxt_mnum;
$f_mnum = sprintf('%05d', $mnum);

$mn = $mnum - 1;
 
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
                <!-- /.card-header -->
        <div class="card-body">
                <form role="form" action="models/debit_model.php?so=<?php echo $so; ?>" method="post" id="form_imp">
                  <!-- text input -->
                  <div class="col-md-6" style="float:left; padding-right: 30px">
                 
                  <div class="col-md-6" style="float:left">
                  <div class="form-group">
                    <label>Memo Number</label>
                    <input type='hidden' name='memonumber' value='<?php echo $mnum; ?>'>
                    <input type='hidden' name='custid' value='<?php echo $custid; ?>'>
                    <input type="text" required readonly name="" value='<?php echo $f_mnum; ?>' maxlength="20" class="form-control" id="inv_input">
                  </div>
                  </div>
                  <div class="col-md-6" style="float:left">
                  <div class="form-group">
                    <label>Date</label>
                    <input type="date" id='dte' required name="date" class="form-control">
                  </div>
                  </div>

                    <div class="col-md-6" style="float:left">
                  <div class="form-group">
                    <label>Invoice Number</label>
                    <input type="text" required readonly name="" value='<?php echo $si; ?>' maxlength="20" class="form-control" id="inv_input">
                  </div>
                  </div>
                  <div class="col-md-6" style="float:left">
                  <div class="form-group">
                    <label>DR Number</label>
                    <input type="text" required readonly name="" value='<?php echo $dr; ?>' maxlength="20" class="form-control" id="inv_input">
                  </div>
                  </div>

                  </div>
                  
                  <div class="col-md-6" style="float:left; padding-left: 30px">
                  
                  <div class="form-group">
                    <label>Credit To</label>
                    <input list="payee_list" name="" readonly value='<?php echo $comp; ?>' class="form-control" maxlength="50">
                  </div>

                  <div class="form-group">
                    <label>Address</label>
                    <input list="payee_list" name="" readonly value='<?php echo $address; ?>' class="form-control" maxlength="50">
                  </div>

                  </div>

                <div style="clear:both; height:15px;"></div>
                <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>

                <table id="modalTbl" style='width:100%' class="table table-bordered table-striped">
                 <thead>
                 <tr>
                      <th style='width:15%'>Quantity</th>
                      <th style='width:50%'>Description</th>
                      <th style='width:15%'>Unit Price</th>
                      <th style='width:15%'>Amount</th
                      <th style='width:5%'></th>
                    </tr>
                 </thead>
                  <tbody id="prod_table">
                  <tr>
                        <td>
                        <input type="text" maxlength='8' name="q[]" id='q1' style=" background-color:transparent; border:transparent" class="form-control" placeholder='Type input here ...'>
                      </td>
                      <td>
                        <input type="text" maxlength='150' name="desc[]" id='desc1' style="background-color:transparent; border:transparent" required class="form-control" placeholder='Type input here ...'>
                      </td>
                      <td>
                        <input type="number" max='1000000' step='any' min='0' name="price[]" id='price1' style="background-color:transparent; border:transparent" class="form-control">
                      </td>
                      <td>
                        <input type="number" max='1000000' step='any' min='0' name="amt[]" id='amt1' style="background-color:transparent; border:transparent" class="form-control tprice">
                      </td>
                      <td> 
                        
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <th colspan="3" style="text-align:right">Total Price: </th>     
                    <th colspan="2" style="text-align:right" id=""><input type="text" name="total_price" id='total_price' style="text-align:right; background-color:transparent; border:transparent" class="form-control" readonly value='0.00'></th>               
                  </tfoot>
                </table>
                <button type="button" onclick="add_row()" class="btn btn-success btn-sm" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-plus'></i> &nbsp;Add New Row</button>
                <br><br>
                <button type="submit" id="" name="save_print" class="btn btn-primary" style="float:right; margin-top:2px; margin-bottom: 20px; margin-right:10px"><i class='fa fa-print'></i> &nbsp;Print and Save</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

<Script>
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
  var newRow = "<tr id="+last_id+"><td><input type='text' maxlength='8' name='q[]' id='q"+last_id+"' style=' background-color:transparent; border:transparent' class='form-control' placeholder='Type input here ...'></td><td><input type='text' maxlength='150' name='desc[]' id='desc1' style='background-color:transparent; border:transparent' class='form-control' placeholder='Type input here ...'></td><td><input type='number' max='10000000' min='0' step='any' name='price[]' id='price"+last_id+"' style='background-color:transparent; border:transparent'  class='form-control'></td><td><input  type='number' max='10000000' min='0' step='any' name='amt[]' id='amt"+last_id+"' style='background-color:transparent; border:transparent' class='form-control tprice'></td><td><center><button id='"+last_id+"' onclick='deleterow(this.id)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td></tr>";
  
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
    $('#q'+id).keydown(function (e) {
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

    $('#price'+id).keydown(function (e) {
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

function total(){
var sum = 0;

$( ".tprice" ).each(function() {
  var x = $(this).val().replace(/\,/g,'');
    if(x == ''){
        x = 0;
    }

  sum += parseFloat(x);;
});

$("#total_price").val(sum.toFixed(2));
}

</script>
<?php
}
elseif(isset($_GET['r_so'])){
$so = $_GET['r_so'];

include 'models/sales_order_model.php';

$som = new Sales_Order();
$som->set_data($so);

$si = $som->invoice;
$dr = $som->dr;
$comp = $som->name;
$address = $som->address;
$custid = $som->custid;
 
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
                <!-- /.card-header -->
        <div class="card-body">
                <form role="form" action="models/rebate_aed.php?so=<?php echo $so; ?>" method="post" id="form_imp">
                  <!-- text input -->
                  <div class="col-md-6" style="float:left; padding-right: 30px">
                 
                  <div class="col-md-12" style="float:left">
                  <div class="form-group">
                    <label>Date</label>
                    <input type="date" id='dte' required name="date" class="form-control">
                    <input type='hidden' name='custid' value='<?php echo $custid; ?>'>
                  </div>
                  </div>

                    <div class="col-md-6" style="float:left">
                  <div class="form-group">
                    <label>Invoice Number</label>
                    <input type="text" required readonly name="" value='<?php echo $si; ?>' maxlength="20" class="form-control" id="inv_input">
                  </div>
                  </div>
                  <div class="col-md-6" style="float:left">
                  <div class="form-group">
                    <label>DR Number</label>
                    <input type="text" required readonly name="" value='<?php echo $dr; ?>' maxlength="20" class="form-control" id="inv_input">
                  </div>
                  </div>

                  </div>
                  
                  <div class="col-md-6" style="float:left; padding-left: 30px">
                  
                  <div class="form-group">
                    <label>Rebate To</label>
                    <input list="payee_list" name="" readonly value='<?php echo $comp; ?>' class="form-control" maxlength="50">
                  </div>

                  <div class="form-group">
                    <label>Address</label>
                    <input list="payee_list" name="" readonly value='<?php echo $address; ?>' class="form-control" maxlength="50">
                  </div>

                  </div>

                <div style="clear:both; height:15px;"></div>
                <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>

                <table id="modalTbl" style='width:100%' class="table table-bordered table-striped">
                 <thead>
                 <tr>
                      <th style='width:15%'>Quantity</th>
                      <th style='width:50%'>Description</th>
                      <th style='width:15%'>Unit Price</th>
                      <th style='width:15%'>Amount</th
                      <th style='width:5%'></th>
                    </tr>
                 </thead>
                  <tbody id="prod_table">
                  <tr>
                        <td>
                        <input type="text" maxlength='8' name="q[]" id='q1' style=" background-color:transparent; border:transparent" class="form-control" placeholder='Type input here ...'>
                      </td>
                      <td>
                        <input type="text" maxlength='150' name="desc[]" id='desc1' style="background-color:transparent; border:transparent" required class="form-control" placeholder='Type input here ...'>
                      </td>
                      <td>
                        <input type="number" max='1000000' step='any' min='0' name="price[]" id='price1' style="background-color:transparent; border:transparent" class="form-control">
                      </td>
                      <td>
                        <input type="number" max='1000000' step='any' min='0' name="amt[]" id='amt1' style="background-color:transparent; border:transparent" class="form-control tprice">
                      </td>
                      <td> 
                        
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <th colspan="3" style="text-align:right">Total Price: </th>     
                    <th colspan="2" style="text-align:right" id=""><input type="text" name="total_price" id='total_price' style="text-align:right; background-color:transparent; border:transparent" class="form-control" readonly value='0.00'></th>               
                  </tfoot>
                </table>
                <button type="button" onclick="add_row()" class="btn btn-success btn-sm" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-plus'></i> &nbsp;Add New Row</button>
                <br><br>
                <button type="submit" id="" name="save_only" class="btn btn-primary" style="float:right; margin-top:2px; margin-bottom: 20px; margin-right:10px"><i class='fa fa-print'></i> &nbsp;Save</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

<Script>
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
  var newRow = "<tr id="+last_id+"><td><input type='text' maxlength='8' name='q[]' id='q"+last_id+"' style=' background-color:transparent; border:transparent' class='form-control' placeholder='Type input here ...'></td><td><input type='text' maxlength='150' name='desc[]' id='desc1' style='background-color:transparent; border:transparent' class='form-control' placeholder='Type input here ...'></td><td><input type='number' max='10000000' min='0' step='any' name='price[]' id='price"+last_id+"' style='background-color:transparent; border:transparent'  class='form-control'></td><td><input  type='number' max='10000000' min='0' step='any' name='amt[]' id='amt"+last_id+"' style='background-color:transparent; border:transparent' class='form-control tprice'></td><td><center><button id='"+last_id+"' onclick='deleterow(this.id)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td></tr>";
  
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
    $('#q'+id).keydown(function (e) {
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

    $('#price'+id).keydown(function (e) {
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

function total(){
var sum = 0;

$( ".tprice" ).each(function() {
  var x = $(this).val().replace(/\,/g,'');
    if(x == ''){
        x = 0;
    }

  sum += parseFloat(x);;
});

$("#total_price").val(sum.toFixed(2));
}

</script>
<?php
}
?>