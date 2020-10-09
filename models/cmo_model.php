<?php
include 'cmo_aed.php';

class CMO {
    public $name;
    public $area;

    public function set_data($id){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `FullName`, `Location` FROM `tbl_cmo` WHERE CMO_ID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($name, $area);
        $stmt->fetch();

        //assign to local variable
        $this->name = $name;
        $this->area = $area;
    }

    public function show_data(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `CMO_ID`, `FullName`, `Location` FROM `tbl_cmo` WHERE Status=?');
        $s = 'Active';
        $stmt->bind_param('s', $s);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cmoID, $fname, $location);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <tr>
                    <td>$fname</td>
                    <td>$location</td>
                    <td>
                    <center>
                    <a href='javascript:void(0);' data-href='view_cmorecord.php?id=$cmoID' class='editCMO'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button></a>
                    <a href='models/cmo_aed.php?id_delete=$cmoID'><button type='button' class='btn btn-danger btn-sm delete' id='$cmoID'><i class='fa fa-trash'></i> Delete</button></a>
                    </center>
                    </td>
                </tr>
                ";
            }
        }
    } 
    
    public function count(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT * FROM `tbl_cmo` WHERE Status="Active"');
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows();
    }

    public function show_data_dl(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `FullName` FROM `tbl_cmo`');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($name);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <option value='$name'>
                ";
            }
        }
    }
}
?>