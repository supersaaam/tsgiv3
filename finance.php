<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Agrimate | Finance Module</title>
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
include 'models/importation_model.php';

$imp = new Importation();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Payment for Imported Goods
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:10%'>Proforma Inv No.</th>
                  <th style='width:28%'>Supplier</th>
                  <th style='width:12%'>Total Amount</th>
                  <th style='width:12%'>Balance</th>
                  <th style='width:38%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
$imp->show_payable();
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
include 'modal_finance.php';
include 'modal_ded_payable.php';
include 'modal_pay.php';
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

   $('#example1 tbody').on('click', '.deduction', function () {
      var dataURL = $(this).attr('data-href');
        $('#view_body_deduction').load(dataURL,function(){
            $('#view_modal_deduction').modal({show:true});
        });
   });

   $('#example1 tbody').on('click', '.paymentBtn', function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body_py').load(dataURL,function(){
            $('#view_modal_py').modal({show:true});
        });
   });

});

//success
<?php
if (isset($_GET['success'])) {
  ?>
    swal("Success", "Successfully updated record.", "success");
    history.pushState(null, null, 'finance');
<?php
} elseif (isset($_GET['paid'])) {
  ?>
      swal("Success", "Successfully recorded payment.", "success");
      history.pushState(null, null, 'finance');
  <?php
} //
elseif (isset($_GET['deductions'])) {
  ?>
        swal("Success", "Successfully recorded deductions and discounts.", "success");
        history.pushState(null, null, 'finance');
    <?php
} //
?>

$("#example1").DataTable();
</script>
