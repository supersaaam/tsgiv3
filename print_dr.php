<html>
<style>
@media print {

    html, body {
      height:100vh; 
      margin: 0 !important; 
      padding: 0 !important;
      overflow: hidden;
    }

}
</style>

<?php
include 'css.php';
include 'models/so_model.php';

$sox = new SO();
$sox->set_data($_GET['so']);
$dr = $_GET['dr'];

date_default_timezone_set("Asia/Manila");
$date = date("F j, Y");
$so = $_GET['so'];
$po = $sox->ponum;
$company = $sox->company;
$si_number = $sox->si_number;
?>

<body>

<div style='width: 6.7in; margin-top: 1.8in; margin-left: 2in; clear: both'>
	<span style='font-size:18px;'><?php echo $date; ?></span>
	<span style='float:right; font-size: 18px; margin-right: 1.5in;'><?php echo $po; ?></span>
</div>

<div style='width: 6.7in; margin-left: 2in; clear: both'>
	<span style='font-size:18px'><?php echo $company; ?></span>
	<span style='float:right; font-size: 18px; margin-right: 1.5in;'><?php echo $si_number; ?></span>
</div>

<br>
<div style='width: 6.7in; margin-left: 1.3in; clear: both; margin-top: 0.5in'>
	
	<table style='width:100%; border:0px solid black; margin-top:10px; font-size: 18px'>
		<?php
		$sox->print_dr($dr);
		?>	
	</table>

</div>

</body>
</html>

<?php
include 'js.php';
?>


<script>

	var text;
    	var drnum = prompt("Input DR Number");
    	
    	var dr = '<?php echo $dr; ?>';
    	
    	if(isNaN(drnum)){
    		alert('Input numbers only');
    		location.reload();
    	}
    	else{
	    	$.ajax({
	    		url: 'models/ajax_dr.php',
	    		type: 'post',
	    		data: {
	    		 	dr : dr,
	    		 	drnum: drnum
	    		},
	    		success: function(data){
	    			window.print();
	    		}
	    	});
    	}
    /*	
    setTimeout("closePrintView()", 1000);
    function closePrintView() {
        document.location.href = 'po_details?id=<?php echo $so; ?>';
    }
    */
</script>
