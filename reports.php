<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Agrimate | Records Module</title>
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
include 'models/actual_prod_model.php';
include 'models/warehouse_model.php';
include 'models/supplier_model.php';
include 'models/customer_model.php';
$cust     = new Customer();
$supp     = new Supplier();
$act_prod = new Actual_Prod();
$wh       = new Warehouse();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Inventory Report
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box">
            <form action='print_inventory.php' method='post'>
            <div class="box-header">

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                    <label>Filter</label>
                    <br>
                    <input type='radio' id='filter' name='filter' checked value='all'> Show all &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' id='filter' name='filter' value='column'> Filter by column
                  </div>
                  </div>

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                    <label>Column</label>
                    <select readonly class="form-control" required name="column" id='column'>
                      <option value="Warehouse" >Warehouse</option>
                      <option value="Product Code" >Product Code</option>
                      <option value="Critical Level" >Critical Level</option>
                    </select>
                  </div>
                  </div>

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                    <label>Value</label>
                    <input readonly list="" id='field' required name="value" class="form-control"  maxlength="50" placeholder="Please input here ...">
                  </div>
                  </div>

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                  <label>&nbsp;</label><br>
                  <button type='submit' class='btn btn-success'><i class='fa fa-file'></i> &nbsp;Generate Report</button>
                  </div>
                  </div>

            </form>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
      <h3>
      Importation Report
      </h3>

        <div class="box">
            <form action='print_importation.php' method='post'>
            <div class="box-header">

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                    <label>Filter</label>
                    <br>
                    <input type='radio' id='filter' name='filter_imp' checked value='all'> Show all &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' id='filter' name='filter_imp' value='column'> Filter by column
                  </div>
                  </div>

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                    <label>Column</label>
                    <select readonly class="form-control" required name="column" id='column_imp'>
                      <option value="Supplier" >Supplier</option>
                      <option value="Delivery Status" >Delivery Status</option>
                    </select>
                  </div>
                  </div>

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                    <label>Value</label>
                    <input readonly list="suppliers_list" id='field_imp' required name="value" class="form-control"  maxlength="50" placeholder="Please input here ...">
                  </div>
                  </div>

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                  <label>&nbsp;</label><br>
                  <button type='submit' class='btn btn-success'><i class='fa fa-file'></i> &nbsp;Generate Report</button>
                  </div>
                  </div>

            </form>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <h3>
      Customer Collection Report
      </h3>

        <div class="box">
            <form action='print_cmo.php' method='post'>
            <div class="box-header">

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                    <label>Filter</label>
                    <br>
                    <input type='radio' id='filter' name='filter_cmo' checked value='all'> Show all &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' id='filter' name='filter_cmo' value='column'> Filter by customer
                  </div>
                  </div>

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                    <label>Customer</label>
                    <input readonly list="customer_list" id='field_cmo' required name="value" class="form-control"  maxlength="50" placeholder="Please input here ...">
                  </div>
                  </div>

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                  <label>&nbsp;</label><br>
                  <button type='submit' class='btn btn-success'><i class='fa fa-file'></i> &nbsp;Generate Report</button>
                  </div>
                  </div>

            </form>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </section>
    <!-- /.content -->

  </div>

                        <datalist id="warehouse">
                          <?php
$wh->show_data_dl();
?>
                        </datalist>

                        <!-- DATALISTS -->
                        <datalist id="customer_list">
                          <?php
$cust->show_data_dl();
?>
                        </datalist>

                       <datalist id="prodcode_list">
                          <?php
$act_prod->show_data_dl();
?>
                        </datalist>

                        <datalist id="suppliers_list">
                          <?php
$supp->show_supplier();
?>
                        </datalist>

                        <datalist id="delstat_list">
                          <option value='Ordered'>
                          <option value='Sailing'>
                          <option value='Delayed'>
                          <option value='Arrived Port'>
                          <option value='On Transit'>
                          <option value='Delivered'>
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
$('input[type=radio][name=filter]').change(function() {
    var filter = $("input[name='filter']:checked").val(); //all / column
    var column = $("#column").val();
    var field = $("#field").val();

    if(filter == 'all'){
        //disable column
            $("#column").attr('readonly', true);
        //disable value
            $("#field").attr('readonly', true);
    }
    else{
        //enable column
            $("#column").attr('readonly', false);
        //enable value
            $("#field").attr('readonly', false);
    }
});

$("#column").change(function (){
    var column = $("#column").val();

    $("#field").val('');

    if(column == 'Product Code'){
        $("#field").attr('list', 'prodcode_list');
    }
    else if(column == 'Warehouse'){
        $("#field").attr('list', 'warehouse');
    }
    else if(column == 'Critical Level'){
        $("#field").attr('readonly', true);
        $("#field").val(' ');
    }
});


$('input[type=radio][name=filter_imp]').change(function() {
    var filter = $("input[name='filter_imp']:checked").val(); //all / column
    var column = $("#column_imp").val();
    var field = $("#field_imp").val();

    if(filter == 'all'){
        //disable column
            $("#column_imp").attr('readonly', true);
        //disable value
            $("#field_imp").attr('readonly', true);
    }
    else{
        //enable column
            $("#column_imp").attr('readonly', false);
        //enable value
            $("#field_imp").attr('readonly', false);
    }
});


$("#column_imp").change(function (){
    var column = $("#column_imp").val();

    $("#field_imp").val('');

    if(column == 'Supplier'){
        $("#field_imp").attr('list', 'suppliers_list');
    }
    else if(column == 'Delivery Status'){
        $("#field_imp").attr('list', 'delstat_list');
    }
});

$('input[type=radio][name=filter_cmo]').change(function() {
    var filter = $("input[name='filter_cmo']:checked").val(); //all / column
    var field = $("#field_cmo").val();

    if(filter == 'all'){
        //disable value
            $("#field_cmo").attr('readonly', true);
    }
    else{
        //enable value
            $("#field_cmo").attr('readonly', false);
    }
});
</script>
