<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Agrimate | Records Module</title>
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
include 'models/check_model.php';
include 'models/company_model.php';
include 'models/payee_model.php';
include 'models/settings_model.php';

$chk = new Check();
$cmp = new Company();
$py  = new Payee();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Generate Check Voucher
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">
              <a href='javascript:void(0);' data-href='view_check.php' id='addCheck'><button type='button' class='btn btn-success'><i class='fa fa-plus'></i> &nbsp;Create New Check Voucher</button></a>
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style='width:10%'>AP Ref Number</th>
                  <th style='width:10%'>Check Number</th>
                  <th style='width:10%'>Check Date</th>
                  <th style='width:14%'>Payee</th>
                  <th style='width:14%'>Company</th>
                  <th style='width:9%'>BIR</th>
                  <th style='width:9%'>EWT</th>
                  <th style='width:9%'>Check Amount</th>
                  <th style='width:15%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
$chk->show_data();?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

      <h3>
      Check Voucher Report
      </h3>

        <div class="box">
            <form action='print_cv.php' method='post'>
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
                      <option value="AP Reference Number" >AP Reference Number</option>
                      <option value="Payee" >Payee</option>
                      <option value="Company" >Company</option>
                      <option value="BIR" >BIR</option>
                    </select>
                  </div>
                  </div>

                  <div class="col-md-3" style="float:left">
                  <div class="form-group">
                    <label>Value</label>
                    <input readonly list="apref_list" id='field' required name="value" class="form-control"  maxlength="50" placeholder="Please input here ...">
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
                        <datalist id="payee_list">
                          <?php
$py->show_data_dl();
?>
                        </datalist>

                        <datalist id="company_list">
                          <?php
$cmp->show_data_dl();
?>
                        </datalist>

                        <datalist id="apref_list">
                          <?php
$chk->show_data_dl();
?>
                        </datalist>

                      <datalist id="bir_list">
                          <option value='BIR'>
                          <option value='Non-BIR'>
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
include 'modal_check.php';
include 'modal_check_details.php';
?>

</body>
</html>
<script>

<?php
if (isset($_GET['success'])) {
  ?>
    swal('Success', 'Record successfully saved.', 'success');
    history.pushState(null, null, 'check');
<?php
}
?>

$(document).ready(function(){
   $('#addCheck').click(function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   });

   $('#example1 tbody').on('click', '.print', function () {
      var dataURL = $(this).attr('data-href');
        $('#view_body_check').load(dataURL,function(){
            $('#view_modal_check').modal({show:true});
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

    if(column == 'AP Reference Number'){
        $("#field").attr('list', 'apref_list');
    }
    else if(column == 'Payee'){
        $("#field").attr('list', 'payee_list');
    }
    else if(column == 'Company'){
        $("#field").attr('list', 'company_list');
    }
    else if(column == 'BIR'){
        $("#field").attr('list', 'bir_list');
    }
});
</script>
