<?php
include 'payee_aed.php';

class Payee {
    public $payee;

    public function set_data($id){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `PayeeName` FROM `tbl_payee` WHERE PayeeID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($payee);
        $stmt->fetch();

        //assign
        $this->payee = $payee;        
    }

    public function show_data(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `PayeeID`, `PayeeName` FROM `tbl_payee` WHERE Deleted=?');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($payee_id, $name);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $name = strtoupper(str_replace('"', '', $name));
                echo "
                <tr>
                    <td>$name</td>
                    <td>
                    <center>
                    <a href='javascript:void(0);' data-href='view_payee.php?id=$payee_id' class='editPayee'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button></a>
                    <a href='models/payee_aed.php?id_delete=$payee_id'><button type='button' class='btn btn-danger btn-sm delete' id='$payee_id'><i class='fa fa-trash'></i> Delete</button>
                    </center></a>
                    </td>
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