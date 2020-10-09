<?php
$id = $_GET['id'];

include 'models/connection.php';

    $ins = $con->prepare('SELECT `Remarks` FROM `tbl_receivable` WHERE `ReceivableID`=?');
    $ins->bind_param('i', $id);
    $ins->execute();
    $ins->store_result();
    $ins->bind_result($remarks);
    $ins->fetch();
    $con->close();
?>

                <form action='models/receivable_aed.php' method='post'>  
                  
                  <div class="form-group">
                    <div style='width:100%'>
                    <label>Remarks</label>
                    <span style='float:right;' id='company'></span>
                    </div>
                    
                    <input type='hidden' name='id' value='<?php echo $id; ?>'>
                    
                    <textarea name='remarks' required rows='5' style='resize:none' class='form-control' placeholder='Type input here...'><?php echo $remarks; ?></textarea>
                  </div>
                  
                  <button type="submit" name='submitRemarks' id='submit' class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Details</button>
                  
                 </form>