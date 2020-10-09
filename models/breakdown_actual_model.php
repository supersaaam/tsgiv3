<?php
class Breakdown_Actual {
    public function show_data(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `CMO_ID`, `FullName`, `Location` FROM `tbl_cmo`');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cmoID, $fname, $location);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <tr>
                    <td>$fname</td>
                    <td>$fname</td>
                    <td>$fname</td>
                    <td>$fname</td>
                </tr>
                ";
            }
        }
    } 
}
?>