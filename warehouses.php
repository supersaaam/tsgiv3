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
include 'models/warehouse_model.php';
include 'models/settings_model.php';

$set = new Settings();
$set->set_hw('260px', '520px');
$warehouse = new Warehouse();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Warehouse Records
        <small>Records Management</small>
      </h1>
          <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="records">Record Management Dashboard</a></li>
              <li class="breadcrumb-item active">Warehouse Records</li>
            </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">
              <a href='javascript:void(0);' data-href='view_warehouse.php' id='addWarehouse'><button type='button' class='btn btn-success'><i class='fa fa-plus'></i> &nbsp;Add New Record</button></a>
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style='width:40%'>Name</th>
                  <th style='width:40%'>Location</th>
                  <th style='width:20%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
$warehouse->show_data();
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
?>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php
include 'modal_warehouse.php';
include 'js.php';
?>

</body>
</html>
<script>

<?php
if (isset($_GET['success'])) {
  ?>
    swal('Success', 'Record successfully saved.', 'success');
    history.pushState(null, null, '/warehouse');
<?php
} elseif (isset($_GET['edited'])) {
  ?>
    swal('Success', 'Record successfully updated.', 'success');
    history.pushState(null, null, '/warehouse');
<?php
} elseif (isset($_GET['deleted'])) {
  ?>
    swal('Success', 'Record successfully deleted.', 'success');
    history.pushState(null, null, '/warehouse');
<?php
}
?>

$(document).ready(function(){
  $('#example1 tbody').on('click', '.editWarehouse', function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   });

   $('#example1 tbody').on('click', '.delete', function () {
      var id = $(this).attr('id');

      swal({
        title: "Are you sure?",
        text: "You are about to delete this warehouse. Proceed?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, proceed",
        cancelButtonText: "No, cancel",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm) {
        if (isConfirm) {
          window.location.href = 'models/warehouse_model.php?id_delete='+id;
        } else {
          swal.close();
        }
      });
   });

   $('#addWarehouse').click(function () {
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
