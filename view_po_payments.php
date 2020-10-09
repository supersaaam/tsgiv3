                    <?php
                        $po = $_GET['po'];
                    ?>
    
                    <form action='models/po_aed.php' method='post'>
                    
                    <div class="form-group" style='float:left; width:48%; margin-right:2%'>
                      <label>FTA Number</label>
                      <input type='text' min='0' max='' name='ftanumber' class='form-control' placeholder='Input number ...' required>
                    </div>
                    
                    <div class="form-group" style='float:left; width:48%; margin-left:2%'>
                      <label>Branch</label>
                      <input type='text' min='0' max='' name='branch' class='form-control' placeholder='Input branch ...' required>
                    </div>
                    
                    <div class="form-group" style='float:left; width:48%; margin-right:2%'>
                      <label>Account Number</label>
                      <input type='text' min='0' max='' name='accnum' class='form-control' placeholder='Input account number ...'required>
                    </div>
                    
                    
                    <div class="form-group" style='float:left; width:48%; margin-left:2%'>
                      <label>Amount to Pay</label>
                      <input type='number' min='0' max='' step='any' name='amount' class='form-control' placeholder='Input amount ...' required>
                    </div>
                    
                    <div class="form-group" style='float:left; width:18%; margin-right:2%'>
                      <label>Currency</label>
                      <select name='currency' class='form-control' required>
                          <option value='USD'>USD</option>
                          <option value='EURO'>EURO</option>
                      </select>
                    </div>
                    
                    <div class="form-group" style='float:left; width:28%; margin-right:2%'>
                      <label>Supplier</label>
                      <select required class="form-control" style='width: 100%' id="supplier">
                          
                          <?php
                          include 'models/connection.php';
                          
                          $stmt = $con->prepare('SELECT `SupplierID`, `CompanyName` FROM `tbl_supplier` WHERE `Deleted`="NO"');
                          $stmt->execute();
                          $stmt->store_result();
                          $stmt->bind_result($sid, $name);
                          if($stmt->num_rows > 0){
                              while($stmt->fetch()){
                                  $po_ftd = sprintf('%06d', $po);
                                  echo "
                                  <option value='$sid'>$name</option>
                                  ";
                              }
                          }
                          
                          $stmt->close();
                          $con->close();
                          ?>
                          
                        </select>
                    </div>
                    
                    <div class="form-group" style='float:left; width:48%; margin-left:2%'>
                      <label>PO Reference(s)</label>
                      <br>
                      <select required class="js-example-basic-multiple" style='width: 100%' id='po' name="po[]" multiple="multiple">
                          <?php
                          include 'models/connection.php';
                          
                          $stmt = $con->prepare('SELECT `PONumber` FROM `tbl_tsgi_po` WHERE PONumber NOT IN (SELECT PONumber FROM tbl_tsgi_po_payment) AND Status="CONFIRMED"');
                          $stmt->execute();
                          $stmt->store_result();
                          $stmt->bind_result($po);
                          if($stmt->num_rows > 0){
                              while($stmt->fetch()){
                                  $po_ftd = sprintf('%06d', $po);
                                  echo "
                                  <option value='$po'>$po_ftd</option>
                                  ";
                              }
                          }
                          ?>
                        </select>
                    </div>
                    
                    
                    
                    <div class='clearfix'></div>
                    
                    <button type='submit' name='payment' class='btn btn-success' style='float:right; margin-right: 10px; margin-bottom: 10px; margin-top: 10px'><i class='fa fa-save'></i>&nbsp;&nbsp;Submit</button>
                    
                    </form>
                    
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
                    <script>
                        $("#supplier").change(function(){
                           var supp = $(this).val();
                           
                           $.ajax({
                               url: 'models/ajax_supplier.php',
                               method: 'post',
                               data: {
                                 supp: supp  
                               },
                               success: function(data){
                                   $("#po").html(data);
                               }
                           });
                        });
                        
                        
                        $(document).ready(function() {
                            var supp = $('#supplier').val();
                           
                           $.ajax({
                               url: 'models/ajax_supplier.php',
                               method: 'post',
                               data: {
                                 supp: supp  
                               },
                               success: function(data){
                                   $("#po").html(data);
                               }
                           });
                        
                            $('.js-example-basic-multiple').select2();
                        });
                    </script>