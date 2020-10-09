<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Agrimate | Sales Module</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <?php
include 'css.php';
?>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php
include 'header.php';
include 'aside.php';
include 'models/sales_order_model.php';
include 'models/customer_model.php';
include 'models/warehouse_model.php';
include 'models/actual_prod_model.php';
include 'models/terms_sm_model.php';
include 'models/cmo_model.php';

$cmo      = new CMO();
$terms    = new Terms_SM();
$act_prod = new Actual_Prod();
$wh       = new Warehouse();
$cust     = new Customer();
$so       = new Sales_Order();
$so->get_last_so();
$id = sprintf('%06d', $so->last_so);
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Generate Sales Order
        <small>Sales and Marketing</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box">
      <!-- /.card-header -->
      <div class="box-body">

              <form role="form" action="models/sales_order_model.php" method="post" id="">
                    <!-- text input -->
                    <div class="col-md-6" style="float:left; padding-right: 30px">

                    <div class="form-group">
                      <label>Sales Order No.</label>
                      <input required name="so_num" value='<?php echo $id; ?>' class="form-control" readonly>
                    </div>

                   <div class="form-group">
                      <label>Customer </label>
                      <input list="customer_list" required name="customer" id='customer' class="form-control" placeholder="Please input customer name ...">
                    </div>

                    <div class="form-group">
                      <label>Address</label>
                      <input required name="address" id='address' class="form-control">
                    </div>

                    <div class="col-md-6" style="float:left">
                    <div class="form-group">
                      <label>CMO</label>
                      <input list="cmo_list" required name="cmo1" id='cmo1' class="form-control" placeholder="Please input CMO name ...">
                    </div>
                    </div>
                    <div class="col-md-6" style="float:left">
                    <div class="form-group">
                      <label id='share'>Share</label>
                      <input type="number" min='0' name="share1" class="form-control" id="share1">
                    </div>
                    </div>

                    <div class="col-md-6" style="float:left">
                    <div class="form-group">
                      <input list="cmo_list" name="cmo2" id='cmo2' class="form-control" placeholder="Please input CMO name ...">
                    </div>
                    </div>
                    <div class="col-md-6" style="float:left">
                    <div class="form-group">
                      <input type="number"  min='0' name="share2" class="form-control" id="share2">
                    </div>
                    </div>

                    </div>

                    <!-- text input -->
                    <div class="col-md-6" style="float:left; padding-right: 30px">

                    <div class="form-group">
                      <label>Purchase Order No.</label>
                      <input name="po_num" class="form-control" maxlength='10' type='text' placeholder="Please input Purchase Order Number ..." >
                    </div>



                    <div class="form-group" style='float: right; width: 33%; margin-left:2%'>
                      <label>Date</label>
                      <input name="date" type='date' id='dte' class="form-control" required>
                    </div>

                    <div class="form-group" style='float: right; width: 63%; margin-right:2%'>
                      <label>Terms</label>
                      <input list="terms_list" required name="terms"  class="form-control" placeholder="Please input terms ...">
                    </div>

                    <div class="form-group">
                      <label>Warehouse</label>
                      <select class="form-control" required name="origin" id="origin">
                        <?php
$wh->show_data_select();
?>
                      </select>
                    </div>

                    <!-- textarea -->
                    <div class="form-group">
                      <label>Delivery Instructions</label>
                      <textarea class="form-control" name="instruction" maxlength="200" rows="3" style="resize:none" placeholder="Input delivery instruction ..."></textarea>
                    </div>

                    </div>

                  <div style="clear:both; height:15px;"></div>
                  <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>

                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style='width:30%'>Product Code</th>
                        <th style='width:12%'>Quantity</th>
                        <th style='width:20%'>Unit Price</th>
                        <th style='width:20%'>Amount</th>
                        <th style='width:11%'><small><b>for testing</small></b></th>
                        <th style='width:6%'></th>
                      </tr>
                    </thead>
                    <tbody id="trans_table">
                      <tr id='tr1'>
                      <td>
                          <input class='counter' id='1' type='hidden'>
                          <input list="prodcode_list" name="prod_code[]" id='code1' maxlength='50' title="Refer to the data list..." style="background-color:transparent; border:transparent; width:95%" class="form-control" required placeholder="Type here ...">
                        </td>
                        <td>
                          <input type="number" min='0' name="quantity[]" id='quan1' style="text-align:right; background-color:transparent; border:transparent; width:100%" required class="form-control num" placeholder='0'>
                        </td>
                      <td>
                          <input name="price[]" id='price1' step='any' style="text-align:right;background-color:transparent; border:transparent" min='0' class="form-control" required type='number'>
                        </td>
                      <td>
                          <input name="amount[]" id='amount1' style="text-align:right;background-color:transparent; border:transparent" readonly class="form-control tprice" required type='text'>
                        </td>
                        <td>
                        <center>
                          <input type="checkbox" name="testing[]" id='pack1' onclick='free(1)'>
                        </center>
                        </td>
                        <td></td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan='3' style='text-align: right'>Total Amount:</th>
                        <td colspan='2'><input type="text" name="total_price" id='total_price' style="text-align:left; background-color:transparent; border:transparent" class="form-control" readonly value='0.00'></td>
                        <td></td>
                      </tr>
                    </tfoot>
                  </table>
                  <button type="button" id="add_row" onclick="add_row1()" class="btn btn-success btn-sm" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-plus'></i> &nbsp;Add New Row</button>
                  <br><br><br>
                  <div id='note' style='visibility: visible; clear:both; float:right; width:300px'>
                  <small><b>Note: </b>Only the first row will be saved if there are 2 CMOs selected since there will be sharing of the quantity purchased by the customer.</small>
                  </div>
                  <br><br><br><br>
                  <button type="submit" onclick='return check()' name="submit" id="submit_new1" class="btn btn-primary" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Submit</button>
                </form>

              </div>
              </div>
              <!-- /.card-body -->
    </section>
    <!-- /.content -->
  </div>

                        <!-- DATALISTS -->
                        <datalist id="customer_list">
                          <?php
$cust->show_data_dl();
?>
                        </datalist>

                        <!-- DATALISTS -->
                      <datalist id="terms_list">
                          <?php
$terms->show_data_dl();
?>
                        </datalist>

                        <datalist id="prodcode_list">
                          <?php
$act_prod->show_data_dl();
?>
                        </datalist>

                        <datalist id="cmo_list">
                          <?php
$cmo->show_data_dl();
?>
                        </datalist>

  <?php
include 'footer.php';
?>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php
include 'js.php';
?>

</body>
</html>
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

$("#customer").on('change', function () {
      var cust = $(this).val();

      $.ajax({
        url: 'models/ajax_sales.php',
        type: 'post',
        data: {
          cust: cust
        },
        success: function(data){
          var res = data.split(';');
          $('#address').val(res[0]);

          var cmo = res[1];
          var cmo_ = cmo.split('*');

          if (typeof cmo_[1] !== 'undefined') {
            //2 cmos
            $("#share").attr('style', 'visibility:visible');
            $("#cmo2").val(cmo_[1]);
            $('#cmo1').val(cmo_[0]);
            $("#cmo2").attr('type', 'text');
            $("#share1").attr('type', 'number');
            $("#share2").attr('type', 'number');
          }
          else if(cmo_[0] !== '' && typeof cmo_[1] === 'undefined'){ //1 cmo
            $("#share").attr('style', 'visibility:visible');
            $("#cmo2").val('');
            $('#cmo1').val(cmo_[0]);
            $("#cmo2").attr('type', 'text');
            $("#share1").attr('type', 'number');
            $("#share2").attr('type', 'number');
          }
          else{ //no cmo
            $("#share").attr('style', 'visibility:visible');
            $("#cmo2").val('');
            $("#cmo1").val('');
            $("#cmo2").attr('type', 'text');
            $("#cmo1").attr('type', 'text');
            $("#share1").attr('type', 'number');
            $("#share2").attr('type', 'number');
          }
        }
      });
  });

var last_id = 2;

  function add_row1(){
  var newRow = "<tr id='tr"+last_id+"'><td><input class='counter' id='"+last_id+"' type='hidden'><input list='prodcode_list' name='prod_code[]' id='code"+last_id+"' maxlength='50' pattern='<?php echo $act_prod->show_code_list(); ?>' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' placeholder='Type here ...'></td><td><input type='number' min='0' name='quantity[]' id='quan"+last_id+"' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control num' placeholder='0'></td><td><input name='price[]' step='any' id='price"+last_id+"' min='0' style='text-align:right;background-color:transparent; border:transparent' class='form-control' type='number'></td><td><input name='amount[]' id='amount"+last_id+"' style='text-align:right;background-color:transparent; border:transparent' class='form-control tprice' readonly type='text'></td><td> <center><input type='checkbox' name='testing[]' id='pack"+last_id+"' onclick='free("+last_id+")'></center></td><td><center><button id='"+last_id+"' onclick='deleterow(this.id)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td></tr>";

  $("#trans_table").append(newRow);

    //Dynamically add functions from here

    add_function(last_id);

  last_id+=1;
}
</script>

<script>
$(document).ready(function() {
  var table = $('#example2').DataTable( {
        info: false,
        sort: false,
        paging: false,
        searching: false
    } );

     var length = (table
         .column( 0 )
         .data()
         .length);

  for (i = 1; i <= length; i++){
      add_function(i);
    }
});

function deleterow(id){
  $("#tr"+id).remove();
  total();
}

function add_function(id){
  $("#code"+id).on('change', function () {
      var code = $(this).val();
      var wh_id = $("#origin").val();

      $.ajax({
        url: 'models/ajax_sales.php',
        type: 'post',
        data: {
          code: code,
          wh_id: wh_id
        },
        success: function(data){
            var res = data.split(';');
            var price = res[0];
            var stock = res[1];

            $("#price"+id).val(price);
            $("#quan"+id).attr('placeholder', 'On stock: '+stock);
            $("#quan"+id).attr('max', stock);

            //set placeholder and max of quan col
            //set value of unit price
        }
      });

  });

  $('#quan'+id).keydown(function (e) {
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

        var x = $('#quan'+id).val();

        if($(this).val().length > 6){
          return false;
        }

        multiply(id);
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

        var x = $('#price'+id).val();

        if($(this).val().length > 6){
          return false;
        }

        multiply(id);
      });

      $('#price'+id).keyup(function (e) {
        multiply(id);
      });

      $('#quan'+id).keyup(function (e) {
        multiply(id);
      });
}

function multiply(id){
  var quan_ = ($("#quan"+id).val()).replace(/\,/g,'');
  var price_ = ($("#price"+id).val()).replace(/\,/g,'');

  var quan = parseFloat(quan_);
  var price = parseFloat(price_);

  if(isNaN(quan)){
    quan = 0;
  }

  if(isNaN(price)){
    price = 0;
  }

  var prod = quan * price;
  var pr = format(prod);

  $("#amount"+id).val(pr);

  total();
}

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

  var sum_ = format(sum);

  $("#total_price").val(sum_);
}

function format(n, sep, decimals) {
    sep = sep || "."; // Default to period as decimal separator
    decimals = decimals || 2; // Default to 2 decimals

    return n.toLocaleString().split(sep)[0]
        + sep
        + n.toFixed(decimals).split(sep)[1];
}

$("#origin").change(function (){
  var orig = $(this).val();

  $(".counter").each(function(){
      var id = $(this).attr('id');
      var prod_code = $("#code"+id).val();

      if(prod_code != ''){
        //ajax to check stock
        $.ajax({
          url: 'models/ajax_sales.php',
          type: 'post',
          data: {
            orig: orig,
            prod_code: prod_code
          },
          success: function(data){
            //update placeholder of quan
            $("#quan"+id).attr('placeholder', 'On Stock: '+data);

            //update max of quan
            $("#quan"+id).attr('max', data);
          }
        });
      }
  });
});


function free(id){
  //-if checked ->amount = 0
  if (document.getElementById('pack'+id).checked)
  {
    $("#amount"+id).val('0.00');
    total();
  } else {
    multiply(id);
  }
}

function check(){
  var arr = [];

  $(".counter").each(function(){
      var id = $(this).attr('id');
      var prod_code = $("#code"+id).val();

      if(prod_code != ''){
        arr.push(prod_code);
      }
  });

  var cmo1 = $("#cmo1").val();
  var cmo2 = $("#cmo2").val()

  if(cmo1 != '' && cmo2 != ''){
    $("#share1").attr('required', true);
    $("#share2").attr('required', true);
  }
  else{
    $("#share1").attr('required', false);
    $("#share2").attr('required', false);
  }

  if(hasDuplicates(arr)){
    swal('Validation', 'Product codes should be distinct. Check your inputs.', 'warning');
    return false;
  }
  else if(cmo1 == cmo2 && cmo1 != '' && cmo2 != ''){
    swal('Validation', 'CMOs should be distinct. Check your inputs.', 'warning');
    return false;
  }
  else{
    return true;
  }
}

function hasDuplicates(array) {
    var valuesSoFar = Object.create(null);
    for (var i = 0; i < array.length; ++i) {
        var value = array[i];
        if (value in valuesSoFar) {
            return true;
        }
        valuesSoFar[value] = true;
    }
    return false;
}

<?php
if (isset($_GET['success'])) {
  ?>
    swal("Success", "Successfully recorded sales order.", "success");
    history.pushState(null, null, 'sales');
<?php
}
?>
</script>
