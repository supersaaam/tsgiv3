<?php
include 'supplier_aed.php';

class Supplier {
    public $name;
    public $add;
    public $acctnumber;
    public $acctname;
    public $bankname;
    public $bankaddress;
    public $swiftcode;
    public $remark;
	public $table;
	public $subdealer;

    public function set_data($id){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `CompanyName`, `CompanyAddress`, `AccountName`, `AccountNumber`, `BankName`, `BankAddress`, `SwiftCode`, `Remarks`, SubDealerOf FROM `tbl_supplier` WHERE SupplierID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($name, $add, $acctname, $acctnumber, $bankname, $bankaddress, $swiftcode, $remark, $subdealer);
        $stmt->fetch();
	$stmt->close();
	$con->close();
	
        //assign
        $this->name = $name;
        $this->add = $add;
        $this->acctnumber = $acctnumber;
        $this->acctname = $acctname;
        $this->bankname = $bankname;
        $this->bankaddress = $bankaddress;
        $this->swiftcode = $swiftcode;
        $this->remark = $remark;
        $this->subdealer = $subdealer;
        
        include 'connection.php';
        $stmt = $con->prepare('SELECT `ContactPerson`, `ContactNumber` FROM `tbl_supplier_contact` WHERE SupplierID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cperson, $cnum);
        $table = '';
        if($stmt->num_rows > 0){
        	while($stmt->fetch()){
        		$table .= "
        		<tr>
        			<td><input type='text' maxlength='100' name='cname[]' value='$cperson' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
        			<td><input type='text' maxlength='100' name='cnumber[]' value='$cnum' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
        		</tr>
        		";
        	}
        }
       
        	$rows = $stmt->num_rows;
        	$rows = 5 - $rows; 
        	
        	while($rows != 0){
        		$table .= "
        		<tr>
        			<td><input type='text' maxlength='100' name='cname[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
        			<td><input type='text' maxlength='100' name='cnumber[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
        		</tr>
        		";
        		$rows-=1;
        	}
        
        $this->table = $table;

    }

    public function show_data(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `SupplierID`, `CompanyName`, `CompanyAddress` FROM `tbl_supplier` WHERE Deleted=?');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($supp_id, $name, $address);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $name = strtoupper(str_replace('"', '', $name));
                $address = strtoupper(str_replace('"', '', $address));
                echo "
                <tr>
                    <td>$name</td>
                    <td>$address</td>
                    <td>
                    <center>
                    <a href='javascript:void(0);' data-href='view_supplier.php?id=$supp_id' class='editSupplier'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button></a>
                    <a href='models/supplier_aed.php?id_delete=$supp_id'<button type='button' class='btn btn-danger btn-sm delete' id='$supp_id'><i class='fa fa-trash'></i> Delete</button></a>
                    </center>
                    </td>
                </tr>
                ";
            }
        }
    }

    public function show_supplier(){
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
                $stmt1 = $con1->prepare('SELECT `ProductDescription` FROM tbl_tsgi_product WHERE SupplierID=? GROUP BY PartNumber');
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
                $stmt1->close();
                $con1->close();
                    
                $con1 = new mysqli($server, $user, $pw, $db);
                $stmt1 = $con1->prepare('SELECT `ProductDescription`, PartNumber FROM tbl_tsgi_product WHERE SupplierID=? GROUP BY PartNumber');
                $stmt1->bind_param('i', $sid);
                $stmt1->execute();
                $stmt1->store_result();
                $stmt1->bind_result($prod, $partnumber);
                if($stmt1->num_rows > 0){

                    echo "<datalist id='pn_$name'>";

                    while($stmt1->fetch()){
                        echo "
                        <option value='$partnumber'>
                        ";
                    }
                    
                    echo '</datalist>';
                }
                $stmt1->close();
                $con1->close();
            }
        }
    }

    public function show_supplier_dl(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `CompanyName`, SupplierID FROM `tbl_supplier` WHERE Deleted=? AND SubDealerOf IS NULL');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($name, $sid);
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
        $stmt = $con->prepare('SELECT * FROM `tbl_supplier` WHERE Deleted="NO"');
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows();
    }
}
?>