<?php
//if so has already dr record redirect to print dr
$so = $_GET['so'];

include 'models/sales_order_model.php';

$som = new Sales_Order();
$som->check_si($so);

if($som->check_si($so)){ //may dr na
     //redirect to printing of DR
     echo "
     <script>
     window.location.href='print_si.php?so=$so';
     </script>
     ";
}
else{ //dr is null
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
                <form action='models/sales_order_model.php?so=<?php echo $so; ?>' method='post'>
                 <div class="form-group">
                    <div style='width:100%'>
                    <label>SI Number</label>
                    <span style='float:right;' id='si'></span>
                    </div>
                    
                    <input type='text' maxlength='100' 
                    onkeypress="return isNumberKey(event)" 
                    onkeyup="loading('si')" id='si_input' value='' required name="si" class="form-control" placeholder='Type input here...'>
                  </div>           

                   <div class="form-group">
                    <label>Date</label>
                    <input type="date" id='dte' required name="date" class="form-control">
                  </div>     

                  <button type="submit" name='save_si'
                   id='submit' class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Details</button>

                   </form>

<?php
}
?>

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

function loading(id){
		document.getElementById(id).innerHTML = "<div style='float:right; font-weight:bold'>&nbsp;&nbsp;&nbsp;Loading</div><div class='loader' style='float:right'></div>"; // Hide the image after the response from the server
		 $('#'+id).attr("style", "color: green");
	}

var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms, 5 second for example
var $input_uname = $('#si_input');

//on keyup, start the countdown
$input_uname.on('keyup', function () {
  $("#submit").attr("disabled", true);
  clearTimeout(typingTimer);
  typingTimer = setTimeout(check_dr, doneTypingInterval);
});

function isNumberKey(evt){
         	var charCode = (evt.which) ? evt.which : event.keyCode
         	if (charCode > 31 && (charCode < 48 || charCode > 57))
            	return false;
         	return true;
    }
    
function check_dr() {
		
		var str = $('#si_input').val();
		
	    if (str.length == 0) { 
	        document.getElementById("si").innerHTML = "";
	        return;
	    } 
		else {
	        var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                document.getElementById("si").innerHTML = this.responseText;
					if(this.responseText == " &nbsp; SI Number already exists! "){
						$("#si").attr("style", "color: red; font-weight: bold; float:right;");
						$("#submit").attr("disabled", true);
					}
					else{
						$("#si").attr("style", "color: green; font-weight: bold; float:right;");
						$("#submit").attr("disabled", false);
					}
	            }
	        };
	        xmlhttp.open("GET", "models/validate_ajax.php?q_si=" + str, true);
	        xmlhttp.send();
	    }
	}

</script>