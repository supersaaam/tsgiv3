<?php
include 'account_aed.php';

class Account_Title {
    
    public $at;
    
    public function set_data($id){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `AccountTitle` FROM `tbl_account_title` WHERE AT_ID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($at);
        $stmt->fetch();

        //assign
        $this->at = $at;        
    }

    public function show_data(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `AT_ID`, `AccountTitle` FROM `tbl_account_title` WHERE Deleted=?');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($at_id, $at);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <tr>
                    <td>$at</td>
                    <td>
                    <center>
                    <a href='javascript:void(0);' data-href='view_account.php?id=$at_id' class='editAccount'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button></a>
                    <a href='models/account_aed.php?id_delete=$at_id'><button type='button' class='btn btn-danger btn-sm delete' id='$at_id'><i class='fa fa-trash'></i> Delete</button></a>
                    </center>
                    </td>
                </tr>
                ";
            }
        }
    }  

    public function count(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT * FROM `tbl_account_title` WHERE Deleted="NO"');
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows();
    }

    public function show_data_dl(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `AccountTitle` FROM `tbl_account_title` WHERE Deleted =? ');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($at);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <option value='$at'>
                ";
            }
        }
    }
}
?>