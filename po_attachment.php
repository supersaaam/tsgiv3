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
include 'models/so_model.php';
include 'models/po_attachment_model.php';

$so = new SO();
$id = $_GET['id'];
$att = new Attachment();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Document Attachments
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class='box'>
    <div class='box-body'>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:80%'>File Name</th>
                  <th style='width:20%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                	$att->show_data($id);
               
                ?>
                </tbody>
              </table>

            </div>
            </div>
            
            
    <div class='clearfix' style='clear:both; height:10px'></div>

    <form method='post' id="form" action='models/po_attachment_model.php' enctype='multipart/form-data'>
     
    <input type="hidden" value="<?php echo $id; ?>" name="id">
    <input id="file-upload" name="docs[]" type="file" multiple="multiple" style='float:left'/>
     <button type='submit' class='btn btn-primary btn-sm' style='float:left'><i class='fa fa-save'></i>&nbsp;&nbsp;Save</button>
    </form>
    
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
<?php
if (isset($_GET['uploaded'])) {
  ?>
    swal("Success", "Successfully uploaded files.", "success");
    history.pushState(null, null, 'po_attachment?id=<?php echo $_GET['id']; ?>');
<?php
}
elseif (isset($_GET['not_uploaded'])) {
  ?>
    swal("Ooopss", "Wasn't able to upload files. Try again!", "error");
    history.pushState(null, null, 'po_attachment?id=<?php echo $_GET['id']; ?>');
<?php
}
elseif (isset($_GET['deleted'])) {
  ?>
    swal("Success", "File attachment successfully deleted.", "success");
    history.pushState(null, null, 'po_attachment?id=<?php echo $_GET['id']; ?>');
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
