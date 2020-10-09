<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Agrimate | Payments Module</title>
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
      Payment Records
      </h1>
      <ol class="breadcrumb">
    </section>

    <!-- Main content -->
    <section class="content">
      <div class='box'>
      <div class='box-body'>
      <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:10%'>SO #</th>
                  <th style='width:5%'>SI #</th>
                  <th style='width:5%'>DR #</th>
                  <th style='width:20%'>Customer</th>
                  <th style='width:10%'>Total Amount</th>
                  <th style='width:10%'>Rebate Amount</th>
                  <th style='width:10%'>Credit Memo</th>
                  <th style='width:10%'>Debit Memo</th>
                  <th style='width:10%'>Balance</th>
                  <th style='width:10%'>Aging</th>
                  <th style='width:10%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
$so->show_payment_rec();
?>
                </tbody>
              </table>
      </div>
      </div>
    </section>


    <br>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Post Dated Checks
      </h1>
      <ol class="breadcrumb">
    </section>

    <!-- Main content -->
    <section class="content">
      <div class='box'>
      <div class='box-body'>
      <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:20%'>Bank Name</th>
                  <th style='width:20%'>Check Number</th>
                  <th style='width:20%'>Check Date</th>
                  <th style='width:20%'>Amount</th>
                  <th style='width:20%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $so->pd_checks();
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
include 'modal_viewpayments.php';
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
$(document).ready(function(){
    $('#example1 tbody').on('click', '.view', function () {
      var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   });

   $('#example1 tbody').on('click', '.viewRec', function () {
      var dataURL = $(this).attr('data-href');
        $('#view_body_records').load(dataURL,function(){
            $('#view_modal_records').modal({show:true});
        });
   });
});

//success
<?php
if (isset($_GET['success'])) {
  ?>
    swal("Success", "Successfully recorded payment.", "success");
    history.pushState(null, null, 'payments');
<?php
}
elseif (isset($_GET['cleared'])) {
  ?>
    swal("Success", "Post dated check successfully recorded as cleared.", "success");
    history.pushState(null, null, 'payments');
<?php
}
?>

$("#example1").DataTable();
$("#example2").DataTable();

</script>
