<?php
include 'actprod_aed.php';

class Actual_Prod {
  public $price;
  public $brand;
  public $desc;
  public $pnum;
  public $min;
  public $max;
  public $stock;
  public $usdprice;
    public $currency;
  /**
   * @param $id
   */
  public function set_data($id) {
    include 'models/connection.php';

    $stmt = $con->prepare('SELECT s.CompanyName, `PartNumber`, `ProductDescription`, `Price`, `MinLevel`, `MaxLevel`, `CurrentStock`, USDPrice, Currency FROM `tbl_tsgi_product` p JOIN tbl_supplier s ON s.SupplierID=p.SupplierID WHERE ProductID=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($brand, $pnum, $desc, $price, $min, $max, $stock, $usdprice, $currency);
    $stmt->fetch();

    //assign
    $this->currency =$currency;
    $this->price  = $price;
    $this->brand = $brand;
    $this->desc = $desc;
    $this->pnum = $pnum;
    $this->min = $min;
    $this->max = $max;
    $this->stock = $stock;
    $this->usdprice = $usdprice;
  }

  public function show_data_dl() {
    include 'models/connection.php';
    // $stmt = $con->prepare('SELECT `ProductCode` FROM `tbl_product_depot`');
    // $stmt->execute();
    // $stmt->store_result();
    // $stmt->bind_result($code);
    // if ($stmt->num_rows > 0) {
    //   while ($stmt->fetch()) {
    //     echo "<option value='$code'>$code</option>";
    //   }
    // }

    $result = $con->query('SELECT * FROM tbl_product_depot');
    while ($row = $result->fetch_assoc()) {
      echo "<option>{$row['ProductCode']}</option>";
    }
  }

  public function show_data_my_dl(){
    include 'models/connection.php';
    
    $stmt = $con->prepare('SELECT `AsOfMonth` FROM `tbl_actual_prod_beg_inv` GROUP BY AsOfMonth');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($asof);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        echo "<option value='$asof'>$asof</option>";
      }
    }
  }

  /**
   * @param $sql
   */
  public function show_query($sql) {
    include 'models/connection.php';

    $stmt = $con->prepare($sql);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($whname, $code, $stock, $cl);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        echo "
                <tr>
                <td>$whname</td>
                <td>$code</td>
                <td>$stock</td>
                <td>$cl</td>
                </tr>
                ";
      }
    }
  }

  /**
   * @return mixed
   */
  public function show_code_list() {
    include 'models/connection.php';
    $stmt = $con->prepare('SELECT `ProductCode` FROM `tbl_product_depot`');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($code);
    $pattern = '';
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        $pattern .= $code . '|';
      }
    }
    return $pattern;
  }

  public function show_data() {
    include 'models/connection.php';
    $stmt = $con->prepare('SELECT `ProductID`, s.CompanyName, `PartNumber`, `ProductDescription`, `Price`, `MinLevel`, `MaxLevel`, `CurrentStock` FROM `tbl_tsgi_product` p JOIN tbl_supplier s ON s.SupplierID=p.SupplierID WHERE Indent="NO" ORDER BY s.CompanyName ASC');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($pid, $brand, $pnum, $desc, $price, $min, $max, $stock);
    if ($stmt->num_rows > 0) {
    $i = 1;
      while ($stmt->fetch()) {
        $price = number_format($price,2);
        echo "
                <tr>
                    <td>$i</td>
                    <td>$brand</td>
                    <td>$pnum</td>
                    <td>$desc</td>
                    <td>$min</td>
                    <td>$max</td>
                    ";
                    
                    $con1 = new mysqli($server, $user, $pw, $db);
                    $stmt1 = $con1->prepare('SELECT `Price`, `InventoryDate`, `CurrentStock` FROM `tbl_tsgi_product` WHERE PartNumber=? AND `CurrentStock` > 0');
                    $stmt1->bind_param('s', $pnum);
                    $stmt1->execute();
                    $stmt1->store_result();
                    $stmt1->bind_result($p, $i_, $s);
                    $ctr_ = 0;
                    if($stmt1->num_rows > 1){
                    
                    	echo "<td>
                    	";
                    	
                    	while($stmt1->fetch()){
                    		
                    		$i_ = date_format(date_create($i_), "M j, y");
                    		
                    		echo "
                    		$p <br>
                    		";
                    		
                    		$ctr_++;
                    	}
                    	
                    	echo "
                    	</td>
                    	";
                    }
                    $stmt1->close();
                    $con1->close();
                    
                    $con1 = new mysqli($server, $user, $pw, $db);
                    $stmt1 = $con1->prepare('SELECT `Price`, `InventoryDate`, `CurrentStock` FROM `tbl_tsgi_product` WHERE PartNumber=? AND `CurrentStock` > 0');
                    $stmt1->bind_param('s', $pnum);
                    $stmt1->execute();
                    $stmt1->store_result();
                    $stmt1->bind_result($p, $i_, $s);
                    $ctr = 0;
                    if($stmt1->num_rows > 1){
                    
                    	echo "<td>
                    	";
                    	
                    	while($stmt1->fetch()){
                    		
                    		$i_ = date_format(date_create($i_), "M j, y");
                    		
                    		echo "
                    		$s <br> 
                    		";
                    		$ctr++;
                    	}
                    	
                    	echo "
                    	</td>
                    	";
                    }
                    $stmt1->close();
                    $con1->close();
                    
                    if($ctr + $ctr_ == 0){
                    	echo "
                    	<td>$price</td>
                    	<td>$stock</td>
                    	";
                    }
                    
                    echo "
                    <td>
                    <center>";
                    
                    session_start();
                    if($_SESSION['access'] == 'Admin' || $_SESSION['access'] == 'Finance'){
                        echo "
                        <a href='javascript:void(0);' data-href='view_act_prod.php?id=$pid&indent' class='editProduct'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button></a>
                        ";
                    }
                    else{
                        echo "
                        <button type='button' disabled class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button>
                        ";
                    }
                    
                    echo "
                    </center>
                    </td>
                </tr>
                ";
                
                $i++;
      }
    }
  }
  
  public function show_data_actual() {
    include 'models/connection.php';
    $stmt = $con->prepare('SELECT `ProductID`, s.CompanyName, `PartNumber`, `ProductDescription`, `Price`, `MinLevel`, `MaxLevel`, `CurrentStock`, ImagePath FROM `tbl_tsgi_product` p JOIN tbl_supplier s ON s.SupplierID=p.SupplierID WHERE Indent="NO" AND CurrentStock > 0 ORDER BY s.CompanyName ASC');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($pid, $brand, $pnum, $desc, $price, $min, $max, $stock, $img);
    if ($stmt->num_rows > 0) {
    $i = 1;
      while ($stmt->fetch()) {
        $price = number_format($price,2);
        echo "
                <tr>
                    <td>$i</td>
                    <td>$brand</td>
                    <td>$pnum</td>
                    <td>$desc</td>
                    <td>$min</td>
                    <td>$max</td>
                    ";
                    
                    $con1 = new mysqli($server, $user, $pw, $db);
                    $stmt1 = $con1->prepare('SELECT `Price`, `InventoryDate`, `CurrentStock` FROM `tbl_tsgi_product` WHERE PartNumber=? AND `CurrentStock` > 0');
                    $stmt1->bind_param('s', $pnum);
                    $stmt1->execute();
                    $stmt1->store_result();
                    $stmt1->bind_result($p, $i_, $s);
                    $ctr_ = 0;
                    if($stmt1->num_rows > 1){
                    
                    	echo "<td>
                    	";
                    	
                    	while($stmt1->fetch()){
                    		
                    		$i_ = date_format(date_create($i_), "M j, y");
                    		
                    		echo "
                    		$p <br>
                    		";
                    		
                    		$ctr_++;
                    	}
                    	
                    	echo "
                    	</td>
                    	";
                    }
                    $stmt1->close();
                    $con1->close();
                    
                    $con1 = new mysqli($server, $user, $pw, $db);
                    $stmt1 = $con1->prepare('SELECT `Price`, `InventoryDate`, `CurrentStock` FROM `tbl_tsgi_product` WHERE PartNumber=? AND `CurrentStock` > 0');
                    $stmt1->bind_param('s', $pnum);
                    $stmt1->execute();
                    $stmt1->store_result();
                    $stmt1->bind_result($p, $i_, $s);
                    $ctr = 0;
                    if($stmt1->num_rows > 1){
                    
                    	echo "<td>
                    	";
                    	
                    	while($stmt1->fetch()){
                    		
                    		$i_ = date_format(date_create($i_), "M j, y");
                    		
                    		echo "
                    		$s <br> 
                    		";
                    		$ctr++;
                    	}
                    	
                    	echo "
                    	</td>
                    	";
                    }
                    $stmt1->close();
                    $con1->close();
                    
                    if($ctr + $ctr_ == 0){
                    	echo "
                    	<td>$price</td>
                    	<td>$stock</td>
                    	";
                    }
                    
                    
                    
                    echo "
                    <td>
                    <center>";
                    
                    if($img != NULL){
                        echo "
                        <a href='models/actprod_aed.php?remove_photo=$pid'><button type='button' class='btn btn-danger btn-xs'><i class='fa fa-times'></i> Remove Photo</button></a>
                        ";
                    }
                    
                    $img = substr($img, 3);
                    
                    echo "
                    <img src='$img' style='width: 80%; margin: 0 auto; height: auto'>
                    </center>
                    <br>
                    
                    <form method='post' id='form$i' action='models/actprod_aed.php' enctype='multipart/form-data'>
                        <input type='file' name='docs' id='fileToUpload$i'>
                        <input type='hidden' value='$pid' name='prod_id'>
                    </form>
                    
                    <script>
                    document.getElementById('fileToUpload$i').onchange = function() {
                        document.getElementById('form$i').submit();
                    };
                    </script>
                    
                    </center>
                    </td>
                    <td>
                    <center> ";
                        
                    session_start();
                    if($_SESSION['access'] == 'Admin' || $_SESSION['access'] == 'Finance'){
                        echo "
                        <a href='javascript:void(0);' data-href='view_act_prod.php?id=$pid' class='editProduct'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button></a>
                        ";
                    }
                    else{
                        echo "
                        <button type='button' disabled class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button>
                        ";
                    }
                        
                    echo "
                    </center>
                    </td>
                </tr>
                ";
                
                $i++;
      }
    }
  }
  
  public function show_indent_data() {
    include 'models/connection.php';
    $stmt = $con->prepare('SELECT `ProductID`, s.CompanyName, `PartNumber`, `ProductDescription`, `Price`, `MinLevel`, `MaxLevel`, `CurrentStock` FROM `tbl_tsgi_product` p JOIN tbl_supplier s ON s.SupplierID=p.SupplierID WHERE Indent="YES"');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($pid, $brand, $pnum, $desc, $price, $min, $max, $stock);
    if ($stmt->num_rows > 0) {
    $i = 1;
      while ($stmt->fetch()) {
        $price = number_format($price,2);
        echo "
                <tr>
                    <td>$i</td>
                    <td>$brand</td>
                    <td>$pnum</td>
                    <td>$desc</td>
                    <td>$min</td>
                    <td>$max</td>
                    ";
                    
                    $con1 = new mysqli($server, $user, $pw, $db);
                    $stmt1 = $con1->prepare('SELECT `Price`, `InventoryDate`, `CurrentStock` FROM `tbl_tsgi_product` WHERE PartNumber=? AND `CurrentStock` > 0');
                    $stmt1->bind_param('s', $pnum);
                    $stmt1->execute();
                    $stmt1->store_result();
                    $stmt1->bind_result($p, $i_, $s);
                    $ctr_ = 0;
                    if($stmt1->num_rows > 1){
                    
                    	echo "<td>
                    	";
                    	
                    	while($stmt1->fetch()){
                    		
                    		$i_ = date_format(date_create($i_), "M j, y");
                    		
                    		echo "
                    		$p <br>
                    		";
                    		
                    		$ctr_++;
                    	}
                    	
                    	echo "
                    	</td>
                    	";
                    }
                    $stmt1->close();
                    $con1->close();
                    
                    $con1 = new mysqli($server, $user, $pw, $db);
                    $stmt1 = $con1->prepare('SELECT `Price`, `InventoryDate`, `CurrentStock` FROM `tbl_tsgi_product` WHERE PartNumber=? AND `CurrentStock` > 0');
                    $stmt1->bind_param('s', $pnum);
                    $stmt1->execute();
                    $stmt1->store_result();
                    $stmt1->bind_result($p, $i_, $s);
                    $ctr = 0;
                    if($stmt1->num_rows > 1){
                    
                    	echo "<td>
                    	";
                    	
                    	while($stmt1->fetch()){
                    		
                    		$i_ = date_format(date_create($i_), "M j, y");
                    		
                    		echo "
                    		$s <br> 
                    		";
                    		$ctr++;
                    	}
                    	
                    	echo "
                    	</td>
                    	";
                    }
                    $stmt1->close();
                    $con1->close();
                    
                    if($ctr + $ctr_ == 0){
                    	echo "
                    	<td>$price</td>
                    	<td>$stock</td>
                    	";
                    }
                    
                    echo "
                    <td>
                    <center>";
                    
                    session_start();
                    if($_SESSION['access'] == 'Admin' || $_SESSION['access'] == 'Finance'){
                        echo "
                        <a href='javascript:void(0);' data-href='view_act_prod.php?id=$pid&indent' class='editProduct'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button></a>
                        ";
                    }
                    else{
                        echo "
                        <button type='button' disabled class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> Edit Details</button>
                        ";
                    }
                    
                    echo "
                    </center>
                    </td>
                </tr>
                ";
                
                $i++;
      }
    }
  }

  /**
   * @return mixed
   */
  public function count() {
    include 'models/connection.php';
    $stmt = $con->prepare('SELECT * FROM `tbl_tsgi_product` WHERE Indent="NO" AND CurrentStock > 0');
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows();
  }
  
  public function count_indent() {
    include 'models/connection.php';
    $stmt = $con->prepare('SELECT * FROM `tbl_tsgi_product` WHERE Indent="YES"');
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows();
  }
  
  public function count_local() {
    include 'models/connection.php';
    $stmt = $con->prepare('SELECT * FROM `tbl_tsgi_product` WHERE Indent="NO"');
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows();
  }
}
?>
