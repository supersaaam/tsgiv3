<?php
  $bom= $_GET['bom'];  
?>

                <form action='models/bom_aed.php' method='post'>
                    
                    <div class="form-group">
                      <label>Amount</label>
                      <input type='hidden' name='bom' value='<?php echo $bom; ?>'>
                      <input type='number' min='0' required max='' step='any' name='po' class='form-control' placeholder='Input amount ...'>
                    </div>
                    
                    <button type='submit' name='submit_po' class='btn btn-success' style='float:right; margin-right: 10px; margin-bottom: 10px; margin-top: 10px'><i class='fa fa-save'></i>&nbsp;&nbsp;Submit</button>
                    
                </form>