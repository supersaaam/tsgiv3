<style>
.loader {
  border: 4px solid #f3f3f3;
  border-radius: 50%;
  border-top: 4px solid #3498db;
  width: 12px;
  height: 12px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<?php

include 'models/customer_model.php';

$cust     = new Customer();
?>

                    <form action='models/receivable_aed.php' method='post'>  
                  
                  <div class="form-group" style='width: 48%; float: left; margin-right: 2%'>
                    <div style='width:100%'>
                    <label>Company </label>
                    <span style='float:right;' id='payee'></span>
                    </div>
                    
                    <input list="customer_list" required name="customer" id='customer' class="form-control" placeholder="Please input customer name ...">
                     
                  </div>
                  
                  <div class="form-group" style='width: 48%; float: left; margin-left: 2%'>
                    <div style='width:100%'>
                    <label>SI Date:</label>
                    <span style='float:right;' id='payee'></span>
                    </div>
                    
                    <input type='date' required name="si_date" class="form-control">
                  </div>
                  
                  <div class="form-group" style='width: 48%; float: left; margin-right: 2%'>
                    <div style='width:100%'>
                    <label>SI Number </label>
                    <span style='float:right;' id='payee'></span>
                    </div>
                    
                    <input type='text' required name="si_number" class="form-control" placeholder="Please input SI number ...">
                     
                  </div>
                  
                  <div class="form-group" style='width: 48%; float: left; margin-left: 2%'>
                    <div style='width:100%'>
                    <label>Gross Sale </label>
                    <span style='float:right;' id='payee'></span>
                    </div>
                    
                    <input type='number' required name="gross" class="form-control" placeholder="Please input gross sale ...">
                     
                  </div>

                  <button type="submit" name='save'
                   id='submit' class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Details</button>
                   </form>

<!-- DATALISTS -->
                        <datalist id="customer_list">
                          <?php
                            $cust->show_data_dl();
                            ?>
                        </datalist>
