<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Agrimate | Importation Module</title>
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
include 'models/attachment_model.php';
include 'models/importation_model.php';

$att = new Attachment();
$imp = new Importation();

if(isset($_GET['inv_'])){
  $inv = $_GET['inv_'];
}
else{
  $inv = $_GET['inv'];
}

$imp->set_data($inv);
$stat = $imp->comp_stat;
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <section class="content-header">
      <h1>
      Document Attachments
      </h1>
      
      <?php
if(isset($_GET['inv'])){
      ?>
          <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="importation">Importation Module</a></li>
              <li class="breadcrumb-item active">Document Attachments</li>
            </ol>
            <?php
}
elseif(isset($_GET['inv_'])){
?>
           <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="finance">Finance Module</a></li>
              <li class="breadcrumb-item active">Document Attachments</li>
            </ol>
<?php
}
            ?>
    </section>

    <!-- Main content -->
    <section class="content">
          <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:80%'>File Name</th>
                  <th style='width:20%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!isset($_GET['inv_'])){
                  $att->show_data($inv);
                }
                else{
                  $att->show_data_($inv);
                }
                ?>
                </tbody>
              </table>
            </div>
            </div>
            
    <div class='clearfix' style='clear:both; height:10px'></div>

    <form method='post' id="form" action='models/attachment_model.php' enctype='multipart/form-data'>

    <?php
if(!isset($_GET['inv_'])){

if ($stat != 'YES') {
  ?>
    <button type="button"
    onclick="complete('<?php echo $inv; ?>')" class="btn btn-primary" style="font-weight:normal; float:right; margin-right:10px"><i class="fa fa-check"></i> &nbsp;Mark as Completed</button>
    <input type="hidden" value="<?php echo $inv; ?>" name="inv">
    <input id="file-upload" name="docs[]" type="file" multiple="multiple"/>
    <?php
}

}
?>

    </form>
    </section>
    <!-- /.content -->

     <div class='clearfix' style='clear:both; height:30px'></div>

  </div>
  <!-- /.content-wrapper -->



<?php
include 'footer.php';
?>

</div>
<!-- ./wrapper -->

<?php
include 'js.php';
?>

</body>
</html>

<script>
document.getElementById("file-upload").onchange = function() {
    document.getElementById("form").submit();
};

<?php
if (isset($_GET['uploaded'])) {
  ?>
    swal("Success", "Successfully uploaded images.", "success");
    history.pushState(null, null, 'attachment?inv=<?php echo $inv; ?>');
    <?php
} elseif (isset($_GET['not_uploaded'])) {
  ?>
    swal("Validation", "An error occured. Please reupload files", "warning");
    history.pushState(null, null, 'attachment?inv=<?php echo $inv; ?>');
    <?php
}
elseif (isset($_GET['deleted'])) {
  ?>
    swal("Success", "Successfully deleted record.", "success");
    history.pushState(null, null, 'attachment?inv=<?php echo $inv; ?>');
    <?php
}
?>

function complete(inv){
  swal({
    title: "Are you sure?",
    text: "Marking this invoice as complete with documents would trigger the Finance Department to ready the payment to the supplier. Proceed?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Yes, proceed!',
    cancelButtonText: "No, cancel it!",
    closeOnConfirm: false,
    closeOnCancel: false
 },
 function(isConfirm){
    if (isConfirm){
      window.location.href = "models/importation_aed.php?inv_comp="+inv;
    } else {
      swal.close();
    }
 });
}

<?php
if (isset($_GET['complete'])) {
  ?>
    swal("Success", "Successfully updated record.", "success");
    history.pushState(null, null, '/attachment?inv=<?php echo $inv; ?>');
    <?php
}
?>

$('#example1').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
</script>
