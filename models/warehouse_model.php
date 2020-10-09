<?php
include 'warehouse_aed.php';

class Warehouse {
    public $col = '';
    public $name;
    public $location;

    public function set_data($id){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `WarehouseName`, `Location` FROM `tbl_warehouse` WHERE WarehouseID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($name, $location);
        $stmt->fetch();

        //assign
        $this->name = $name;
        $this->location = $location;
    } 

    public function show_data(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `WarehouseID`, `WarehouseName`, `Location` FROM `tbl_warehouse` WHERE Deleted=?');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($wh_id, $name, $location);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <tr>
                    <td>$name</td>
                    <td>$location</td>
                    <td>
                    <center>
                    <a href='javascript:void(0);' data-href='view_warehouse.php?id=$wh_id' class='editWarehouse'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button></a>
                    <button type='button' class='btn btn-danger btn-sm delete' id='$wh_id'><i class='fa fa-trash'></i> Delete</button>
                    </center>
                    </td>
                </tr>
                ";
            }
        }
    }  
    
    public function count(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT * FROM `tbl_warehouse`');
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows();
    }

    public function show_data_select(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `WarehouseID`, `WarehouseName` FROM `tbl_warehouse`');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($wh_id, $name);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <option value='$wh_id'>$name</option>
                ";
            }
        }
    }

    public function show_data_dl(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `WarehouseName` FROM `tbl_warehouse` WHERE Deleted=?');
        $d='NO';
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

    public function show_data_th(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `WarehouseName` FROM `tbl_warehouse`');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($name);
        $col= '';
        $i = 4;
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $name = ucwords(strtolower($name));
                echo "
                <th style='width:100px'>$name</th>
                <th style='width:100px'>T.O.S.</th>
                <th style='width:100px'>for del.</th>
                ";
                $j = $i + 1;
                $k = $i + 2;
                $col .= $j.', '.$k.', ';
                $i += 3;
            }
        }

        $this->col = $col;
    }
}
?>