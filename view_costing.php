                    <?php
                        $po = $_GET['po'];
                        
                        //get value
                        include 'models/connection.php';
                        
                        $stmt = $con->prepare('SELECT `FreightCost`, `DutiesCost`, `BrokerageCost`, `BankCharge`,Currency, TotalAmount, ExchangeRate, Insurance FROM `tbl_tsgi_po` WHERE `PONumber`=?');
                        $stmt->bind_param('i', $po);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($freight, $duties, $brokerage, $bank, $currency, $amt, $exrate, $insurance);
                        $stmt->fetch();
                        $stmt->close();
                        $con->close();
                        
                    ?>
                    
                    <form action='models/po_aed.php' method='post'>
                    
                    <div class="form-group" style='float:left; width:48%; margin-right:2%'>
                      <label>Forwarding Cost (PHP)</label>
                      <input type='hidden' name='amount' value='<?php echo $amt; ?>'>
                      <input type='hidden' name='po' value='<?php echo $po; ?>'>
                      <input type='number' min='0' max='' value='<?php echo $freight; ?>' step='any' name='freight' class='form-control' placeholder='Input amount ...'>
                    </div>
                    
                    <div class="form-group" style='float:left; width:48%; margin-left:2%'>
                      <label>Duties and Taxes (PHP)</label>
                      <input type='number' min='0' max='' value='<?php echo $duties; ?>' step='any' name='duties' class='form-control' placeholder='Input amount ...'>
                    </div>
                    
                    <div class="form-group" style='float:left; width:48%; margin-right:2%'>
                      <label>Brokerage Cost (PHP)</label>
                      <input type='number' min='0' max='' step='any' name='brokerage' value='<?php echo $brokerage; ?>' class='form-control' placeholder='Input amount ...'>
                    </div>
                    
                    <div class="form-group" style='float:left; width:48%; margin-left:2%'>
                      <label>Insurance Cost (PHP)</label>
                      <input type='number' min='0' max='' value='<?php echo $insurance; ?>' step='any' name='insurance' class='form-control' placeholder='Input amount ...'>
                    </div>
                    
                    <div class="form-group" style='float:left; width:48%; margin-right:2%'>
                      <label>Exchange Rate</label>
                      <input type='number' min='0' max='' value='<?php echo $exrate; ?>' step='any' name='phpvalue' class='form-control' placeholder='Input amount ...'>
                    </div>
                    
                    <div class="form-group" style='float:left; width:48%; margin-left:2%'>
                      <label>Bank Charge (USD)</label>
                      <input type='number' min='0' max='' value='<?php echo $bank; ?>' step='any' name='bankcharge' class='form-control' placeholder='Input amount ...'>
                    </div>
                    
                    <div class='clearfix'></div>
                    
                    <button type='submit' name='costing' class='btn btn-success' style='float:right; margin-right: 10px; margin-bottom: 10px; margin-top: 10px'><i class='fa fa-save'></i>&nbsp;&nbsp;Submit</button>
                    
                    </form>