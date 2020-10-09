<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Transcendo | Quote Requests Module</title>
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
include 'models/supplier_model.php';
include 'models/settings_model.php';
include 'models/quotation_model.php';


$q = new Quotation();
$set = new Settings();
$set->set_hw('420px', '520px');
$supplier = new Supplier();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Quotation Requests
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">
              <a href='javascript:void(0);' data-href='view_qr.php' id='addSupplier'><button type='button' class='btn btn-success'><i class='fa fa-plus'></i> &nbsp;Add New Record</button></a>
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style='width:10%'>Control #</th>
                  <th style='width:15%'>Customer</th>
                  <th style='width:15%'>Contact Person/Number</th>
                  <th style='width:20%'>Content</th>
                  <th style='width:15%'>Remarks/Special Instruction</th>
                  <th style='width:10%'>Date Quoted</th>
                  <th style='width:15%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
			$q->show_request();
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
include 'modal_qr.php';
include 'modal_quoted.php';
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

$(document).ready(function() {
    $('#example1').DataTable( {
        page: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                     columns: [ 0, 1, 2, 3, 4, 5 ]
                }
            }
        ]
    } );
});


<?php
if (isset($_GET['success'])) {
  ?>
    swal('Success', 'Record successfully saved.', 'success');
    history.pushState(null, null, 'quote_request');
<?php
} 
elseif (isset($_GET['quoted'])) {
  ?>
    swal('Success', 'Record successfully marked as quoted.', 'success');
    history.pushState(null, null, 'quote_request');
<?php
} 
elseif (isset($_GET['edited'])) {
  ?>
    swal('Success', 'Record successfully edited.', 'success');
    history.pushState(null, null, 'quote_request');
<?php
} 
elseif (isset($_GET['deleted'])) {
  ?>
    swal('Success', 'Record successfully deleted.', 'success');
    history.pushState(null, null, 'quote_request');
<?php
} 
?>

$(document).ready(function(){
  $('#example1 tbody').on('click', '.editQR', function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   
   });
   
   $('#example1 tbody').on('click', '.quoted', function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body_q').load(dataURL,function(){
            $('#view_modal_q').modal({show:true});
        });
   
   });
   

   $('#addSupplier').click(function () {
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
