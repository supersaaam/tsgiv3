<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Agrimate | Inventory Monitoring Module</title>
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
include 'models/inventory_model.php';
include 'models/so_cmo_model.php';
include 'models/so_product_model.php';

$so_prod = new SO_Product();
$so_cmo  = new SO_CMO();
$wh      = new Warehouse();
$inv     = new Inventory();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Inventory Monitoring
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- /.card-header -->
      <div class='box'>
      <div class="box-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:300px'>Product Code</th>
                  <th style='width:100px;'>Exp Date</th>
                  <th style='width:100px;'>Avg / Month</th>
                  <th style='width:100px;'>Mos. to go</th>
                  <?php
$wh->show_data_th();
?>
                  <th style='width:100px'>Total</th>
                  <th style='width:100px'>Stocks on Hand</th>
                  <th style='width:100px'>Critical Level</th>
                </tr>
                </thead>
                <tbody>
                <?php
$inv->show_data();
?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            </div>
    </section>
    <!-- /.content -->
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
    $('#example2').DataTable( {
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        ScrollXInner: "100%",
        fixedColumns: {
            leftColumns: 1
        },
        "columnDefs": [
            {
                "targets": [ <?php echo $wh->col; ?> 1, 2, 3, -2 ],
                "visible": false,
                "searchable": false
            }
          ]
    } );
} );
</script>
