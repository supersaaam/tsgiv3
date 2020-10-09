<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Agrimate | Sales Order Records Module</title>
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

$so = new Sales_Order();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Pending Sales Order Records
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class='box'>
    <div class='box-body'>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:13%'>SO #</th>
                  <th style='width:26%'>Customer</th>
                  <th style='width:13%'>Terms</th>
                  <th style='width:13%'>Amount</th>
                  <th style='width:13%'>Prev Balance</th>
                  <th style='width:25%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
$so->show_data_verify();
?>
                </tbody>
              </table>

            </div>
            </div>
    </section>
    <!-- /.content -->
  </div>

  <?php
include 'footer.php';
include 'modal_viewso.php';
include 'modal_deductions.php';
include 'modal_records.php';
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
<?php
if (isset($_GET['success'])) {
  ?>
    swal("Success", "Successfully verified sales order.", "success");
    history.pushState(null, null, 'so_records');
<?php
} elseif (isset($_GET['deducted'])) {
  ?>
      swal("Success", "Successfully recorded deductions for the sales order.", "success");
      history.pushState(null, null, 'so_records');
  <?php
} elseif (isset($_GET['deductions'])) {
  ?>
      swal("Success", "Successfully recorded deductions for the sales order.", "success");
      history.pushState(null, null, 'so_records');
  <?php
} elseif (isset($_GET['remarks'])) {
  ?>
      swal("Success", "Remarks successfully sent.", "success");
      history.pushState(null, null, 'so_records');
  <?php
}
?>


$("#example1").DataTable();

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

</script>
