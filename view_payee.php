<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];

    include 'models/payee_model.php';
    $py = new Payee();

    $py->set_data($id);
    $payee = $py->payee;
}
else{
    $id = '';
    $payee = '';
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

                    <form action='models/payee_model.php?id=<?php echo $id; ?>' method='post'>  
                  <div class="form-group">
                    <div style='width:100%'>
                    <label>Payee Name</label>
                    <span style='float:right;' id='payee'></span>
                    </div>
                    
                    <input type='text' maxlength='200' 
                    onkeyup="loading('payee')" id='payee_input' value='<?php echo $payee; ?>' required name="payee" class="form-control" placeholder='Type input here...'>
                  </div>

                  <button type="submit" 
                  
                  <?php
                    if($payee != ''){
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

    function check_payee() {
		
		var str = $('#payee_input').val();
		
	    if (str.length == 0) { 
	        document.getElementById("payee").innerHTML = "";
	        return;
	    } 
		else {
	        var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                document.getElementById("payee").innerHTML = this.responseText;
					if(this.responseText == " &nbsp; Payee already exists! "){
						$("#payee").attr("style", "color: red; font-weight: bold; float:right;");
						$("#submit").attr("disabled", true);
					}
					else{
						$("#payee").attr("style", "color: green; font-weight: bold; float:right;");
						$("#submit").attr("disabled", false);
					}
	            }
	        };
	        xmlhttp.open("GET", "models/validate_ajax.php?q_payee=" + str, true);
	        xmlhttp.send();
	    }
	}

var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms, 5 second for example
var $input_name = $('#payee_input');

//on keyup, start the countdown
$input_name.on('keyup', function () {
  $("#submit").attr("disabled", true);
  clearTimeout(typingTimer);
  typingTimer = setTimeout(check_payee, doneTypingInterval);
});
</script>

