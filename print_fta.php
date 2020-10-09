<?php
include 'css.php';
include 'models/po_payment_model.php';
include 'models/tsgi_model.php';

$po = new PO_Payment();
$tsgi = new TSGI();

$fta = $_GET['fta'];
$po->set_data($fta);
$tsgi->set_data();

date_default_timezone_set("Asia/Manila");
$date = date("F j, Y");

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
    $rettxt .= ' dollars only.';
}
return $rettxt; 
} 
?>
<body>

<span style='position: absolute; float:left; font-size: 15px; margin-top: 0.3in; margin-left: 1.5in;'><?php echo $po->branch; ?></span>

<span style='position: absolute; float:left; font-size: 15px; margin-top: 0.4in; margin-left: 7in;'><?php echo $date; ?></span>

<span style='position: absolute; float:left; font-size: 15px; margin-left: 1.8in; margin-top: 1.5in;'><?php echo $po->accnum; ?></span>

<span style='position: absolute; float:left; font-size: 15px; margin-top: 0.7in; margin-left: 6.2in;'><?php echo $po->company; ?></span>

<span style='position: absolute; float:left; font-size: 15px; margin-top: 1in; margin-left: 5.9in;'><?php echo $po->address; ?></span>

<span style='position: absolute; float:left; font-size: 15px; margin-top: 1.3in; margin-left: 6.1in;'><?php echo $po->bank; ?></span>

<span style='position: absolute; float:left; font-size: 15px; margin-top: 1.6in; margin-left: 6in;'><?php echo $po->bankaddress; ?></span>

<span style='position: absolute; float:left; font-size: 15px; margin-top: 1.9in; margin-left: 6.1in;'><?php echo $po->supp_accnum.' - '.$po->swift; ?></span>

<span style='position: absolute; float:left; font-size: 11px; margin-top: 2.2in; margin-left: 4.5in;'><?php echo ucwords(numberTowords($po->amt)); ?></span>

<span style='position: absolute; float:left; font-size: 11px; margin-top: 2.2in; margin-left: 7.7in;'><?php echo $po->amt; ?></span>

<span style='position: absolute; float:left; font-size: 15px; margin-left: 1.8in; margin-top: 4.5in;'><?php echo 'SO Ref(s): '.$po->poref; ?></span>

<span style='position: absolute; float:left; font-size: 11px; margin-left: 0.3in; margin-top: 5.2in;'><?php echo $tsgi->name; ?></span>

<span style='position: absolute; float:left; font-size: 11px; margin-left: 2.3in; margin-top: 5.2in;'><?php echo $tsgi->tel; ?></span>

<span style='position: absolute; float:left; font-size: 11px; margin-left: 0.3in; margin-top: 5.4in;'><?php echo $tsgi->address; ?></span>

<span style='position: absolute; float:left; font-size: 11px; margin-left: 2.3in; margin-top: 5.4in;'><?php echo $tsgi->bday; ?></span>

<span style='position: absolute; float:left; font-size: 11px; margin-left: 0.3in; margin-top: 5.6in;'><?php echo $tsgi->nature; ?></span>

<span style='position: absolute; float:left; font-size: 11px; margin-left: 2in; margin-top: 5.6in;'>Payment to Supplier</span>

</body>

<?php
include 'js.php';
?>

<script>
    
    window.print();
    
    setTimeout("closePrintView()", 1000);
    function closePrintView() {
        window.close();
    }
    
</script>