<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Agrimate | Accounting Module</title>
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
      Sales Order Records (for Approval)
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class='box'>
          <div class='box-body'>
          <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:10%'>SO #</th>
                  <th style='width:26%'>Customer</th>
                  <th style='width:13%'>Terms</th>
                  <th style='width:13%'>Amount</th>
                  <th style='width:13%'>Remarks</th>
                  <th style='width:25%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
$so->show_data_approve();
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
include 'modal_disapprove.php';
include 'modal_viewso.php';
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
  $('#example1 tbody').on('click', '.openView', function () {
       var id = $(this).attr('id');
       window.location.href='models/sales_order_model.php?approve='+id;
   });

   $('#example1 tbody').on('click', '.disapprove', function () {
      var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   });

    $('#example1 tbody').on('click', '.view', function () {
      var dataURL = $(this).attr('data-href');
        $('#view_body_so').load(dataURL,function(){
            $('#view_modal_so').modal({show:true});
        });
   });
});

<?php
if (isset($_GET['success'])) {
  ?>
    swal("Success", "Successfully approved sales order.", "success");
    history.pushState(null, null, 'accounting');
<?php
} elseif (isset($_GET['success'])) {
  ?>
      swal("Success", "Successfully disapproved sales order.", "success");
      history.pushState(null, null, 'accounting');
  <?php
}
?>

$("#example1").DataTable();
</script>
