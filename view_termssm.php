<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];

    include 'models/terms_sm_model.php';
    $terms = new Terms_SM();

    $terms->set_data($id);
    $term = $terms->term;
    $days = $terms->days;
}
else{
    $id = '';
    $term = '';
    $days = '';
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

                    <form action='models/terms_sm_model.php?id=<?php echo $id; ?>' method='post'>  
                  <div class="form-group">
                    <div style='width:100%'>
                    <label>Payment Term</label>
                    <span style='float:right;' id='term'></span>
                    </div>
                    
                    <input type='text' maxlength='200' 

                    <?php
                    if($term != ''){
                        echo " readonly ";
                    }
                    else{
                        echo "";
                    }
                   ?>

                    onkeyup="loading('term')" id='term_input' value='<?php echo $term; ?>' required name="term" class="form-control" placeholder='Type input here...'>
                  </div>

                  <div class="form-group">
                    <label>Days</label>
                    <input type='text' maxlength='11' onkeypress="return isNumberKey(event)" value='<?php echo $days; ?>' name="days" class="form-control" placeholder='Type input here...'>
                  </div>

                  <button type="submit" 
                  
                  <?php
                    if($term != ''){
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

    function check_term() {
		
		var str = $('#term_input').val();
		
	    if (str.length == 0) { 
	        document.getElementById("term").innerHTML = "";
	        return;
	    } 
		else {
	        var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                document.getElementById("term").innerHTML = this.responseText;
					if(this.responseText == " &nbsp; Term already exists! "){
						$("#term").attr("style", "color: red; font-weight: bold; float:right;");
						$("#submit").attr("disabled", true);
					}
					else{
						$("#term").attr("style", "color: green; font-weight: bold; float:right;");
						$("#submit").attr("disabled", false);
					}
	            }
	        };
	        xmlhttp.open("GET", "models/validate_ajax.php?q_termsm=" + str, true);
	        xmlhttp.send();
	    }
    }
    
    function isNumberKey(evt){
         	var charCode = (evt.which) ? evt.which : event.keyCode
         	if (charCode > 31 && (charCode < 48 || charCode > 57))
            	return false;
         	return true;
    }

var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms, 5 second for example
var $input_name = $('#term_input');

//on keyup, start the countdown
$input_name.on('keyup', function () {
  $("#submit").attr("disabled", true);
  clearTimeout(typingTimer);
  typingTimer = setTimeout(check_term, doneTypingInterval);
});
</script>

