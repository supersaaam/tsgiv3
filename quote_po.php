<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Transcendo | Quotation Module</title>
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
include 'models/quotation_model.php';
include 'models/supplier_model.php';
include 'models/customer_model.php';
include 'models/terms_sm_model.php';

$cust     = new Customer();
$supplier = new Supplier();
$terms    = new Terms_SM();
$q = new Quotation();
$q->set_data($_GET['id']);
$id = sprintf('%06d', $_GET['id']);
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Purchase Order (from Quotation)
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box">
      <!-- /.card-header -->
      <div class="box-body">

              <form role="form" action="models/so_aed.php" method="post" id="">
                    <!-- text input -->
                    <div class="col-md-6" style="float:left; padding-right: 30px">

                    <div class="form-group" style='float:left; width:48%; margin-right:2%'>
                      <label>Quotation No.</label>
                      <input required name="q_num" value='<?php echo $id; ?>' class="form-control" readonly>
                    </div>
                    
                    <div class="form-group" style='float:left; width:48%; margin-left:2%'>
                      <label>Purchase Order No.</label>
                      <input required name="po" class="form-control">
                    </div>

                   <div class="form-group">
                      <label>Customer </label>
                      <input type='text' required name="customer" id='customer' readonly class="form-control" value='<?php echo $q->company; ?>' placeholder="Please input customer name ...">
                    </div>

                      <?php
                    if($q->deltime != NULL){
                    ?>
                    
                    <tr>
                    <div class="form-group">
                      <label>VAT Type</label>
                      <br>
                      <input name='vat_type' type='radio' value='VAT'
                      
                      <?php
                      if($q->vattype=='VAT'){
                        echo ' checked ';
                      }
                      ?>
                      
                      > &nbsp;VAT
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     <input name='vat_type' type='radio' value='Non-VAT' 
                     
                     <?php
                      if($q->vattype=='Non-VAT'){
                        echo ' checked ';
                      }
                      ?>
                      
                     > &nbsp;Non-VAT
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     <input name='vat_type' type='radio' value='Zero-Rated' 
                     
                     <?php
                      if($q->vattype=='Zero-Rated'){
                        echo ' checked ';
                      }
                      ?>
                      
                     > &nbsp;Zero-Rated
                    </div>
                    </tr>
                    
                    <?php 
                    }
                    ?>
                    
                    </div>

                    <!-- text input -->
                    <div class="col-md-6" style="float:left; padding-right: 30px">
            
                        <div class="form-group" style='float: left; width: 48%; margin-right: 2%'>
                      <label>PO Date</label>
                      <input name="date" type='date' id='dte' class="form-control" required>
                    </div>

                    <div class="form-group" style='float: left; width: 48%; margin-left: 2%'>
                      <label>Delivery Date</label>
                     <input name="del_date" type='date' id='dte_' class="form-control" required>
                    </div>

		   <div class="form-group">
                      <label>Terms of Payment</label>
                      <input list="terms_list" required name="terms"  value='<?php echo $q->terms; ?>' class="form-control" placeholder="Please input terms ...">
                    </div>
                    
                    </div>

                  <div style="clear:both; height:15px;"></div>
                  <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>

                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style='width:15%'>Brand</th>
                        <th style='width:28%'>Description</th>
                        <th style='width:8%'>Our Part #</th>
                        <th style='width:8%'>Yr Part #</th>
                        <th style='width:6%'>UOM</th>
                        <th style='width:6%'>AVL</th>
                        <th style='width:6%'>Qty</th>
                        <th style='width:9%'>Unit Price</th>
                        <th style='width:9%'>Line Total</th>
                        <th style='width:5%'></th>
                      </tr>
                    </thead>
                    <tbody id="trans_table">
                      <?php
                      	$q->show_q_bd($id);
                      ?>
                    </tbody>
                    <tfoot>
                        <tr>
                        <th colspan='8' style='text-align: right'>Discount</th>
                        <td colspan='2'><input type="text" name="" id='discount' style="text-align:left; background-color:transparent; border:transparent" class="form-control" readonly value='<?php echo $q->disc; ?>'></td>
                      </tr>
                      <tr>
                        <th colspan='8' id='vat_desc' style='text-align: right'>Total Sales (VAT Inclusive)</th>
                        <td colspan='2'><input type="text" name="total_price" id='total_price' style="text-align:left; background-color:transparent; border:transparent" class="form-control" readonly value='0.00'></td>
                      </tr>
                      <tr id='vat'>
                        <th colspan='8' style='text-align: right'>Less: VAT</th>
                        <td colspan='2'><input type="text" id='vat_' style="text-align:left; background-color:transparent; border:transparent" class="form-control" readonly value='0.00'></td>
                      </tr>
                      <tr id='vat1'>
                        <th colspan='8' style='text-align: right'>Amount: Net of VAT</th>
                        <td colspan='2'><input type="text" id='net' style="text-align:left; background-color:transparent; border:transparent" class="form-control" readonly value='0.00'></td>
                      </tr>
                      
                    
                    
                    </tfoot>
                  </table>
                  <button type="button" id="add_row" onclick="add_row1()" class="btn btn-success btn-sm" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-plus'></i> &nbsp;Add New Row</button>
                  

                    <div style="clear:both; height:15px;"></div>
                  <button type="submit" name="submit" id="submit_new1" class="btn btn-primary" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Submit</button>
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

                        <datalist id="brand_list">
                          <?php
                            $supplier->show_supplier_dl();
                            ?>
                            <option value='N/A'>
                        </datalist>


			<!-- DATALISTS -->
                      <datalist id="terms_list">
                          <?php
			$terms->show_data_dl();
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
$supplier->show_supplier();
?>

</body>
</html>
<script>	

$(document).ready(function(){
    var vat = '<?php echo $q->vattype; ?>';
    
    if (vat == 'Zero-Rated') {
        $('#vat').hide();
        $('#vat1').hide();
        $("#vat_desc").html('Total Sales (VAT Exclusive)');
    }
    else if (vat == 'Non-VAT') {
        $('#vat').hide();
        $('#vat1').hide();
        $("#vat_desc").html('Total Sales (VAT Exclusive)');
    }
    else if (vat == 'VAT') {
        $('#vat').show();
        $('#vat1').show();
        $("#vat_desc").html('Total Sales (VAT Inclusive)');
    }
});

$('input[type=radio][name=vat_type]').change(function() {
    if (this.value == 'Zero-Rated') {
        $('#vat').hide();
        $('#vat1').hide();
        $("#vat_desc").html('Total Sales (VAT Exclusive)');
    }
    else if (this.value == 'Non-VAT') {
        $('#vat').hide();
        $('#vat1').hide();
        $("#vat_desc").html('Total Sales (VAT Exclusive)');
    }
    else if (this.value == 'VAT') {
        $('#vat').show();
        $('#vat1').show();
        $("#vat_desc").html('Total Sales (VAT Inclusive)');
    }
});

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
    		$("#cperson").html(data);
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
$("#dte_").val(today);

var last_id = '<?php echo $q->ctr; ?>';

  function add_row1(){
  var newRow = "<tr id='tr"+last_id+"'><td><input class='counter' id='"+last_id+"' type='hidden'><input type='hidden' name='brand[]' id='brand_"+last_id+"'><input list='brand_list' id='brand"+last_id+"' maxlength='50' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...'></td><td><input type='hidden' name='productID[]' id='productID"+last_id+"'><input readonly name='product[]' id='product"+last_id+"' maxlength='200' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...'></td><td><input id='ourpartnum" + last_id +"' name='ourpartnum[]' readonly maxlength='200' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...'></td><td><input type='text' name='yourpartnum[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control'></td><td><input type='text' name='uom[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control'></td><td><input type='text' name='avail[]' value='No' id='avail"+last_id+"' readonly style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'></td><td><input type='number' name='quantity[]' id='quan"+last_id+"' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'></td><td><input type='text' id='unitprice"+last_id+"' name='price[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'></td><td><input name='linetotal[]' id='linetotal"+last_id+"' step='any' style='text-align:right;background-color:transparent; border:transparent' min='0' class='form-control tprice' readonly required type='text'></td><td><center><button id='"+last_id+"' onclick='deleterow(this.id)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td></tr>";

  $("#trans_table").append(newRow);

    //Dynamically add functions from here

    add_function(last_id);

  last_id+=1;

  var rowCount = $('#example2 tr').length - 2;
  if(rowCount != 0){
      $("#submit_new1").attr('disabled', false);
  }
}

$("textarea").keydown(function(e) {
    if(e.keyCode === 9) { // tab was pressed
        // get caret position/selection
        var start = this.selectionStart;
        var end = this.selectionEnd;

        var $this = $(this);
        var value = $this.val();

        // set textarea value to: text before caret + tab + text after caret
        $this.val(value.substring(0, start)
                    + "\t"
                    + value.substring(end));

        // put caret at right position again (add one for the tab)
        this.selectionStart = this.selectionEnd = start + 1;

        // prevent the focus lose
        e.preventDefault();
    }
});


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

$("#brand1").on('change', function(){
    $("#product1").attr('readonly', false);
    $(this).attr('disabled', true);
    $("#brand_1").val($(this).val());
    $("#product1").attr('list', $(this).val());
    $("#ourpartnum1").attr('list', 'pn_'+$(this).val());
    $("#ourpartnum1").attr('readonly', false);
});

$("#quan1").bind('keyup', function(){
    var quan = $(this).val();
    var productID = $("#productID1").val();

    $.ajax({
        url: 'models/ajax_qty.php',
        type: 'post',
        data:{
            quan: quan,
            productID: productID
        },
        success: function(data){
            //update availability
            $("#avail1").val(data);
        }
    });
});

$("#product1").on('change', function(){
    var productName = $(this).val();
    var brand = $("#brand1").val();

    $.ajax({
        url: 'models/ajax_quote.php',
        type: 'post',
        data:{
            productName: productName,
            brand: brand
        },
        success:function(data){
            if(data != '###'){
                $("#product1").attr('readonly', true);
                var res = data.split('#');
                $("#productID1").val(res[0]);
                $("#ourpartnum1").val(res[1]);
                $("#ourpartnum1").attr('readonly', true);
                if(res[3] > 0){
                    $("#avail1").val('Yes');
                }
                $("#unitprice1").val(res[2]);
            }
        }
    });
});

function deleterow(id){
  $("#tr"+id).remove();
  total();

  var rowCount = $('#example2 tr').length - 2;
  if(rowCount == 0){
      $("#submit_new1").attr('disabled', true);
  }
}

$("#ourpartnum1").on('change', function(){
    var pn = $(this).val();
    var brand = $("#brand1").val();

    $.ajax({
        url: 'models/ajax_quote_pn.php',
        type: 'post',
        data:{
            pn: pn,
            brand: brand
        },
        success:function(data){
            if(data != '###'){
                $("#ourpartnum1").attr('readonly', true);
                var res = data.split('#');
                $("#productID1").val(res[0]);
                $("#product1").val(res[1]);
                $("#product1").attr('readonly', true);
                if(res[3] > 0){
                    $("#avail1").val('Yes');
                }
                $("#unitprice1").val(res[2]);
            }
        }
    });
});

function add_function(id){
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

    $('#unitprice'+id).keydown(function (e) {
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

      $('#unitprice'+id).keyup(function (e) {
        multiply(id);
      });

      $('#quan'+id).keyup(function (e) {
        multiply(id);
      });

      $("#brand"+id).on('change', function(){
        $("#product"+id).attr('readonly', false);
        $(this).attr('disabled', true);
        $("#brand_"+id).val($(this).val());
        $("#product"+id).attr('list', $(this).val());
        $("#ourpartnum"+id).attr('list', 'pn_'+$(this).val());
        $("#ourpartnum"+id).attr('readonly', false);
    });

    $("#product"+id).on('change', function(){
        var productName = $(this).val();
        var brand = $("#brand"+id).val();

        $.ajax({
            url: 'models/ajax_quote.php',
            type: 'post',
            data:{
                productName: productName,
                brand: brand
            },
            success:function(data){
                //get productID
                //get partNum
                //get Availability
                //get Price
                if(data != '###'){
                    $("#product"+id).attr('readonly', true);
                    var res = data.split('#');
                    $("#productID"+id).val(res[0]);
                    $("#ourpartnum"+id).val(res[1]);
                    $("#ourpartnum"+id).attr('readonly', true);
                    if(res[3] > 0){
                        $("#avail"+id).val('Yes');
                    }
                    $("#unitprice"+id).val(res[2]);
                }
            }
        });
    });
    
    $("#ourpartnum"+id).on('change', function(){
    var pn = $(this).val();
    var brand = $("#brand"+id).val();

    $.ajax({
        url: 'models/ajax_quote_pn.php',
        type: 'post',
        data:{
            pn: pn,
            brand: brand
        },
        success:function(data){
            if(data != '###'){
                $("#ourpartnum"+id).attr('readonly', true);
                var res = data.split('#');
                $("#productID"+id).val(res[0]);
                $("#product"+id).val(res[1]);
                $("#product"+id).attr('readonly', true);
                if(res[3] > 0){
                    $("#avail"+id).val('Yes');
                }
                $("#unitprice"+id).val(res[2]);
            }
        }
    });
    });
}


function multiply(id){
  var quan_ = ($("#quan"+id).val()).replace(/\,/g,'');
  var price_ = ($("#unitprice"+id).val()).replace(/\,/g,'');

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
  
  $("#linetotal"+id).val(pr);

  total();
}

$(document).ready(function(){
	total();
});

function total(){
  var sum = 0;

  var disc = $("#disc")
  $( ".tprice" ).each(function() {
    if($(this).val() == ''){
      var x = 0;
    }
    else{
      var x = $(this).val().replace(/\,/g,'');
    }
    sum += parseFloat(x);;
  });
  
  sum -= parseFloat('<?php echo $q->disc; ?>');
  
  var net = format(sum/1.12);
  var vat = format(sum - (sum/1.12));
  var sum_ = format(sum);

  $("#net").val(net);
  $("#vat_").val(vat);
  $("#total_price").val(sum_);
}

function format(n, sep, decimals) {
    sep = sep || "."; // Default to period as decimal separator
    decimals = decimals || 2; // Default to 2 decimals

    return n.toLocaleString().split(sep)[0]
        + sep
        + n.toFixed(decimals).split(sep)[1];
}

function check(){
  var arr = [];

  $(".counter").each(function(){
      var id = $(this).attr('id');
      var prod_code = $("#product"+id).val();

      if(prod_code != ''){
        arr.push(prod_code);
      }
  });

  if(hasDuplicates(arr)){
    swal('Validation', 'Products should be distinct. Check your inputs.', 'warning');
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
</script>
