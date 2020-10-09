<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Transcendo | Bill of Materials Module</title>
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
include 'models/bom_model.php';
include 'models/customer_model.php';
include 'models/terms_sm_model.php';

$bom = new BOM();
$terms    = new Terms_SM();
$cust     = new Customer();
?>

                        <datalist id="product_list">
                          <?php
                            $bom->show_prod_list();
                            ?>
                        </datalist>
                        
    <!--FIRST TABLE END-->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>
        <label style='float:left'>BOM #<?php echo sprintf('%06d', $_GET['bom']); ?></label>
      </h3>
      <br><br>
    </section>
    
    <section class="content-header">
      <h1>
        Local Components
      </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
    <div class="box">
      <!-- /.card-header -->
      <div class="box-body">

              <form role="form" action="models/bom_aed.php" method="post" id="">
            <!--START OF FIRST TABLE-->    
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <center>
                        <th style='width:31%'>Description</th>
                        <th style='width:8%'>Part #</th>
                        <th style='width:8%'>Qty</th>
                        <th style='width:12%'>(PHP) Net Price</th>
                        <th style='width:12%'>(PHP) Marked-up Price</th>
                        <th style='width:12%'>(PHP) Selling Price (w/ VAT)</th>
                        <th style='width:12%'>(PHP) Total Price VAT-Ex</th>
                        <th style='width:5%'></th>
                        </center>
                      </tr>
                    </thead>
                    <tbody id="trans_table">
                    <?php
                 
                        if($bom->get_local($_GET['bom']) > 0){
                            $bom->show_local($_GET['bom']);   
                        }
                        else{
                  
                    ?>
                        
                        
                      <tr id='tr1'>
                        <td>
                          <input class='counter' id='1' type='hidden'>
                          <input type='hidden' name='productID[]' id='productID1'>
                          <input id='product1' name='product[]' maxlength='200' title="Refer to the data list..." style="background-color:transparent; border:transparent; width:95%" class="form-control" required list='product_list' placeholder="Type here ...">
                        </td>
                        <td>
                          <input type="text" name='ourpartnum[]' id='ourpartnum1' style="text-align:right; background-color:transparent; border:transparent; width:100%" class="form-control">
                        </td>
                        <td>
                          <input type="number" name='quantity[]' id='quan1' style="text-align:right; background-color:transparent; border:transparent; width:100%" required class="form-control">
                        </td>
                        <td>
                          <input type="text" id='net_price1' name='net_price[]' style="text-align:right; background-color:transparent; border:transparent; width:100%" required class="form-control">
                        </td>
                        <td>
                          <input type="text" id='mu_price1' readonly name='mu_price[]' style="text-align:right; background-color:transparent; border:transparent; width:100%" required class="form-control">
                        </td>
                        <td>
                          <input type="text" id='unitprice1' readonly name='price[]' style="text-align:right; background-color:transparent; border:transparent; width:100%" required class="form-control">
                        </td>
                        <td>
                          <input name="linetotal[]" id='linetotal1' step='any' style="text-align:right;background-color:transparent; border:transparent" min='0' class="form-control tprice" readonly required type='text'>
                        </td>
                       <td><center><button onclick='deleterow(1)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td>
                      </tr>
                      
                      <?php 
                      }
                      ?>
                      
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan='6' id='vat_desc' style='text-align: right'>Total Local Components</th>
                        <td colspan='2'><input type="text" name="total_price" id='total_price' style="text-align:left; background-color:transparent; border:transparent" class="form-control" readonly value='0.00'></td>
                      </tr>
                    </tfoot>
                  </table>
                  <button type="button" id="add_row" onclick="add_row1()" class="btn btn-success btn-sm" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-plus'></i> &nbsp;Add New Row</button>
                  
                  <div style="clear:both; height:15px;"></div>
                                    <input type='hidden' name='bom' value='<?php echo $_GET['bom']; ?>'>
                                    <button type="submit" onclick='return check()' name="local" id="submit_new1" class="btn btn-primary" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Submit</button>
                  
                  <div style="clear:both; height:15px;"></div>

                    
                </form>

            <!--END OF FIRST TABLE-->
            
              </div>
              </div>
              <!-- /.card-body -->
    </section>
    <!-- /.content -->
    <!--1ST TABLE END-->
  </div>

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

$(document).ready(function() {
    total();
    
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

                    <?php
                        if($bom->get_local($_GET['bom']) > 0){
                    ?>
                        var last_id = '<?php echo $bom->get_local($_GET['bom'])+1; ?>';
                    <?php    
                        }
                        else{
                    ?>
                        var last_id = 2;
                        
                    <?php
                        }
                    ?>
                        
  function add_row1(){
  var newRow = "<tr id='tr"+last_id+"'><td><input class='counter' id='"+last_id+"' type='hidden'><input type='hidden' name='productID[]' id='productID"+last_id+"'><input id='product"+last_id+"' name='product[]' maxlength='200' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...' list='product_list'></td><td><input type='text' name='ourpartnum[]' id='ourpartnum"+last_id+"' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control'></td><td><input type='number' name='quantity[]' id='quan"+last_id+"' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'></td><td><input type='text' id='net_price"+last_id+"' name='net_price[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'></td><td><input type='text' id='mu_price"+last_id+"' readonly name='mu_price[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'></td><td><input type='text' readonly id='unitprice"+last_id+"' name='price[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'></td><td><input name='linetotal[]' id='linetotal"+last_id+"' step='any' style='text-align:right;background-color:transparent; border:transparent' min='0' class='form-control tprice' readonly required type='text'></td><td><center><button onclick='deleterow("+last_id+")' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td></tr>";

  $("#trans_table").append(newRow);

    //Dynamically add functions from here

    add_function(last_id);

  last_id+=1;

  var rowCount = $('#example2 tr').length - 2;
  if(rowCount != 0){
      $("#submit_new1").attr('disabled', false);
  }
}

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
            brand: 'Local'
        },
        success:function(data){
            if(data != '###'){
                $("#product1").attr('readonly', true);
                var res = data.split('#');
                $("#productID1").val(res[0]);
                $("#ourpartnum1").val(res[1]);
                $("#ourpartnum1").attr('readonly', true);
                $("#unitprice1").val(res[2]);
                $("#mu_price1").val((parseFloat(res[2])/1.12).toFixed(2));
                $("#net_price1").val((parseFloat(res[2])/1.12/1.3).toFixed(2));
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

    $('#net_price'+id).keydown(function (e) {
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

      $('#net_price'+id).keyup(function (e) {
        multiply(id);
      });

      $('#quan'+id).keyup(function (e) {
        multiply(id);
      });

    $("#product"+id).on('change', function(){
        var productName = $(this).val();
        var brand = $("#brand"+id).val();

        $.ajax({
            url: 'models/ajax_quote.php',
            type: 'post',
            data:{
                productName: productName,
                brand: 'Local'
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
                    $("#unitprice"+id).val(res[2]);
                    $("#mu_price"+id).val((parseFloat(res[2])/1.12).toFixed(2));
                    $("#net_price"+id).val((parseFloat(res[2])/1.12/1.3).toFixed(2));
            }
            }
        });
    });
}

function multiply(id){
  var quan_ = ($("#quan"+id).val()).replace(/\,/g,'');
  var net_ = ($("#net_price"+id).val()).replace(/\,/g,'');

  var quan = parseFloat(quan_);
  var net = parseFloat(net_);

  if(isNaN(quan)){
    quan = 0;
  }

  if(isNaN(net)){
      net = 0;
  }

  var mu_price = net * 1.3;
  var unitprice = net * 1.3 * 1.12;

  var prod = quan * mu_price;
  var pr = format(prod);

  $("#unitprice"+id).val(unitprice.toFixed(2));
  $("#mu_price"+id).val(mu_price.toFixed(2));
  $("#linetotal"+id).val(pr);

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

<?php
if (isset($_GET['success'])) {
  ?>
    swal("Success", "Successfully recorded local components.", "success");
    history.pushState(null, null, 'local?bom=<?php echo $_GET['bom']; ?>');
<?php
}
?>
</script>
