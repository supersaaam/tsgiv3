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
include 'models/supplier_model.php';
include 'models/customer_model.php';
include 'models/terms_sm_model.php';
include 'models/pr_model.php';

$pr = new PR();
$terms    = new Terms_SM();
$cust     = new Customer();
$supplier = new Supplier();
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Purchase Request
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box">
      <!-- /.card-header -->
      <div class="box-body">

              <form role="form" action="models/pr_aed.php" method="post" id="">
                    
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style='width:25%'>Brand</th>
                        <th style='width:30%'>Description</th>
                        <th style='width:20%'>Our Part #</th>
                        <th style='width:20%'>Qty to Order</th>
                        <th style='width:5%'></th>
                      </tr>
                    </thead>
                    <tbody id="trans_table">
                      <?php 
                      $pr->show_pr_revise_bd($_GET['brand']);
                      ?>
                    </tbody>
                  </table>
                  <button type="button" id="add_row" onclick="add_row1()" class="btn btn-success btn-xs" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-plus'></i> &nbsp;Add New Row</button>
                  
                  <div class='clearfix'>&nbsp;</div>
                  
                  <input type='hidden' name='prnums' value='<?php echo rtrim($pr->prbd_, ','); ?>'>
                  <input type='hidden' name='brandx' value='<?php echo $_GET['brand']; ?>'>
                  
                  <button type="submit" name="revise_submit" id="submit_new1" class="btn btn-primary" style="float:right; margin-top:15px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Submit</button>
                  
                </form>

              </div>
              </div>
              <!-- /.card-body -->
    </section>
    <!-- /.content -->
  </div>

                     <!-- DATALISTS -->
                      <datalist id="terms_list">
                          <?php
			$terms->show_data_dl();
			?>
                        </datalist>
                        
                        <datalist id="cperson_list">
                        </datalist>
                        
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
                        
<?php
    $supplier->show_supplier();
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
    
var last_id = '<?php echo $pr->rows; ?>';

  function add_row1(){
  var newRow = "<tr id='tr"+last_id+"'><td><input class='counter' id='"+last_id+"' type='hidden'><input type='hidden' name='brand[]' id='brand_"+last_id+"'><input list='brand_list' id='brand"+last_id+"' maxlength='50' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...'></td><td><input type='hidden' name='productID[]' id='productID"+last_id+"'><input readonly name='product[]' id='product"+last_id+"' maxlength='200' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...'></td><td><input type='text' name='ourpartnum[]' id='ourpartnum"+last_id+"' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control'></td><td><input type='number' name='quantity[]' id='quan"+last_id+"' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'></td><td><center><button id='"+last_id+"' onclick='deleterow(this.id)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td></tr>";

  $("#trans_table").append(newRow);

    //Dynamically add functions from here

    add_function(last_id);

  last_id+=1;

  var rowCount = $('#example2 tr').length;
  if(rowCount != 0){
      $("#submit_new1").attr('disabled', false);
  }
}
    

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
            }
        }
    });
});

function deleterow(id){
  $("#tr"+id).remove();
 
  var rowCount = $('#example2 tr').length ;
  
  if(rowCount == 0){
      $("#submit_new1").attr('disabled', true);
  }
}

function add_function(id){
    
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
                }
            }
        });
    });
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
