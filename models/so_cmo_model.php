<?php
class SO_CMO{
    public function show_data(){
        include 'connection.php';

        $stmt = $con->prepare('SELECT tbl_so_product.ProductCode, `SONumber`, `CMO_Name`, `Share` FROM `tbl_so_cmo` JOIN tbl_so_product ON tbl_so_product.SO_ID=tbl_so_cmo.SONumber');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($code, $so, $cmo, $share);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $so = sprintf('%06d', $so);
                echo "
                <tr>
                    <td>$so</td>
                    <td>$code</td>
                    <td>$cmo</td>
                    <td>$share</td>
                </tr>
                ";
            }
        }
    }
}  
?>