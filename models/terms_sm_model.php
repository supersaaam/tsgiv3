<?php
include 'termssm_aed.php';

class Terms_SM {
    public $term;
    public $days;

    public function set_data($id){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `DaysLabel`, `Days` FROM `tbl_terms` WHERE Term_ID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($term, $days);
        $stmt->fetch();

        //assign
        $this->term = $term;        
        $this->days = $days;
    }

    public function show_data(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `Term_ID`, `DaysLabel`, `Days` FROM `tbl_terms` WHERE Deleted=?');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($tID, $days, $d);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <tr>
                    <td>$days</td>
                    <td>$d</td>
                    <td>
                    <center>
                    <a href='javascript:void(0);' data-href='view_termssm.php?id=$tID' class='editTerms'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button></a>
                    <a href='models/termssm_aed.php?id_delete=$tID'><button type='button' class='btn btn-danger btn-sm delete' id='$tID'><i class='fa fa-trash'></i> Delete</button></a>
                    </center>
                    </td>
                </tr>
                ";
            }
        }
    } 

    public function show_data_dl(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `DaysLabel` FROM `tbl_terms`');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($days);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <option value='$days'>
                ";
            }
        }
    } 
    
    public function count(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT * FROM `tbl_terms` WHERE Deleted="NO"');
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows();
    }
}
?>