<?php
$so = $_GET['so'];
?>

                    <form action='models/cr_aed.php' method='post'>
                        
                    <div class="form-group" style='float:left; width:48%; margin-right:2%'>
                      <label>Amount</label>
                      <input type='number' min='0' max='' step='any' name='amount' class='form-control' placeholder='Input amount ...' required>
                    </div>
                    
                    <div class="form-group" style='float:left; width:48%; margin-left:2%'>
                      <label>Mode of Payment</label>
                      <br>
                      <input type='radio' name='mode' checked value='Cash'> &nbsp;Cash
                      &nbsp;&nbsp;&nbsp;
                      <input type='radio' name='mode' value='Check'> &nbsp;Check
                    </div>
                    
                    <div class='clearfix'>&nbsp;</div>
                    <div id='check'>
                        
                    </div>
                    
                    <input type='hidden' name='so' value='<?php echo $so; ?>'>
                    <button type='submit' name='submit' class='btn btn-success' style='float:right; margin-right: 10px'><i class='fa fa-save'></i>&nbsp;&nbsp;Submit</button>
                    
                    </form>
<script>

$('input[type=radio][name=mode]').change(function() {
    if (this.value == 'Check') {
        var con = "<div class='form-group' style='float:left; width:48%; margin-right:2%'><label>Bank</label><input type='text' maxlength='200' name='bank' class='form-control' placeholder='Input bank ...' required></div><div class='form-group' style='float:left; width:48%; margin-left:2%'><label>Branch</label><input type='text' maxlength='200' name='branch' class='form-control' placeholder='Input branch ...' required></div><div class='form-group' style='float:left; width:48%; margin-right:2%'><label>Check Number</label><input type='text' maxlength='200' name='checknumber' class='form-control' placeholder='Input check number ...' required></div><div class='form-group' style='float:left; width:48%; margin-left:2%'><label>Check Date</label><input type='date' name='date' class='form-control' required></div>";
        
        $("#check").html(con);
    }
    else if (this.value == 'Cash') {
        var con = "";
        $("#check").html(con);
    }
});

</script>