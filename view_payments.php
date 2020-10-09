<?php
include 'models/sales_order_model.php';
include 'models/payment_model.php';
include 'models/misc_model.php';

$misc    = new Misc();
$so      = new Sales_Order();
$payment = new Payment();
$id      = $_GET['so'];
$so->set_data($id);

$payment->get_total_payment($id);
?>

              <!-- /.card-header -->
              <div class="card-body">
                <?php
if ($so->balance > 0) {
  ?>
                <form role="form" action="models/payment_model.php" method="post" id="imp_form">
                  <!-- text input -->
                  <div class="col-md-6" style="float:left; padding-right: 30px">

                  <div class="form-group">
                    <label>Customer</label>
                    <input type='hidden' name="customerid" class="form-control" value='<?php echo $so->custid; ?>'>
                    <input type='text' required name="" class="form-control" readonly value='<?php echo $so->name; ?>'>
                  </div>

                  <div class="form-group" style='float:left; margin-right: 2%; width:48%'>
                    <label>Provisional Rec. No.</label>
                    <input type='text' maxlength='15' name="pr" class="form-control" placeholder='Type input here...'>
                </div>

                  <div class="form-group" style='float:left; margin-left: 2%; width:48%'>
                    <label>PR Date</label>
                    <input type="date" required name="pr_date" id='pr_dte' class="form-control">
                  </div>

                    <div class="form-group" style='float:left; margin-right: 5%; width:68%'>
                    <label>Bank Name</label>
                    <input type='text' maxlength='50' required name="bank" class="form-control" placeholder='Type input here...'>
                  </div>

                  <div class="form-group" style='float:left; margin-right: 2%; width:25%'>
                    <label>Post Dated:</label>
                    <br>
                    <input type='radio' name="post_dated" value='YES'> Yes
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name="post_dated" checked value='NO'> No
                  </div>

                  <div class="form-group" style='float:left; margin-right: 2%; width:48%'>
                    <label>Check Number</label>
                    <input type='text' maxlength='20' required name="check" class="form-control" placeholder='Type input here...'>
                  </div>

                  <div class="form-group" style='float:left; margin-left: 2%; width:48%'>
                    <label>Check Date</label>
                    <input type="date" required name="check_date" id='' class="form-control">
                  </div>

                  </div>

                  <div class="col-md-6" style="float:left; padding-left: 30px">

                  <div class="form-group" style='float:left; margin-right: 3%; width:31.3%'>
                    <label>Sales Order No.</label>
                    <input type='text' required name="so" class="form-control" readonly value='<?php echo sprintf('%06d', $id); ?>'>
                  </div>

                  <div class="form-group" style='float:left; margin-right: 3%; width:31.3%'>
                    <label>Sales Inv. No.</label>
                    <input type='text' required name="" class="form-control" readonly value='<?php echo $so->invoice ?>'>
                  </div>

                  <div class="form-group" style='float:left; width:31.3%'>
                    <label>Delivery Rec. No.</label>
                    <input type='text' required name="" class="form-control" readonly value='<?php echo $so->dr; ?>'>
                  </div>

                  <div class="form-group" style='float:left; margin-right: 2%; width:48%'>
                    <label>Collection Rec. No.</label>
                    <input type='text' maxlength='15' name="cr" class="form-control" placeholder='Type input here...'>
                </div>

                  <div class="form-group" style='float:left; margin-left: 2%; width:48%'>
                    <label>CR Date</label>
                    <input type="date" name="cr_date" id='cr_dte' class="form-control">
                </div>

                  <div class="form-group" style='float:left; margin-right: 2%; width:48%'>
                    <label>Date Received</label>
                    <input type="date" required name="date_rec" id='' class="form-control">
                </div>

                  <div class="form-group" style='float:left; margin-left: 2%; width:48%'>
                    <label>Date Deposited</label>
                    <input type="date" required name="date_dep" id='' class="form-control">
                  </div>


                <div class="form-group" style='float:left; margin-left: 2%; width:48%'>
                  <label>Total Amount Due</label>
                  <input type='text' step='any' required name="" class="form-control" readonly value='<?php echo $so->total; ?>'>
                </div>


                <div class="form-group" style='float:left; margin-left: 2%; width:48%'>
                  <label>Total Amount Paid</label>
                  <input type='text' required name="" class="form-control" readonly value='<?php echo $payment->sum; ?>'>
                </div>

                  </div>

                <div style="clear:both; height:15px;"></div>

                <!-- text input -->
                <div class="col-md-6" style="float:left; padding-right: 30px">

                </div>

                <div style="clear:both; height:15px;"></div>

                <table id="example2" style='width: 70%; margin: 0 auto;' class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style='width:50%'>Miscellaneous Fee</th>
                        <th style='width:45%'>Amount</th>
                        <th style='width:5%'></th>
                      </tr>
                    </thead>
                    <tbody id="trans_table">
                      <tr id='tr1'>
                      <td>
                          <input class='counter' id='1' type='hidden'>
                          <input list="misc_list" name="misc[]" id='misc1' maxlength='50' style="background-color:transparent; border:transparent; width:95%" class="form-control" placeholder="Type here ...">
                        </td>
                      <td>
                          <input name="amount[]" id='amount1' style="text-align:right;background-color:transparent; border:transparent" class="form-control tprice" type='number' step='any' min='0' max='1000000'>
                        </td>
                        <td></td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th style='text-align: right'>Total Amount:</th>
                        <td><input type="text" name="total_price" id='total_price' style="text-align:left; background-color:transparent; border:transparent" class="form-control" readonly value='0.00'></td>
                        <td></td>
                      </tr>
                      <tr>
                      <center>
                    <td colspan='3'><button type="button" id="add_row" onclick="add_row1()" class="btn btn-success btn-sm" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-plus'></i> &nbsp;Add New Row</button></td>
                      </center>
                      </tr>
                    </tfoot>
                  </table>



                <div class="col-md-6" style="float:left; padding-left: 30px">

                <div class="form-group">
                  <label>Remaining Balance</label>
                  <input type='text' required name="" class="form-control" id='balance' readonly value='<?php echo $so->balance; ?>'>
                </div>
                </div>
                <div class="col-md-6" style="float:left; padding-left: 30px">

                <div class="form-group">
                  <label>Amount Received</label>
                  <input type='number' step='any' onkeypress="return isNumberKey(event)" min='1' required name="amt_rec" id='paid' class="form-control" placeholder='Type input here...'>
                </div>

                </div>


                  <br>
                  <br>
                  <button type="submit" name="save" id="print_dr" class="btn btn-primary" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Payment</button>
                  <br>
                  <br>
                  <br>
                </form>
                <?php
}
?>
              </div>
              <!-- /.card-body -->

                        <datalist id="misc_list">
                          <?php
$misc->show_misc();
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
$("#pr_dte").val(today);
$("#cr_dte").val(today);

var last_id = 2;

function add_row1(){
var newRow = "<tr id='tr"+last_id+"'><td><input class='counter' id='"+last_id+"' type='hidden'><input list='misc_list' name='misc[]' id='misc"+last_id+"' maxlength='50' style='background-color:transparent; border:transparent; width:95%' class='form-control' placeholder='Type here ...'></td><td><input name='amount[]' id='amount"+last_id+"' style='text-align:right;background-color:transparent; border:transparent' class='form-control tprice' type='number' step='any' min='0' max='1000000'></td><td><center><button id='"+last_id+"' onclick='deleterow(this.id)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td></tr>";

$("#trans_table").append(newRow);

  //Dynamically add functions from here

  add_function(last_id);

last_id+=1;
}

function deleterow(id){
  $("#tr"+id).remove();
  total();
}

var balance = $("#balance").val();

function total(){
  var sum = 0;

  $( ".tprice" ).each(function() {
    if($(this).val() == ''){
      var x = 0;
    }
    else{
      var x = $(this).val().replace(/\,/g,'');
    }
    sum += parseFloat(x);;
  });

  //var sum_ = format(sum);

  $("#total_price").val(sum);

  var misc = parseFloat($("#total_price").val());
  var paid = parseFloat($("#paid").val());
  var min = balance - misc;

  $("#paid").attr('max', min);
  $("#paid").attr('min', 0);

  $("#balance").val(min)
}

function add_function(id){
  $('#amount'+id).keydown(function (e) {
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

        total();
      });

      $('#amount'+id).keyup(function (e) {
        total();
      });
}

var length = $("#example2 tr").length;
  length = parseInt(length) - 2;

$(document).ready(function() {
  for (i = 1; i <= length; i++){
      add_function(i);
    }
});

function isNumberKey(evt){
          var charCode = (evt.which) ? evt.which : event.keyCode
          if (charCode > 31 && (charCode < 48 || charCode > 57))
              return false;
          return true;
    }
</script>
