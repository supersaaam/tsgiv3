<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];

    include 'models/packaging_model.php';
    $pk = new Packaging();

    $pk->set_data($id);
    $packaging = $pk->packaging;
    $divisor = $pk->divisor;
}
else{
    $id = '';
    $packaging = '';
    $divisor = '';
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

                    <form action='models/packaging_model.php?id=<?php echo $id; ?>' method='post'>  
                  <div class="form-group">
                    <div style='width:100%'>
                    <label>Packaging</label>
                    <span style='float:right;' id='packaging'></span>
                    </div>
                    
                    <input type='text' maxlength='200' 
                    
                    <?php
                    if($packaging != ''){
                      echo ' readonly ';
                    }
                    ?>

                    onkeyup="loading('packaging')" id='packaging_input' value='<?php echo $packaging; ?>' required name="packaging" class="form-control" placeholder='Type input here...'>
                  </div>

                  <div class="form-group">
                    <label>Divisor</label>
                    <input type='text' maxlength='11' onkeypress="return isNumberKey(event)" value='<?php echo $divisor; ?>' name="divisor" class="form-control" placeholder='Type input here ...'>
                  </div>

                  <button type="submit" 
                  
                  <?php
                    if($packaging != ''){
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

    function isNumberKey(evt){
         	var charCode = (evt.which) ? evt.which : event.keyCode
         	if (charCode > 31 && (charCode < 48 || charCode > 57))
            	return false;
         	return true;
    }

    function check_packaging() {
		
		var str = $('#packaging_input').val();
		
	    if (str.length == 0) { 
	        document.getElementById("packaging").innerHTML = "";
	        return;
	    } 
		else {
	        var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                document.getElementById("packaging").innerHTML = this.responseText;
					if(this.responseText == " &nbsp; Packaging already exists! "){
						$("#packaging").attr("style", "color: red; font-weight: bold; float:right;");
						$("#submit").attr("disabled", true);
					}
					else{
						$("#packaging").attr("style", "color: green; font-weight: bold; float:right;");
						$("#submit").attr("disabled", false);
					}
	            }
	        };
	        xmlhttp.open("GET", "models/validate_ajax.php?q_packaging=" + str, true);
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


var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms, 5 second for example
var $input_name = $('#packaging_input');

//on keyup, start the countdown
$input_name.on('keyup', function () {
  $("#submit").attr("disabled", true);
  clearTimeout(typingTimer);
  typingTimer = setTimeout(check_packaging, doneTypingInterval);
});
</script>

