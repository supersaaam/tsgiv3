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
include 'models/actual_prod_model.php';
include 'models/settings_model.php';

$set = new Settings();
$set->set_hw('300px', '520px');
$ap = new Actual_Prod();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Indent Product Records
        <small>Records Management</small>
      </h1>
          <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="records">Record Management Dashboard</a></li>
              <li class="breadcrumb-item active">Indent Product Records</li>
            </ol>
            
        <div class='clearfix'>&nbsp;</div>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style='width:2%'></th>
                  <th style='width:20%'>Brand</th>
                  <th style='width:10%'>Part Number</th>
                  <th style='width:18%'>Description</th>
                  <th style='width:9%'>Min</th>
                  <th style='width:8%'>Max</th>
                  <th style='width:10%'>Price</th>
                  <th style='width:8%'>Current Stock</th>
                  <th style='width:15%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $ap->show_indent_data();
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
include 'modal_actprod.php';
include 'modal_pr.php';
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
if (isset($_GET['edited'])) {
  ?>
    swal('Success', 'Record successfully updated.', 'success');
    history.pushState(null, null, 'indent_products');
<?php
}
elseif (isset($_GET['partnumber'])) {
  ?>
    swal('Validation', 'Part number already exists.', 'warning');
    history.pushState(null, null, 'indent_products');
<?php
}
?>

$(document).ready(function(){
  $('#example1 tbody').on('click', '.editProduct', function () {
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
