<?php
include 'origin_aed.php';

class Origin {
    public $origin;

    public function set_data($id){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `Origin` FROM `tbl_origin` WHERE OriginID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($origin);
        $stmt->fetch();

        //assign
        $this->origin = $origin;        
    }


    public function show_data(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `OriginID`, `Origin` FROM `tbl_origin` WHERE Deleted=?');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($o_ID, $origin);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <tr>
                    <td>$origin</td>
                    <td>
                    <center>
                    <a href='javascript:void(0);' data-href='view_origin.php?id=$o_ID' class='editOrigin'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button></a>
                    <button type='button' class='btn btn-danger btn-sm delete' id='$o_ID'><i class='fa fa-trash'></i> Delete</button>
                    </center>
                    </td>
                </tr>
                ";
            }
        }
    }    

    public function show_origin(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `Origin` FROM `tbl_origin` WHERE Deleted=?');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($origin);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <option value='$origin'>
                ";
            }
        }
    }    

    public function count(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT * FROM `tbl_origin`');
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows();
    }
}
?>