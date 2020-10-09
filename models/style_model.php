<?php
class Style{
    public function show_select(){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `BS_ID`, `BusinessStyle` FROM `tbl_business_style`');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $style);
        while($stmt->fetch()){
            echo "
                <option value='$id'>$style</option>
            ";
        }
    }
}
?>