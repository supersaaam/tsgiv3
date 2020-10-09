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
        Payable Records
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">
              <a href='javascript:void(0);' data-href='view_payable_tsgi.php' id='addPayee'><button type='button' class='btn btn-success'><i class='fa fa-plus'></i> &nbsp;Add New Record</button></a>
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style='width:15%'>Particular</th>
                  <th style='width:15%'>Account Number</th>
                  <th style='width:15%'>Contact Number</th>
                  <th style='width:15%'>Due Date</th>
                  <th style='width:15%'>Amount</th>
                  <th style='width:25%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
$py->show_data();
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
include 'footer.php';
include 'modal_payable.php';
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
    history.pushState(null, null, 'payable_accounts');
<?php
}
elseif (isset($_GET['success_pm'])) {
  ?>
    swal('Success', 'Record successfully saved.', 'success');
    history.pushState(null, null, 'payable_accounts');
<?php
}
elseif (isset($_GET['edited'])) {
  ?>
    swal('Success', 'Record successfully updated.', 'success');
    history.pushState(null, null, 'payable_accounts');
<?php
} elseif (isset($_GET['deleted'])) {
  ?>
    swal('Success', 'Record successfully deleted.', 'success');
    history.pushState(null, null, 'payable_accounts');
<?php
}
?>

$(document).ready(function(){
  $('#example1 tbody').on('click', '.editPayee', function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   });

   $('#addPayee').click(function () {
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
