<form action='models/quote_aed.php' method='post'>
<?php
	//echo $_GET['q'];
	
	include 'models/connection.php';
	
	$stmt = $con->prepare('SELECT `QuotationID` FROM `tbl_quote` WHERE `Status`="APPROVED" AND QuotationID NOT IN (SELECT `QuoteID` FROM `tbl_quote_request`)');
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($qid);
	
	echo "<label style='font-weight: normal'>Reference Quotation Number</label>";
	echo "<select name='quotationID' required class='form-control' placeholder='Please choose quotation number...'>";
	echo "<option disabled>Please choose quotation number...</option>";
  
	if($stmt->num_rows > 0){
		while($stmt->fetch()){
			
			$qid_fmtd = sprintf('%06d', $qid);

			echo "
				<option value='$qid'>$qid_fmtd</option>
			";
		}
	}
	
	echo "</select>";
	
?>
<input type='hidden' name='qrid' value='<?php echo $_GET['q']; ?>'>
<button type='submit' class='btn btn-success' style='margin-bottom: 20px; margin-top: 20px; float:right' name='quoted' value=''><i class='fa fa-save'></i> &nbsp;Submit</button>
</form>