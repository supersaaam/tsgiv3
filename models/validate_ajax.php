<?php
include 'connection.php'; #connection string '$con'

if(isset($_GET['q'])){
	
	$q = $_GET['q'];
	$hint = '';
	
	$stmt = $con->prepare('SELECT * FROM tbl_users WHERE Username = ?');
	$stmt->bind_param('s', $q);
	$stmt->execute();
	$stmt->store_result();

	// lookup all hints from array if $q is different from "" 
	if ($q !== '') {
		if($stmt->num_rows > 0){
			$hint = ' &nbsp; Username already exists! ';
		}
	}
	else{
		$hint = ' &nbsp; Valid username.';
	}
	   
	
	// Output "no suggestion" if no hint was found or output correct values 
	echo $hint === '' ? ' &nbsp; Valid username.' : $hint;
}
elseif(isset($_GET['q_cname'])){
	
	$q = $_GET['q_cname'];
	$hint = '';
	
	$stmt = $con->prepare('SELECT * FROM tbl_customers WHERE CompanyName= ?');
	$stmt->bind_param('s', $q);
	$stmt->execute();
	$stmt->store_result();

	// lookup all hints from array if $q is different from "" 
	if ($q !== '') {
		if($stmt->num_rows > 0){
			$hint = ' &nbsp; Company name already exists! ';
		}
	}
	else{
		$hint = ' &nbsp; Valid company name.';
	}
	   
	
	// Output "no suggestion" if no hint was found or output correct values 
	echo $hint === '' ? ' &nbsp; Valid company name.' : $hint;
}
elseif(isset($_GET['q_sname'])){
	
	$q = $_GET['q_sname'];
	$hint = '';
	
	$stmt = $con->prepare('SELECT * FROM tbl_supplier WHERE CompanyName= ?');
	$stmt->bind_param('s', $q);
	$stmt->execute();
	$stmt->store_result();

	// lookup all hints from array if $q is different from "" 
	if ($q !== '') {
		if($stmt->num_rows > 0){
			$hint = ' &nbsp; Supplier name already exists! ';
		}
	}
	else{
		$hint = ' &nbsp; Valid company name.';
	}
	   
	
	// Output "no suggestion" if no hint was found or output correct values 
	echo $hint === '' ? ' &nbsp; Valid company name.' : $hint;
}
elseif(isset($_GET['q_cmo_name'])){
	
	$q = $_GET['q_cmo_name'];
	$hint = '';
	
	$stmt = $con->prepare('SELECT * FROM tbl_cmo WHERE FullName= ?');
	$stmt->bind_param('s', $q);
	$stmt->execute();
	$stmt->store_result();

	// lookup all hints from array if $q is different from "" 
	if ($q !== '') {
		if($stmt->num_rows > 0){
			$hint = ' &nbsp; Name already exists! ';
		}
	}
	else{
		$hint = ' &nbsp; Valid name.';
	}
	   
	
	// Output "no suggestion" if no hint was found or output correct values 
	echo $hint === '' ? ' &nbsp; Valid name.' : $hint;
}
elseif(isset($_GET['q_whname'])){
	
	$q = $_GET['q_whname'];
	$hint = '';
	
	$stmt = $con->prepare('SELECT * FROM tbl_warehouse WHERE WarehouseName= ?');
	$stmt->bind_param('s', $q);
	$stmt->execute();
	$stmt->store_result();

	// lookup all hints from array if $q is different from "" 
	if ($q !== '') {
		if($stmt->num_rows > 0){
			$hint = ' &nbsp; Warehouse name already exists! ';
		}
	}
	else{
		$hint = ' &nbsp; Valid name.';
	}
	   
	
	// Output "no suggestion" if no hint was found or output correct values 
	echo $hint === '' ? ' &nbsp; Valid name.' : $hint;
}
elseif(isset($_GET['q_pname'])){
	
	$q = $_GET['q_pname'];
	$hint = '';
	
	$stmt = $con->prepare('SELECT * FROM tbl_product WHERE ProductName= ?');
	$stmt->bind_param('s', $q);
	$stmt->execute();
	$stmt->store_result();

	// lookup all hints from array if $q is different from "" 
	if ($q !== '') {
		if($stmt->num_rows > 0){
			$hint = ' &nbsp; Product name already exists! ';
		}
	}
	else{
		$hint = ' &nbsp; Valid name.';
	}
	   
	
	// Output "no suggestion" if no hint was found or output correct values 
	echo $hint === '' ? ' &nbsp; Valid name.' : $hint;
}
elseif(isset($_GET['q_packaging'])){
	
	$q = $_GET['q_packaging'];
	$hint = '';
	
	$stmt = $con->prepare('SELECT * FROM tbl_packaging WHERE Packaging= ?');
	$stmt->bind_param('s', $q);
	$stmt->execute();
	$stmt->store_result();

	// lookup all hints from array if $q is different from "" 
	if ($q !== '') {
		if($stmt->num_rows > 0){
			$hint = ' &nbsp; Packaging already exists! ';
		}
	}
	else{
		$hint = ' &nbsp; Valid packaging.';
	}
	   
	
	// Output "no suggestion" if no hint was found or output correct values 
	echo $hint === '' ? ' &nbsp; Valid packaging.' : $hint;
}
elseif(isset($_GET['q_payee'])){
	
	$q = $_GET['q_payee'];
	$hint = '';
	
	$stmt = $con->prepare('SELECT * FROM tbl_payee WHERE PayeeName= ?');
	$stmt->bind_param('s', $q);
	$stmt->execute();
	$stmt->store_result();

	// lookup all hints from array if $q is different from "" 
	if ($q !== '') {
		if($stmt->num_rows > 0){
			$hint = ' &nbsp; Payee already exists! ';
		}
	}
	else{
		$hint = ' &nbsp; Valid payee.';
	}
	   
	
	// Output "no suggestion" if no hint was found or output correct values 
	echo $hint === '' ? ' &nbsp; Valid payee.' : $hint;
}
elseif(isset($_GET['q_termimp'])){
	
	$q = $_GET['q_termimp'];
	$hint = '';
	
	$stmt = $con->prepare('SELECT * FROM tbl_payment_terms WHERE PaymentTerms= ?');
	$stmt->bind_param('s', $q);
	$stmt->execute();
	$stmt->store_result();

	// lookup all hints from array if $q is different from "" 
	if ($q !== '') {
		if($stmt->num_rows > 0){
			$hint = ' &nbsp; Term already exists! ';
		}
	}
	else{
		$hint = ' &nbsp; Valid term.';
	}
	   
	
	// Output "no suggestion" if no hint was found or output correct values 
	echo $hint === '' ? ' &nbsp; Valid term.' : $hint;
}
elseif(isset($_GET['q_termsm'])){
	
	$q = $_GET['q_termsm'];
	$hint = '';
	
	$stmt = $con->prepare('SELECT * FROM tbl_terms WHERE DaysLabel= ?');
	$stmt->bind_param('s', $q);
	$stmt->execute();
	$stmt->store_result();

	// lookup all hints from array if $q is different from "" 
	if ($q !== '') {
		if($stmt->num_rows > 0){
			$hint = ' &nbsp; Term already exists! ';
		}
	}
	else{
		$hint = ' &nbsp; Valid term.';
	}
	   
	
	// Output "no suggestion" if no hint was found or output correct values 
	echo $hint === '' ? ' &nbsp; Valid term.' : $hint;
}
elseif(isset($_GET['q_origin'])){
	
	$q = $_GET['q_origin'];
	$hint = '';
	
	$stmt = $con->prepare('SELECT * FROM tbl_origin WHERE Origin= ?');
	$stmt->bind_param('s', $q);
	$stmt->execute();
	$stmt->store_result();

	// lookup all hints from array if $q is different from "" 
	if ($q !== '') {
		if($stmt->num_rows > 0){
			$hint = ' &nbsp; Origin already exists! ';
		}
	}
	else{
		$hint = ' &nbsp; Valid origin.';
	}
	   
	
	// Output "no suggestion" if no hint was found or output correct values 
	echo $hint === '' ? ' &nbsp; Valid origin.' : $hint;
}
elseif(isset($_GET['q_dr'])){
	
	$q = $_GET['q_dr'];
	$hint = '';
	
	$stmt = $con->prepare('SELECT * FROM tbl_sales_order WHERE DR_Number= ? OR SI_Number=?');
	$stmt->bind_param('ss', $q, $q);
	$stmt->execute();
	$stmt->store_result();

	// lookup all hints from array if $q is different from "" 
	if ($q !== '') {
		if($stmt->num_rows > 0){
			$hint = ' &nbsp; DR Number already exists! ';
		}
	}
	else{
		$hint = ' &nbsp; Valid DR Number.';
	}
	   
	
	// Output "no suggestion" if no hint was found or output correct values 
	echo $hint === '' ? ' &nbsp; Valid DR Number.' : $hint;
}
elseif(isset($_GET['q_si'])){
	
	$q = $_GET['q_si'];
	$hint = '';
	
	$stmt = $con->prepare('SELECT * FROM tbl_sales_order WHERE SI_Number= ? OR DR_Number=?');
	$stmt->bind_param('ss', $q, $q);
	$stmt->execute();
	$stmt->store_result();

	// lookup all hints from array if $q is different from "" 
	if ($q !== '') {
		if($stmt->num_rows > 0){
			$hint = ' &nbsp; SI Number already exists! ';
		}
	}
	else{
		$hint = ' &nbsp; Valid SI Number.';
	}
	   
	
	// Output "no suggestion" if no hint was found or output correct values 
	echo $hint === '' ? ' &nbsp; Valid SI Number.' : $hint;
}
elseif(isset($_GET['q_company'])){
	
	$q = $_GET['q_company'];
	$hint = '';
	
	$stmt = $con->prepare('SELECT * FROM tbl_company WHERE CompanyName= ?');
	$stmt->bind_param('s', $q);
	$stmt->execute();
	$stmt->store_result();

	// lookup all hints from array if $q is different from "" 
	if ($q !== '') {
		if($stmt->num_rows > 0){
			$hint = ' &nbsp; Company already exists! ';
		}
	}
	else{
		$hint = ' &nbsp; Valid company.';
	}
	   
	
	// Output "no suggestion" if no hint was found or output correct values 
	echo $hint === '' ? ' &nbsp; Valid company.' : $hint;
}
elseif(isset($_GET['q_account'])){
	
	$q = $_GET['q_account'];
	$hint = '';
	
	$stmt = $con->prepare('SELECT * FROM tbl_account_title WHERE AccountTitle= ?');
	$stmt->bind_param('s', $q);
	$stmt->execute();
	$stmt->store_result();

	// lookup all hints from array if $q is different from "" 
	if ($q !== '') {
		if($stmt->num_rows > 0){
			$hint = ' &nbsp; Account Title already exists! ';
		}
	}
	else{
		$hint = ' &nbsp; Valid account title.';
	}
	
	// Output "no suggestion" if no hint was found or output correct values 
	echo $hint === '' ? ' &nbsp; Valid account title.' : $hint;
}
?>