<?php
if(isset($_GET['id'])){
    include 'models/user_model.php';
    $user = new User();

    $user->set_data($_GET['id']);
    $uname = $user->username;
    $fname = $user->fname;
    $lname = $user->lname;
    $mname = $user->mname;
    $pw = $user->pw;
}
else{
    $uname = '';
    $fname = '';
    $lname = '';
    $mname = '';
    $pw = '';
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

            <!-- /.card-header -->
            <div class="card-body">
                <form role="form" action="models/user_model.php" method="post" id="imp_form">
                  <div class="form-group">
                    <div style='width:100%'>
                    <label>Username</label>
                    <span style='float:right;' id='uname'></span>
                    </div>
                    <input type='text' maxlength='50' required 
                    
                    <?php
                    if($uname != ''){
                        echo ' readonly ';
                    }
                    ?>

                    onkeyup="loading('uname')" value='<?php echo $uname; ?>' id='username' name="username" class="form-control" placeholder='Type input here...'>
                  </div>

                  <div class="form-group">
                    <label>First Name</label>
                    <input type='text' maxlength='50' onkeypress="return onlyAlphabets(event,this)" required value='<?php echo $fname; ?>' name="fname" class="form-control" placeholder='Type input here...'>
                  </div>

                  <div class="form-group">
                    <label>Middle Name</label>
                    <input type='text' maxlength='50' onkeypress="return onlyAlphabets(event,this)" required value='<?php echo $mname; ?>' name="mname" class="form-control" placeholder='Type input here...'>
                  </div>

                  <div class="form-group">
                    <label>Last Name</label>
                    <input type='text' maxlength='50' onkeypress="return onlyAlphabets(event,this)" required value='<?php echo $lname; ?>' name="lname" class="form-control" placeholder='Type input here...'>
                  </div>

                  <div class="form-group">
                    <label>Password</label>
                    <input type='password' maxlength='50' required value='<?php echo $pw; ?>' name="pw" class="form-control" placeholder='Type input here...'>
                  </div>
               
                  <button type="submit" 
                  
                  <?php
                    if($uname != ''){
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

<script>
    function loading(id){
		document.getElementById(id).innerHTML = "<div style='float:right; font-weight:bold'>&nbsp;&nbsp;&nbsp;Loading</div><div class='loader' style='float:right'></div>"; // Hide the image after the response from the server
		 $('#'+id).attr("style", "color: green");
	}

    function check_username() {
		
		var str = $('#username').val();
		
	    if (str.length == 0) { 
	        document.getElementById("uname").innerHTML = "";
	        return;
	    } 
		else {
	        var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                document.getElementById("uname").innerHTML = this.responseText;
					if(this.responseText == " &nbsp; Username already exists! "){
						$("#uname").attr("style", "color: red; font-weight: bold; float:right;");
						$("#submit").attr("disabled", true);
					}
					else{
						$("#uname").attr("style", "color: green; font-weight: bold; float:right;");
						$("#submit").attr("disabled", false);
					}
	            }
	        };
	        xmlhttp.open("GET", "models/validate_ajax.php?q=" + str, true);
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
var $input_uname = $('#username');

//on keyup, start the countdown
$input_uname.on('keyup', function () {
  $("#submit").attr("disabled", true);
  clearTimeout(typingTimer);
  typingTimer = setTimeout(check_username, doneTypingInterval);
});
</script>