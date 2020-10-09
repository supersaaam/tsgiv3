<?php
include 'user_aed.php';

class User {
    //local variables;
    public $username;
    public $fname;
    public $mname;
    public $lname;
    public $pw;
    
    public function show_data(){
        include 'models/connection.php';
        $d = 'NO';

        $stmt = $con->prepare('SELECT `UserID`, `LastName`, `FirstName`, `MiddleName`, `Username` FROM `tbl_users` WHERE Deleted=?');
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($userid, $lname, $fname, $mname, $uname);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $full = strtoupper($fname.' '.$lname);
                echo "
                <tr>
                    <td>$uname</td>
                    <td>$full</td>
                    <td>
                    <center>
                        <a href='javascript:void(0);' data-href='view_user?id=$userid' class='editUser'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button></a>
                        <a href='models/user_aed.php?id_delete=$userid'><button type='button' class='btn btn-danger btn-sm delete' id='$userid'><i class='fa fa-trash'></i> Delete</button></a>
                    </center>
                    </td>
                </tr>
                ";
            }
        }
    }
    
    public function count(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `UserID`, `LastName`, `FirstName`, `MiddleName`, `Username` FROM `tbl_users` WHERE Deleted="NO"');
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows();
    }

    public function set_data($id){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `LastName`, `FirstName`, `MiddleName`, `Username`, `Password` FROM `tbl_users` WHERE UserID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($lname, $fname, $mname, $username, $pw);
        $stmt->fetch();

        //assign to local variables;
        $this->username = $username;
        $this->fname = $fname;
        $this->mname = $mname;
        $this->lname = $lname;
        $this->pw = $pw;
    }
}
?>