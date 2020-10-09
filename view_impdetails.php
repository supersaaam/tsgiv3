<?php
include 'models/importation_model.php';
include 'models/payable_model.php';

$imp = new Importation();
$id = $_GET['inv'];
$imp->set_data($id);

$pay = new Payable();
$pay->set_data($id);
$pay_id = $pay->pid;
?>
              <!-- /.card-header -->
              <div class="card-body">
                <form role="form" action="models/payable_model.php" method="post" id="imp_form">
                  <!-- text input -->
                  <div class="col-md-6" style="float:left; padding-right: 30px">

                  <div class="form-group" style='float:left; width:48%; margin-right: 2%'>
                    <label>Proforma Inv. No.</label>
                    <input type="text" required name="prof_inv_no" maxlength="20" class="form-control" id="inv_input1" onkeyup="loading('inv_val1')" readonly value='<?php echo $imp->invnum; ?>'>
                  </div>

                  <div class="form-group" style='float:left; width:48%; margin-left: 2%'>
                    <label>Date</label>
                    <input type="date" required readonly name="prof_inv_date" class="form-control" value='<?php echo $imp->profdate; ?>'>
                  </div>
                  
                  <div class="form-group">
                    <label>Amount Due</label>
                     <input list="term_list" readonly required name="" class="form-control" maxlength="50"  value='<?php echo $imp->netpayment; ?>'>
                  </div>

                  <div class="form-group">
                    <label>Bank Name</label>
                    <input type='text' required name="bank" class="form-control" placeholder='Please input here...' value='<?php echo $pay->bank; ?>' maxlength='50'>
                  </div>

                  <div class="form-group">
                    <label>Bank Address</label>
                    <input type='text' required name="bankaddress" class="form-control" value='<?php echo $pay->address; ?>' placeholder='Please input here...' maxlength='50'>
                  </div>

                  <div class="form-group">
                    <label>Bank Account Number</label>
                    <input type='text' required name="banknumber" value='<?php echo $pay->account; ?>' class="form-control" placeholder='Please input here...' maxlength='50'>
                  </div>

                  </div>
                  
                  <div class="col-md-6" style="float:left; padding-left: 30px">
                  
                  <div class="form-group">
                    <label>Supplier</label>
                    <input list="suppliers_list" readonly required name="supplier" class="form-control" value='<?php echo $imp->supplier; ?>'>
                  </div>

                  <div class="form-group">
                    <label>Payment Term</label>
                     <input list="term_list" readonly required name="term" class="form-control" maxlength="50"  value='<?php echo $term_sel = $imp->term; ?>'>
                  </div>

                  <div class="form-group" style='float:left; width:48%; margin-right: 2%'>
                    <label>Swift Code</label>
                    <input type="text" required value='<?php echo $pay->swift; ?>' name="swiftcode" maxlength="20" class="form-control" placeholder='Please input here...'>
                  </div>

                  <div class="form-group" style='float:left; width:48%; margin-left: 2%'>
                    <label>IBAN Number</label>
                    <input type="text" required name="ivannum" maxlength="20" value='<?php echo $pay->ivan; ?>' class="form-control" placeholder='Please input here...'>
                  </div>

                  <!-- textarea -->
                  <div class="form-group">
                    <label>Special Reminders</label>
                    <textarea class="form-control" name="reminder" maxlength="200" rows="4" style="resize:none" placeholder="Input special reminder ..."><?php echo $pay->rem; ?></textarea>
                  </div>
                  
                  </div>

                  <button type="submit" name="save" id="" class="btn btn-primary" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Submit</button>

                  </form>

                  <div style="clear:both; height:15px;"></div>
                <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>

                  <br>
                  <h4><center><b>Deductions</b></center></h4>
                <br>

                  <table id="example3" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th style='width:65%'>Deductions</th>
                      <th style='width:35%'>Amount</th>
                    </tr>
                  </thead>
                  <tbody id="prod_table1">
                      <?php
                      $pay->show_deductions($id);
                      ?>
                  </tbody>
                  <tfoot>
                  <tr>
                      <th style="text-align:right">Total Deductions:</th>
                      <th><?php echo $pay->total_ded; ?></th>
                  </tr>
                  </tfoot>
                </table>

                <div style="clear:both; height:15px;"></div>
                <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>

                  <br>
                  <h4><center><b>Payments</b></center></h4>
                <br>

                  <table id="payment" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th style='width:12%'>Date Paid</th>
                      <th style='width:22%'>Bank</th>
                      <th style='width:18%'>PHP Amount</th>
                      <th style='width:18%'>Charges</th>
                      <th style='width:12%'>Rate</th>
                      <th style='width:18%'>Amount Paid</th>
                    </tr>
                  </thead>
                  <tbody id="prod_table1">
                      <?php
                      $pay->show_paid($id);
                      ?>
                  </tbody>
                  <tfoot>
                  <tr>
                      <th colspan='5' style="text-align:right">Total Amount to Pay:</th>
                      <th><?php echo $imp->netpayment; ?></th>
                  </tr>
                  <tr>
                      <th colspan='5' style="text-align:right">Total Amount Paid:</th>
                      <th><?php echo $pay->total_paid; ?></th>
                  </tr>
                  <tr>
                      <th colspan='5' style="text-align:right">Remaining Balance:</th>
                      <th><?php echo $imp->balance; ?></th>
                  </tr>
                  </tfoot>
                </table>
                
              </div>
              <!-- /.card-body -->
