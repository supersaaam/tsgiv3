<?php
include 'customer_aed.php';

Class Customer {
    public $name;
    public $address;
    public $credit;
    public $tin;
    public $industry;
    public $table;
    public $table_view;
    public $table_ca;
    public $table_ca_view;
    
    public function set_data($id){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `CompanyName`, `CompanyAddress`, `CreditLimit`, `TIN`, Industry FROM `tbl_customers`
        WHERE `CustomerID`=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($name, $address, $credit, $tin, $ind);
        $stmt->fetch();
	$stmt->close();
	$con->close();
	
        //assign local variable
        $this->name = $name;
        $this->address = $address;
        $this->credit = $credit;
        $this->tin = $tin;
        $this->industry = $ind;
        
        include 'connection.php';
        $stmt = $con->prepare('SELECT `ContactPerson`, `Department`, `ContactNumber` FROM `tbl_customers_contact` WHERE CustomerID=? AND Deleted!="YES"');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cperson, $dept, $cnum);
        $table = '';
        $table_view = '';
        if($stmt->num_rows > 0){
        	while($stmt->fetch()){
        		$table .= "
        		<tr>
        			<td><input type='text' maxlength='100' name='cname[]' value='$cperson' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
        			<td><input type='text' maxlength='100' name='cnumber[]' value='$cnum' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
        			<td><input type='text' maxlength='100' name='department[]' value='$dept' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>			
        		</tr>
        		";
        		
        		$table_view .= "
        		<tr>
        			<td><input type='text' readonly maxlength='100' name='cname[]' value='$cperson' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
        			<td><input type='text' readonly maxlength='100' name='cnumber[]' value='$cnum' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
        			<td><input type='text' readonly maxlength='100' name='department[]' value='$dept' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>			
        		</tr>
        		";
        	}
        }
        
        	$rows = $stmt->num_rows;
        	$rows = 5 - $rows; 
        	
        	/*
        	while($rows != 0){
        		$table .= "
        		<tr>
        			<td><input type='text' maxlength='100' name='cname[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
        			<td><input type='text' maxlength='100' name='cnumber[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>
        			<td><input type='text' maxlength='100' name='department[]' style='background-color: transparent; width:100%; border: 0px' placeholder='Type here...'></td>			
        		</tr>
        		";
        		$rows-=1;
        	}
        	*/
        	
        $this->table = $table;
        $this->table_view = $table_view;
        $stmt->close();
        $con->close();
        
        include 'connection.php';
        $stmt = $con->prepare('SELECT tbl_cmo.FullName, `Address` FROM `tbl_customers_address` LEFT JOIN tbl_cmo ON tbl_cmo.CMO_ID=tbl_customers_address.AgentID  WHERE CustomerID=? AND tbl_customers_address.Deleted!="YES"');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cmo, $address);
        $table_ca = '';
        if($stmt->num_rows > 0){
        	while($stmt->fetch()){
        		$cmo = strtoupper($cmo);
        		$table_ca .= "
        		<tr>
        			<td><input type='text' maxlength='200' name='address[]' value='$address' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
        			<td><input list='cmo_list' id='cmo1' name='cmo[]' value='$cmo' maxlength='100' class='form-control' pattern='".$this->pattern_()."' placeholder='Please input agent name ...'></td>		
        		</tr>
        		";
        		
        		$table_ca_view .= "
        		<tr>
        			<td><input type='text' maxlength='200' name='address[]' value='$address' style='background-color:transparent; width:100%; border: 0px' readonly placeholder='Type here...'></td>
        			<td><input list='cmo_list' id='cmo1' name='cmo[]' value='$cmo' maxlength='100' class='form-control' pattern='".$this->pattern_()."' readonly placeholder='Please input agent name ...'></td>		
        		</tr>
        		";
        	}
        }
        
        	$rows = $stmt->num_rows;
        	$rows = 5 - $rows; 
        	
        	while($rows != 0){
        		$table_ca .= "
        		<tr>
        			<td><input type='text' maxlength='200' name='address[]' style='background-color:transparent; width:100%; border: 0px' placeholder='Type here...'></td>
        			<td><input list='cmo_list' id='cmo1' name='cmo[]' maxlength='100' class='form-control' pattern='".$this->pattern_()."' placeholder='Please input agent name ...'></td>
        		</tr>
        		";
        		$rows-=1;
        	}
        
        $this->table_ca = $table_ca;
        $this->table_ca_view = $table_ca_view;
    }

    public function show_data(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT CustomerID, `CompanyName` FROM `tbl_customers` WHERE Deleted=?');
        $d = 'NO';
        $stmt->bind_param('s', $d);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cust_id, $cname);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $cname = strtoupper(str_replace('"','', $cname));
                echo "
                <tr>
                    <td>$cname</td>
                    <td>";
                    
                    $con1 = new mysqli($server, $user, $pw, $db);
                    $cmo = $con1->prepare('SELECT c.FullName, `Address` FROM `tbl_customers_address` ca LEFT JOIN tbl_cmo c ON c.CMO_ID=ca.AgentID WHERE ca.CustomerID=? AND ca.Deleted!="YES"');
                    $cmo->bind_param('i', $cust_id);
                    $cmo->execute();
                    $cmo->store_result();
                    $cmo->bind_result($cmo_name, $address);
                    if($cmo->num_rows > 0){
                        while($cmo->fetch()){
                            $cmo_name = strtoupper($cmo_name);
                            $address = strtoupper($address);
                            echo "
                                $address - $cmo_name </br> 
                            ";
                        }
                    }
                    else{
                        echo " ";
                    }

                echo "</td>
                    <td>
                    <center>
                        
                        <a href='javascript:void(0);' data-href='view_customer.php?id=$cust_id&view' class='viewCustomer'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i> View Details</button></a>
                        
                        <a href='javascript:void(0);' data-href='view_customer.php?id=$cust_id' class='editCustomer'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-edit'></i> Edit Details</button></a>
                        <a href='models/customer_aed.php?id_delete=$cust_id'<button type='button' class='btn btn-danger btn-sm delete' id='$cust_id'><i class='fa fa-trash'></i> Delete</button></a>
                    </center>
                    </td>
                </tr>
                ";
            }
        }
    }

    public function show_data_dl(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `CompanyName` FROM `tbl_customers` WHERE Deleted!="YES"');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cname);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $cname = strtoupper(str_replace('"','', $cname));
                echo "
                <option value='$cname'>
                ";
            }
        }
    }

    public function pattern(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `CompanyName` FROM `tbl_customers`');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cname);
        $pattern = '';
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $cname = strtoupper(str_replace('"','', $cname));
                $pattern .= $cname.'|';
            }
        }

        return $pattern;
    }
    
    public function count(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `CustomerID` FROM `tbl_customers` WHERE Deleted="NO"');
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows();
    }
    
    public function pattern_(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `FullName` FROM `tbl_cmo`  WHERE Status!="Inactive"');
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