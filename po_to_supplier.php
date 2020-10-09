<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Transcendo | Importation Module</title>
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
include 'models/po_model.php';

$p = new PO();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Pending PO to Supplier
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class='box'>
    <div class='box-body'>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:12%'>PO No.</th>
                  <th style='width:12%'>Date</th>
                  <th style='width:32%'>Company</th>
                  <th style='width:17%'>Total Amount</th>
                  <th style='width:7%'>Type</th>
                  <th style='width:20%'>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        $p->show_pending();
                    ?>
                </tbody>
              </table>

            </div>
            </div>
    </section>
    <!-- /.content -->
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Confirmed PO to Supplier
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class='box'>
        <div class="box-header">
              <h3 class="box-title">
              <a href='javascript:void(0);' data-href='view_costing_multiple.php' id='costing'><button disabled type='button' class='btn btn-success' id='costing_button'><i class='fa fa-calculator'></i> &nbsp;Compute Selected</button></a>
              
                      <input type='hidden' name='compute' id='compute'>
                      
              </h3>
            </div>
    <div class='box-body'>
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:7%'>PO No.</th>
                  <th style='width:7%'>SO Ref No.</th>
                  <th style='width:7%'>Date</th>
                  <th style='width:18%'>Company</th>
                  <th style='width:12%'>Total Amount</th>
                  <th style='width:9%'>Status</th>
                  <th style='width:7%'>Type</th>
                  <th style='width:5%'></th>
                  <th style='width:28%'>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        $p->show_confirmed();
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
include 'modal_po.php';
include 'modal_costing_multiple.php';
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

$(".checkbox").change(function() {
    var i = parseInt(document.querySelectorAll('input[type="checkbox"]:checked').length);
    
    if(i > 0){
        $("#costing_button").removeAttr("disabled");
        var x = $("input[name=compute]:checked").map(
     function () {return this.value;}).get().join(",");
        $("#compute").val(x);
    }
    else{
       $("#costing_button").attr("disabled", true);
    }
});


$(document).ready(function(){
 
   $('#example1 tbody').on('click', '.confirm', function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   
   });
});

<?php
if (isset($_GET['updated'])) {
  ?>
    swal("Success", "Successfully marked as confirmed.", "success");
    history.pushState(null, null, 'po_to_supplier');
<?php
}
elseif (isset($_GET['success'])) {
  ?>
    swal("Success", "Successfully edit PO.", "success");
    history.pushState(null, null, 'po_to_supplier');
<?php
}
?>


$("#example1").DataTable();
$("#example2").DataTable();

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

$('#costing').click(function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   });
   
</script>
