<?php
include 'product_aed.php';

class Product {
    public $name;
    public $desc;

    public function set_data($id){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `ProductName`, `Description` FROM `tbl_product` WHERE ProductID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($name, $desc);
        $stmt->fetch();

        //assign
        $this->name = $name;
        $this->desc = $desc;
    } 

    public function show_data(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `ProductID`, `ProductName`, `Description` FROM `tbl_product` WHERE Deleted=?');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($prod_id, $name, $desc);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <tr>
                    <td>$name</td>
                    <td>$desc</td>
                    <td>
                    <center>
                    <a href='javascript:void(0);' data-href='view_product.php?id=$prod_id' class='editProduct'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button></a>
                    <button type='button' class='btn btn-danger btn-sm delete' id='$prod_id'><i class='fa fa-trash'></i> Delete</button>
                    </center>
                    </td>
                </tr>
                ";
            }
        }
    }    

    public function show_product(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `ProductName` FROM `tbl_product` WHERE Deleted=?');
        $d = 'NO';
        $stmt->bind_param('s', $d);
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

    public function count(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT * FROM `tbl_product`');
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows();
    }
}
?>