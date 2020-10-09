<?php
if(isset($_GET['so'])){
    $so = $_GET['so'];
    $cr = $_GET['cr'];
    
    include 'models/connection.php';
    
    $stmt = $con->prepare('SELECT `TotalAmount`, `Balance`, c.CompanyName, c.CompanyAddress, c.Industry,c.TIN, `SINumber`, p.Bank, p.Branch, p.CheckNumber, p.CheckDate, p.Amount FROM tbl_tsgi_so so JOIN tbl_customers c ON so.CustomerID=c.CustomerID JOIN tbl_tsgi_payment p ON p.SONumber=so.SO_ID WHERE `SO_ID`=? AND PaymentID=?');
    $stmt->bind_param('ii', $so, $cr);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amt, $bal, $company, $address, $industry, $tin, $si, $bank, $branch, $checknumber, $checkdate, $amt_);
    $stmt->fetch();
    
    
?>

<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
</style>
<body>

	<div style='height: 4.3in; width: 8in; border: 1px solid black'>
		
		<div style='width: 32%; height: 4:29in; float: left'>
		    
		    <div style='width: 100%; height: 0.5375in'>&nbsp;</div>
            <div style='width: 50%; text-align: center; height: 0.104375in; font-size: 70%; float:left;'><?php echo $si; ?></div>
            <div style='width: 50%; text-align: center; height: 0.104375in; font-size: 70%; float:left;'><?php echo $amt; ?></div>
            
            
            <div style='width: 100%; height: 1.55in'>&nbsp;</div>
            
            <?php
            if($bank != null){
            ?>
            
            <div style='width: 50%; text-align: center; height: 0.104375in; font-size: 70%; float:left;'>&nbsp;</div>
            <div style='width: 50%; text-align: center; height: 0.104375in; font-size: 70%; float:left;'>x</div>
            
            
            <?php
            }
            else{
            ?>
            
            <div style='width: 50%; text-align: center; height: 0.104375in; font-size: 70%; float:left;'>x</div>
            <div style='width: 50%; text-align: center; height: 0.104375in; font-size: 70%; float:left;'>&nbsp;</div>
            
            <?php
            }
            ?>
            
            <div style='width: 25%; text-align: center; height: 0.104375in; font-size: 70%; float:left;'>&nbsp;</div>
            <div style='width: 75%; text-align: center; height: 0.104375in; font-size: 70%; float:left;'><?php echo $bank; ?></div>
            
            
            <div style='width: 30%; text-align: center; height: 0.104375in; font-size: 70%; float:left;'>&nbsp;</div>
            <div style='width: 70%; text-align: center; height: 0.104375in; font-size: 70%; float:left;'><?php echo $branch; ?></div>
            
            
            <div style='width: 40%; text-align: center; height: 0.104375in; font-size: 70%; float:left;'>&nbsp;</div>
            <div style='width: 60%; text-align: center; height: 0.104375in; font-size: 70%; float:left;'><?php echo $checknumber; ?></div>
            
            
            <div style='width: 45%; text-align: center; height: 0.104375in; font-size: 70%; float:left;'>&nbsp;</div>
            <div style='width: 55%; text-align: center; height: 0.104375in; font-size: 70%; float:left;'><?php echo $checkdate; ?></div>
            
            
            <div style='width: 40%; text-align: center; height: 0.104375in; font-size: 70%; float:left;'>&nbsp;</div>
            <div style='width: 60%; text-align: center; height: 0.104375in; font-size: 70%; float:left;'><?php echo $amt; ?></div>
            
            
		</div>
		
		<div style='width: 68%; height: 1.075in'>&nbsp;</div>
		
		<div style='width: 45%; height: 0.26875in; float:left'>&nbsp;</div>		
		<div style='width: 23%; height: 0.26875in; float:left'>
			<?php
				date_default_timezone_set('Asia/Manila');
				echo date('F j, Y');
			?>
		</div>
		
		<div style='width: 23%; height: 0.26875in; float:left'>&nbsp;</div>		
		<div style='width: 27%; height: 0.26875in; float:left; font-size: 70%'>
			<?php
				echo $company;
			?>
		</div>
		<div style='width: 18%; height: 0.26875in; float:left; font-size: 70%'>
			<?php
				echo $tin;
			?>
		</div>
		
		<div style='width: 21%; height: 0.20875in; float:left'>&nbsp;</div>
		<div style='width: 47%; height: 0.20875in; float:left; font-size: 70%'>
		    <?php echo $address; ?>
		</div>
		
		<div style='width: 32%; height: 0.20875in; float:left'>&nbsp;</div>
		<div style='width: 36%; height: 0.20875in; float:left; font-size: 50%'><?php echo $industry; ?></div>
		
		<div style='width: 21%; height: 0.20875in; float:left'>&nbsp;</div>
		<div style='width: 47%; height: 0.20875in; float:left; font-size: 50%'>
		    
<?php
function numberTowords($num)
{ 
$ones = array( 
1 => "one", 
2 => "two", 
3 => "three", 
4 => "four", 
5 => "five", 
6 => "six", 
7 => "seven", 
8 => "eight", 
9 => "nine", 
10 => "ten", 
11 => "eleven", 
12 => "twelve", 
13 => "thirteen", 
14 => "fourteen", 
15 => "fifteen", 
16 => "sixteen", 
17 => "seventeen", 
18 => "eighteen", 
19 => "nineteen" 
); 
$tens = array( 
1 => "ten",
2 => "twenty", 
3 => "thirty", 
4 => "forty", 
5 => "fifty", 
6 => "sixty", 
7 => "seventy", 
8 => "eighty", 
9 => "ninety" 
); 
$hundreds = array( 
"hundred", 
"thousand", 
"million", 
"billion", 
"trillion", 
"quadrillion" 
); //limit t quadrillion 
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){ 
if($i < 20){ 
$rettxt .= $ones[$i]; 
}elseif($i < 100){ 
$rettxt .= $tens[substr($i,0,1)]; 
$rettxt .= " ".$ones[substr($i,1,1)]; 
}else{ 
$rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
$rettxt .= " ".$tens[substr($i,1,1)]; 
$rettxt .= " ".$ones[substr($i,2,1)]; 
} 
if($key > 0){ 
$rettxt .= " ".$hundreds[$key]." "; 
} 
} 
if($decnum > 0){ 
    if($rettxt != ''){
        $rettxt .= " and "; 
    }
    if($decnum < 20){ 
    $rettxt .= $ones[$decnum]; 
    }elseif($decnum < 100){ 
    $rettxt .= $tens[substr($decnum,0,1)]; 
    $rettxt .= " ".$ones[substr($decnum,1,1)]; 
    }
    $rettxt .= ' centavos';
    $rettxt .= ' only.';
}
else{
    $rettxt .= ' pesos only.';
}
return $rettxt; 
} 
        echo strtoupper(numberTowords($amt_));
		    
?>
		 
		</div>
		
		<div style='width: 50%; height: 0.20875in; float:left'>&nbsp;</div>
		<div style='width: 18%; height: 0.20875in; float:left'>
			<?php
				echo number_format($amt_, 2);
			?>
		</div>
		
		<div style='width: 28%; height: 0.26875in; float:left'>&nbsp;</div>
		<div style='width: 40%; height: 0.26875in; float:left'>
			SI Number - <?php echo $si; ?>
		</div>
		
		<div style='width: 68%; height: 0.16875in; float:left'>&nbsp;</div>
		
		<div style='width: 68%; height: 0.26875in; float:left'>&nbsp;</div>		
		
	</div>


</body>

<?php
include 'js.php';
?>

<script>

	var text;
    var or = prompt("Input CR Number");
    	
    	var cr = '<?php echo $_GET['cr']; ?>';
    	
    	$.ajax({
    		url: 'models/ajax_payment.php',
    		type: 'post',
    		data: {
    		 	or : or,
    		 	cr: cr
    		},
    		success: function(data){
    			window.print();
    		}
    	});
    	
	setTimeout("closePrintPreview()", 1000);
	
	function closePrintPreview(){
		document.location.href='po_details?id=<?php echo $so; ?>';
	}
	
</script>

<?php
}
?>
