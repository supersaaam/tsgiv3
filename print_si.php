<?php
include 'css.php';
include 'models/so_model.php';

$sox = new SO();
$sox->set_data($_GET['so']);

date_default_timezone_set("Asia/Manila");
$date = date("F j, Y");
$so = $_GET['so'];
$po = $sox->ponum;
$company = $sox->company;
?>

<body>

<div style='width: 6.7in; margin-top: 1.4in; margin-left: 1.7in; clear: both'>
	<span style='font-size:15px;'><?php echo $company; ?></span>
	<span style='float:right; font-size: 15px; margin-right: 1.5in;'><?php echo $date; ?></span>
</div>

<div style='width: 6.7in; margin-left: 1.7in; clear: both'>
	<span style='font-size:13px'><?php echo $sox->c_address; ?></span>
	<span style='float:right; font-size: 15px;margin-right: 1.5in;'><?php echo $sox->terms; ?></span>
</div>

<div style='width: 6.7in; margin-left: 1.7in; clear: both'>
	<span style='font-size:13px'><?php echo $sox->c_industry; ?></span>
	<span style='float:right; font-size: 15px'></span>
</div>

<div style='width: 6.7in; margin-left: 1.7in; clear: both'>
	<span style='font-size:15px'><?php echo $sox->c_tin; ?></span>
	<span style='float:right; font-size: 15px'></span>
</div>

<br>
<div style='width: 6.7in; margin-left: 1.8in; clear: both'>
	
	<table style='width:80%; border:0px solid black; margin-top:10px'>
		<?php
		$sox->print_si($so);
		?>	
	</table>
    
</div>

<?php
if($sox->vattype == 'VAT'){
?>
    <div style='position: absolute; top: 5.6in; right: 1.5in;'>
            <?php 
                $amt = $sox->ta;
                echo $amt ."<br>";
                echo number_format($amt-($amt/1.12),2);
                echo "<br>";
                echo number_format($amt/1.12,2);
            ?>
    </div>
<?php
}
elseif($sox->vattype == 'Non-VAT'){
?>
    <div style='position: absolute; top: 5.6in; left: 1.8in;'>
            <?php 
                $amt = $sox->ta;
                echo "<br>";
                echo "<br>";
                echo "<br>";
                echo $sox->ta;
            ?>
    </div>
<?php
}
elseif($sox->vattype == 'Zero-Rated'){
?>
    <div style='position: absolute; top: 5.6in; left: 1.8in;'>
            <?php 
                $amt = $sox->ta;
                echo "<br>";
                echo "<br>";
                echo "<br>";
                echo "<br>";
                echo $sox->ta;
            ?>
    </div>
<?php
}
?>

</body>

<?php
include 'js.php';
?>


<script>

	var text;
    	var sinum = prompt("Input SI Number");
    	
    	var so = '<?php echo $so; ?>';
    	
    	if(isNaN(sinum)){
    		alert('Input numbers only');
    		location.reload();
    	}
    	else{
	    	$.ajax({
	    		url: 'models/ajax_si.php',
	    		type: 'post',
	    		data: {
	    		 	so : so,
	    		 	sinum: sinum
	    		},
	    		success: function(data){
	    			window.print();
	    		}
	    	});
    	}
    	
    setTimeout("closePrintView()", 1000);
    function closePrintView() {
        document.location.href = 'po_details?id=<?php echo $so; ?>';
    }
</script>