<?php
class Inventory {
    public function show_data(){
        include 'connection.php';

        $con1 = new mysqli($server, $user, $pw, $db);
        $con2 = new mysqli($server, $user, $pw, $db);

        //get all products first
        $stmt = $con->prepare('SELECT DISTINCT pd.ProductCode, CriticalLevel FROM `tbl_product_depot` pd JOIN tbl_actual_product ap ON ap.ProductCode=pd.ProductCode');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($code, $cl);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <tr>
                <td>$code</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                ";
                //loop for all the warehouses
                $depot = $con2->prepare('SELECT `WarehouseID` FROM `tbl_warehouse` ORDER BY WarehouseID ASC');
                $depot->execute();
                $depot->store_result();
                $depot->bind_result($w);
                $total = 0;
                if($depot->num_rows > 0){
                    while($depot->fetch()){

                        //get all warehouse
                        $wh = $con1->prepare('SELECT `CurrentStock` FROM `tbl_product_depot` WHERE `ProductCode`=? AND WarehouseID=?');
                        $wh->bind_param('si', $code, $w);
                        $wh->execute();
                        $wh->store_result();
                        $wh->bind_result($stock);
                        $wh->fetch();
                        if($wh->num_rows > 0){
                            echo "
                            <td>$stock</td>
                            ";
                            $total += $stock;
                        }
                        else{
                            echo "
                            <td>0</td>
                            ";
                        }
                        echo "
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        ";
                    }
                }

                echo "
                <td>$total</td>
                <td>&nbsp;</td>
                <td>$cl";
                
                if($total <= $cl){
                    echo "<small class='label pull-right bg-red'>Critical</small>";
                }
                
                echo "</td>
                </tr>
                ";
            }
        }
    }
}
?>