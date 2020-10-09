<?php
include 'credit_aed.php';

class Credit{
    public $nxt_mnum;
    public $date;
    public $inv;
    public $dr;
    public $company;
    public $address;
    public $total;

    public function set_data($mn){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT CreditDate, Total, SI_Number, DR_Number, `Address`, CompanyName FROM tbl_credit c JOIN tbl_sales_order so ON c.SONumber=so.SONumber JOIN tbl_customers cs ON cs.CustomerID=so.CustomerID WHERE MemoNumber=?');
        $stmt->bind_param('i', $mn);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($date, $total, $inv, $dr, $address, $company);
        $stmt->fetch();

        $this->date = $date;
        $this->total = $total;
        $this->inv = $inv;
        $this->dr = $dr;
        $this->address = $address;
        $this->company = $company;
    }

    public function show_data($si){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `MemoNumber`, `CreditDate`, `Total` FROM tbl_credit c JOIN tbl_sales_order so ON so.SONumber=c.SONumber WHERE so.SI_Number=?');
        $stmt->bind_param('i', $si);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($mnumber, $date, $amount);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $mnumber = sprintf("%06d", $mnumber);
                $date = date_format(date_create($date), "F j, Y");
                $amount = number_format($amount,2);

                echo "
                <tr>
                    <td>$mnumber</td>
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

    public function show_data_cm($id){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `Quantity`, `Description`, `UnitPrice`, `Amount` FROM `tbl_credit_bd` WHERE MemoNumber=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($q, $desc, $p, $amt);
        while($stmt->fetch()){
            if($p == 0.00){
                $p = '';
            }
            else{
                $p = number_format($p, 2);
            }

            if($amt == 0.00){
                $amt = '';
            }
            else{
                $amt = number_format($amt, 2);
            }

            if($q == 0){
                $q = '';
            }

            echo "
            <tr>
            <td>$q</td>
            <td colspan='3'>$desc</td>
            <td>$p</td>
            <td>$amt</td>
            </tr>
            ";
        }
    }

    public function get_last_id(){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT MemoNumber FROM tbl_credit ORDER BY MemoNumber DESC');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($mnum);
        $stmt->fetch();

        $mnum+= 1;

        $this->nxt_mnum = $mnum;
        
    }
}
?>