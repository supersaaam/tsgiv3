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
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <?php
include 'header_top.php';
include 'models/sales_order_model.php';
include 'models/customer_model.php';

$so   = new Sales_Order();
$cust = new Customer();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Sales Order Records
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class='box'>
    <div class='box-body'>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:10%'>SO #</th>
                  <th style='width:22%'>Customer</th>
                  <th style='width:19%'>Address</th>
                  <th style='width:13%'>Terms</th>
                  <th style='width:13%'>Amount</th>
                  <th style='width:13%'>Status</th>
                  <th style='width:10%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
$so->show_data_all();
?>
                </tbody>
              </table>

            </div>
            </div>

    <h3>
      Sales Order Report
      </h3>

        <div class="box">
            <form action='print_so.php' method='post'>
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
                      <option value="SO Number" >SO Number</option>
                      <option value="Customer" >Customer</option>
                      <option value="Status" >Status</option>
                    </select>
                  </div>
                  </div>

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                    <label>Value</label>
                    <input readonly list="so_list" id='field' required name="value" class="form-control"  maxlength="50" placeholder="Please input here ...">
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

                        <!-- DATALISTS -->
                        <datalist id="customer_list">
                          <?php
$cust->show_data_dl();
?>
                        </datalist>

                        <datalist id="so_list">
                          <?php
$so->show_data_dl();
?>
                        </datalist>

                        <datalist id="stat_list">
                          <option value='Approved'>
                          <option value='Disapproved'>
                          <option value='Pending'>
                        </datalist>

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

    if(column == 'SO Number'){
        $("#field").attr('list', 'so_list');
    }
    else if(column == 'Status'){
        $("#field").attr('list', 'stat_list');
    }
    else if(column == 'Customer'){
        $("#field").attr('list', 'customer_list');
    }
});
</script>
