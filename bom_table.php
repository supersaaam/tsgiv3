<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Transcendo | Bill of Materials Module</title>
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
include 'models/bom_model.php';

$bom = new BOM();
$bom->get_last_q();
$id = $bom->last_id;
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bill of Materials
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">
              <a href='models/bom_aed.php?add_bom=<?php echo $id; ?>'><button type='button' class='btn btn-success'><i class='fa fa-plus'></i> &nbsp;Add New BOM</button></a>
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style='width:9.5%%'>Action</th>
                  <th style='width:24%'>Project Name</th>
                  <th style='width:9.5%'>Foreign</th>
                  <th style='width:9.5%%'>Local</th>
                  <th style='width:9.5%%'>Labor</th>
                  <th style='width:9.5%%'>SubCon</th>
                  <th style='width:9.5%%'>Permits</th>
                  <th style='width:9.5%%'>Actual BOM</th>
                  <th style='width:9.5%%'>Miscellaneous</th>
                </tr>
                </thead>
                <tbody>
                <?php
			        $bom->show_data();
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
include 'modal_ins_po.php';
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

   $('#example1 tbody').on('click', '.ins_po', function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   
   });

$(document).ready(function() {
    $('#example1').DataTable();
});

</script>
<script>
<?php
if (isset($_GET['success_name'])) {
  ?>
    swal('Success', 'Project name successfully updated.', 'success');
    history.pushState(null, null, 'generate_bom');
<?php
}
elseif (isset($_GET['deleted'])) {
  ?>
    swal('Success', 'Project successfully deleted.', 'success');
    history.pushState(null, null, 'generate_bom');
<?php
}
?>
</script>
