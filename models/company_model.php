<?php
include 'company_aed.php';

class Company {
    public $company;
    
    public function set_data($id){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `CompanyName` FROM `tbl_company` WHERE CompanyID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($company);
        $stmt->fetch();

        //assign
        $this->company = $company;        
    }

    public function show_data(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `CompanyID`, `CompanyName` FROM `tbl_company` WHERE Deleted=?');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($comp_id, $name);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <tr>
                    <td>$name</td>
                    <td>
                    <center>
                    <a href='javascript:void(0);' data-href='view_company.php?id=$comp_id' class='editCompany'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button></a>
                    <button type='button' class='btn btn-danger btn-sm delete' id='$comp_id'><i class='fa fa-trash'></i> Delete</button>
                    </center>
                    </td>
                </tr>
                ";
            }
        }
    } 

    public function count(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT * FROM `tbl_company`');
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows();
    }

    public function show_data_dl(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `CompanyName` FROM `tbl_company` WHERE Deleted =? ');
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