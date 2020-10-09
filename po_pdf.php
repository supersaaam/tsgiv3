<?php
namespace Dompdf;

require_once 'dompdf-0.7.0/autoload.inc.php';
include 'models/po_model_.php';

$dompdf = new Dompdf(); 
$po = new PO();

$ponum = $_GET['po'];
$po->set_data($ponum);

$po_fmtd = 'TSGIPO-'.sprintf('%03d', $ponum).'-'.strtoupper($po->brand);


$date = date_format(date_create($po->date), 'j F Y');
//content here

$del_address = $po->del_address;

if($del_address != NULL) {
    $del_address = "
<tr>
    <td>DELIVERY ADDRESS: </td>
    <td><b>$po->del_address</b></td>
</tr>";

$div = "<div style='clear:both; height: 50px;'>&nbsp;</div>";
$ship_inco = "";

$message = $po->show_bd_local($ponum);
}
else{
    $del_address = '';
    $div = '';
    
$ship_inco = "
<tr>
    <td>SHIP VIA: </td>
    <td><b>$po->shipment</b></td>
</tr>
<tr>
    <td>INCOTERMS: </td>
    <td><b>$po->incoterms</b></td>
</tr>";

$message = $po->show_bd($ponum);

}

$type = $po->type;
$dompdf->loadHtml("

<style>
div {
    font-family: 'Helvetica'
}
</style>

<div style='margin: 0 auto; width: 90%; height: 3px; background-color: #027C9E; border-radius: 1px'>&nbsp;</div>

<div style='height: 150px; float:left; width: 45%; margin-left: 5%'>
<br>
<img src='images/tsgi.png' width='300px'>
</div>

<div style='float:left; width: 45%; text-align: right; margin-right: 5%; font-size: 15px'>
<br>
<b style='font-weight: bold'> 2/F 198 Diversion Rd. Sta Ursula, Batingan</b>
<b style='font-weight: bold'> Binangonan, Rizal, Philippines 1940</b><br>
<b style='font-weight: bold'> Tel. No.: +63 2 616 1554</b>
<b style='font-weight: bold'> <a href='mailto:sales@transcendosolutions.com'>sales@transcendosolutions.com</a></b>
<b style='font-weight: bold'> <a target='_new' href='http://transcendosolutions.com'>transcendosolutions.com</a></b>
</div>

<div style='width: 100%; margin-left: 5%; margin-top: 140px; font-weight: normal; font-size: 15px'>
<h3><center>$type PURCHASE ORDER</center></h3>
<h4 style='font-weight: normal'><center>$po_fmtd</center></h4>
<table style='float: left; border=0px; width: 48%; font-size: 90%; margin-right: 2%; margin-top: 20px; float:left'>
<tr>
    <td>DATE: </td>
    <td><b>$date</b></td>
</tr>
<tr>
    <td>TO: </td>
    <td><b>$po->brand</b></td>
</tr>
<tr>
    <td>ATTN: </td>
    <td><b>$po->cperson</b></td>
</tr>
</table>

<table style='float: left; border=0px; width: 48%; font-size: 90%; margin-left: 2%; margin-top: 20px; float:left'>
<tr>
    <td>TERMS: </td>
    <td><b>$po->terms</b></td>
</tr>

$ship_inco
$del_address

<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
</table>

<br>

$div 

<table style='border: 0px; width: 38%; float:left; margin-left: 2%'>
<tr>
    <td style='text-align: right;'></td>
</tr>
</table>
</div>

<br><br>
<div style='width: 100%; margin-top: 60px;'>
$message
</div>

<div style='width: 100%; margin-left: 5.5%; clear:both; font-weight: normal; font-size: 15px'>
<br><br>
$po->note
</div>

<div style='width: 100%; margin-left: 5.5%; clear:both; font-weight: normal; font-size: 15px'>
<br><br>
<b>Approved by:</b><br><br>
Reginald C. Ventura<br>
<b>Managing Director</b>
<br><br>
</div>

<div style='position: absolute; bottom: 10px; width: 100%;'>
    <center style='font-size: 14px; color: gray'>www.transcendosolutions.com</center>
    <br>
    <div style='margin: 0 auto; width: 90%; height: 3px; background-color: #027C9E; border-radius: 1px'>&nbsp;</div>
</div>

");

$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("QT #$qid_fmtd.pdf", array("Attachment" => false));

exit(0);
?>