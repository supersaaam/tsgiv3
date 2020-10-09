<?php
include 'packaging_aed.php';

class Packaging {
    public $packaging;
    public $divisor;

    public function set_data($id){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `Packaging`, `Divisor` FROM `tbl_packaging` WHERE PackagingID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($packaging, $divisor);
        $stmt->fetch();

        //assign
        $this->packaging = $packaging;
        $this->divisor = $divisor;        
    }

    public function show_data(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `PackagingID`, `Packaging`, `Divisor` FROM `tbl_packaging` WHERE Deleted=?');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($pack_id, $packaging, $divisor);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <tr>
                    <td>$packaging</td>
                    <td>$divisor</td>
                    <td>
                    <center>
                    <a href='javascript:void(0);' data-href='view_packaging.php?id=$pack_id' class='editPackaging'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button></a>
                    <button type='button' class='btn btn-danger btn-sm delete' id='$pack_id'><i class='fa fa-trash'></i> Delete</button>
                    </center>
                    </td>
                </tr>
                ";
            }
        }
    }    

    public function show_packaging(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `Packaging` FROM `tbl_packaging` WHERE Deleted=?');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($packaging);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <option value='$packaging'>
                ";
            }
        }
    }    

    public function count(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT * FROM `tbl_packaging`');
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows();
    }
}
?>