<?php
include 'models/connection.php';
$stmt = $con->prepare('SELECT `CompanyName`, SupplierID FROM `tbl_supplier` WHERE Deleted=?');
$d = 'NO';
$stmt->bind_param('s', $d);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($name, $sid);
if($stmt->num_rows > 0){
    while($stmt->fetch()){

        $con1 = new mysqli($server, $user, $pw, $db);
        $stmt1 = $con1->prepare('SELECT `ProductDescription` FROM tbl_tsgi_product WHERE SupplierID=?');
        $stmt1->bind_param('i', $sid);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($prod);
        if($stmt1->num_rows > 0){

            echo "<datalist id='$name'>";

            while($stmt1->fetch()){
                echo "
                <option value='$prod'>
                ";
            }
            
            echo '</datalist>';
        }
    }
}
?>