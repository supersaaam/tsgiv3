<?php
include 'models/sales_order_model.php';

$so = new Sales_Order();
$id = $_GET['so'];
?>
                    <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th style='width:15%'>SI No. </th>
                      <th style='width:15%'>DR No.</th>
                      <th style='width:15%'>DR Countered</th>
                      <th style='width:15%'>Total Due</th>
                      <th style='width:15%'>Amount Paid</th>
                      <th style='width:15%'>Balance</th>
                      <th style='width:10%'>Aging</th>
                    </tr>
                  </thead>
                  <tbody id="prod_table1">
                      <?php
                        $so->show_unpaid_so($id);
                      ?>
                  </tbody>
                </table>

                <div style="clear:both; height:15px;"></div>
                <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>

                <form action='models/sales_order_model.php' method='post'>
                <!-- textarea -->
                <div class="form-group">
                    <label>Remarks</label>
                    <input type='hidden' name='so' value='<?php echo $id; ?>'>
                    <textarea class="form-control" required name="remarks_" maxlength="200" rows="4" style="resize:none" placeholder="Input remarks ..."></textarea>
                  </div>
                  <button type="submit"  id="submit_new" name="remarks" class="btn btn-primary" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Submit</button>
                </form>
              </div>
              <!-- /.card-body -->

