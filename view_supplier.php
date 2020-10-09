<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];

    include 'models/supplier_model.php';
    $supp = new Supplier();

    $supp->set_data($id);
    $name = $supp->name;
    $add = $supp->add;
    $acctname = $supp->acctname;
    $acctnumber = $supp->acctnumber;
    $bankname = $supp->bankname;
    $bankaddress = $supp->bankaddress;
    $swiftcode = $supp->swiftcode;
    $remark = $supp->remark;
    $subdealer = $supp->subdealer;
    $table = $supp->table;
}
else{
    include 'models/supplier_model.php';
    
    $id = '';
    $name = '';
    $subdealer = NULL;
    $add = '';
    $acctname = '';
    $acctnumber = '';
    $bankname = '';
    $bankaddress = '';
    $swiftcode = '';
    $remark = '';
    $table = "
    <tr>
                  				<td><input type='text' maxlength='100' required name='cname[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' required name='cnumber[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  			
                  			</tr>
                  			<tr>
                  				<td><input type='text' maxlength='100' name='cname[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='cnumber[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  			
                  			</tr>
                  			<tr>
                  				<td><input type='text' maxlength='100' name='cname[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='cnumber[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  			</tr>
                  			<tr>
                  				<td><input type='text' maxlength='100' name='cname[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='cnumber[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  			</tr>
                  			<tr>
                  				<td><input type='text' maxlength='100' name='cname[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
                  				<td><input type='text' maxlength='100' name='cnumber[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
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


                    <form action='models/supplier_model.php?id=<?php echo $id; ?>' method='post'>  
                  <div class="form-group" style='width: 48%; margin-right: 2%; float: left'>
                    <div style='width:100%'>
                    <label>Company Name</label>
                    <span style='float:right;' id='name'></span>
                    </div>
                    
                    <input type='text' maxlength='200' 
                    
                    <?php
                    if($name != ''){
                      echo ' readonly ';
                    }
                    ?>

                    onkeyup="loading('name')" id='name_input' value='<?php echo $name; ?>' required name="name" class="form-control" placeholder='Type input here...'>
                  </div>
                    
                    
                    <div class="form-group" style='width: 48%; margin-left: 2%; float: left'>
                    <label>Subdealer Of</label>
                    <select name='subdealer' class='form-control' required>
                        <?php
                        function selected($id){
                            
                            $supp = new Supplier();
                            $supp->set_data($_GET['id']);
                            
                            if($id == $supp->subdealer){
                                echo ' selected ';
                            }
                        }
                        ?>
                        
                        
                        <option value='N/A' <?php selected(NULL); ?>>Not Applicable</option>
                        <?php
                            include 'models/connection.php';
                            
                            $stmt = $con->prepare("SELECT SupplierID, CompanyName FROM `tbl_supplier` WHERE SubDealerOf IS NULL AND Deleted='NO'");
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($sid, $name);
                            if($stmt->num_rows > 0){
                                while($stmt->fetch()){
                                    echo "
                                        <option value='$sid'";
                                        
                                        echo selected($sid);
                                        
                                    echo ">$name </option>
                                    ";
                                }
                            }
                        ?>
                    </select>
                  </div>
                  
                  <div class="form-group">
                    <label>Company Address</label>
                    <textarea required style='resize:none' maxlength='200' name="address" class="form-control" placeholder='Type input here...'><?php echo $add; ?></textarea>
                  </div>

                  <div class="form-group" style='width: 48%; float: left; margin-right: 2%'>
                    <label>Account Name</label>
                    <input type='text' maxlength='100' id='' value='<?php echo $acctname; ?>' name="acctname" class="form-control" placeholder='Type input here...'>
                  </div>
			
		<div class="form-group" style='width: 48%; float: left; margin-left: 2%'>
                    <label>Account Number</label>
                    <input type='text' maxlength='50' value='<?php echo $acctnumber; ?>' name="acctnumber" class="form-control" placeholder='Type input here...'>
                  </div>
                  
                  <div class="form-group" style='width: 48%; float: left; margin-right: 2%'>
                    <label>Bank Name</label>
                    <input type='text' maxlength='100' id='' value='<?php echo $bankname; ?>' name="bankname" class="form-control" placeholder='Type input here...'>
                  </div>
			
		<div class="form-group" style='width: 48%; float: left; margin-left: 2%'>
                    <label>Address</label>
                    <input type='text' maxlength='100' value='<?php echo $bankaddress; ?>' name="bankaddress" class="form-control" placeholder='Type input here...'>
                  </div>
                  
                  <div class="form-group" style='width: 48%; float: left; margin-right: 2%'>
                    <label>Swift Code</label>
                    <input type='text' maxlength='20' id='' value='<?php echo $swiftcode; ?>' name="swiftcode" class="form-control" placeholder='Type input here...'>
                  </div>
			
		<div class="form-group" style='width: 48%; float: left; margin-left: 2%'>
                    <label>Remarks</label>
                    <input type='text' maxlength='100' value='<?php echo $remark; ?>' name="remark" class="form-control" placeholder='Type input here...'>
                  </div>
                  
                  
                  <div class='clearfix'>&nbsp;</div>
                  
                  <div style='margin-top: 10px' class='form-group'>
                  	<label style='font-size: 130%'>Contact Persons</label>
                  	<br>
                  	<table id="example" class="table table-bordered table-striped" style="width:100%">
                  		<thead>
                  			<th style='width: 50%'>Name</th>
                  			<th style='width: 50%'>Contact Number</th>
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
                    if($id != ''){
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
                   
<script>
    function loading(id){
		document.getElementById(id).innerHTML = "<div style='float:right; font-weight:bold'>&nbsp;&nbsp;&nbsp;Loading</div><div class='loader' style='float:right'></div>"; // Hide the image after the response from the server
		 $('#'+id).attr("style", "color: green");
	}

    function check_name() {
		
		var str = $('#name_input').val();
		
	    if (str.length == 0) { 
	        document.getElementById("name").innerHTML = "";
	        return;
	    } 
		else {
	        var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                document.getElementById("name").innerHTML = this.responseText;
					if(this.responseText == " &nbsp; Supplier name already exists! "){
						$("#name").attr("style", "color: red; font-weight: bold; float:right;");
						$("#submit").attr("disabled", true);
					}
					else{
						$("#name").attr("style", "color: green; font-weight: bold; float:right;");
						$("#submit").attr("disabled", false);
					}
	            }
	        };
	        xmlhttp.open("GET", "models/validate_ajax.php?q_sname=" + str, true);
	        xmlhttp.send();
	    }
	}

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

function isNumberKey(evt){
         	var charCode = (evt.which) ? evt.which : event.keyCode
         	if (charCode > 31 && (charCode < 48 || charCode > 57))
            	return false;
         	return true;
    }

var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms, 5 second for example
var $input_name = $('#name_input');

//on keyup, start the countdown
$input_name.on('keyup', function () {
  $("#submit").attr("disabled", true);
  clearTimeout(typingTimer);
  typingTimer = setTimeout(check_name, doneTypingInterval);
});
</script>

