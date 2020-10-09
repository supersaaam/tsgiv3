<?php
$id = $_GET['id'];
?>

                <form action='models/receivable_aed.php' method='post'>  
                  
                  <div class="form-group">
                    <div style='width:100%'>
                    <label>Countered Date</label>
                    <span style='float:right;' id='company'></span>
                    </div>
                    
                    <input type='hidden' name='id' value='<?php echo $id; ?>'>
                    <input type='date' required name="ctrDate" class="form-control" placeholder='Type input here...'>
                  </div>
                  
                  <button type="submit" name='submitCtr' id='submit' class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Details</button>
                  
                 </form>