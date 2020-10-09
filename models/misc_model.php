<?php
class Misc{
    public function show_misc(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `Description` FROM `tbl_misc`');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($desc);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <option value='$desc'>
                ";
            }
        }
    }    
}
?>