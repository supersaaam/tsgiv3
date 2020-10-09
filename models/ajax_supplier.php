                        <?php
                          include 'connection.php';
                          
                          $supp = $_POST['supp'];
                          
                          $stmt = $con->prepare('SELECT `PONumber` FROM `tbl_tsgi_po` WHERE PONumber NOT IN (SELECT PONumber FROM tbl_tsgi_po_payment) AND SupplierID=? AND Status="CONFIRMED"');
                          $stmt->bind_param('i', $supp);
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
                          else{
                            echo "
                            <option value='' disabled='true'>No pending PO for this supplier.</option>
                            ";   
                          }
                          ?>