<?php
include 'models/sales_order_model.php';

$so = new Sales_Order();
$id = $_GET['so'];
$so->set_data($id);
?>
              <!-- /.card-header -->
              <div class="card-body">
                <form role="form" action="models/sales_order_aed.php" method="post" id="imp_form">

                  <input type='hidden' name='sonumber' value='<?php echo $id; ?>'>

                <?php
                if(isset($_GET['approved'])){
                ?>

                <div class="col-md-12" style="float:left">

                <div class="form-group" style='width: 19%; float:left; margin-right: 10px'>
                  <label>SI Number</label>
                  <input type='text' name="si_number" class="form-control"

                  <?php
if ($so->invoice != '') {
  ?>
                         echo ' readonly ';
                  <?php
}
?>

                  value='<?php echo $so->invoice; ?>'>
                </div>

                <div class="form-group"style='width: 19%; float:left; margin-right: 10px'>
                  <label>SI Date</label>
                  <input type='date' name="si_date" class="form-control"

                  <?php
if ($so->si_date != '') {
  ?>
                         echo ' readonly ';
                  <?php
}
?>

                  value='<?php echo $so->si_date; ?>'>
                </div>

                <div class="form-group" style='width: 19%; float:left; margin-right: 10px'>
                  <label>DR Number</label>
                  <input type='text' name="dr_number" class="form-control"

                  <?php
if ($so->dr != '') {
  ?>
                         echo ' readonly ';
                  <?php
}
?>

                  value='<?php echo $so->dr; ?>'>
                </div>

                <div class="form-group"style='width: 19%; float:left; margin-right: 10px'>
                  <label>DR Date</label>
                  <input type='date' name="dr_date" class="form-control"

                  <?php
if ($so->dr_date != '') {
  ?>
                         echo ' readonly ';
                  <?php
}
?>

                  value='<?php echo $so->dr_date; ?>'>
                </div>

                <?php
if ($so->bir == '') {
  ?>
                <div class="form-group"style='width: 18%; float:left'>
                <label>BIR Type</label>
                <br>
                  <input type='radio' name='bir' required value='BIR'> BIR
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type='radio' name='bir' required value='Non-BIR'> Non-BIR
                  </div>
                <?php
} else {
  ?>

                 <div class="form-group"style='width: 18%; float:left'>
                <label>BIR Type</label>
                <br>
                  <?php echo $so->bir; ?>
                  </div>

                <?php
}
?>

                </div>

                <?php
                }
                ?>

                  <!-- text input -->
                  <div class="col-md-6" style="float:left; padding-right: 30px">

                  <div class="form-group">
                    <label>Customer</label>
                    <input type='text' required name="" class="form-control" readonly value='<?php echo $so->name; ?>'>
                  </div>

                  <div class="form-group">
                    <label>Address</label>
                    <input type='text' required name="" class="form-control" readonly value='<?php echo $so->address; ?>'>
                  </div>

                  </div>

                  <div class="col-md-6" style="float:left; padding-left: 30px">

                  <div class="col-md-6" style="float:left">
                  <div class="form-group">
                    <label>Terms</label>
                    <input type='text' required name="" class="form-control" readonly value='<?php echo $so->terms; ?>'>
                </div>
                  </div>
                  <div class="col-md-6" style="float:left">
                  <div class="form-group">
                    <label>Date</label>
                    <input type="date" required name="" id='dte' class="form-control">
                  </div>
                  </div>

                  <div class="col-md-6" style="float:left">
                  <div class="form-group">
                    <label>Sales Order No.</label>
                    <input type='text' required name="" class="form-control" readonly value='<?php echo sprintf('%06d', $id); ?>'>
                </div>
                  </div>
                  <div class="col-md-6" style="float:left">
                  <div class="form-group">
                    <label>Purchase Order No.</label>
                    <input type='text' required name="" class="form-control" readonly value='<?php echo $so->po; ?>'>
                </div>
                  </div>

                  </div>

                <div style="clear:both; height:15px;"></div>
                <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>

                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th style='width:40%'>Product Code</th>
                      <th style='width:15%'>Unit Price</th>
                      <th style='width:10%'>Quantity</th>
                      <th style='width:15%'>Total Amount</th>
                      <th style='width:20%'>Remarks</th>
                    </tr>
                  </thead>
                  <tbody id="prod_table1">
                      <?php
$so->show_product($id);
?>
                  </tbody>
                  <tfoot>
                  <tr>
                      <th colspan='3' style="text-align:right">Total Amount:</th>
                      <th><?php echo $so->total; ?></th>
                      <th>&nbsp;</th>
                  </tr>
                  </tfoot>
                </table>

                 <div style="clear:both; height:15px;"></div>

                  <?php
                if(isset($_GET['approved'])){
                    if ($so->invoice == '' || $so->si_date == '' || $so->dr_date == '' || $so->dr == '' || $so->bir == '') {
                    ?>

                    <button type="submit" id="submit_new" name="update_so" class="btn btn-info" style="float:right; margin-top:2px; margin-bottom: 20px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Changes</button>

                    <?php
                    }
                                    
                    if ($so->invoice != '') {
                      ?>
                    <a href='print_si.php?so=<?php echo $id; ?>' class='print'><button type='button' style='float:right' class='btn btn-warning btn-sm'><i class='fa fa-print'></i> &nbsp;Print SI</button></a>
                                    <?php
                    }

                    if ($so->dr != '') {
                      ?>
                    <a href='print_dr.php?so=<?php echo $id; ?>' class='print'><button type='button' style='float:right; margin-right: 10px' class='btn btn-primary btn-sm'><i class='fa fa-print'></i> &nbsp;Print DR</button></a>
                                    <?php
                    }
                }
?>

              </form>
              </div>
              <!-- /.card-body -->

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
</script>
