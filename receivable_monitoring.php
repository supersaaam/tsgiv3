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


include 'models/receivable_model.php';

$r = new Receivable();

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Receivable Monitoring
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class='box'>
        
            <div class="box-header">
              <h3 class="box-title">
              <a href='javascript:void(0);' data-href='view_receivable.php' id='addPayee'><button type='button' class='btn btn-success'><i class='fa fa-plus'></i> &nbsp;Add New Record</button></a>
              </h3>
            </div>
            <!-- /.box-header -->
            
    <div class='box-body'>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                  
                <tr>
                  <th style='width:10%'>Company</th>
                  <th style='width:10%'>SI Date</th>
                  <th style='width:10%'>Countered Date</th>
                  <th style='width:10%'>Due Date</th>
                  <th style='width:10%'>SI Number</th>
                  <th style='width:10%'>Gross Amount</th>
                  <th style='width:10%'>Net Amount</th>
                  <th style='width:10%'>VAT</th>
                  <th style='width:10%'>Remarks</th>
                  <th style='width:10%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
$r->show_data();
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
      Paid Receivable Monitoring
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class='box'>
        
    <div class='box-body'>
            <table id="example2" class="table table-bordered table-striped">
              <thead>
                  
                <tr>
                  <th style='width:15%'>Company</th>
                  <th style='width:10%'>SI Date</th>
                  <th style='width:10%'>Countered Date</th>
                  <th style='width:10%'>Due Date</th>
                  <th style='width:10%'>SI Number</th>
                  <th style='width:10%'>Gross Amount</th>
                  <th style='width:10%'>Net Amount</th>
                  <th style='width:10%'>VAT</th>
                  <th style='width:15%'>Remarks</th>
                </tr>
                </thead>
                <tbody>
                <?php
$r->show_data_paid();
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
include 'modal_receivable.php';
include 'modal_date.php';
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
    swal('Success', 'Record successfully saved.', 'success');
    history.pushState(null, null, 'receivable_monitoring');
<?php
}
elseif (isset($_GET['paid'])) {
  ?>
    swal('Success', 'Record successfully marked as paid.', 'success');
    history.pushState(null, null, 'receivable_monitoring');
<?php
}
elseif (isset($_GET['ctrDate'])) {
  ?>
    swal('Success', 'Countered Date successfully recorded.', 'success');
    history.pushState(null, null, 'receivable_monitoring');
<?php
}
elseif (isset($_GET['dueDate'])) {
  ?>
    swal('Success', 'Due Date successfully recorded.', 'success');
    history.pushState(null, null, 'receivable_monitoring');
<?php
}
elseif (isset($_GET['remarks'])) {
  ?>
    swal('Success', 'Remarks successfully recorded.', 'success');
    history.pushState(null, null, 'receivable_monitoring');
<?php
}
elseif (isset($_GET['deleted'])) {
  ?>
    swal('Success', 'Record successfully deleted.', 'success');
    history.pushState(null, null, 'receivable_monitoring');
<?php
}
?>

$(document).ready(function(){
   $('#addPayee').click(function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   });
   
   $('#example1 tbody').on('click', '.ctrDate', function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body_date').load(dataURL,function(){
            $('#view_modal_date').modal({show:true});
        });
   });
});

$(function () {
    $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    })
    $('#example2').DataTable();
  })
</script>