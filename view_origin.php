<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];

    include 'models/origin_model.php';
    $orig = new Origin();

    $orig->set_data($id);
    $origin = $orig->origin;
}
else{
    $id = '';
    $origin = '';
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

                    <form action='models/origin_model.php?id=<?php echo $id; ?>' method='post'>  
                  <div class="form-group">
                    <div style='width:100%'>
                    <label>Origin</label>
                    <span style='float:right;' id='origin'></span>
                    </div>
                    
                    <input type='text' maxlength='200' 
                    onkeyup="loading('origin')" onkeypress="return onlyAlphabets(event,this)" id='origin_input' value='<?php echo $origin; ?>' required name="origin" class="form-control" placeholder='Type input here...'>
                  </div>

                  <button type="submit" 
                  
                  <?php
                    if($origin != ''){
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

    function check_origin() {
		
		var str = $('#origin_input').val();
		
	    if (str.length == 0) { 
	        document.getElementById("origin").innerHTML = "";
	        return;
	    } 
		else {
	        var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                document.getElementById("origin").innerHTML = this.responseText;
					if(this.responseText == " &nbsp; Origin already exists! "){
						$("#origin").attr("style", "color: red; font-weight: bold; float:right;");
						$("#submit").attr("disabled", true);
					}
					else{
						$("#origin").attr("style", "color: green; font-weight: bold; float:right;");
						$("#submit").attr("disabled", false);
					}
	            }
	        };
	        xmlhttp.open("GET", "models/validate_ajax.php?q_origin=" + str, true);
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
var $input_name = $('#origin_input');

//on keyup, start the countdown
$input_name.on('keyup', function () {
  $("#submit").attr("disabled", true);
  clearTimeout(typingTimer);
  typingTimer = setTimeout(check_origin, doneTypingInterval);
});
</script>

