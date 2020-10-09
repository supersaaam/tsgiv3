<?php
namespace Dompdf;

require_once 'dompdf-0.7.0/autoload.inc.php';
include 'models/quotation_model_.php';

$dompdf = new Dompdf(); 
$q = new Quotation();

$qid = $_GET['id'];
$qid_fmtd = sprintf('%06d', $qid);

$q->set_data($qid);
$revnum = $q->revnum;

if($revnum > 0){
	$qid_fmtd .= '_rev_'.sprintf('%02d', $revnum);
}

$date = date_format(date_create($q->date), 'j F Y');
//content here

$message = $q->show_bd($qid);

$notes = '';

if($q->qb == '16'){
    $signatory = 'Dhesiree M. Sumaylo';
}
else{
    $signatory = 'Reginald C. Ventura';    
}


if($q->notes != ''){
	$notes = "
<div style='width: 100%; margin-left: 5.5%; clear:both; font-weight: normal; font-size: 15px'>
<br><br>
<b>Note:</b>
<br><br>
    <div style='margin-left: 20px'>".$q->notes."</div>
</div>
	";	
}

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
<b style='font-weight: bold'> 2/F 198 Diversion Rd. Sta Ursula, Batingan</b><br>
<b style='font-weight: bold'> Binangonan, Rizal,<br> Philippines 1940</b><br>
<b style='font-weight: bold'> Tel. No.: +63 2 616 1554</b><br>
<b style='font-weight: bold'> <a href='mailto:sales@transcendosolutions.com'>sales@transcendosolutions.com</a></b><br>
<b style='font-weight: bold'> <a target='_new' href='http://transcendosolutions.com'>transcendosolutions.com</a></b>
</div>

<div style='width: 100%; margin-left: 5%; margin-top: 150px; font-weight: normal; font-size: 15px'>
<table style='border=0px; width: 58%; margin-right: 2%; float:left'>
<tr>
    <td>DATE: </td>
    <td><b>$date</b></td>
</tr>
<tr>
    <td>TO: </td>
    <td><b>$q->cperson</b>, $q->dept</td>
</tr>
$q->cc
<tr>
    <td>COMPANY: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><b>$q->company</b></td>
</tr>
<tr>
    <td></td>
    <td>$q->address</td>
</tr>
</table>

<table style='border: 0px; width: 38%; float:left; margin-left: 2%'>
<tr>
    <td style='text-align: right'>TSGI QT #$qid_fmtd</td>
</tr>
$q->qt_ref
</table>
</div>

<div style='width: 100%; margin-left: 5.5%; clear:both; font-weight: normal; font-size: 15px'>
<br><br>
Dear $q->salutation,
<br><br>
$q->intro
</div>

<br><br>
$message

$notes

<div style='width: 100%; margin-left: 5.5%; clear:both; font-weight: normal; font-size: 15px'>
<br><br>
We trust the above quotation meet your requirements and looking forward to receive your favourable
reply. 
</div>

<div style='width: 100%; margin-left: 5.5%; clear:both; font-weight: normal; font-size: 15px'>
<br><br>
<b>Terms and Conditions:</b>
<br><br>
	<div style='margin-left: 20px; width: 100%'>
	<b>Notes: </b>
	$q->n
	<br>
	<b>Payment Terms: </b> &nbsp;&nbsp;&nbsp; $q->terms
	<br>
	$q->en
	</div>
</div>

<div style='width: 100%; margin-left: 5.5%; clear:both; font-weight: normal; font-size: 15px'>
<br><br><br><br>
Truly Yours,
<br><br>
$signatory
<br>
<b>Transcendo Solutions Global Inc.</b>
</div>

<div style='position: absolute; bottom: 10px; width: 100%;'>
    <center style='font-size: 14px; color: gray'>www.transcendosolutions.com</center>
    <br>
    <div style='margin: 0 auto; width: 90%; height: 3px; background-color: #027C9E; border-radius: 1px'>&nbsp;</div>
</div>

");

$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("QT #$qid_fmtd.pdf", array("Attachment" => false));

exit(0);
?>