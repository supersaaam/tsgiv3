<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Agrimate | Records Module</title>
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
include 'models/check_model.php';
include 'models/company_model.php';
include 'models/payee_model.php';
include 'models/settings_model.php';

$chk = new Check();
$cmp = new Company();
$py  = new Payee();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Approve Check Voucher
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style='width:9%'>AP Ref Number</th>
                  <th style='width:9%'>Check Number</th>
                  <th style='width:9%'>Check Date</th>
                  <th style='width:14%'>Payee</th>
                  <th style='width:13%'>Company</th>
                  <th style='width:8%'>BIR</th>
                  <th style='width:8%'>EWT</th>
                  <th style='width:8%'>Check Amount</th>
                  <th style='width:22%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
$chk->show_data_for_approval();?>
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
?>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php
include 'js.php';
include 'modal_check_details.php';
?>

</body>
</html>

<script>

<?php
if (isset($_GET['approved'])) {
  ?>
    swal('Success', 'Record successfully approved.', 'success');
    history.pushState(null, null, 'check_approval');
<?php
}
elseif (isset($_GET['cancelled'])) {
    ?>
      swal('Success', 'Record successfully cancelled.', 'success');
      history.pushState(null, null, 'check_approval');
  <?php
  }
?>

$(document).ready(function(){
   $('#example1 tbody').on('click', '.print', function () {
      var dataURL = $(this).attr('data-href');
        $('#view_body_check').load(dataURL,function(){
            $('#view_modal_check').modal({show:true});
        });
   });
});

  $(function () {
    $('#example1').DataTable();
  })

</script>
