<form action='models/so_aed.php' method='post'>
<table id="example2" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style='width:40%'>Description</th>
                        <th style='width:15%'>Current Stock</th>
                        <th style='width:15%'>Qty Ordered</th>
                        <th style='width:15%'>Qty Remaining</th>
                        <th style='width:15%'>Qty Delivered</th>
                      </tr>
                    </thead>
                    <tbody id="trans_table">
                      <?php
                  
                  include 'models/so_model.php';
		  $so = new SO();    
			
                  if(isset($_GET['dr'])){
                  	$dr = $_GET['dr'];
                  	$so->show_q_bd_dr_($dr);
                  }
                  else{
                  	$id = $_GET['id'];
        			$so->show_q_bd_dr($id);
        		  }
			
                      ?>
                    </tbody>
                    </table>
       
       <?php
       if(isset($_GET['dr'])){
       ?>
       
       <input type='hidden' name='dr' value='<?php echo $dr; ?>'>
       <button type="submit" name='update_dr' id='submit' class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Update Details</button>
       
       <?php
       }
       else{
       ?>
       
       <input type='hidden' name='so_id' value='<?php echo $id; ?>'>
       <button type="submit" name='submit_dr' id='submit' class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Details</button>
       
       <?php
       }
       ?>
             
</form>