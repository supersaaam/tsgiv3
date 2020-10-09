<?php
class BOM{
    public $last_id;
    
    public function show_prod_list(){
                include 'connection.php';
                $stmt1 = $con->prepare('SELECT `ProductDescription` FROM tbl_tsgi_product WHERE SupplierID=36 GROUP BY PartNumber');
                $stmt1->execute();
                $stmt1->store_result();
                $stmt1->bind_result($prod);
                if($stmt1->num_rows > 0){
                    while($stmt1->fetch()){
                        echo "
                        <option value='$prod'>
                        ";
                    }
                }
    }
    
    public function get_foreign($bom){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT COUNT(*) FROM `tbl_tsgi_bom_foreign` WHERE BOM_ID=?');
        $stmt->bind_param('i', $bom);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cnt);
        $stmt->fetch();
        
        return $cnt;
    }
    
    public function show_foreign($bom){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT s.SupplierID, s.CompanyName, p.ProductID, p.ProductDescription, p.Price, p.PartNumber, `Quantity`, `MarkedupPrice`, `TotalPrice` FROM tbl_tsgi_bom_foreign f JOIN tbl_supplier s ON s.SupplierID=f.BrandID JOIN tbl_tsgi_product p ON p.ProductID=f.ProductID WHERE BOM_ID=?');
        $stmt->bind_param('i', $bom);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($supp_id, $brand, $pid, $desc, $price, $pnum, $q, $mup, $tp);
        if($stmt->num_rows > 0){
            $i = 1;
            while($stmt->fetch()){
                echo "
                <tr id='tr$i'>
                        <td>
                            <input class='counter' id='$i' type='hidden'>
                          <input type='hidden' name='brand[]' id='brand_$i' value='$supp_id'>
                          <input list='brand_list' id='brand$i' maxlength='50' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...' value='$brand'>
                        </td>
                        <td>
                            <input type='hidden' name='productID[]' id='productID$i' value='$pid'>
                          <input id='product$i' name='product[]' readonly maxlength='200' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...' value='$desc'>
                        </td>
                        <td>
                          <input type='text' name='ourpartnum[]' id='ourpartnum$i' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control' value='$pnum'>
                        </td>
                        <td>
                          <input type='number' name='quantity[]' id='quan$i' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control' value='$q'>
                        </td>
                        <td>
                          <input type='text' id='mu_price$i' name='mu_price[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control' value='$mup'>
                        </td>
                        <td>
                          <input type='text' id='unitprice$i' name='price[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control' value='$price'>
                        </td>
                        <td>
                          <input name='linetotal[]' id='linetotal$i' step='any' style='text-align:right;background-color:transparent; border:transparent' min='0' class='form-control tprice' readonly required type='text' value='$tp'>
                        </td>
                       <td><center><button onclick='deleterow($i)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td>
                      </tr>
                ";
                
                $i++;
            }
        }
    }
    
    public function get_local($bom){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT COUNT(*) FROM `tbl_tsgi_bom_local` WHERE BOM_ID=?');
        $stmt->bind_param('i', $bom);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cnt);
        $stmt->fetch();
        
        return $cnt;
    }
    
    public function show_local($bom){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT p.ProductID, p.PartNumber, p.ProductDescription, p.USDPrice, `Quantity`, `MarkedupPrice`, `PriceVAT`, `TotalPrice` FROM tbl_tsgi_bom_local l JOIN tbl_tsgi_product p ON p.ProductID=l.ProductID WHERE BOM_ID=?');
        $stmt->bind_param('i', $bom);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($pid, $pnum, $desc, $netprice, $q, $mup, $sp, $tp);
        if($stmt->num_rows > 0){
            $i = 1;
            while($stmt->fetch()){
                echo "
                <tr id='tr$i'>
                        <td>
                            <input class='counter' id='$i' type='hidden'>
                            <input type='hidden' name='productID[]' id='productID$i' value='$pid'>
                          <input id='product$i' name='product[]' readonly maxlength='200' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...' value='$desc'>
                        </td>
                        <td>
                          <input type='text' name='ourpartnum[]' id='ourpartnum$i' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control' value='$pnum'>
                        </td>
                        <td>
                          <input type='number' name='quantity[]' id='quan$i' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control' value='$q'>
                        </td>
                        <td>
                          <input type='text' id='net_price$i' name='net_price[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control' value='$netprice'>
                        </td>
                        <td>
                          <input type='text' id='mu_price$i' readonly name='mu_price[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control' value='$mup'>
                        </td>
                        <td>
                          <input type='text' id='unitprice$i' readonly name='price[]' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control' value='$sp'>
                        </td>
                        <td>
                          <input name='linetotal[]' id='linetotal$i' step='any' style='text-align:right;background-color:transparent; border:transparent' min='0' class='form-control tprice' readonly required type='text' value='$tp'>
                        </td>
                       <td><center><button onclick='deleterow($i)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td>
                      </tr>
                ";
                
                $i++;
            }
        }
    }
    
    public function get_labor($bom){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT COUNT(*) FROM `tbl_tsgi_bom_labor` WHERE BOM_ID=?');
        $stmt->bind_param('i', $bom);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cnt);
        $stmt->fetch();
        
        return $cnt;
    }
    
    public function show_labor($bom){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT `Manpower`, `Quantity`, `Days`, `DailyRate`, `LineTotal` FROM `tbl_tsgi_bom_labor` WHERE BOM_ID=?');
        $stmt->bind_param('i', $bom);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($desc, $quan, $days, $rate, $lt);
        if($stmt->num_rows > 0){
            $i = 1;
            while($stmt->fetch()){
                echo "
                <tr id='tr$i'>
                        <td>
                          <input class='counter' id='$i' type='hidden'>
                          <input id='' style='text-align:left; background-color:transparent; border:transparent; width:100%' name='desc[]' maxlength='200' type='text' required placeholder='Type here ...' value='$desc'>
                        </td>
                        <td>
                          <input type='number' min='0' name='quantity[]' id='quan$i' value='$quan' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        <td>
                          <input type='number' min='0' name='days[]' id='days$i' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control' value='$days'>
                        </td>
                        <td>
                          <input type='number' name='rate[]' id='rate$i' value='$rate' style='text-align:right; background-color:transparent; border:transparent; width:100%' required step='any' min='0' class='form-control'>
                        </td>
                        <td>
                          <input name='linetotal[]' id='linetotal$i' value='$lt' step='any' style='text-align:right;background-color:transparent; border:transparent' min='0' class='form-control tprice' readonly required type='text'>
                        </td>
                       <td><center><button onclick='deleterow($i)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td>
                      </tr>
                ";
                
                $i++;
            }
        }
    }
    
    public function get_permit($bom){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT COUNT(*) FROM `tbl_tsgi_bom_permit` WHERE BOM_ID=?');
        $stmt->bind_param('i', $bom);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cnt);
        $stmt->fetch();
        
        return $cnt;
    }
    
    public function show_permit($bom){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT `Quantity`, `Description`, `Price`, `LineTotal` FROM `tbl_tsgi_bom_permit` WHERE BOM_ID=?');
        $stmt->bind_param('i', $bom);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($quan, $desc, $price, $lt);
        if($stmt->num_rows > 0){
            $i = 1;
            while($stmt->fetch()){
                echo "
                <tr id='tr$i'>
                        <td>
                          <input class='counter' id='$i' type='hidden'>
                          <input id='' style='text-align:left; background-color:transparent; border:transparent; width:100%' name='desc[]' maxlength='200' type='text' required placeholder='Type here ...' value='$desc'>
                        </td>
                        <td>
                          <input type='number' min='0' name='quantity[]' id='quan$i' value='$quan' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        <td>
                          <input type='number' min='0' name='price[]' id='price$i' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control' step='any' value='$price'>
                        </td>
                        <td>
                          <input name='linetotal[]' id='linetotal$i' value='$lt' step='any' style='text-align:right;background-color:transparent; border:transparent' min='0' class='form-control tprice' readonly required type='text'>
                        </td>
                       <td><center><button onclick='deleterow($i)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td>
                      </tr>
                ";
                
                $i++;
            }
        }
    }
    
    public function get_subcon($bom){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT COUNT(*) FROM `tbl_tsgi_bom_subcon` WHERE BOM_ID=?');
        $stmt->bind_param('i', $bom);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cnt);
        $stmt->fetch();
        
        return $cnt;
    }
    
    public function show_subcon($bom){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT `Quantity`, `Description`, `Price`, `ComputedPrice`, `MarkedupPrice`, `LineTotal` FROM `tbl_tsgi_bom_subcon` WHERE `BOM_ID`=?');
        $stmt->bind_param('i', $bom);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($quan, $desc, $price, $cp, $mp, $lt);
        if($stmt->num_rows > 0){
            $i = 1;
            while($stmt->fetch()){
                echo "
                <tr id='tr$i'>
                        <td>
                          <input class='counter' id='$i' type='hidden'>
                          <input id='' style='text-align:left; background-color:transparent; border:transparent; width:100%' name='desc[]' maxlength='200' type='text' required placeholder='Type here ...' value='$desc'>
                        </td>
                        <td>
                          <input type='number' min='0' name='quantity[]' id='quan$i' value='$quan' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control'>
                        </td>
                        <td>
                          <input type='number' min='0' name='price[]' id='price$i' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control' step='any' value='$price'>
                        </td>
                        <td>
                          <input type='number' min='0' name='comp_price[]' id='comp_price$i' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control' readonly step='any' value='$cp'>
                        </td>
                        <td>
                          <input type='number' min='0' name='mu_price[]' id='mu_price$i' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control' readonly step='any' value='$mp'>
                        </td>
                        <td>
                          <input name='linetotal[]' id='linetotal$i' value='$lt' step='any' style='text-align:right;background-color:transparent; border:transparent' min='0' class='form-control tprice' readonly required type='text'>
                        </td>
                       <td><center><button onclick='deleterow($i)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td>
                      </tr>
                ";
                
                $i++;
            }
        }
    }
    
    public function get_last_q() {
        include 'connection.php';
    
        $stmt = $con->prepare('SELECT `BOM_ID` FROM `tbl_tsgi_bom` ORDER BY BOM_ID DESC');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($bom_id);
        $i = 0;
        if ($stmt->num_rows > 0) {
          while ($stmt->fetch()) {
            if ($i === 0) {
              $this->last_id = $bom_id + 1;
              $i++;
            }
          }
        } else {
          $this->last_id = 1;
        }
      }
    
    public function show_data(){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT `BOM_ID`, `ForeignComp`, `LocalComp`, `Labor`, `SubCon`, `StructurePermits`, `InsuranceRep`, `ActualBOM`, `POAmount`, `Variance`, ProjectName FROM `tbl_tsgi_bom` WHERE Deleted="NO"');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($bom_id, $foreign, $local, $labor, $subcon, $structure, $insurance, $actualbom, $po, $variance, $proj);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $id = $bom_id;
                $bom_id = sprintf('%06d', $bom_id);
                
                $foreign = number_format($foreign, 2);
                $local = number_format($local, 2);
                $labor = number_format($labor, 2);
                $subcon = number_format($subcon,2);
                $structure = number_format($structure,2);
                $insurance = number_format($insurance,2);
                $actualbom = number_format($actualbom,2);
                $po = number_format($po,2);
                $variance = number_format($variance,2);
                
                echo "
                <tr>
                    <td>
                    <center>
                    <div class='btn-group'>
                      <button type='button' class='btn btn-primary btn-sm'>Action</button>
                      <button type='button' class='btn btn-primary btn-sm dropdown-toggle' data-toggle='dropdown' aria-expanded='true'>
                        <span class='caret'></span>
                        <span class='sr-only'>Toggle Dropdown</span>
                      </button>
                      <ul class='dropdown-menu' role='menu'>
                        <li><a href='foreign?bom=$bom_id'>Foreign Components</a></li>
                        <li><a href='local?bom=$bom_id'>Local Components</a></li>
                        <li><a href='labor?bom=$bom_id'>Labor</a></li>
                        <li><a href='permit?bom=$bom_id'>Structure / Permits</a></li>
                        <li><a href='subcon?bom=$bom_id'>Sub Contracts</a></li>
                        <li><a href='models/bom_aed.php?bom=$bom_id&actual'>Compute for Actual BOM</a></li>
                        <li><a href='models/bom_aed.php?bom=$bom_id&insurance'>Compute for Miscellaneous</a></li>
                        
                        <li><a href='models/bom_aed.php?bom=$bom_id&delete'>Delete BOM</a></li>
                        
                      </ul>
                    </div>
                    </center>
                    </td>
                    <td>
                    $proj
                    <br>
                    <br>
                    <center>
                    <button class='btn btn-info btn-xs' data-toggle='modal' data-target='#bom_proj$id'>Update Project Name</button></td>
                    </center>
                    <td>$foreign</td>
                    <td>$local</td>
                    <td>$labor</td>
                    <td>$subcon</td>
                    <td>$structure</td>
                    <td>$insurance</td>
                    <td>$actualbom</td>
                </tr>
                ";   
                
                echo "
                 <div id='bom_proj$id' class='modal fade' role='dialog'>
		  <div class='modal-dialog'>
	     	    <form action='models/bom_aed.php' method='post'>
		    <!-- Modal content-->
		    <div class='modal-content'>
		      <div class='modal-header'>
		        <button type='button' class='close' data-dismiss='modal'>&times;</button>
		        <h4 class='modal-title'>Bill of Materials</h4>
		      </div>
		      <div class='modal-body'>
		      	<div class='form-group'>
	                    <label>Project Name</label>
	                    <input type='hidden' name='bom_id' value='$id'>
	                    <textarea name='proj_name' required class='form-control' rows='6' style='resize:none'>$proj</textarea>
	                  </div>		      
		      </div>
		      <div class='modal-footer'>
		        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
		        <button type='submit' name='proj_submit' class='btn btn-primary'>Submit</button>
		      </div>
		    </div>
		    </form>
		  </div>
		</div>
                ";
            }
        }
        $stmt->close();
        $con->close();
    }
}
?>