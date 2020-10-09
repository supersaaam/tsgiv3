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
        Actual Inventory Records
        <small>Records Management</small>
      </h1>
          <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="records">Record Management Dashboard</a></li>
              <li class="breadcrumb-item active">Inventory Stock Records</li>
            </ol>
            
        <a href='javascript:void(0);' data-href='view_pr_inventory.php' id='genPR'><button type="button"  name="submit" id="" class="btn btn-success" style="float:right; margin-top:10px; margin-right:20px; margin-bottom:10px"><i class='fa fa-file'></i> &nbsp;Generate PR</button></a>
        
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
                  <th style='width:10%'>Brand</th>
                  <th style='width:10%'>Part Number</th>
                  <th style='width:18%'>Description</th>
                  <th style='width:5%'>Min</th>
                  <th style='width:5%'>Max</th>
                  <th style='width:10%'>Price</th>
                  <th style='width:5%'>Current Stock</th>
                  <th style='width:20%'>Picture</th>
                  <th style='width:15%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $ap->show_data_actual();
                  ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </section>
    
    
    <section class="content-header">
      <h1> 
        Inventory Stock Report
      </h1>
    <div class='clearfix'>&nbsp;</div>
    </section>
    
    <!-- Main content -->
    <section class="content">
    <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <form action='product_report.php' method='post' target='_new'>
                <div class="box-header">
                      <div class="col-md-3" style="float:left">
                      <div class="form-group">
                        <label>Brand</label>
                        <input list='brand_list' required name="supplier" class="form-control"  maxlength="50" placeholder="Please input here ...">
                      </div>
                      </div>
    
                      <div class="col-md-3" style="float:left">
                      <div class="form-group">
                      <label>&nbsp;</label><br>
                      <button type='submit' class='btn btn-success'><i class='fa fa-file'></i> &nbsp;Generate Report</button>
                      </div>
                </div>
              </form>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>

                        <datalist id="brand_list">
                          <?php
                            include 'models/supplier_model.php';
                            $supplier = new Supplier();
                            $supplier->show_supplier_dl();
                            ?>
                            <option value='N/A'>
                        </datalist>

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
    history.pushState(null, null, 'actual_product');
<?php
}
elseif (isset($_GET['image_success'])) {
  ?>
    swal('Success', 'Image successfully uploaded.', 'success');
    history.pushState(null, null, 'actual_product');
<?php
}
elseif (isset($_GET['image_removed'])) {
  ?>
    swal('Success', 'Image successfully removed.', 'success');
    history.pushState(null, null, 'actual_product');
<?php
}
elseif (isset($_GET['image_error'])) {
  ?>
    swal('Error', 'Image upload failed.', 'error');
    history.pushState(null, null, 'actual_product');
<?php
}
/*
elseif (isset($_GET['pr_sent'])) {
  
  if(!isset($_SESSION['used_pnum'])){
  ?>
    swal('Success', 'PR successfully sent.', 'success');
    history.pushState(null, null, 'actual_product');
<?php
  }
  else{
?>
    var used_prnum = '<?php echo $_SESSION['used_pnum']; ?>';
    var newStr = used_prnum.substring(0, used_prnum.length - 2);
    
    if(newStr == ''){
        swal('Success', 'PR successfully sent.', 'success');
    }
    else{
        swal('Validation', 'The following part numbers are already used: '+newStr+'. They are not sent for PR.', 'warning');
    }
    
    history.pushState(null, null, 'actual_product');
    
<?php
    unset($_SESSION['used_pnum']);
  }
}
*/
elseif (isset($_GET['partnumber'])) {
  ?>
    swal('Validation', 'Part number already exists.', 'warning');
    history.pushState(null, null, 'actual_product');
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
   
   $('#genPR').click(function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body_PR').load(dataURL,function(){
            $('#view_modal_PR').modal({show:true});
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
