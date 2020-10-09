<form action='print_pickuplist.php?so=<?php echo $_GET['id']; ?>' method='post'>
<table id="example2" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style='width:40%'>Description</th>
                        <th style='width:15%'>Current Stock</th>
                        <th style='width:15%'>Qty Ordered</th>
                        <th style='width:15%'>Qty Remaining</th>
                        <th style='width:15%'>Qty To Pick-up</th>
                      </tr>
                    </thead>
                    <tbody id="trans_table">
                      <?php
                  
                  include 'models/so_model.php';
		  $so = new SO();    
			
                    $id = $_GET['id'];
        			$so->show_q_bd_dr($id);
        		    $so->set_data($id);
                      ?>
                    </tbody>
                    </table>
       
        <input type='hidden' name='company' value='<?php echo $so->company; ?>'>
       <input type='hidden' name='poref' value='<?php echo $so->ponum; ?>'>
        <input type='hidden' name='so_id' value='<?php echo $id; ?>'>
       <button type="submit" name='submit_dr' id='submit' class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-print'></i> &nbsp;Print Pick-up List</button>
       
       
       <button type="submit" name='submit_dr_pic' id='' class="btn btn-info" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-print'></i> &nbsp;Print Pick-up List (w/ Picture)</button>
             
</form>