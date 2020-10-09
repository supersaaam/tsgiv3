                  
                  <form action='models/sales_order_model.php?dr=<?php echo $_GET['dr']; ?>' method='post'>
                  <div class="form-group">
                    <label>Date</label>
                    <input type="date" id='dte' required name="date" class="form-control">
                  </div>     

                  <button type="submit" name='save_drc'
                   id='submit' class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Details</button>
                   </form>

<Script>
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();

if(dd<10) {
    dd = '0'+dd
} 

if(mm<10) {
    mm = '0'+mm
} 

today = yyyy + '-' + mm + '-' + dd;
$("#dte").val(today); 
</script>