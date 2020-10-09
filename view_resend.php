<?php
$so = $_GET['so'];
?>

                <form action='models/sales_order_model.php?id=<?php echo $so; ?>' method='post'>  
                    
                  <div class="form-group">
                    <label></label>
                    <textarea maxlength='150' onkeypress="" rows='2' style='resize:none' required name="reason" class="form-control" placeholder='Type input here...'></textarea>
                    <input type='hidden' name='so' value='<?php echo $so; ?>'>
                  </div>
                  
                  <button type="submit" name='resend' id='submit' class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Details</button>
                   </form>