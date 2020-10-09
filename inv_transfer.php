<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Agrimate | Stock Transfer Module</title>
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
include 'models/warehouse_model.php';
include 'models/actual_prod_model.php';
include 'models/transfer_model.php';

$act_prod = new Actual_Prod();
$wh       = new Warehouse();
$trans    = new Transfer();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Transfer of Stocks
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- /.card-header -->
      <div class='box'>
      <div class="box-body">
      <form role="form" action="models/transfer_model.php" method="post" id="">
                  <!-- text input -->
                  <div class="col-md-3" style="float:left; padding-right: 30px">

                  <div class="form-group">
                    <label>Origin</label>
                    <select class="form-control" required name="origin" id="origin">
                      <?php
$wh->show_data_select();
?>
                    </select>
                  </div>

                  </div>

                  <!-- text input -->
                  <div class="col-md-3" style="float:left; padding-right: 30px">

                  <div class="form-group">
                    <label>Destination</label>
                    <select class="form-control" required name="destination" id="destination">
                      <?php
$wh->show_data_select();
?>
                    </select>
                  </div>

                  </div>

                  <!-- text input -->
                  <div class="col-md-3" style="float:left; padding-right: 30px">

                  <div class="form-group">
                    <label>Shipping Line</label>
                    <input name="shipline" maxlength='50' class="form-control tprice" required type='text'>
                  </div>

                  </div>

                  <!-- text input -->
                  <div class="col-md-3" style="float:left; padding-right: 30px">

                  <div class="form-group">
                    <label>Date</label>
                    <input name="date" type='date' id='dte' class="form-control" required>
                  </div>

                  </div>

                <div style="clear:both; height:15px;"></div>
                <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>

                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th style='width:50%'>Product Code</th>
                      <th style='width:20%'>Qty Available</th>
                      <th style='width:20%'>Qty to Transfer</th>
                      <th style='width:10%'></th>
                    </tr>
                  </thead>
                  <tbody id="trans_table">
                    <tr id='tr1'>
                    <td>
                        <input class='counter' id='1' type='hidden'>
                        <!-- pattern="<?php //echo $act_prod->show_code_list(); ?>" -->
                        <input list="prodcode_list" name="prod_code[]" maxlength='50' id='code1'  title="Refer to the data list..." style="background-color:transparent; border:transparent; width:95%" class="form-control" placeholder="Type here ...">
                      </td>
                      <td>
                        <input type="number" readonly id='quan_av1' style="text-align:right; background-color:transparent; border:transparent" required class="form-control num">
                      </td>
                      <td>
                        <input type="number" min='0' name="quantity[]" id='quan1' style="text-align:right; background-color:transparent; border:transparent" class="form-control num" placeholder='0'>
                      </td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
                <button type="button" id="add_row" onclick="add_row1()" class="btn btn-success btn-sm" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-plus'></i> &nbsp;Add New Row</button>
                <br><br>
                <button type="submit" onclick='return check()' name="submit" id="submit_new1" class="btn btn-primary" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-truck'></i> &nbsp;Transfer Stocks</button>
              </form>
      </div>
      </div>

      <div class='box'>
      <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style='width:15%'>STF #</th>
                  <th style='width:15%'>Date Created</th>
                  <th style='width:20%'>Origin</th>
                  <th style='width:20%'>Destination</th>
                  <th style='width:25%'>Shipping Line</th>
                  <th style='width:20%'>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
$trans->show_data();
?>
                </tbody>
              </table>
      </div>
      </div>
    </section>
    <!-- /.content -->
  </div>

                        <datalist id="prodcode_list">
                          <?php
$act_prod->show_data_dl();
?>
                        </datalist>
  <?php
include 'footer.php';
include 'modal_viewtransfer.php';
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
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();

if(dd<10) {
    dd = '0'+dd
}

if(mm<10) {
    mm = '0'+mm
}

today = yyyy + '-' + mm + '-' + dd;
$("#dte").val(today);

var last_id = 2;

function add_row1(){
  var newRow = "<tr id='tr"+last_id+"'><td><input class='counter' id='"+last_id+"' type='hidden'><input list='prodcode_list' name='prod_code[]' pattern='<?php echo $act_prod->show_code_list(); ?>' id='code"+last_id+"' title='Refer to the data list...' maxlength='50' style='background-color:transparent; border:transparent; width: 95%' class='form-control' placeholder='Type here ...'></td><td><input type='number' id='quan_av"+last_id+"' readonly style='text-align:right; background-color:transparent; border:transparent' required class='form-control num'></td><td><input type='number' min='0' name='quantity[]' id='quan"+last_id+"' style='text-align:right; background-color:transparent; border:transparent' class='form-control num' placeholder='0'></td><td><center><button id='"+last_id+"' onclick='deleterow(this.id)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td></tr>";

  $("#trans_table").append(newRow);

    //Dynamically add functions from here

    add_function(last_id);

  last_id+=1;
}

function deleterow(id){
  $("#tr"+id).remove();
}

$(function () {
    $('#example1').DataTable();
  })

$(document).ready(function(){
  $('#example1 tbody').on('click', '.openView', function () {
        var dataURL = $(this).attr('data-href');
        $('#view_body').load(dataURL,function(){
            $('#view_modal').modal({show:true});
        });
   });
});

var table = $('#example2').DataTable({
    "paging": false,
    "info": false,
    "searching": false,
    "ordering": false
  });
  var length = (table
         .column( 0 )
         .data()
         .length);

$(document).ready(function() {
  for (i = 1; i <= length; i++){
      add_function(i);
    }
});

function check(){
  //check values of the two select
    //origin
    var orig = $("#origin").val();

    //destination
    var dest = $("#destination").val();

    if(orig == dest){
      swal('Validation', 'Values of origin and destination should not be similar.', 'warning');
      return false;
    }
    else{
      var arr = [];

      $(".counter").each(function(){
          var id = $(this).attr('id');
          var prod_code = $("#code"+id).val();

          if(prod_code != ''){
            arr.push(prod_code);
          }
      });

      if(hasDuplicates(arr)){
        swal('Validation', 'Product codes should be distinct. Check your inputs.', 'warning');
        return false;
      }
      else{
        return true;
      }
    }
}

function hasDuplicates(array) {
    var valuesSoFar = Object.create(null);
    for (var i = 0; i < array.length; ++i) {
        var value = array[i];
        if (value in valuesSoFar) {
            return true;
        }
        valuesSoFar[value] = true;
    }
    return false;
}

function add_function(id){
  $("#code"+id).change(function () {
    console.log("hi")
      var code = $(this).val();

      $.ajax({
        url: 'models/ajax_transfer.php',
        type: 'post',
        data: {
          code: code
        },
        success: function(data){
          var res = data.split(';');
          var code = res[0];
          var desc = res[1];
          var pack = res[2];

          $("#prod"+id).val(desc);
          $("#pack"+id).val(pack);

          var orig = $("#origin").val();
          update_max(id, code, orig); //function for changing the max of quantity depending on product code and origin
        }
      });
  });
}

function update_max(id, code, orig){
  $.ajax({
    url: 'models/ajax_transfer.php',
    type: 'post',
    data: {
      codex: code,
      orig: orig
    },
    success: function(data){
      $("#quan_av"+id).val(data);
      $("#quan"+id).attr('max', data);
    }
  });
}

$("#origin").change(function(){
  var orig = $(this).val();

  $(".counter").each(function(){
    var id = $(this).attr("id");
    var code = $("#code"+id).val();

    if(code != ''){
      //update availability column and max of qty to transfer based on origin and product code
      $.ajax({
        url: 'models/ajax_transfer.php',
        type: 'post',
        data: {
          orig_y: orig,
          code_y: code
        },
        success: function(data){
          $("#quan_av"+id).val(data);
          $("#quan"+id).attr('max', data);
        }
      });
    }

  });
});

<?php
if (isset($_GET['transferred'])) {
  ?>
    swal({
      title: 'Successfully transferred stocks.',
      text: "Do you want to print it now?",
      type: 'success',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Print'
    }).then((result) => {
      if (result.value) {
        location.href="print_stf?id=<?php echo $_GET['id']; ?>"
      }
    })
    history.pushState(null, null, 'inv_transfer');
<?php
} elseif (isset($_GET['remarks'])) {
  ?>
    swal("Success", "Successfully recorded remarks.", "success");
    history.pushState(null, null, 'inv_transfer');
<?php
}
?>
</script>
