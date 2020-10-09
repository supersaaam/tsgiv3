<?php
namespace Dompdf;

class PO{
    public $date;
    public $brand;
    public $amt;
    public $currency;
    public $stat;
    public $terms;
    public $cperson;
    public $shipment;
    public $incoterms;
    public $note;
    public $type;
    public $del_address;
    public $ar;
    
    public function set_data($po){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT `Date`,s.CompanyName, `TotalAmount`, `Currency`, `Status`, t.DaysLabel, sc.ContactPerson, po.Shipment, po.Incoterms, po.Note, po.RemainingAR, po.Type, po.DeliveryAddress FROM tbl_tsgi_po po JOIN tbl_supplier s ON s.SupplierID=po.SupplierID JOIN tbl_terms t ON t.Term_ID=po.Terms LEFT JOIN tbl_supplier_contact sc ON sc.SC_ID=po.ContactPersonID WHERE PONumber=?');
        $stmt->bind_param('i', $po);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($date, $brand, $amt, $currency, $stat, $terms, $cperson, $shipment, $incoterms, $note, $ar, $type, $del_address);
        $stmt->fetch();
        $stmt->close();
        $con->close();
        
        $this->terms = $terms;
        $this->date = $date;
        $this->brand = $brand;
        $this->amt = $amt;
        $this->currency = $currency;
        $this->stat = $stat;
        $this->cperson = $cperson;
        $this->shipment = $shipment;
        $this->incoterms = $incoterms;
        
        if($type == NULL) {
            $type = 'Foreign';
        }
        
        $this->type = strtoupper($type);
        $this->del_address = $del_address;
        
        if($note!=NULL){
            $this->note = "<b>NOTE:</b><br><br>".$note;
        }
        else{
            $this->note = '';
        }
        
        $this->ar = $ar;
    }
    
    public function show_bd($id){
        include 'connection.php';
        $m = '';

        $stmt = $con->prepare('SELECT `PO_BD`, po.`PONumber`, p.ProductDescription, p.PartNumber, `Quantity`, `PricePerUnit`, po.Currency, po.TotalAmount, Discount, RemainingAR FROM tbl_tsgi_po_bd pobd JOIN tbl_tsgi_product p ON p.ProductID=pobd.ProductID RIGHT JOIN tbl_tsgi_po po ON po.PONumber=pobd.PONumber WHERE po.PONumber=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($pobd, $po, $desc, $partnum, $q, $price, $currency, $total_amount, $disc, $ar);
        if($stmt->num_rows > 0){
            
            $m .= "<table border='1|0' cellpadding='5' style='border-collapse: collapse; width: 100%; font-family: Helvetica; font-size: 13px'>";
            $m .= "
                <thead>
                    <tr>
                        <th></th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Price/Unit</th>
                        <th>Discount</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
            ";

		$i = 1;
		$total_comp = 0;
            while($stmt->fetch()){
                $disc_fmt = number_format($disc, 2);
                $disc_ = $price * ($disc/100);
                $sub = number_format(($price - $disc_)* $q, 2);
                $sub_for_comp = ($price - $disc_)* $q;
                $price = number_format($price, 2);
                $q = number_format($q, 2);
                
                if($currency == 'USD'){
                    $c = '$';
                }
                elseif($currency == 'EURO'){
                    $c = '&#128;';
                }
                elseif($currency == 'PHP'){
                    $c = 'P';
                }
                
                $m .= "
                    <tr>
                        <td>$i</td>
                        <td>$partnum - $desc</td>
                        <td>$q</td>
                        <td>$c $price</td>
                        <td>$disc_fmt%</td>
                        <td>$c $sub</td>
                    </tr>
                ";
                $i++;
            
            $total_comp += str_replace(',', '', number_format($sub_for_comp, 2));
            }
            
            $total_ = number_format($total_comp, 2);
            $ar_ = number_format($ar, 2);
            $toPay = $total_comp - $ar;
            
            if($toPay < 0){
                $toPay = 0;
            }
            
            $toPay_ = number_format($toPay, 2);
            
            $m .= "<tfoot>
            <tr>
                <th colspan='5' style='text-align: right'>Total Amount</th>
                <td>$c $total_</td>
            </tr>
            <tr>
                <th colspan='5' style='text-align: right'>Less: Account Receivable</th>
                <td>$c $ar_</td>
            </tr>
            <tr>
                <th colspan='5' style='text-align: right'>Total Amount to Pay</th>
                <td>$c $toPay_</td>
            </tr>";
            
            $m .= "</tfoot></table>";
        }

        return $m;
    }
    
    
    public function show_bd_local($id){
        include 'connection.php';
        $m = '';

        $stmt = $con->prepare('SELECT `PO_BD`, po.`PONumber`, p.ProductDescription, p.PartNumber, `Quantity`, `PricePerUnit`, po.Currency, po.TotalAmount, Discount, RemainingAR FROM tbl_tsgi_po_bd pobd JOIN tbl_tsgi_product p ON p.ProductID=pobd.ProductID RIGHT JOIN tbl_tsgi_po po ON po.PONumber=pobd.PONumber WHERE po.PONumber=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($pobd, $po, $desc, $partnum, $q, $price, $currency, $total_amount, $disc, $ar);
        if($stmt->num_rows > 0){
            
            $m .= "<table border='1|0' cellpadding='5' style='border-collapse: collapse; width: 100%; font-family: Helvetica; font-size: 13px'>";
            $m .= "
                <thead>
                    <tr>
                        <th></th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Price/Unit</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
            ";

		$i = 1;
		$total_comp = 0;
            while($stmt->fetch()){
                $disc_fmt = number_format($disc, 2);
                $disc_ = $price * ($disc/100);
                $sub = number_format(($price - $disc_)* $q, 2);
                $sub_for_comp = ($price - $disc_)* $q;
                $price = number_format($price, 2);
                $q = number_format($q, 2);
                
                if($currency == 'USD'){
                    $c = '$';
                }
                elseif($currency == 'EURO'){
                    $c = '&#128;';
                }
                elseif($currency == 'PHP'){
                    $c = 'P';
                }
                
                $m .= "
                    <tr>
                        <td>$i</td>
                        <td>$partnum - $desc</td>
                        <td>$q</td>
                        <td>$c $price</td>
                        <td>$c $sub</td>
                    </tr>
                ";
                $i++;
            
            $total_comp += str_replace(',', '', number_format($sub_for_comp, 2));
            }
            
            $total_ = number_format($total_comp, 2);
            $ar_ = number_format($ar, 2);
            $toPay = $total_comp - $ar;
            
            if($toPay < 0){
                $toPay = 0;
            }
            
            $toPay_ = number_format($toPay, 2);
            $vat_ex = number_format($total_comp/1.12, 2);
            $vat = number_format($total_comp - ($total_comp/1.12), 2);
            
            $m .= "<tfoot>
            <tr>
                <th colspan='4' style='text-align: right'>Less: VAT</th>
                <td>$c $vat</td>
            </tr>
            <tr>
                <th colspan='4' style='text-align: right'>Amount: Net of VAT </th>
                <td>$c $vat_ex</td>
            </tr>
            <tr>
                <th colspan='4' style='text-align: right'>Total Amount Due</th>
                <td>$c $total_</td>
            </tr>
            ";
            
            $m .= "</tfoot></table>";
        }

        return $m;
    }
}
?>