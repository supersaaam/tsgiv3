<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Agrimate | Inventory Report</title>
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

include 'models/warehouse_model.php';
include 'models/actual_prod_model.php';

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
      <form action="print_inv_table.php">
        <div class='box'>
          <div class="box-body">
            <div class="row">
              <div class="form-group col-md-4">
                <label>Warehouse</label>
                <input list="warehouse_list" name="warehouse" class="form-control"placeholder="(Optional)">
              </div>
              <div class="form-group col-md-4">
                <label>Product Code</label>
                <input list="prodcode_list" name="prodcode" class="form-control"placeholder="(Optional)">
              </div>
              <div class="form-group col-md-4">
                <label>Date Range</label>
                <input name="date" class="form-control" placeholder="(Optional)" daterangepicker>
              </div>
              <div class="form-group col-md-12">
                <label>&nbsp;</label><br>
                <button type='submit' class='btn btn-success pull-right'><i class='fa fa-file'></i> &nbsp;Generate Report</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </section>
    <!-- /.content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Inventory Report (Monthly)
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <form action="print_inv_report.php">
        <div class='box'>
          <div class="box-body">
            <div class="row">
              <div class="form-group col-md-3">
                <label>Warehouse</label>
                <input list="warehouse_list" name="warehouse" class="form-control" required>
              </div>
              <div class="form-group col-md-3">
                <label>Product Code</label>
                <input list="prodcode_list" name="prodcode" class="form-control" required>
              </div>
              <div class="form-group col-md-3">
                <label>Month - Year</label>
                <input list="monthyear_list" name="month_year" class="form-control" required>
              </div>
              <div class="form-group col-md-3">
                <label>&nbsp;</label><br>
                <button type='submit' class='btn btn-success pull-right'><i class='fa fa-file'></i> &nbsp;Generate Report</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </section>
    <!-- /.content -->
  </div>

                        <datalist id="prodcode_list">
                          <?php
$act_prod->show_data_dl();
?>
                        </datalist>

                        <datalist id="monthyear_list">
                          <?php
$act_prod->show_data_my_dl();
?>
                        </datalist>

                        <datalist id="warehouse_list">
                          <?php
$wh->show_data_dl();
?>
                        </datalist>
  <?php
include 'footer.php';
include 'modal_viewtransfer.php';
?>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php
include 'js.php';
?>

<script>
  $(document).ready(function(){
    $("[daterangepicker]").daterangepicker({
      opens: 'left'
    }).on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });

    $("[daterangepicker]").val('')
  })
</script>
</body>
</html>
