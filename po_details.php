<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Transcendo | Sales Order Module</title>
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
include 'models/so_model.php';
include 'models/po_attachment_model.php';

$so = new SO();
$id = $_GET['id'];
$so->set_data($id);
$att = new Attachment();

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sales Order Details
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

                    <div class="form-group" style='float:left; width:33%; margin-right:2%'>
                      <label>Sales Order No.</label>
                      <input required name="q_num" value='<?php echo sprintf("%06d", $id); ?>' class="form-control" readonly>
                    </div>
                    
                    <div class="form-group" style='float:left; width:33%; margin-right:2%'>
                      <label>Purchase Order No.</label>
                      <input required name="po" value='<?php echo $so->ponum; ?>' readonly class="form-control">
                    </div>
                    
                    <div class="form-group" style='float:left; width:30%;'>
                      <label>Quotation No.</label>
                      <br>
                      <input required name="" value='<?php echo $so->qid; ?>' readonly class="form-control" style='width: 40%; float: left'>
                      
                      <a href='quote_pdf?id=<?php echo $so->qid; ?>' target='_new'>
		                <button class='btn btn-success btn-xs' type='button' style='float: right'><i class='fa fa-file-pdf-o'></i>&nbsp; View Quote</button>
		                </a>
		                
                    </div>

                   <div class="form-group">
                      <label>Customer </label>
                      <input type='text' required name="customer" id='customer' readonly class="form-control" value='<?php echo $so->company; ?>' placeholder="Please input customer name ...">
                    </div>

                    </div>

                    <!-- text input -->
                    <div class="col-md-6" style="float:left; padding-right: 30px">
            
                        <div class="form-group" style='float: left; width: 48%; margin-right: 2%'>
                      <label>PO Date</label>
                      <input name="date" type='date' value='<?php echo $so->podate; ?>' readonly class="form-control" required>
                    </div>

                    <div class="form-group" style='float: left; width: 48%; margin-left: 2%'>
                      <label>Delivery Date</label>
                     <input name="del_date" type='date' value='<?php echo $so->deldate; ?>' readonly class="form-control" required>
                    </div>

		   <div class="form-group">
                      <label>Terms of Payment</label>
                      <input list="terms_list" required name="terms" value='<?php echo $so->terms; ?>' readonly class="form-control" placeholder="Please input terms ...">
                    </div>
                    
                    </div>

                  <div style="clear:both; height:15px;"></div>
                  <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>

                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style='width:38%'>Description</th>
                        <th style='width:10%'>Part Number</th>
                        <th style='width:6%'>UOM</th>
                        <th style='width:6%'>AVL</th>
                        <th style='width:11%'>Qty Ordered</th>
                        <th style='width:11%'>Qty Delivered</th>
                        <th style='width:9%'>Unit Price</th>
                        <th style='width:9%'>Line Total</th>
                      </tr>
                    </thead>
                    <tbody id="trans_table">
                      <?php
                      	$so->show_q_bd($id);
                      ?>
                    </tbody>
                    <tfoot>
                        
                      <tr>
                        <th colspan='7' style='text-align: right'>Discount</th>
                        <td colspan='2'><input type="text" name="" id='discount' style="text-align:left; background-color:transparent; border:transparent" class="form-control" readonly value='<?php echo $so->disc; ?>'></td>
                      </tr>
                      <tr>
                        <th colspan='7' id='vat_desc' style='text-align: right'>Total Sales (VAT Inclusive)</th>
                        <td colspan='2'><input type="text" name="total_price" id='total_price' style="text-align:left; background-color:transparent; border:transparent" class="form-control" readonly value='0.00'></td>
                      </tr>
                      <tr id='vat'>
                        <th colspan='7' style='text-align: right'>Less: VAT</th>
                        <td colspan='2'><input type="text" id='vat_' style="text-align:left; background-color:transparent; border:transparent" class="form-control" readonly value='0.00'></td>
                      </tr>
                      <tr id='vat1'>
                        <th colspan='7' style='text-align: right'>Amount: Net of VAT</th>
                        <td colspan='2'><input type="text" id='net' style="text-align:left; background-color:transparent; border:transparent" class="form-control" readonly value='0.00'></td>
                      </tr>
                    </tfoot>
                  </table>
                
                    <div style="clear:both; height:15px;"></div>
                    
                    <?php
                    if($so->si_return == null){
                        if($so->delivered_all != 'YES'){
                    ?>
                    
                  <a href='javascript:void(0);' data-href='view_pr.php?pr=<?php echo $id; ?>' id='genPR'><button type="button"  name="submit" id="" class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-file'></i> &nbsp;Generate PR</button></a>
                  
                  <?php
                        }
                    else{
                   ?>
                   
                    <button type="button" disabled name="" id="" class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-file'></i> &nbsp;Generate PR</button>
                    
                   <?php
                    }
                  
                    if($so->delivered_all != 'YES'){
                  ?>
                  <button type="button" name="submit" disabled id="" class="btn btn-primary" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-file'></i> &nbsp;Generate SI</button>
                  <?php
                    }
                    else{
                ?>
                    <a href='print_si.php?so=<?php echo $id; ?>'><button type="button" name="submit" id="" class="btn btn-primary" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-file'></i> &nbsp;Generate SI</button></a>
                  <?php
                    }
                  ?>
                  
                  <a href='javascript:void(0);' data-href='view_dr.php?id=<?php echo $id; ?>' id='genDR'><button type="button"  name="submit" id="" class="btn btn-info" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-file'></i> &nbsp;Generate DR</button></a>
                  
                  <a href='javascript:void(0);' data-href='view_pl.php?id=<?php echo $id; ?>' id='genPL'><button type="button"  name="submit" id="" class="btn btn-warning" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-file'></i> &nbsp;Generate Pick List</button></a>
                  
                  <?php
                  }
                  ?>
                </form>

              </div>
              </div>
              <!-- /.card-body -->
    </section>
    <!-- /.content -->
    
    
    
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Document Attachments
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class='box'>
    <div class='box-body'>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:80%'>File Name</th>
                  <th style='width:20%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                	$att->show_data($id);
               
                ?>
                </tbody>
              </table>


		
    <div class='clearfix' style='clear:both; height:50px'></div>
    <div style='float:right'>
    <form method='post' id="form" action='models/po_attachment_model.php' enctype='multipart/form-data'>
     
    <input type="hidden" value="<?php echo $id; ?>" name="id">
    <input id="file-upload" name="docs[]" type="file" multiple="multiple" style='float:left'/>
     <button type='submit' class='btn btn-success' style='float:left; margin-left: 100px'><i class='fa fa-save'></i>&nbsp;&nbsp;Save</button>
    </form>
    </div>
    
            </div>
            </div>
            
    </section>
    <!-- /.content -->
    
    
    
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      DR Records
      </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
    <div class='box'>
    <div class='box-body'>
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:10%'>Control Number</th>
                  <th style='width:10%'>DR Number</th>
                  <th style='width:20%'>Date Generated</th>
                  <th style='width:20%'>Date Returned</th>
                  <th style='width:50%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                	$so->show_dr($id);
                ?>
                </tbody>
              </table>
            </div>
            </div>
    </section>
    <!-- /.content -->
    
    <!-- Content Header (Page header) -->
    <section class="content-header" style='margin-top: -50px'>
      <h1>
      Payment Records
      </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
    <div class='box'>
        
        
                    <?php
                    if($so->si_return != null && $so->bal > 0){
                    ?>
                    
                <a href='javascript:void(0);' data-href='view_cr.php?so=<?php echo $id; ?>' id='genCR'><button type="button"  name="submit" id="" class="btn btn-success" style="float:right; margin-top:20px; margin-bottom:20px; margin-right:20px"><i class='fa fa-file'></i> &nbsp;Generate CR</button></a>
        
                    <?php
                    }
                    else{
                      ?>
                      
                      <button type="button" disabled  name="submit" id="" class="btn btn-success" style="float:right; margin-top:20px; margin-bottom:20px; margin-right:20px"><i class='fa fa-file'></i> &nbsp;Generate CR</button>
                      
                      <?php
                    }
                    ?>
        
    <div class='box-body'>
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:15%'>CR Number</th>
                  <th style='width:15%'>Date</th>
                  <th style='width:15%'>Amount</th>
                  <th style='width:20%'>Bank</th>
                  <th style='width:18%'>Check Number</th>
                  <th style='width:18%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $so->show_cr($id);
                ?>
                </tbody>
              </table>
            
    </section>
    <!-- /.content -->
    
  </div>

                        
  <?php
include 'modal_dr.php';
include 'modal_pr.php';
include 'modal_cr.php';
include 'modal_pl.php';
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

$(document).ready(function(){
    var vat = '<?php echo $so->vattype; ?>';
    
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
    
	total();
});

$('#genDR').click(function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   });
   
   $('#genCR').click(function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body_CR').load(dataURL,function(){
            $('#view_modal_CR').modal({show:true});
        });
   });
   
   $('#genPR').click(function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body_PR').load(dataURL,function(){
            $('#view_modal_PR').modal({show:true});
        });
   });
   
   $('#genPL').click(function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body_PL').load(dataURL,function(){
            $('#view_modal_PL').modal({show:true});
        });
   });
   
 $(document).ready(function(){
  $('#example2 tbody').on('click', '.editDR', function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   });
});

<?php
if (isset($_GET['uploaded'])) {
  ?>
    swal("Success", "Successfully uploaded files.", "success");
    history.pushState(null, null, 'po_details?id=<?php echo $_GET['id']; ?>');
<?php
}
elseif (isset($_GET['not_uploaded'])) {
  ?>
    swal("Ooopss", "Wasn't able to upload files. Try again!", "error");
    history.pushState(null, null, 'po_details?id=<?php echo $_GET['id']; ?>');
<?php
}
elseif (isset($_GET['deleted'])) {
  ?>
    swal("Success", "File attachment successfully deleted.", "success");
    history.pushState(null, null, 'po_details?id=<?php echo $_GET['id']; ?>');
<?php
}
elseif (isset($_GET['dr'])) {
  ?>
    swal("Success", "DR record successfully saved.", "success");
    history.pushState(null, null, 'po_details?id=<?php echo $_GET['id']; ?>');
<?php
}

elseif (isset($_GET['dr_edit'])) {
  ?>
    swal("Success", "DR record successfully edited.", "success");
    history.pushState(null, null, 'po_details?id=<?php echo $_GET['id']; ?>');
<?php
}
elseif (isset($_GET['dr_delete'])) {
  ?>
    swal("Success", "DR record successfully deleted.", "success");
    history.pushState(null, null, 'po_details?id=<?php echo $_GET['id']; ?>');
<?php
}
//
elseif (isset($_GET['dr_return'])) {
  ?>
    swal("Success", "DR return date successfully recorded.", "success");
    history.pushState(null, null, 'po_details?id=<?php echo $_GET['id']; ?>');
<?php
}

elseif (isset($_GET['pr'])) {
  ?>
    swal("Success", "PR record successfully saved.", "success");
    history.pushState(null, null, 'po_details?id=<?php echo $_GET['id']; ?>');
<?php
}
//payment
elseif (isset($_GET['payment'])) {
  ?>
    swal("Success", "CR record successfully saved.", "success");
    history.pushState(null, null, 'po_details?id=<?php echo $_GET['id']; ?>');
<?php
}
elseif (isset($_GET['paid'])) {
  ?>
    swal("Success", "Payment successfully recorded.", "success");
    history.pushState(null, null, 'po_details?id=<?php echo $_GET['id']; ?>');
<?php
}
?>

$("#example1").DataTable();
$("#example2").DataTable();

$(document).ready(function(){
  $('#example1 tbody').on('click', '.openView', function () {
       var id = $(this).attr('id');
       window.location.href='models/sales_order_model.php?verify='+id;
   });

   $('#example1 tbody').on('click', '.viewRec', function () {
      var dataURL = $(this).attr('data-href');
        $('#view_body_records').load(dataURL,function(){
            $('#view_modal_records').modal({show:true});
        });
   });

   $('#example1 tbody').on('click', '.view', function () {
      var dataURL = $(this).attr('data-href');
        $('#view_body_so').load(dataURL,function(){
            $('#view_modal_so').modal({show:true});
        });
   });

});

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

var disc = '<?php echo $so->disc; ?>';

if(disc == ''){
    disc = 0;
}
else{
    disc = parseFloat(disc);
}


    sum -= disc;
    
  var net = format(sum/1.12);
  var vat = format(sum - (sum/1.12));
  var sum_ = format(sum);

  $("#net").val(net);
  $("#vat_").val(vat);
  $("#total_price").val(sum_);
}

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

var last_id = 2;

  function add_row1(){
  var newRow = "<tr id='tr"+last_id+"'><td><input class='counter' id='"+last_id+"' type='hidden'><input type='hidden' name='brand[]' id='brand_"+last_id+"'><input list='brand_list' id='brand"+last_id+"' maxlength='50' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...'></td><td><input type='hidden' name='productID[]' id='productID"+last_id+"'><input readonly name='product[]' id='product"+last_id+"' maxlength='200' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...'></td><td><input type='text' name='ourpartnum[]' id='ourpartnum"+last_id+"' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control'></td><td><input type='text' name='yourpartnum[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control'></td><td><input type='text' name='uom[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control'></td><td><input type='text' name='avail[]' value='No' id='avail"+last_id+"' readonly style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'></td><td><input type='number' name='quantity[]' id='quan"+last_id+"' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'></td><td><input type='text' id='unitprice"+last_id+"' name='price[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'></td><td><input name='linetotal[]' id='linetotal"+last_id+"' step='any' style='text-align:right;background-color:transparent; border:transparent' min='0' class='form-control tprice' readonly required type='text'></td><td><center><button id='"+last_id+"' onclick='deleterow(this.id)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td></tr>";

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
