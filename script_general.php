<script>
    function loading(id){
		document.getElementById(id).innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class='loader' style='float:left; margin-top:5px'></div><div style='float:left; font-weight: bold'>&nbsp;&nbsp;&nbsp;Loading</div>"; // Hide the image after the response from the server
		 $('#'+id).attr("style", "color: green");
	}

/*
Functions for keypresses
*/
//setup before functions
var typingTimer;                //timer identifier
var doneTypingInterval = 2000;  //time in ms, 5 second for example
var $input_inv = $('#inv_input');

//on keyup, start the countdown
$input_inv .on('keyup', function () {
  clearTimeout(typingTimer);
  typingTimer = setTimeout(validate_inv, doneTypingInterval);
});

    function validate_inv() {
        var str = $("#inv_input").val();
		
		var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	        if (this.readyState == 4 && this.status == 200) {
			
            document.getElementById("inv_val").innerHTML = this.responseText;
					
			if(this.responseText == "Invoice number already exists."){
                $("#inv_val").attr("style", "color: red; font-weight: bold");
				$("#submit_new").attr("disabled", true);
			}
			else{
				$("#inv_val").attr("style", "color: green; font-weight: bold");
				$("#submit_new").attr("disabled", false);
			}
	        }
	        };
	    xmlhttp.open("GET", "models/ajax_invoice.php?num=" + str, true);
	    xmlhttp.send();
    }

$("#startDatePicker").change(function(){
    document.getElementById("endDatePicker").min = $(this).val(); 
});
</script>