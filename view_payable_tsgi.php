<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];

    include 'models/payable_tsgi_model.php';
    $py = new Payable();

    $py->set_data($id);
    
    $particular = $py->particular;
    $accountnum = $py->accountnum;
    $contactnum = $py->contactnum;
    $duedate = $py->duedate;
    $amount = $py->amount;
    
}
else{
    $particular = '';
    $accountnum = '';
    $contactnum = '';
    $duedate = '';
    $amount = '';
}
?>

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

                    <form action='models/payable_tsgi_model.php?id=<?php echo $id; ?>' method='post'>  
                  <div class="form-group">
                    <div style='width:100%'>
                    <label>Particular</label>
                    <span style='float:right;' id='payee'></span>
                    </div>
                    
                    <input type='text' maxlength='200' value='<?php echo $particular; ?>' required name="particular" class="form-control" placeholder='Type input here...'>
                  </div>
                  
                  <div class="form-group">
                    <div style='width:100%'>
                    <label>Account Number:</label>
                    <span style='float:right;' id='payee'></span>
                    </div>
                    
                    <input type='text' maxlength='200' value='<?php echo $accountnum; ?>' required name="accountnum" class="form-control" placeholder='Type input here...'>
                  </div>
                  
                  <div class="form-group">
                    <div style='width:100%'>
                    <label>Contact Number</label>
                    <span style='float:right;' id='payee'></span>
                    </div>
                    
                    <input type='text' maxlength='200' value='<?php echo $contactnum; ?>' required name="contactnum" class="form-control" placeholder='Type input here...'>
                  </div>
                  
                  <div class="form-group">
                    <div style='width:100%'>
                    <label>Due Date</label>
                    <span style='float:right;' id='payee'></span>
                    </div>
                    
                    <input type='text' maxlength='200' value='<?php echo $duedate; ?>' required name="duedate" class="form-control" placeholder='Type input here...'>
                  </div>
                  
                  <div class="form-group">
                    <div style='width:100%'>
                    <label>Amount</label>
                    <span style='float:right;' id='payee'></span>
                    </div>
                    
                    <input type='number' value='<?php echo $amount; ?>' required name="amount" class="form-control" placeholder='Type input here...'>
                  </div>

                  <button type="submit" 
                  
                  <?php
                    if($particular != ''){
                        echo "
                            name='update'
                        ";
                    }
                    else{
                        echo "
                            name='save'
                        ";
                    }
                   ?>
                  
                   id='submit' class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Details</button>
                   </form>
