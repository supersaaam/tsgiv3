<?php
include 'models/cmo_cust_model.php';
$cmo_cust = new CMO_Cust();
    
if(isset($_GET['id'])){
    include 'models/customer_model.php';
    include 'models/style_model.php';

    $cust = new Customer();
    $style = new Style();

    $cust->set_data($_GET['id']);
    
    $id = $_GET['id'];
    $name = $cust->name;
    $address = $cust->address;
    $credit = $cust->credit;
    $tin = $cust->tin;
    $industry = $cust->industry;
    $table = $cust->table;
    $table_ca = $cust->table_ca;
    $table_view = $cust->table_view;
    $table_ca_view = $cust->table_ca_view;
}
else{
    include 'models/style_model.php';
    $style = new Style();

    $id= '';
    $name = '';
    $address = '';
    $credit = '';
    $tin = '';
    $industry = '';
    $table_ca = "
    <tr>
                  				<td><input type='text' maxlength='200' name='address[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input list='cmo_list' id='cmo1' name='cmo[]' value='' maxlength='100' class='form-control' pattern='".$cmo_cust->pattern()."' placeholder='Please input agent name ...'></td>
                  		</tr>
    <tr>
                  				<td><input type='text' maxlength='200' name='address[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input list='cmo_list' id='cmo1' name='cmo[]' value='' maxlength='100' class='form-control' pattern='".$cmo_cust->pattern()."' placeholder='Please input agent name ...'></td>
                  		</tr>
    <tr>
                  				<td><input type='text' maxlength='200' name='address[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input list='cmo_list' id='cmo1' name='cmo[]' value='' maxlength='100' class='form-control' pattern='".$cmo_cust->pattern()."' placeholder='Please input agent name ...'></td>
                  		</tr>
    <tr>
                  				<td><input type='text' maxlength='200' name='address[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input list='cmo_list' id='cmo1' name='cmo[]' value='' maxlength='100' class='form-control' pattern='".$cmo_cust->pattern()."' placeholder='Please input agent name ...'></td>
                  		</tr>
    <tr>
                  				<td><input type='text' maxlength='200' name='address[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input list='cmo_list' id='cmo1' name='cmo[]' value='' maxlength='100' class='form-control' pattern='".$cmo_cust->pattern()."' placeholder='Please input agent name ...'></td>
                  		</tr>
    ";
    $table = "
    <tr>
                  				<td><input type='text' maxlength='100' required name='cname[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' required name='cnumber[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' required name='department[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  			</tr>
                  			<tr>
                  				<td><input type='text' maxlength='100' name='cname[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='cnumber[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='department[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  			</tr>
                  			<tr>
                  				<td><input type='text' maxlength='100' name='cname[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='cnumber[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='department[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  			</tr>
                  			<tr>
                  				<td><input type='text' maxlength='100' name='cname[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='cnumber[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='department[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  			</tr>
                  			<tr>
                  				<td><input type='text' maxlength='100' name='cname[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='cnumber[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='department[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  			</tr>
                  			<tr>
                  				<td><input type='text' maxlength='100' name='cname[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='cnumber[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='department[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  			</tr>
                  			<tr>
                  				<td><input type='text' maxlength='100' name='cname[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='cnumber[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='department[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  			</tr>
                  			<tr>
                  				<td><input type='text' maxlength='100' name='cname[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='cnumber[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='department[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  			</tr>
                  			<tr>
                  				<td><input type='text' maxlength='100' name='cname[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='cnumber[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='department[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  			</tr>
                  			<tr>
                  				<td><input type='text' maxlength='100' name='cname[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='cnumber[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='department[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  			</tr>
    ";
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

<?php
if(isset($_GET['view'])){
?>
            
            <!-- /.card-header -->
            <div class="card-body">
                <form role="form" action="models/customer_model.php" method="post" id="imp_form">
                  <div class="form-group">
                    <div style='width:100%'>
                    <label>Company Name</label>
                    <span style='float:right;' id='cname'></span>
                    </div>
                    <input type='hidden' name='id' value='<?php echo $id; ?>'>
                    <input type='text' maxlength='50' readonly required 
                    onkeyup="loading('cname')" value='<?php echo $name.$x; ?>' id='comp_name' name="name" class="form-control" placeholder='Type input here...'>
                  </div>

                   <div class="form-group">
                    <label>Industry</label>
                    <input type='text' readonly maxlength='50' value='<?php echo $industry; ?>' name="industry" required class="form-control" placeholder='Type input here...'>
                  </div>

                  <div  style='width: 48%; float:left; margin-right: 2%'>
                    <label>Credit Limit</label>
                    <input type='text' maxlength='20' readonly onkeypress="return isNumberKey(event)" value='<?php echo $credit; ?>' name="credit" class="form-control" placeholder='Type input here...'>
                  </div>

                  <div style='width: 48%; float:left; margin-left: 2%'>
                    <label>TIN</label>
                    <input type='text' maxlength='20' readonly onkeypress="return isNumberKey(event)" value='<?php echo $tin; ?>' name="tin" class="form-control" placeholder='Type input here...'>
                  </div>
                  
                  <div class='clearfix'>&nbsp;</div>
                  
                  <div style='margin-top: 10px' class='form-group'>
                  	<label style='font-size: 130%'>Company Address</label>
                  	<br>
                  	<table id="example" class="table table-bordered table-striped" style="width:100%">
                  		<thead>
                  			<th style='width: 50%'>Address</th>
                  			<th style='width: 50%'>Agent</th>
                  		</thead>
                  		<tbody>
                  			<?php 
                  			echo $table_ca_view;
                  			?>
                  		</tbody>
                  	</table>
                  </div>
                  
                  <div class='clearfix'>&nbsp;</div>
                  
                  <div style='margin-top: 10px' class='form-group'>
                  	<label style='font-size: 130%'>Contact Persons</label>
                  	<br>
                  	<table id="example" class="table table-bordered table-striped" style="width:100%">
                  		<thead>
                  			<th style='width: 40%'>Name</th>
                  			<th style='width: 30%'>Contact Number</th>
                  			<th style='width: 30%'>Department</th>
                  		</thead>
                  		<tbody>
                  			<?php 
                  			echo $table_view;
                  			?>
                  		</tbody>
                  	</table>
                  </div>
               
                </form>

            </div>
            <!-- /.card-body -->


<?php
}
else{
?>


            <!-- /.card-header -->
            <div class="card-body">
                <form role="form" action="models/customer_model.php" method="post" id="imp_form">
                  <div class="form-group">
                    <div style='width:100%'>
                    <label>Company Name</label>
                    <span style='float:right;' id='cname'></span>
                    </div>
                    <input type='hidden' name='id' value='<?php echo $id; ?>'>
                    <input type='text' maxlength='50' required 
                    onkeyup="loading('cname')" value='<?php echo $name; ?>' id='comp_name' name="name" class="form-control" placeholder='Type input here...'>
                  </div>

                   <div class="form-group">
                    <label>Industry</label>
                    <input type='text' maxlength='50' value='<?php echo $industry; ?>' name="industry" required class="form-control" placeholder='Type input here...'>
                  </div>

                  <div  style='width: 48%; float:left; margin-right: 2%'>
                    <label>Credit Limit</label>
                    <input type='text' maxlength='20' onkeypress="return isNumberKey(event)" value='<?php echo $credit; ?>' name="credit" class="form-control" placeholder='Type input here...'>
                  </div>

                  <div style='width: 48%; float:left; margin-left: 2%'>
                    <label>TIN</label>
                    <input type='text' maxlength='20' onkeypress="return isNumberKey(event)" value='<?php echo $tin; ?>' name="tin" class="form-control" placeholder='Type input here...'>
                  </div>
                  
                  <div class='clearfix'>&nbsp;</div>
                  
                  <div style='margin-top: 10px' class='form-group'>
                  	<label style='font-size: 130%'>Company Address</label>
                  	<br>
                  	<table id="example" class="table table-bordered table-striped" style="width:100%">
                  		<thead>
                  			<th style='width: 50%'>Address</th>
                  			<th style='width: 50%'>Agent</th>
                  		</thead>
                  		<tbody>
                  			<?php 
                  			echo $table_ca;
                  			?>
                  		</tbody>
                  	</table>
                  </div>
                  
                  <div class='clearfix'>&nbsp;</div>
                  
                  <div style='margin-top: 10px' class='form-group'>
                  	<label style='font-size: 130%'>Contact Persons</label>
                  	<br>
                  	<table id="example" class="table table-bordered table-striped" style="width:100%">
                  		<thead>
                  			<th style='width: 40%'>Name</th>
                  			<th style='width: 30%'>Contact Number</th>
                  			<th style='width: 30%'>Department</th>
                  		</thead>
                  		<tbody>
                  			<?php 
                  			echo $table;
                  			?>
                  		</tbody>
                  	</table>
                  </div>
               
                  <button type="submit" 
                  
                  <?php
                    if($name != ''){
                        echo "
                            name='update'
                        ";
                    }
                    else{
                        echo "
                            name='save'
                        ";
                    }
                   ?>
                  
                   id='submit' class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Details</button>
                </form>

            </div>
            <!-- /.card-body -->

			<datalist id="cmo_list">
                          <?php
                          $cmo_cust->show_data_dl();
                          ?>
                        </datalist>
                        
<?php
}
?>
                        
<script>


function onlyAlphabets(e, t) {

if (window.event) {
    var charCode = window.event.keyCode;
}
else if (e) {
    var charCode = e.which;
}
else { return true; }
if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 32 || charCode == 46 || charCode == 8)
    return true;
else
    return false;

}

function loading(id){
		document.getElementById(id).innerHTML = "<div style='float:right; font-weight:bold'>&nbsp;&nbsp;&nbsp;Loading</div><div class='loader' style='float:right'></div>"; // Hide the image after the response from the server
		 $('#'+id).attr("style", "color: green");
	}

    function isNumberKey(evt){
         	var charCode = (evt.which) ? evt.which : event.keyCode
         	if (charCode > 31 && (charCode < 48 || charCode > 57))
            	return false;
         	return true;
    }

  function check_comp_name() {
		
		var str = $('#comp_name').val();
		var name = '<?php echo $name; ?>';
		
		if(str.trim() == name.trim()){
		    document.getElementById("cname").innerHTML = "";
	        return;
	    }
		else if (str.length == 0) { 
	        document.getElementById("cname").innerHTML = "";
	        return;
	    } 
		else {
	        var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                document.getElementById("cname").innerHTML = this.responseText;
					if(this.responseText == " &nbsp; Company name already exists! "){
						$("#cname").attr("style", "color: red; font-weight: bold; float:right;");
						$("#submit").attr("disabled", true);
					}
					else{
						$("#cname").attr("style", "color: green; font-weight: bold; float:right;");
						$("#submit").attr("disabled", false);
					}
	            }
	        };
	        xmlhttp.open("GET", "models/validate_ajax.php?q_cname=" + str, true);
	        xmlhttp.send();
	    }
	}

var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms, 5 second for example
var $input_cname = $('#comp_name');

//on keyup, start the countdown
$input_cname.on('keyup', function () {
  $("#submit").attr("disabled", true);
  clearTimeout(typingTimer);
  typingTimer = setTimeout(check_comp_name, doneTypingInterval);
});
</script>