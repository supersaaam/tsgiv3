<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Agrimate | Sales Order Records Module</title>
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
include 'models/customer_model.php';
include 'models/sales_order_model.php';

$so   = new Sales_Order();
$cust = new Customer();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      SI and DR Records
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class='box'>
    <div class='box-body'>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:4%'>SI Number</th>
                  <th style='width:4%'>DR Number</th>
                  <th style='width:17%'>Company Name</th>
                  <th style='width:10%'>Amount</th>
                  <th style='width:10%'>SI Returned</th>
                  <th style='width:10%'>DR Returned</th>
                  <th style='width:10%'>DR Delivered</th>
                  <th style='width:35%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
$so->show_data_sidr();
?>
                </tbody>
              </table>

            </div>
            </div>

      <h3>
      Sales Invoice Report
      </h3>

        <div class="box">
            <form action='print_si_report.php' method='post'>
            <div class="box-header">

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                    <label>Filter</label>
                    <br>
                    <input type='radio' id='filter' name='filter' checked value='all'> Show all &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' id='filter' name='filter' value='column'> Filter by column
                  </div>
                  </div>

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                    <label>Column</label>
                    <select readonly class="form-control" required name="column" id='column'>
                      <option value="SI Number" >SI Number</option>
                      <option value="DR Number" >DR Number</option>
                      <option value="Company" >Company</option>
                    </select>
                  </div>
                  </div>

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                    <label>Value</label>
                    <input readonly list="si_list" id='field' required name="value" class="form-control"  maxlength="50" placeholder="Please input here ...">
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

    </section>
    <!-- /.content -->
  </div>


                        <datalist id="customer_list">
                          <?php
$cust->show_data_dl();
?>
                        </datalist>

                        <datalist id="si_list">
                          <?php
$so->show_data_dl_si();
?>
                        </datalist>

                        <datalist id="dr_list">
                          <?php
$so->show_data_dl_dr();
?>
                        </datalist>

  <?php
include 'footer.php';
include 'modal_drc.php';
include 'modal_records.php';
include 'modal_cdm.php';
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

$("#example1").DataTable();

function tick_si(id){
    if($("#"+id).prop('checked')){
        var dataURL = 'si_date.php?id='+id;
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
    }

}

function tick_dr(id){
    if($("#"+id).prop('checked')){
        var dataURL = 'dr_date.php?id='+id;
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
    }
}

$('#example1 tbody').on('click', '.viewDrc', function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   });

   $('#example1 tbody').on('click', '.viewRec', function () {
      var dataURL = $(this).attr('data-href');
        $('#view_body_records').load(dataURL,function(){
            $('#view_modal_records').modal({show:true});
        });
   });

   $('#example1 tbody').on('click', '.viewCdm', function () {
      var dataURL = $(this).attr('data-href');
        $('#view_body_cdm').load(dataURL,function(){
            $('#view_modal_cdm').modal({show:true});
        });
   });

<?php
if (isset($_GET['drc'])) {
  ?>
    swal("Success", "Successfully recorded DR Countered Date.", "success");
    history.pushState(null, null, 'sidr_records');
<?php
} elseif (isset($_GET['sid'])) {
  ?>
    swal("Success", "Successfully recorded SI Returned Date.", "success");
    history.pushState(null, null, 'sidr_records');
<?php
} elseif (isset($_GET['drd'])) {
  ?>
    swal("Success", "Successfully recorded DR Returned Date.", "success");
    history.pushState(null, null, 'sidr_records');
<?php
} elseif (isset($_GET['success_debit'])) {
  ?>
    swal("Success", "Successfully recorded Debit Memo.", "success");
    history.pushState(null, null, 'sidr_records');
<?php
} elseif (isset($_GET['success'])) {
  ?>
    swal("Success", "Successfully recorded Credit Memo.", "success");
    history.pushState(null, null, 'sidr_records');
<?php
}
?>

$('input[type=radio][name=filter]').change(function() {
    var filter = $("input[name='filter']:checked").val(); //all / column
    var column = $("#column").val();
    var field = $("#field").val();

    if(filter == 'all'){
        //disable column
            $("#column").attr('readonly', true);
        //disable value
            $("#field").attr('readonly', true);
    }
    else{
        //enable column
            $("#column").attr('readonly', false);
        //enable value
            $("#field").attr('readonly', false);
    }
});


$("#column").change(function (){
    var column = $("#column").val();

    $("#field").val('');

    if(column == 'SI Number'){
        $("#field").attr('list', 'si_list');
    }
    else if(column == 'DR Number'){
        $("#field").attr('list', 'dr_list');
    }
    else if(column == 'Company'){
        $("#field").attr('list', 'customer_list');
    }
});
</script>
