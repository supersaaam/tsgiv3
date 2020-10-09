<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Transcendo | Records Module</title>
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

//Models
include 'models/customer_model.php';
include 'models/settings_model.php';
include 'models/cmo_cust_model.php';

$customer = new Customer();
$cmo_cust = new CMO_Cust();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Customers
        <small>Records Management</small>
      </h1>
          <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="records">Record Management Dashboard</a></li>
              <li class="breadcrumb-item active">Customers</li>
            </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">
              <a href='javascript:void(0);' data-href='view_customer.php' id='addCustomer'><button type='button' class='btn btn-success'><i class='fa fa-plus'></i> &nbsp;Add New Record</button></a>
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style='width:30%'>Company Name</th>
                  <th style='width:40%'>Address - Agent</th>
                  <th style='width:30%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
$customer->show_data();
?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>

  <?php
include 'modal_customer.php';
include 'modal_cmo.php';
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
<?php
if (isset($_GET['cmo'])) {
  ?>
    swal('Success', 'CMO successfully assigned to customer.', 'success');
    history.pushState(null, null, 'customer');
<?php
} elseif (isset($_GET['edited'])) {
  ?>
      swal('Success', 'Customer record successfully edited.', 'success');
      history.pushState(null, null, 'customer');
<?php
} elseif (isset($_GET['deleted'])) {
  ?>
      swal('Success', 'Customer record successfully deleted.', 'success');
      history.pushState(null, null, 'customer');
  <?php
} elseif (isset($_GET['success'])) {
  ?>
        swal('Success', 'Customer record successfully inserted.', 'success');
        history.pushState(null, null, 'customer');
    <?php
}
?>

$(document).ready(function(){
  $('#example1 tbody').on('click', '.editCustomer', function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   });
   
   $('#example1 tbody').on('click', '.viewCustomer', function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   });

   $('#example1 tbody').on('click', '.editCMO', function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body_cmo').load(dataURL,function(){
            $('#view_modal_cmo').modal({show:true});
        });
   });

   $('#addCustomer').click(function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   });
});

  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
