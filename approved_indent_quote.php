<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Transcendo | Quotation Module</title>
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
include 'models/quotation_model.php';

$q = new Quotation();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Approved Indent Quotation
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class='box'>
    <div class='box-body'>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
               <tr>
                  <th style='width:6%'>Quotation No.</th>
                  <th style='width:10%'>PR No.</th>
                  <th style='width:10%'>Date</th>
                  <th style='width:16%'>Client</th>
                  <th style='width:14%'>Quoted By</th>
                  <th style='width:4%'>Currency</th>
                  <th style='width:10%'>Total Amount</th>
                  <th style='width:20%'>Remarks</th>
                  <th style='width:10%'>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                       $q->show_data_approved_in();
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
include 'modal_viewso.php';
include 'modal_deductions.php';
include 'modal_records.php';
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
                     columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
                }
            }
        ]
    } );
} );

<?php
if (isset($_GET['rejected'])) {
  ?>
    swal("Success", "Successfully marked quotation as rejected.", "success");
    history.pushState(null, null, 'approved_indent_quote');
<?php
}
elseif (isset($_GET['success_po'])) {
  ?>
    swal("Success", "Successfully recorded quotation as purchase order.", "success");
    history.pushState(null, null, 'approved_indent_quote');
<?php
}

elseif (isset($_GET['disapproved'])) {
  ?>
    swal("Success", "Successfully recorded quotation as for revision.", "success");
    history.pushState(null, null, 'approved_indent_quote');
<?php
}
elseif (isset($_GET['remarks'])) {
  ?>
    swal("Success", "Successfully recorded remarks.", "success");
    history.pushState(null, null, 'approved_indent_quote');
<?php
}
elseif (isset($_GET['accepted'])) {
  ?>
    swal("Success", "Successfully marked quotation as accepted.", "success");
    history.pushState(null, null, 'approved_indent_quote');
<?php
}
?>


$(document).ready(function(){
  $('#example1 tbody').on('click', '.openView', function () {
       var id = $(this).attr('id');
       window.location.href='models/sales_order_model.php?verify='+id;
   });

   $('#example1 tbody').on('click', '.viewRec', function () {
      var dataURL = $(this).attr('data-href');
        $('#view_body_records').load(dataURL,function(){
            $('#view_modal_records').modal({show:true});
        });
   });

   $('#example1 tbody').on('click', '.view', function () {
      var dataURL = $(this).attr('data-href');
        $('#view_body_so').load(dataURL,function(){
            $('#view_modal_so').modal({show:true});
        });
   });

});

</script>
