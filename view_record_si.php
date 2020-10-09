<?php
include 'models/payment_model.php';
include 'models/credit_model.php';
include 'models/rebate_model.php';
include 'models/debit_model.php';

$payment = new Payment();
$id = $_GET['si'];
$payment->get_total_payment($id);

$rebate = new Rebate();
$credit = new Credit();
$debit = new Debit();
?>
                    <!-- /.card-header -->
              <div class="card-body">
              <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th style='width:15%'>PR #</th>
                      <th style='width:15%'>CR #</th>
                      <th style='width:25%'>Bank</th>
                      <th style='width:15%'>Check Number</th>
                      <th style='width:15%'>Check Date</th>
                      <th style='width:15%'>Amount Paid</th>
                    </tr>
                  </thead>
                  <tbody id="prod_table1">
                      <?php
                        $payment->show_data($id);
                      ?>
                  </tbody>
                </table>
                <br>
                <table id="example2" style='width: 80%; margin: 0 auto' class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th style='width:50%'>Miscellaneous Fees</th>
                      <th style='width:50%'>Amount</th>
                    </tr>
                  </thead>
                  <tbody id="prod_table1">
                      <?php
                        $payment->show_misc($id);
                      ?>
                  </tbody>
                </table>
                <br>
                <table id="example3" style='width: 80%; margin: 0 auto' class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th style='width:20%'>Rebate Number</th>
                      <th style='width:40%'>Rebate Date</th>
                      <th style='width:40%'>Amount</th>
                    </tr>
                  </thead>
                  <tbody id="prod_table1">
                      <?php
                        $rebate->show_data($id);
                      ?>
                  </tbody>
                </table>
                <br>
                <table id="example3" style='width: 80%; margin: 0 auto' class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th style='width:20%'>Credit Memo Number</th>
                      <th style='width:40%'>Credit Date</th>
                      <th style='width:40%'>Amount</th>
                    </tr>
                  </thead>
                  <tbody id="prod_table1">
                      <?php
                        $credit->show_data($id);
                      ?>
                  </tbody>
                </table>
                <br>
                <table id="example3" style='width: 80%; margin: 0 auto' class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th style='width:20%'>Debit Memo Number</th>
                      <th style='width:40%'>Debit Date</th>
                      <th style='width:40%'>Amount</th>
                    </tr>
                  </thead>
                  <tbody id="prod_table1">
                      <?php
                        $debit->show_data($id);
                      ?>
                  </tbody>
                </table>
                <br>
                <br>
              </div>
              <!-- /.card-body -->
