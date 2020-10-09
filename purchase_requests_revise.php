<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Transcendo | PR Module</title>
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
include 'models/pr_model.php';

$pr = new PR();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php
        $pr->show_pr_revise();
        
        if($pr->prcnt == 0) {
            echo "
            <div style='clear: both; height: 300px;'></div>
            <center>
            <span style='font-size: 30px; font-weight: bold;'>No PR records to show...</span>
            <center>
            ";
        }
    ?>
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
<?php
if (isset($_GET['pending'])) {
  ?>
    swal("Success", "PR successfully revised and is marked as pending.", "success");
    history.pushState(null, null, 'purchase_requests_revise');
<?php
}
elseif (isset($_GET['approved'])) {
  ?>
    swal("Success", "PR successfully recorded as approved.", "success");
    history.pushState(null, null, 'purchase_requests');
<?php
}
?>


$("#example1").DataTable();

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
