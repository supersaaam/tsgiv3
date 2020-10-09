<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Agrimate | Inventory Breakdown Module</title>
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
    include 'models/breakdown_model.php';
    include 'models/packaging_model.php';
    
    $bd = new Breakdown();
    $packaging = new Packaging();
  ?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Inventory Breakdown
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class='box'>
        <div class='box-body'>
        <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:17%'>Proforma Inv. No.</th>
                  <th style='width:20%'>Date Created</th>
                  <th style='width:32%'>Supplier</th>
                  <th style='width:16%'>Delivery Status</th>
                  <th style='width:15%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $bd->show_data();
                ?>
                </tbody>
              </table>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
                        <datalist id="packaging_list">
                          <?php
                          $packaging->show_packaging();
                          ?>
                        </datalist>
  <?php
    include 'footer.php';
    include 'modal_viewbreakdown.php';
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
$('#example1').DataTable();
    
$(document).ready(function(){
  $('#example1 tbody').on('click', '.openView', function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   });
});

<?php
if(isset($_GET['success'])){
?>
    swal("Success", "Successfully inserted in inventory record.", "success");
    history.pushState(null, null, '/inv_breakdown');
<?php
}
?>

</script>

