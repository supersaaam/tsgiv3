<?php
class Rebate{
    public function show_data($si){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `RebateNumber`, `RebateDate`, `Total` FROM tbl_rebate c JOIN tbl_sales_order so ON so.SONumber=c.SONumber WHERE so.SI_Number=?');
        $stmt->bind_param('i', $si);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($rnumber, $date, $amount);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $rnumber = sprintf("%06d", $rnumber);
                $date = date_format(date_create($date), "F j, Y");
                $amount = number_format($amount,2);

                echo "
                <tr>
                    <td>$rnumber</td>
                    <td>$date</td>
                    <td>$amount</td>
                </tr>
                ";
            }
        }
        else{
            echo "
            <tr>
                <td colspan='3'><center>No data to show...</center></td>
            </tr>
            ";
        }
    }
}
?>