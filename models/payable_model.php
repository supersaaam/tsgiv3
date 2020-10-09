<?php
include 'payable_aed.php';

class Payable {
    public $bank;
    public $address;
    public $account;
    public $swift;
    public $ivan;
    public $rem;
    public $total_ded;
    public $total_paid;
    public $pid;
    public $bal;

    public function get_balance($id){
        include 'connection.php';

        $stmt = $con->prepare('SELECT Balance FROM `tbl_payables` JOIN tbl_importation ON tbl_importation.ProformaInvNo=tbl_payables.ProformaInvNo WHERE PayableID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($bal);
        $stmt->fetch();
        if($stmt->num_rows > 0){
            $this->bal = $bal;
        }
    }

    public function set_data($inv){
        include 'connection.php';

        $stmt = $con->prepare('SELECT PayableID, `BankName`, `BankAddress`, `AccountNumber`, `SwiftCode`, `IVAN_Number`, `Reminder` FROM `tbl_payables` WHERE ProformaInvNo=?');
        $stmt->bind_param('s', $inv);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($pid, $bank, $add, $num, $sc, $ivan, $rem);
        $stmt->fetch();
        if($stmt->num_rows > 0){
            $this->bank = $bank;
            $this->address = $add;
            $this->account = $num;
            $this->swift = $sc;
            $this->ivan = $ivan;
            $this->rem = $rem;
            $this->pid = $pid;
        }
        else{
            $this->bank = '';
            $this->address = '';
            $this->account = '';
            $this->swift = '';
            $this->ivan = '';
            $this->rem = '';
            $this->pid = '';
        }
    }  
    
    public function show_deductions($id){
        include 'connection.php';

        $stmt = $con->prepare('SELECT `Description`, `Amount` FROM `tbl_payable_deductions` WHERE ProfInvNum=?');
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($d, $a);
        if($stmt->num_rows > 0){
            $total = 0;
            while($stmt->fetch()){
                $total += $a;
                $a = number_format($a, 2);
                echo "
                <tr>
                    <td>$d</td>
                    <td>$a</td>
                </tr>
                ";
            }
            $this->total_ded = number_format($total,2);
        }
        else{
            echo "
            <tr>
                <td colspan='2'><center>No deductions made yet...</center></td>
            </tr>
            ";
            $this->total_ded = '0.00';
        }
    }

    public function show_paid($id){
        include 'connection.php';

        $stmt = $con->prepare('SELECT `DatePaid`, `Bank`, `PHPAmount`, AmountPaid, Rate, BankCharges FROM `tbl_paid` JOIN tbl_payables ON tbl_payables.PayableID=tbl_paid.PayableID WHERE tbl_payables.ProformaInvNo=?');
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($date, $bank, $amt, $pd, $rate, $charges);
        if($stmt->num_rows > 0){
            $total = 0;
            while($stmt->fetch()){
                $total += $pd;
                $date = date_format(date_create($date), 'F j, Y');
                $amt = number_format($amt, 2);
                $pd = number_format($pd, 2);
                $charges = number_format($charges, 2);
                echo "
                <tr>
                    <td>$date</td>
                    <td>$bank</td>
                    <td>$amt</td>
                    <td>$charges</td>
                    <td>$rate</td>
                    <td>$pd</td>
                    
                </tr>
                ";
            }
            $this->total_paid = number_format($total,2);
        }
        else{
            echo "
            <tr>
                <td colspan='6'><center>No payments made yet...</center></td>
            </tr>
            ";
            $this->total_paid = '0.00';
        }
    }
}
?>