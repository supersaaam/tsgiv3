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
      Approved Sales Order Records
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class='box'>
    <div class='box-body'>
    <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:16%'>SO #</th>
                  <th style='width:33%'>Customer</th>
                  <th style='width:15%'>Amount</th>
                  <th style='width:12%'>Terms</th>
                  <th style='width:12%'>Date</th>
                  <th style='width:10%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
$so->show_data_approved();
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
include 'modal_print.php';
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
if (isset($_GET['dr'])) {
  ?>
    swal("Success", "Successfully updated SO.", "success");
    history.pushState(null, null, 'approved_records');
<?php
} elseif (isset($_GET['si'])) {
  ?>
    swal("Success", "Successfully updated SO.", "success");
    history.pushState(null, null, 'approved_records');
<?php
}
?>


$("#example2").DataTable();

$(document).ready(function(){
    $('#example2 tbody').on('click', '.view', function () {
      var dataURL = $(this).attr('data-href');
        $('#view_body_so').load(dataURL,function(){
            $('#view_modal_so').modal({show:true});
        });
   });

   $('#example2 tbody').on('click', '.print', function () {
      var dataURL = $(this).attr('data-href');
        $('#view_body_print').load(dataURL,function(){
            $('#view_modal_print').modal({show:true});
        });
   });

   $('#example2 tbody').on('click', '.deduction', function () {
      var dataURL = $(this).attr('data-href');
        $('#view_body_deduction').load(dataURL,function(){
            $('#view_modal_deduction').modal({show:true});
        });
   });
});

</script>
