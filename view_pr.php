<form action='models/so_aed.php' method='post'>
<table id="example2" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style='width:50%'>Description</th>
                        <th style='width:12.5%'>Current Stock</th>
                        <th style='width:12.5%'>Qty Ordered</th>
                        <th style='width:12.5%'>Qty Remaining</th>
                        <th style='width:12.5%'>Qty to Order</th>
                      </tr>
                    </thead>
                    <tbody id="trans_table">
                      <?php
                  
                  include 'models/so_model.php';
		  $so = new SO();    
			
                  if(isset($_GET['pr'])){
                  	$pr = $_GET['pr'];
                  	$so->show_q_bd_pr($pr);
                  }
                  ?>
                    </tbody>
                    </table>
       
       <input type='hidden' name='pr' value='<?php echo $pr; ?>'>
       <button type="submit" name='submit_pr' id='submit' class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save for PR</button>
           
</form>