<?php
include 'receivable_aed.php';


class Receivable {

    public function show_data(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `ReceivableID`, `Company`, `SIDate`, `CounteredDate`, `DueDate`, `SINumber`, `GrossSale`, `NetSale`, `VAT`, `Remarks` FROM `tbl_receivable` WHERE Status="NOT PAID" AND DelStatus="NO" ORDER BY DueDate ASC');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($rid, $company, $sidate, $ctrddate, $due, $sinumber, $gross, $net, $vat, $remarks);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                
                $sidate = date_format(date_create($sidate), 'F j, Y');
                
                if($ctrddate){
                    $ctrddate = date_format(date_create($ctrddate), 'F j, Y');
                    
                }
                else{
                    $ctrbtn = '';
                    
                }
                
                date_default_timezone_set('Asia/Manila');
                
                $today = date('Y-m-d');
                $oneweek = date('Y-m-d', strtotime('+7 days'));
                
                if($due){
                    if($due < $today){
                        $color = 'style="color: red; font-weight:bold"';
                    }
                    elseif($due <= $oneweek){
                        $color = 'style="color: orange; font-weight:bold"';
                    }
                    else{
                        $color = '';
                    }
                }
                else{
                    $color = '';
                }
                
                $ctrbtn = "<br><br><a href='javascript:void(0);' data-href='set_ctrDate.php?id=$rid' class='ctrDate'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-calendar'></i> &nbsp;Set Date</button></a>";
                
                $duebtn = "<br><br><a href='javascript:void(0);' data-href='set_dueDate.php?id=$rid' class='ctrDate'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-calendar'></i> &nbsp;Set Date</button></a>";
                
                $rembtn = "<br><br><a href='javascript:void(0);' data-href='set_remarks.php?id=$rid' class='ctrDate'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-file-text'></i> &nbsp;Update Remarks</button></a>";
                
                if($due){
                    $due = date_format(date_create($due), 'F j, Y');
                }
                
                $gross = number_format($gross, 2);
                $vat = number_format($vat, 2);
                $net = number_format($net, 2);
                
                echo "
                <tr $color>
                    <td>$company</td>
                    <td>$sidate</td>
                    <td>$ctrddate $ctrbtn</td>
                    <td>$due $duebtn</td>
                    <td>$sinumber</td>
                    <td>$gross</td>
                    <td>$net</td>
                    <td>$vat</td>
                    <td>$remarks $rembtn</td>
                    <td>
                    <center>
                    <a href='models/receivable_aed.php?id_paid=$rid'><button type='button' class='btn btn-success btn-sm delete'><i class='fa fa-check'></i> Mark as Paid</button>
                    </a>
                    <a href='models/receivable_aed.php?id_delete=$rid'><button type='button' class='btn btn-danger btn-sm delete'><i class='fa fa-trash'></i> Delete</button>
                    </a>
                    </center>
                    </td>
                </tr>
                ";
            }
        }
    } 
    
    
    public function show_data_paid(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `ReceivableID`, `Company`, `SIDate`, `CounteredDate`, `DueDate`, `SINumber`, `GrossSale`, `NetSale`, `VAT`, `Remarks` FROM `tbl_receivable` WHERE Status="PAID" AND DelStatus="NO"');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($rid, $company, $sidate, $ctrddate, $due, $sinumber, $gross, $net, $vat, $remarks);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                
                $sidate = date_format(date_create($sidate), 'F j, Y');
                
                if($ctrddate){
                    $ctrddate = date_format(date_create($ctrddate), 'F j, Y');
                    $ctrbtn = "<a href='models/receivable_aed.php?ctrd=$rid'><button class='btn btn-success btn-sm'><i class='fa fa-calendar'></i>&nbsp; Set Date</button></a></center>";
                }
                else{
                    $ctrbtn = '';
                    
                }
                
                if($due){
                    $due = date_format(date_create($due), 'F j, Y');
                }
                
                $gross = number_format($gross, 2);
                $vat = number_format($vat, 2);
                $net = number_format($net, 2);
                
                echo "
                <tr>
                    <td>$company</td>
                    <td>$sidate</td>
                    <td>$ctrddate</td>
                    <td>$due</td>
                    <td>$sinumber</td>
                    <td>$gross</td>
                    <td>$net</td>
                    <td>$vat</td>
                    <td>$remarks</td>
                </tr>
                ";
            }
        }
    } 
    
}
?>