<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Transcendo | Accounting Module</title>
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
include 'models/payable_tsgi_model.php';
include 'models/settings_model.php';

$set = new Settings();
$set->set_hw('150px', '520px');
$py = new Payable();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Payable Monitoring
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class='box'>
    <div class='box-body'>
       
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style='width:20%'>Particular</th>
                  <th style='width:20%'>Account Number</th>
                  <th style='width:15%'>Contact Number</th>
                  <th style='width:15%'>Due Date</th>
                  <th style='width:20%'>Amount</th>
                  <th style='width:10%'>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php
$py->show_data_pm();
?>
                </tbody>
              </table>
              
            </div>
            </div>
    </section>
    <!-- /.content -->
   
   
   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Paid Payables
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class='box'>
    <div class='box-body'>
       
            <table id="example2" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style='width:22%'>Particular</th>
                  <th style='width:22%'>Account Number</th>
                  <th style='width:17%'>Contact Number</th>
                  <th style='width:17%'>Due Date</th>
                  <th style='width:22%'>Amount</th>
                </tr>
                </thead>
                <tbody>
                  <?php
$py->show_data_pm_paid();
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
?>

</body>
</html>

<script>
<?php
if (isset($_GET['paid'])) {
  ?>
    swal('Success', 'Successfully marked as paid.', 'success');
    history.pushState(null, null, 'payable_monitoring');
<?php
}
?>

     $(function () {
    
    $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    })
    
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
