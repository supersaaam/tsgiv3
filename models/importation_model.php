<?php
include 'importation_aed.php';

class Importation {
    public $invnum; 
    public $supplier;
    public $term;
    public $reminders;
    public $status;
    public $origin;
    public $total;
    public $deldate;
    public $comminv;
    public $commdate;
    public $profdate;
    public $currency;
    public $comp_stat;
    public $netpayment;
    public $balance;

    public function show_query($sql){
        include 'models/connection.php';

        $stmt = $con->prepare($sql);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($inv, $date, $sname, $del, $deldate, $total, $bal);

        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $date = date_format(date_create($date), "F j, Y");
                $deldate = date_format(date_create($deldate), "F j, Y");
                $total = number_format($total,2);
                $bal = number_format($bal,2);
                echo "
                <table id='example2' style='border: 2px solid black; ' class='table table-bordered table-striped'>
                <tbody>
                <tr>
                    <td style='width:25%'>
                    <b>Proforma Invoice Number:</b><br>
                    $inv
                    </td>
                    <td style='width:25%'>
                    <b>Proforma Invoice Date:</b><br>
                    $date
                    </td>
                    <td style='width:25%'>
                    <b>Delivery Status:</b><br>
                    $del
                    </td>
                    <td style='width:25%'>
                    <b>Delivery Date:</b><br>
                    $deldate
                    </td>
                </tr>
                <tr>
                    <td colspan='2' style='width:50%'>
                    <b>Supplier:</b><br>
                    $sname
                    </td>
                    <td style='width:25%'>
                    <b>Total Amount:</b><br>
                    $total
                    </td>
                    <td style='width:25%'>
                    <b>Balance:</b><br>
                    $bal
                    </td>
                </tr>
                <tr>
                        <td colspan='4'>&nbsp;</td>
                </tr>
                <tr>
                <td colspan='4'>
                    <table style='width:100%; margin: 0 auto' class='table table-bordered table-striped'>
                        <tr>
                            <th style='width:25%'><center>Product</center></th>
                            <th style='width:25%'><center>Packaging</center></th>
                            <th style='width:10%'><center>Quantity</center></th>
                            <th style='width:10%'><center>Unit</center></th>
                            <th style='width:15%'><center>Price</center></th>
                            <th style='width:15%'><center>Total</center></th>
                        </tr>";
                
                        $con1 = new mysqli($server, $user, $pw, $db);
                        $imp_prod = $con1->prepare('SELECT p.ProductName, pg.Packaging, `Quantity`, `Unit`, `Price`, `Total` FROM tbl_imp_product ip JOIN tbl_product p ON p.ProductID=ip.ProductID JOIN tbl_packaging pg ON pg.PackagingID=ip.PackagingID WHERE ProformaInvNo=?');
                        $imp_prod->bind_param('i', $inv);
                        $imp_prod->execute();
                        $imp_prod->store_result();
                        $imp_prod->bind_result($pname, $pkg, $q, $u, $p, $t);
                        while($imp_prod->fetch()){
                            $p = number_format($p, 2);
                            $t = number_format($t, 2);
                            echo "
                            <tr>
                                <td>$pname</td>
                                <td>$pkg</td>
                                <td>$q</td>
                                <td>$u</td>
                                <td>$p</td>
                                <td>$t</td>
                            </tr>
                            ";
                        }
                echo "
                    </table>
                </td>
                </tr>
                <tr>
                        <td colspan='4'>&nbsp;</td>
                </tr>
                </tbody>
                </table>
                <div class='pagebreak'> </div>
                ";
            }
        }
        else{
            echo "<center>No record to show... </center>";
        }
    }

    public function show_invoices(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `ProformaInvNo` FROM `tbl_importation`');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($prof);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <option value='$prof'>
                ";
            }
        }
    }

    public function show_data(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `ProformaInvNo`, `DeliveryStatus`, `Origin`, tbl_supplier.CompanyName, `DateCreated`, Balance, Total FROM `tbl_importation` JOIN tbl_supplier ON tbl_supplier.SupplierID=tbl_importation.SupplierID ORDER BY DateCreated DESC');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($invnum, $delstat, $origin, $supp, $created, $bal, $total);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $supp = str_replace('"', '', $supp);
                $created = date_format(date_create($created), "M j, Y");
                echo "
                <tr>
                    <td>$invnum</td>
                    <td>$created</td>
                    <td>$supp</td>
                    <td>";
                    
                    if($total == $bal){
                        echo $delstat;
                    }
                    elseif($bal == 0.00){
                        echo 'FULLY PAID';
                    }
                    else{
                        echo 'PARTIALLY PAID';
                    }

                    echo    
                    "</td>
                    <td>
                    <center>";

                    if($delstat != 'DELIVERED'){
                        echo "
                        <a href='javascript:void(0);' data-href='view_importation?inv=$invnum' class='openView'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> &nbsp;Edit Details</button></a>
                        <a href='attachment?inv=$invnum'>
                        ";
                    }
                    else{
                        echo "
                        <a href='javascript:void(0);' data-href='view_importation?inv=$invnum' class='openView'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i> &nbsp;View Details</button></a>
                        <a href='attachment?inv=$invnum'>
                        ";
                    }

                    echo
                    "<button type='button' name='save_imp' class='btn btn-warning btn-sm'><i class='fa fa-file-text-o'></i> &nbsp;Attachments</button></a>
                    </center>
                    </td>
                </tr>
                ";
            }
        }
    }

    public function set_data($id){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `ProformaInvNo`, `ProformaInvDate`, `CommercialInvNo`, `CommInvDate`, `Currency`, `SpecialReminders`, `DeliveryStatus`, `DeliveredDate`, `Total`,  DeductedAmount, tbl_payment_terms.PaymentTerms, tbl_supplier.CompanyName, tbl_origin.Origin, StatusComplete, Balance FROM `tbl_importation` JOIN tbl_payment_terms ON tbl_payment_terms.PT_ID=tbl_importation.PaymentTerm JOIN tbl_supplier ON tbl_supplier.SupplierID=tbl_importation.SupplierID JOIN tbl_origin ON tbl_origin.OriginID=tbl_importation.Origin WHERE ProformaInvNo = ?');
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($invnum, $profdate, $comminv, $commdate, $currency, $reminder, $delstat, $deldate, $total, $ded, $terms, $compname, $origin, $comp_stat, $bal);
        $stmt->fetch();

        //set class variables
        $this->invnum = $invnum; 
        $this->supplier = str_replace('"', '', $compname);
        $this->term = $terms;
        $this->reminders = $reminder;
        $this->status=$delstat;
        $this->origin=$origin;
        $this->total = $total;  
        $this->deldate = $deldate;
        $this->profdate = $profdate;
        $this->comminv = $comminv;
        $this->currency = $currency;
        $this->commdate = $commdate;
        $this->comp_stat = $comp_stat;
        $this->netpayment = number_format($total, 2);
        $this->balance = number_format($bal, 2);
    }

    public function show_payable(){
        include 'connection.php';

        $stmt = $con->prepare('SELECT tbl_importation.ProformaInvNo, PayableID, tbl_importation.ProformaInvNo, tbl_supplier.CompanyName, `Total`, `Balance`, `StatusDeduction`, DeductedAmount, Currency FROM `tbl_importation` JOIN tbl_supplier ON tbl_supplier.SupplierID=tbl_importation.SupplierID LEFT JOIN tbl_payables ON tbl_payables.ProformaInvNo=tbl_importation.ProformaInvNo');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($invnum, $pid, $prof, $supp, $total, $bal, $stat, $ded, $currency);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $supp = str_replace('"', '', $supp);
                $total = number_format($total - $ded, 2);
                $bal = number_format($bal, 2);
                echo "
                <tr>
                    <td>$prof</td>
                    <td>$supp</td>
                    <td>$total</td>
                    <td>$bal</td>
                    <td><center>";

                    if($bal != '0.00' && $pid != null){
                        echo "
                        <a href='javascript:void(0);' data-href='view_payable?pid=$pid&amt=$bal&currency=$currency' class='paymentBtn'><button type='button' name='' id='' class='btn btn-primary btn-sm'><i class='fa fa-money'></i> &nbsp;Payment</button></a>
                        ";
                    }
                    else{
                        echo "
                        <button type='button' disabled name='' id='' class='btn btn-primary btn-sm'><i class='fa fa-money'></i> &nbsp;Payment</button>
                        ";
                    }

                    if($bal!='0.00' && $pid != null){
                        echo "
                        <a href='javascript:void(0);' data-href='deductions_payable?inv=$prof' class='deduction'><button type='button' class='btn btn-warning btn-sm'><i class='fa fa-list'></i> &nbsp;Deductions</button></a>
                        ";        
                    }
                    else{
                        echo "
                        <button type='button' disabled class='btn btn-warning btn-sm'><i class='fa fa-list'></i> &nbsp;Deductions</button>
                        ";
                    }
                    
                        echo "
                        <a href='javascript:void(0);' data-href='view_impdetails?inv=$prof' class='view'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i> &nbsp;View Details</button></a>
                        <a href='attachment?inv_=$invnum'>
                        <button type='button' name='save_imp' class='btn btn-default btn-sm'><i class='fa fa-file-text-o'></i> &nbsp;Attachments</button></a>
                        ";
                    


                echo 
                    "</center></td>
                </tr>
                ";
            }            
        }
    }
}
?>