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
include 'models/importation_model.php';
include 'models/terms_imp_model.php';
include 'models/product_model.php';
include 'models/supplier_model.php';
include 'models/packaging_model.php';
include 'models/origin_model.php';

$t_imp     = new Terms_Imp();
$prod      = new Product();
$supp      = new Supplier();
$packaging = new Packaging();
$imp       = new Importation();
$origin    = new Origin();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Importation Module
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">
              <button data-toggle="modal" data-target="#myModal" type='button' class='btn btn-success'><i class='fa fa-plus'></i> &nbsp;Add New Record</button>
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:15%'>Prof. Invoice No.</th>
                  <th style='width:16%'>Date Created</th>
                  <th style='width:30%'>Supplier</th>
                  <th style='width:14%'>Status</th>
                  <th style='width:25%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
$imp->show_data();
?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

      <h3>
      Importation Report
      </h3>

        <div class="box">
            <form action='print_importation.php' method='post'>
            <div class="box-header">

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                    <label>Filter</label>
                    <br>
                    <input type='radio' id='filter' name='filter_imp' checked value='all'> Show all &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' id='filter' name='filter_imp' value='column'> Filter by column
                  </div>
                  </div>

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                    <label>Column</label>
                    <select readonly class="form-control" required name="column" id='column_imp'>
                      <option value="Proforma Invoice" >Proforma Invoice</option>
                      <option value="Proforma Invoice Date" >Proforma Invoice Date</option>
                      <option value="Supplier" >Supplier</option>
                      <option value="Origin" >Origin</option>
                      <option value="Delivery Status" >Delivery Status</option>
                    </select>
                  </div>
                  </div>

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                    <label>Value</label>
                    <input readonly list="profinv_list" id='field_imp' required name="value" class="form-control"  maxlength="50" placeholder="Please input here ...">
                  </div>
                  </div>

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                  <label>&nbsp;</label><br>
                  <button type='submit' class='btn btn-success'><i class='fa fa-file'></i> &nbsp;Generate Report</button>
                  </div>
                  </div>

            </div>
          </form>
        </div>
      <h3>
      Importation Table Report
      </h3>

      <form action="print_inv_table.php">
        <div class='box'>
          <div class="box-body">
            <div class="row">
              <div class="form-group col-md-4">
                <label>Warehouse</label>
                <input list="warehouse_list" name="warehouse" class="form-control"placeholder="(Optional)">
              </div>
              <div class="form-group col-md-4">
                <label>Product Code</label>
                <input list="prodcode_list" name="prodcode" class="form-control"placeholder="(Optional)">
              </div>
              <div class="form-group col-md-4">
                <label>Date Range</label>
                <input name="date" class="form-control" placeholder="(Optional)" daterangepicker>
              </div>
              <div class="form-group col-md-12">
                <label>&nbsp;</label><br>
                <button type='submit' class='btn btn-success pull-right'><i class='fa fa-file'></i> &nbsp;Generate Report</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </section>
    <!-- /.content -->
  </div>

                        <!-- DATALISTS -->
                        <datalist id="products_list">
                          <?php
$prod->show_product();
?>
                        </datalist>

                        <datalist id="suppliers_list">
                          <?php
$supp->show_supplier();
?>
                        </datalist>

                        <datalist id="packaging_list">
                          <?php
$packaging->show_packaging();
?>
                        </datalist>

                        <datalist id="profinv_list">
                          <?php
$imp->show_invoices();
?>
                        </datalist>

                        <datalist id="term_list">
                          <?php
$t_imp->show_terms_dl();
?>
                        </datalist>

                        <datalist id="origin_list">
                          <?php
$origin->show_origin();
?>
                        </datalist>

                        <datalist id="delstat_list">
                          <option value='Ordered'>
                          <option value='Sailing'>
                          <option value='Delayed'>
                          <option value='Arrived Port'>
                          <option value='On Transit'>
                          <option value='Delivered'>
                        </datalist>

  <?php
include 'footer.php';
?>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php
include 'js.php';

//MODALS
include 'modal_newimp.php';
include 'modal_viewimp.php';
include 'script_modal.php';
include 'script_general.php';
?>

</body>
</html>

<script>
<?php
if (isset($_GET['success'])) {
  ?>
    swal("Success", "Successfully added new record.", "success");
    history.pushState(null, null, 'importation');
    <?php
} elseif (isset($_GET['edited'])) {
  ?>
    swal("Success", "Successfully edited record.", "success");
    history.pushState(null, null, 'importation');
    <?php
}
?>
</script>

<script>
$(document).ready(function(){
  $('#example1 tbody').on('click', '.openView', function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   });
});

$(function () {
  var table = $("#example1").DataTable();
  table.destroy();

    $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })

  $('input[type=radio][name=filter_imp]').change(function() {
    var filter = $("input[name='filter_imp']:checked").val(); //all / column
    var column = $("#column_imp").val();
    var field = $("#field_imp").val();

    if(filter == 'all'){
        //disable column
            $("#column_imp").attr('readonly', true);
        //disable value
            $("#field_imp").attr('readonly', true);
    }
    else{
        //enable column
            $("#column_imp").attr('readonly', false);
        //enable value
            $("#field_imp").attr('readonly', false);
    }
});

$("#column_imp").change(function (){
    var column = $("#column_imp").val();

    $("#field_imp").val('');

    if(column == 'Supplier'){
        $("#field_imp").attr('list', 'suppliers_list');
    }
    else if(column == 'Delivery Status'){
        $("#field_imp").attr('list', 'delstat_list');
    }
    else if(column == 'Proforma Invoice'){
        $("#field_imp").attr('list', 'profinv_list');
    }
    else if(column == 'Origin'){
        $("#field_imp").attr('list', 'origin_list');
    }
});
</script>
