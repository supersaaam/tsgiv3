<?php
include 'termsimp_aed.php';

class Terms_Imp {
    public $term;

    public function set_data($id){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `PaymentTerms` FROM `tbl_payment_terms` WHERE PT_ID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($term);
        $stmt->fetch();

        //assign
        $this->term = $term;        
    }

    public function show_data(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `PT_ID`, `PaymentTerms` FROM `tbl_payment_terms` WHERE Deleted=?');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($ptID, $terms);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <tr>
                    <td>$terms</td>
                    <td>
                    <center>
                    <a href='javascript:void(0);' data-href='view_termsimp.php?id=$ptID' class='editTerms'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button></a>
                    <a href='models/termsimp_aed.php?id_delete=$ptID'><button type='button' class='btn btn-danger btn-sm delete' id='$ptID'><i class='fa fa-trash'></i> Delete</button></a>
                    </center>
                    </td>
                </tr>
                ";
            }
        }
    } 

    public function show_terms(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `PT_ID`, `PaymentTerms` FROM `tbl_payment_terms`');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($ptID, $terms);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <option value='$ptID'>$terms</option>
                ";
            }
        }
    }

    public function show_terms_dl(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `PaymentTerms` FROM `tbl_payment_terms` WHERE Deleted=?');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($terms);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <option value='$terms'>
                ";
            }
        }
    }    

    public function show_terms_selected($sel){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `PT_ID`, `PaymentTerms` FROM `tbl_payment_terms`');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($ptID, $terms);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <option value='$ptID'";

                echo $this->selected($terms, $sel);

                echo ">$terms</option>
                ";
            }
        }
    }

    public function selected($terms, $sel){
        if($sel == $terms){
          return 'selected';
        }
    }
    
    public function count(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT * FROM `tbl_payment_terms` WHERE Deleted="NO"');
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows();
    }
}
?>