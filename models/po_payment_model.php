<?php
class PO_Payment{
    public $branch;
    public $amt;
    public $accnum;
    public $currency;
    public $company;
    public $address;
    public $bank;
    public $bankaddress;
    public $supp_accnum;
    public $swift;
    public $poref;
    
    public function set_data($fta){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT `Branch`, `Amount`, p.`AccountNumber`, p.`Currency`, s.CompanyName, s.CompanyAddress, s.BankName, s.BankAddress, s.AccountNumber, s.SwiftCode FROM tbl_tsgi_po_payment p JOIN tbl_tsgi_po po ON po.PONumber=p.PONumber JOIN tbl_supplier s ON s.SupplierID=po.SupplierID WHERE FTA_Number=?');
        $stmt->bind_param('s', $fta);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($branch, $amt, $accnum, $currency, $company, $address, $bank, $bankaddress, $supp_accnum, $swift);
        $stmt->fetch();
        $stmt->close();
        $con->close();
        
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT po.SOReferenceNumber FROM tbl_tsgi_po_payment p JOIN tbl_tsgi_po po ON p.PONumber=po.PONumber WHERE `FTA_Number`=?');
        $stmt->bind_param('s', $fta);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($so);
        $poref = '';
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $poref .= $so.', ';
            }
        }
        
        $this->poref = substr($poref, 0, -2);
        
        $this->branch = $branch;
        $this->amt = $amt;
        $this->accnum = $accnum;
        $this->currency = $currency;
        $this->company = $company;
        $this->address = $address;
        $this->bank = $bank;
        $this->bankaddress = $bankaddress;
        $this->supp_accnum = $supp_accnum;
        $this->swift = $swift;
    }
}
?>