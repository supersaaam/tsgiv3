<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Transcendo | Payment Module</title>
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
include 'models/po_model.php';

$po = new PO();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Payments to Supplier
      
      <a href='javascript:void(0);' data-href='view_po_payments.php?po=<?php echo $po_num; ?>' id='payment'><button type="button"  name="submit" id="" class="btn btn-success" style="float:right;margin-bottom:20px; margin-right:20px"><i class='fa fa-file'></i> &nbsp;Generate Payment</button></a>
      </h1>
    </section>

    <div class='clearfix'></div>
    
    <!-- Main content -->
    <section class="content">
    <div class='box'>
    <div class='box-body'>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:16%'>Fund Transfer No.</th>
                  <th style='width:20%'>Branch</th>
                  <th style='width:16%'>Account Number</th>
                  <th style='width:16%'>PO Reference(s)</th>
                  <th style='width:16%'>Amount</th>
                  <th style='width:16%'>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                       $po->show_payment();
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
include 'modal_payment.php';
?>

</body>
</html>

<script>
<?php
if (isset($_GET['payment'])) {
  ?>
    swal("Success", "Successfully recorded payment.", "success");
    history.pushState(null, null, 'payments_to_supplier');
<?php
}
?>


$("#example1").DataTable();

$(document).ready(function(){
  $('#payment').click(function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body_payment').load(dataURL,function(){
            $('#view_modal_payment').modal({show:true});
        });
   });
   

});

</script>
