                    <?php
                        $po = $_GET['po'];
                    ?>
                    <form action='models/po_aed.php' method='post'>
                    <div class="form-group" style='float:left; width: 100%'>
                      <label>SO Reference Number</label>
                      <input type='hidden' name='po' value='<?php echo $po; ?>' required>
                      <input type='text' maxlength='100' name='so_ref' class='form-control' placeholder='Input reference number ...' required>
                    </div>
                    <button type='submit' style='float: right; margin-right: 10px' name='update' class='btn btn-success'><i class='fa fa-save'>&nbsp;&nbsp;</i>Update</button>
                    </form>