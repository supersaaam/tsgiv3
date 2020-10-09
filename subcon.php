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
        Sub Contracts
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
                        <th style='width:30%'>Description</th>
                        <th style='width:13%'>Quantity</th>
                        <th style='width:13%'>Price</th>
                        <th style='width:13%'>Computed Price</th>
                        <th style='width:13%'>Marked-up Price</th>
                        <th style='width:13%'>Line Total</th>
                        <th style='width:5%'></th>
                        </center>
                      </tr>
                    </thead>
                    <tbody id="trans_table">
                    
                    <?php
                    if($bom->get_subcon($_GET['bom']) > 0){
                            $bom->show_subcon($_GET['bom']);   
                        }
                        else{
                    ?>
                        
                      <tr id='tr1'>
                        <td>
                          <input class='counter' id='1' type='hidden'>
                          <input id='' style="text-align:left; background-color:transparent; border:transparent; width:100%" name='desc[]' maxlength='200' type='text' required placeholder="Type here ...">
                        </td>
                        <td>
                          <input type="number" min='0' name='quantity[]' id='quan1' style="text-align:right; background-color:transparent; border:transparent; width:100%" required class="form-control">
                        </td>
                        <td>
                          <input type="number" min='0' name='price[]' id='price1' style="text-align:right; background-color:transparent; border:transparent; width:100%" required class="form-control">
                        </td>
                        <td>
                          <input type="number" min='0' name='comp_price[]' id='comp_price1' readonly style="text-align:right; background-color:transparent; border:transparent; width:100%" required class="form-control">
                        </td>
                        <td>
                          <input type="number" min='0' name='mu_price[]' id='mu_price1' readonly style="text-align:right; background-color:transparent; border:transparent; width:100%" required class="form-control">
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
                        <th colspan='5' id='vat_desc' style='text-align: right'>Total Sub Contracts</th>
                        <td colspan='2'><input type="text" name="total_price" id='total_price' style="text-align:left; background-color:transparent; border:transparent" class="form-control" readonly value='0.00'></td>
                      </tr>
                    </tfoot>
                  </table>
                  <button type="button" id="add_row" onclick="add_row1()" class="btn btn-success btn-sm" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-plus'></i> &nbsp;Add New Row</button>
                  
                  <div style="clear:both; height:15px;"></div>
                                    <input type='hidden' name='bom' value='<?php echo $_GET['bom']; ?>'>
                                    <button type="submit" name="subcon" id="submit_new1" class="btn btn-primary" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Submit</button>
                  
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
                        var last_id = 2;
                
  function add_row1(){
  var newRow = "<tr id='tr"+last_id+"'><td><input class='counter' id='"+last_id+"' type='hidden'><input id='' name='desc[]' style='text-align:left; background-color:transparent; border:transparent; width:100%' maxlength='200' type='text' required placeholder='Type here ...'></td><td><input type='number' min='0' name='quantity[]' id='quan"+last_id+"' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'></td><td><input type='number' min='0' name='price[]' id='price"+last_id+"' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'></td><td><input type='number' min='0' name='comp_price[]' id='comp_price"+last_id+"' readonly style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'></td><td><input type='number' min='0' name='mu_price[]' id='mu_price"+last_id+"' readonly style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'></td><td><input name='linetotal[]' id='linetotal"+last_id+"' step='any' style='text-align:right;background-color:transparent; border:transparent' min='0' class='form-control tprice' readonly required type='text'></td><td><center><button onclick='deleterow("+last_id+")' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td></tr>";

  $("#trans_table").append(newRow);

    //Dynamically add functions from here

    add_function(last_id);

  last_id+=1;

  var rowCount = $('#example2 tr').length - 2;
  if(rowCount != 0){
      $("#submit_new1").attr('disabled', false);
  }
}

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
  var p_ = ($("#price"+id).val()).replace(/\,/g,'');
  
  var quan = parseFloat(quan_);
  var p = parseFloat(p_);
  
  if(isNaN(quan)){
    quan = 0;
  }

  if(isNaN(p)){
      p = 0;
  }
  
  var cp = (p / 1.12)*0.98;
  var mu = (p / 1.12)*0.98 * 1.3;
  
  var lt = quan * mu;
  var pr = format(lt);

  $("#comp_price"+id).val(cp.toFixed(2));
  $("#mu_price"+id).val(mu.toFixed(2));
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

<?php
if (isset($_GET['success'])) {
  ?>
    swal("Success", "Successfully recorded sub contracts.", "success");
    history.pushState(null, null, 'subcon?bom=<?php echo $_GET['bom']; ?>');
<?php
}
?>
</script>
