<?php
include 'payable_aed.php';

class Payable {
    public $particular;
    public $accountnum;
    public $contactnum;
    public $duedate;
    public $amount;

    public function set_data($id){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `Particular`, `AccountNumber`, `ContactNumber`, `DueDate`, `Amount` FROM `tbl_payable` WHERE PayableID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($particular, $accountnum, $contactnum, $duedate, $amount);
        $stmt->fetch();

        //assign
        $this->particular = $particular;  
        $this->accountnum = $accountnum;
        $this->contactnum = $contactnum;
        $this->duedate = $duedate;
        $this->amount = $amount;
    }

    public function show_data(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `PayableID`, `Particular`, `AccountNumber`, `ContactNumber`, `DueDate`, `Amount` FROM `tbl_payable` WHERE Deleted=?');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($py_id, $particular, $accountnum, $contactnum, $duedate, $amount);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <tr>
                    <td>$particular</td>
                    <td>$accountnum</td>
                    <td>$contactnum</td>
                    <td>$duedate</td>
                    <td>$amount</td>
                    <td>
                    <center>
                    
                    
                    <a href='javascript:void(0);' data-href='add_payable_tsgi.php?id=$py_id' class='editPayee'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-plus'></i> Add Payable</button></a>
                    
                    <a href='javascript:void(0);' data-href='view_payable_tsgi.php?id=$py_id' class='editPayee'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button></a>
                    <a href='models/payable_aed.php?id_delete=$py_id'><button type='button' class='btn btn-danger btn-sm delete' id='$py_id'><i class='fa fa-trash'></i> Delete</button>
                    </center></a>
                    </td>
                </tr>
                ";
            }
        }
    } 
    
    public function show_data_pm(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `PM_ID`, `Particular`, `AccountNumber`, `ContactNumber`, `DueDate`, `Amount` FROM `tbl_payable_monitoring` WHERE Status="NOT PAID" ORDER BY DueDate ASC');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($py_id, $particular, $accountnum, $contactnum, $duedate, $amount);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                
                date_default_timezone_set('Asia/Manila');
                
                $today = date('Y-m-d');
                $oneweek = date('Y-m-d', strtotime('+7 days'));
                
                if($duedate < $today){
                    $color = 'style="color: red; font-weight:bold"';
                }
                elseif($duedate <= $oneweek){
                    $color = 'style="color: orange; font-weight:bold"';
                }
                else{
                    $color = '';
                }
                
                $duedate = date_format(date_create($duedate), 'F j, Y');
                
                
                echo "
                <tr $color>
                    <td>$particular</td>
                    <td>$accountnum</td>
                    <td>$contactnum</td>
                    <td>$duedate</td>
                    <td>$amount</td>
                    <td>
                    <center>
                    
                    <a href='models/payable_aed.php?id_paid=$py_id'><button type='button' class='btn btn-success btn-sm delete' id='$py_id'><i class='fa fa-check'></i> Mark as Paid</button>
                    </center></a>
                    </td>
                </tr>
                ";
            }
        }
    } 
    
    public function show_data_pm_paid(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `PM_ID`, `Particular`, `AccountNumber`, `ContactNumber`, `DueDate`, `Amount` FROM `tbl_payable_monitoring` WHERE Status="PAID" ORDER BY DueDate ASC');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($py_id, $particular, $accountnum, $contactnum, $duedate, $amount);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                
                $duedate = date_format(date_create($duedate), 'F j, Y');
                
                echo "
                <tr>
                    <td>$particular</td>
                    <td>$accountnum</td>
                    <td>$contactnum</td>
                    <td>$duedate</td>
                    <td>$amount</td>
                    
                </tr>
                ";
            }
        }
    } 
    
    public function count(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT * FROM `tbl_payee` WHERE Deleted="NO"');
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows();
    }

    public function show_data_dl(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `PayeeName` FROM `tbl_payee` WHERE DELETED =? ');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($pname);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <option value='$pname'>
                ";
            }
        }
    }
}
?>