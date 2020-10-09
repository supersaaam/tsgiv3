<?php
class SO_Product{
    public function show_data(){
        include 'connection.php';

        $stmt = $con->prepare('SELECT `SO_ID`, `ProductCode`, `Quantity` FROM `tbl_so_product` WHERE `Remarks`=?');
        $rem = 'for testing';
        $stmt->bind_param('s', $rem);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $code, $q);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $id = sprintf('%06d', $id);
                echo "
                <tr>
                    <td>$id</td>
                    <td>$code</td>
                    <td>$q</td>
                </tr>
                ";
            }
        }
    }
}
?>