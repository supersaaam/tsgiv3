<?php
//Email here
$headers = 
	'From: transcendosolutions.com' . "\r\n" .
    'Reply-To: ' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
	// send email
	
require_once "phpmailer/PHPMailerAutoload.php";

//PHPMailer Object
$mail = new PHPMailer;

//From email address and name
$mail->From = "system@transcendosolutions.com";
$mail->FromName = "Transcendo Solutions";

$mail->addAddress("dhesireems@transcendosolutions.com"); //Recipient name is optional
$mail->addAddress("sales@transcendosolutions.com");
$mail->addAddress('jaypcavitana@gmail.com');

//Address to which recipient will reply
//$mail->addReplyTo("efwadmin@commlinked.net", "Reply");

//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = "Reminder for Quotation and Customer Balances";
$message = "";

$message .= 'This is to remind you of the requests for quotation which are still pending. The following requests need to be quoted...';
$message .= "<br><br>";
$message .= "<table border='1|0' cellpadding='5' style='border-collapse: collapse; width: 100%; font-family: Helvetica; font-size: 13px'>";
$message .= "
	<thead>
		<tr>
			<th>Company</th>
			<th>Contact Person</th>
			<th>Date Requested</th>
			<th>Content</th>
			<th>Remarks</th>
		</tr>
	</thead>
";

include 'connection.php';

$stmt = $con->prepare("SELECT c.CompanyName, cc.ContactPerson, `DateRequested`, `Content`, `Remarks` FROM tbl_quote_request qr JOIN tbl_customers c ON qr.CustomerID=c.CustomerID JOIN tbl_customers_contact cc ON cc.CC_ID=qr.ContactPerson WHERE qr.Status='PENDING' ORDER BY DateRequested ASC");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($company, $cperson, $date, $content, $remarks);
if($stmt->num_rows > 0){
	while($stmt->fetch()){
		$date = date_format(date_create($date), "F j, Y");
		$message .= "
			<tr>
				<td>".$company."</td>
				<td>".$cperson."</td>
				<td>".$date."</td>
				<td>".$content."</td>
				<td>".$remarks."</td>
			</tr>
		";
	}
}
else{
    $message .= "
        <tr>
            <td colspan='5'><center>No records to show...</center></td>
        </tr>
    ";
}
$stmt->close();
$con->close();

$message .= "</table>";
$message .= "<br><br>To view these requests, please clink <a href='http://admin.transcendosolutions.com/quote_request'>here</a>.";


$message .= "<br><br>";
$message .= 'The following are records of customers with unpaid dues...';
$message .= "<br><br>";
$message .= "<table border='1|0' cellpadding='5' style='border-collapse: collapse; width: 100%; font-family: Helvetica; font-size: 13px'>";
$message .= "
	<thead>
		<tr>
			<th>SO Number</th>
			<th>Invoice Number</th>
			<th>Invoice Amount</th>
			<th>Balance</th>
			<th>Company</th>
			<th>Due Date</th>
		</tr>
	</thead>
";

include 'connection.php';

$stmt = $con->prepare("SELECT `SO_ID`, `TotalAmount`, `Balance`, `DueDate`, `SINumber`, c.CompanyName FROM tbl_tsgi_so so JOIN tbl_customers c ON c.CustomerID=so.CustomerID WHERE Balance > 0 AND DueDate != NULL ORDER BY DueDate ASC");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($so, $amt, $bal, $due, $si, $company);
if($stmt->num_rows > 0){
	while($stmt->fetch()){
		$due = date_format(date_create($due), "F j, Y");
		$so = sprintf('%06d', $so);
		$message .= "
			<tr>
				<td>".$so."</td>
				<td>".$si."</td>
				<td>".$amt."</td>
				<td>".$bal."</td>
				<td>".$company."</td>
				<td>".$due."</td>
			</tr>
		";
	}
}
else{
    $message .= "
        <tr>
            <td colspan='6'><center>No records to show...</center></td>
        </tr>
    ";
}
$stmt->close();
$con->close();

$message .= "</table>";
$message .= "<br><br>To view these requests, please clink <a href='http://admin.transcendosolutions.com/po_from_customer'>here</a>.";

$message .= "<br><br>";
$message .= 'The following are records of our balances to suppliers...';
$message .= "<br><br>";
$message .= "<table border='1|0' cellpadding='5' style='border-collapse: collapse; width: 100%; font-family: Helvetica; font-size: 13px'>";
$message .= "
	<thead>
		<tr>
			<th>SO Reference Number</th>
			<th>Supplier</th>
			<th>Amount</th>
		</tr>
	</thead>
";

include 'connection.php';

$stmt = $con->prepare("SELECT `SOReferenceNumber`, s.CompanyName, `TotalAmount`, `Currency` FROM tbl_tsgi_po po JOIN tbl_supplier s ON s.SupplierID=po.SupplierID WHERE Status='CONFIRMED'");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($soref, $supp, $amt, $currency);
if($stmt->num_rows > 0){
	while($stmt->fetch()){
	    
	    if($currency == 'USD'){
	        $c = '$';
	    }
	    else{
	        $c = '&euro;';
	    }
	    
		$message .= "
			<tr>
				<td>".$soref."</td>
				<td>".$supp."</td>
				<td>".$c.' '.$amt."</td>
			</tr>
		";
	}
}
else{
    $message .= "
        <tr>
            <td colspan='3'><center>No records to show...</center></td>
        </tr>
    ";
}
$stmt->close();
$con->close();

$message .= "</table>";
$message .= "<br><br>To view these balances, please clink <a href='http://admin.transcendosolutions.com/po_to_supplier'>here</a>.";

$mail->Body = $message;
$mail->send();


//after 30 days from qt date (if not approved: automatically put it in the rejected quotes)
//SELECT `QuotationID` FROM `tbl_quote` WHERE DATE_ADD(Date, INTERVAL 30 DAY) < CURDATE() AND Status='PENDING'

include 'connection.php';
$stmt = $con->prepare("UPDATE `tbl_quote` SET `Status`='REJECTED',`ReasonForRejection`='Quotation reached 30 days validity period.' WHERE DATE_ADD(Date, INTERVAL 30 DAY) < CURDATE() AND Status='PENDING'");
$stmt->execute();
$stmt->close();
$con->close();

?>