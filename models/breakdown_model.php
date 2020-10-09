<?php
include 'breakdown_aed.php';

class Breakdown {
    public function show_data(){
        include 'models/connection.php';
        $stat = 'DELIVERED';
        $s_bd = 'NO';
        $stmt = $con->prepare('SELECT `ProformaInvNo`, `DeliveryStatus`, `Origin`, tbl_supplier.CompanyName, `DateCreated` FROM `tbl_importation` JOIN tbl_supplier ON tbl_supplier.SupplierID=tbl_importation.SupplierID WHERE DeliveryStatus=? AND StatusBreakdown = ?');
        $stmt->bind_param('ss', $stat, $s_bd);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($invnum, $delstat, $origin, $supp, $created);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $supp = str_replace('"', '', $supp);
                $created = date_format(date_create($created), "M j, Y");
                echo "
                <tr>
                    <td>$invnum</td>
                    <td>$created</td>
                    <td>$supp</td>
                    <td>$delstat</td>
                    <td>
                    <center>
                        <a data-href='view_breakdown?inv=$invnum' class='openView'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-list'></i> &nbsp;Breakdown</button></a>
                    </center>
                    </td>
                </tr>
                ";
            }
        }
    }
}
?>