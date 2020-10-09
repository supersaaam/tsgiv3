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
      Disapproved Sales Order Records
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class='box'>
    <div class='box-body'>
    <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:8%'>SO #</th>
                  <th style='width:25%'>Customer</th>
                  <th style='width:10%'>Amount</th>
                  <th style='width:10%'>Less</th>
                  <th style='width:10%'>Total</th>
                  <th style='width:25%'>Reason</th>
                  <th style='width:10%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $so->show_data_disapproved();
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
  ?>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php
include 'js.php';
include 'modal_resend.php';
?>

</body>
</html>

<script>

$("#example3").DataTable();

$(document).ready(function(){
    $('#example3 tbody').on('click', '.resend', function () {
      var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   });
});

<?php
if (isset($_GET['resent'])) {
  ?>
    swal("Success", "Successfully resent for approval.", "success");
    history.pushState(null, null, 'disapproved_records');
    <?php
}
?>
</script>
