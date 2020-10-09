<?php
include 'cmo_cust_aed.php';

class CMO_Cust{
    public function show_form($id){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT FullName FROM tbl_cmo_cust cc 
        JOIN tbl_cmo cm ON cc.CMO_ID=cm.CMO_ID
        WHERE cc.CustomerID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($fname);
        if($stmt->num_rows > 0){
            if($stmt->num_rows == 1){
                $stmt->fetch();
                $fname = strtoupper($fname);
                echo "
                <div class='form-group'>
                    <label>Agent Name</label>
                    <input list='cmo_list' id='cmo1' required name='cmo[]' value='$fname' maxlength='100' class='form-control' pattern='"; 
                    
                    echo $this->pattern();

                    echo "' placeholder='Please input agent name ...'>
                </div>
                ";
            }
            echo "
                    <button type='submit' name='update' onclick='return check()' id='submit' class='btn btn-success' style='float:right; margin-top:2px; margin-right:10px'><i class='fa fa-save'></i> &nbsp;Save Details</button>
                    ";
        }
        else{
            echo "
            <div class='form-group'>
                <label>Agent Name</label>
                <input list='cmo_list'  id='cmo1' required name='cmo[]'  maxlength='100' class='form-control' pattern='"; 
                
                echo $this->pattern();

                echo "' placeholder='Please input agent name ...'>
            </div>
            ";

            echo "
                    <button type='submit' name='save' id='submit' onclick='return check()' class='btn btn-success' style='float:right; margin-top:2px; margin-right:10px'><i class='fa fa-save'></i> &nbsp;Save Details</button>
                    ";
        }
    }

    public function show_data_dl(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `FullName` FROM `tbl_cmo` WHERE Status!="Inactive"');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($fname);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $fname = strtoupper(str_replace('"','', $fname));
                echo "
                <option value='$fname'>
                ";
            }
        }
    }

    public function pattern(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `FullName` FROM `tbl_cmo` WHERE Status!="Inactive"');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($fname);
        $pattern = '';
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $fname = strtoupper(str_replace('"','', $fname));
                $pattern .= $fname.'|';
            }
        }

        return $pattern;
    }
}
?>