<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];

    include 'models/actual_prod_model.php';
    $ap = new Actual_Prod();

    $ap->set_data($id);
    $price = $ap->price;
    $brand = $ap->brand;
    $desc = $ap->desc;
    $pnum = $ap->pnum;
    $min = $ap->min;
    $max = $ap->max;
    $stock = $ap->stock;
    $usdprice = $ap->usdprice;
    $currency= $ap->currency;
}
?>

<style>
.loader {
  border: 4px solid #f3f3f3;
  border-radius: 50%;
  border-top: 4px solid #3498db;
  width: 12px;
  height: 12px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

                    <form action='models/actual_prod_model.php?id=<?php echo $id; ?>' method='post'>  
                  <div class="form-group">
                    <div style='width:100%'>
                    <label>Brand</label>
                    </div>
                    
                    <input type='text' maxlength='200' readonly id='name_input' value='<?php echo $brand; ?>' required name="brand" class="form-control">
                  </div>
                  
                  <div class="form-group">
                    <div style='width:100%'>
                    <label>Product Description</label>
                    </div>
                    
                    <input type='text' maxlength='200' id='name_input' value='<?php echo $desc; ?>' required name="description" class="form-control">
                  </div>

                  <div class="form-group">
                    <label>Part Number</label>
                    <input type='text' maxlength='20' 
                    value='<?php echo $pnum; ?>' required name="pnum" class="form-control" placeholder='Type input here...'>
                  </div>

                  <div class="form-group" style='width: 23%; margin-right: 3%; float: left'>
                    <label>Min Level</label>
                    <input type='number' min='0' max='1000000' required value='<?php echo $min; ?>' name="min" class="form-control" placeholder='Type input here...'>
                  </div>

                  <div class="form-group" style='width: 23%; margin-right: 3%; float: left'>
                    <label>Max Level</label>
                    <input type='number' min='0' max='1000000' required value='<?php echo $max; ?>' name="max" class="form-control" placeholder='Type input here...'>
                  </div>

                  <div class="form-group" style='width: 23%; float: left'>
                    <label>Current Stock</label>
                    <input type='number' min='0' max='1000000' required value='<?php echo $stock; ?>' name="stock" class="form-control" placeholder='Type input here...'>
                  </div>
                  
                  <div class='clearfix'>&nbsp;</div>

                  <div class="form-group" style='width: 23%; margin-right: 3%; float: left'>
                    <label>Brand Unit Price</label>
                    <input type='number' step='any' min='0' required  max='1000000' value='<?php echo $usdprice; ?>' id='usdprice' name="usdprice" class="form-control" placeholder='Type input here...'>
                  </div>
                  
                  <div class="form-group" style='width: 23%; margin-right: 3%; float: left'>
                    <label>Selling Price</label>
                    <input type='number' step='any' min='0' required  readonly max='1000000' id='price' value='<?php echo $price; ?>' name="price" class="form-control" placeholder='Type input here...'>
                  </div>
                  
                  <div class="form-group" style='width: 23%; float: left'>
                    <label>Currency</label>
                    <br>
                  <input type='radio' name='currency' 
                  
                  <?php
                  if($currency == 'USD'){
                      echo ' checked ';
                  }
                  ?>
                  
                  value='USD'> USD
                  &nbsp; &nbsp; &nbsp;
                  
                  <input type='radio' name='currency' 
                  
                  <?php
                  if($currency == 'EURO'){
                      echo ' checked ';
                  }
                  ?>
                  
                  value='EURO'> EURO
                   &nbsp; &nbsp; &nbsp;
                  
                  <input type='radio' name='currency' 
                  
                  <?php
                  if($currency == 'AUD'){
                      echo ' checked ';
                  }
                  ?>
                  
                  value='AUD'> AUD
                  </div>
                
                <div class='clearfix'>&nbsp;</div>
                  
                  <?php
                  if(isset($_GET['indent'])){
                  ?>
                  
                    <button type="submit" 
                  name='update_indent' id='submit' class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Details</button>
                   
                   
                  <?php
                  }
                  else{
                  ?>
                  
                  <button type="submit" 
                  name='update' id='submit' class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Details</button>
                   
                  <?php
                  }
                  ?>
                  
                  </form>
                   
                   <script>
                       
$('input[type=radio][name=currency]').change(function() {
    var usd = $("#usdprice").val();
    if(isNaN(usd) || usd == ''){
            usd = 0;
    }
        
    if (this.value == 'USD') {
        var p = usd*120*1.12;
    }
    else if (this.value == 'EURO') {
        var p = usd*130*1.12;
    }
    else if (this.value == 'AUD') {
        var p = usd*110*1.12;
    }
        $("#price").val(p.toFixed(2));
    
});

$("#usdprice").on('keyup', function(){
   var usd = $("#usdprice").val();
    if(isNaN(usd) || usd == ''){
            usd = 0;
    }
     
    var c = $("input[name='currency']:checked").val()
    
    if (c == 'USD') {
        var p = usd*120*1.12;
    }
    else if (c == 'EURO') {
        var p = usd*130*1.12;
    }
    else if (c == 'AUD') {
        var p = usd*110*1.12;
    }
        $("#price").val(p.toFixed(2)); 
        
});


                   </script>
