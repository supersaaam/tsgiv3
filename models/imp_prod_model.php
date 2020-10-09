<?php
class Imp_Prod {
    public $ctr;
    public $bd_ctr;


    public function selected($stat, $x){
      if($x == $stat){
        return 'selected';
      }
    }

    public function show_data($id){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT ProformaInvNo, tbl_product.ProductName, tbl_packaging.Packaging, Quantity, Price, Total, Unit FROM tbl_imp_product JOIN tbl_product ON tbl_product.ProductID=tbl_imp_product.ProductID JOIN tbl_packaging ON tbl_packaging.PackagingID=tbl_imp_product.PackagingID WHERE ProformaInvNo = ?');
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($invnum, $prod, $pack, $q, $p, $t, $u);
        if($stmt->num_rows > 0){
            $i = 1;
            while($stmt->fetch()){
                $q = number_format($q);
                $p = number_format($p, 2);
                $t = number_format($t, 2);
                if($i === 1){
                echo "
                    <tr>
                      <td>
                        <input list='products_list' name='product[]' maxlength='50' style='background-color:transparent; border:transparent' class='form-control' required value='$prod'>
                      </td>
                      <td>
                        <input list='packaging_list' name='packaging[]' maxlength='50' style='background-color:transparent; border:transparent' class='form-control' required value='$pack'>
                      </td>
                      <td>
                        <input type='text' maxlength='8' name='quantity[]' id='quan1$i' style='text-align:right; background-color:transparent; border:transparent' required class='form-control num' value='$q'>
                      </td>
                      <td>
                      <select class='form-control' required name='unit[]'>
                        <option value='N/A'";
                         
                      echo $this->selected('N/A', $u);
                      
                    echo  " >N/A</option>
                        <option value='Vial'";
                         
                        echo $this->selected('Vial', $u);
                        
                      echo  " >Vial</option>
                        <option value='Kg'";
                        
                        echo $this->selected('Kg', $u);

                      echo " >Kg</option>
                        <option value='Liter'";
                        
                        echo $this->selected('Liter', $u);

                      echo  " >Liter</option>
                      </select>
                      </td>
                      <td>
                        <input type='text' maxlength='8' name='price[]' step='any' id='price1$i' style='text-align:right; background-color:transparent; border:transparent' required class='form-control' value='$p'>
                      </td>
                      <td>
                        <input type='text' name='total[]' id='total1$i' style='text-align:right; background-color:transparent; border:transparent' class='form-control tprice1' required readonly value='$t'>
                      </td>
                    </tr>
                ";
                }
                else{
                    echo "
                    <tr id='$i'>
                      <td>
                        <input list='products_list' name='product[]' maxlength='50' style='background-color:transparent; border:transparent' class='form-control' value='$prod'>
                      </td>
                      <td>
                        <input list='packaging_list' name='packaging[]' maxlength='50' style='background-color:transparent; border:transparent' class='form-control' value='$pack'>
                      </td>
                      <td>
                        <input type='text' maxlength='8' name='quantity[]' id='quan1$i' style='text-align:right; background-color:transparent; border:transparent' class='form-control num' value='$q'>
                      </td>
                      <td>
                      <select class='form-control' name='unit[]'>
                      <option value='N/A'";
                         
                      echo $this->selected('N/A', $u);
                      
                    echo  " >N/A</option>
                        <option value='Vial'";
                         
                        echo $this->selected('Vial', $u);
                        
                      echo  " >Vial</option>
                        <option value='Kg'";
                        
                        echo $this->selected('Kg', $u);

                      echo " >Kg</option>
                        <option value='Liter'";
                        
                        echo $this->selected('Liter', $u);

                      echo  " >Liter</option>
                      </select>
                      </td>
                      <td>
                        <input type='text' maxlength='8' name='price[]' step='any' id='price1$i' style='text-align:right; background-color:transparent; border:transparent' class='form-control' value='$p'>
                      </td>
                      <td>
                        <input type='text' name='total[]' id='total1$i' style='text-align:right; background-color:transparent; border:transparent' class='form-control tprice1' readonly value='$t'>
                      </td>
                      <td>
                      <center><button id='$i' onclick='deleterow(this.id)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></
                      </td>
                    </tr>
                ";
                }
                $i++;
            }

            $this->ctr = $i;
        }
    } 
    
    public function show_data_bd($id){
      include 'models/connection.php';
      $stmt = $con->prepare('SELECT ProformaInvNo, tbl_product.ProductName, tbl_packaging.Packaging, Quantity, Price, Total, Unit, ImpProd_ID, tbl_product.ProductID FROM tbl_imp_product JOIN tbl_product ON tbl_product.ProductID=tbl_imp_product.ProductID JOIN tbl_packaging ON tbl_packaging.PackagingID=tbl_imp_product.PackagingID WHERE ProformaInvNo = ?');
      $stmt->bind_param('s', $id);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($invnum, $prod, $pack, $q, $p, $t, $u, $ip_id, $prod_id);
      if($stmt->num_rows > 0){
          $i = 1;
          while($stmt->fetch()){
              $q = number_format($q);
              $p = number_format($p, 2);
              $t = number_format($t, 2);
              echo "
              <tr>
                <td colspan='5'>
                <table id='addrow$i' class='table table-bordered table-striped'>
              ";
              if($i === 1){
              echo "
               <thead>
                <tr>
                <th colspan='3'><center>FROM IMPORTATION</center></th>
                <th colspan='3'><center>BREAKDOWN</center></th>
                </tr>
                </thead>
                <tbody>
                   <tr>
                      <th style='width:28%'>Product</th>
                      <th style='width:19%'>Pkg</th>
                      <th style='width:15%'>Qty</th>
                      <th style='width:19%'>Pkg</th>
                      <th style='width:15%'>Qty</th>
                      <th style='width:4%'></th>
                    </tr>
                  <tr>
                    <td>
                      <input type='hidden' name='ip_id[]' value='$ip_id'>
                      <input type='hidden' name='prod_id[]' value='$prod_id'>
                      <input list='products_list' name='product[]' maxlength='50' style='background-color:transparent; border:transparent' class='form-control' readonly required value='$prod'>
                    </td>
                    <td>
                      <input list='packaging_list' name='packaging[]' maxlength='50' style='background-color:transparent; border:transparent' class='form-control' readonly required value='$pack'>
                    </td>
                    <td>
                      <input type='text' maxlength='8' name='quantity[]' id='quan1$i' style='text-align:right; background-color:transparent; border:transparent' required class='form-control num' readonly value='$q'>
                    </td>
                    <td>
                    <input type='hidden' value='$prod_id' name='pq_prod[]'>
                    <input list='packaging_list' id='pk$i' name='packaging_bd[]' maxlength='50' style='background-color:transparent; border:transparent' class='form-control' required placeholder='Please type here...'>
                    </td>
                    <td>
                      <input type='text' maxlength='8' name='quantity_bd[]' id='quanbd1$i' style='text-align:right; background-color:transparent; border:transparent' required class='form-control num' value='0'>
                    </td>
                    <td>
                    <center>
                    <button onclick='copyrow($i, $q, \"". $pack. "\")' type='button' class='btn btn-success btn-sm'><i class='fa fa-pencil'></i></button>
                    </center>
                    </td>
                  </tr>
              ";
              }
              else{
                  echo "
                  <tr>
                      <th style='width:28%'>Product</th>
                      <th style='width:19%'>Pkg</th>
                      <th style='width:15%'>Qty</th>
                      <th style='width:19%'>Pkg</th>
                      <th style='width:15%'>Qty</th>
                      <th style='width:5%'></th>
                    </tr>
                  <tr>
                    <td>
                    <input type='hidden' name='ip_id[]' value='$ip_id'>
                    <input type='hidden' name='prod_id[]' value='$prod_id'>  
                    <input list='products_list' name='product[]' maxlength='50' style='background-color:transparent; border:transparent' class='form-control' readonly value='$prod'>
                    </td>
                    <td>
                      <input list='packaging_list' name='packaging[]' maxlength='50' style='background-color:transparent; border:transparent' class='form-control' readonly value='$pack'>
                    </td>
                    <td>
                      <input type='text' maxlength='8' name='quantity[]' id='quan1$i' style='text-align:right; background-color:transparent; border:transparent' readonly class='form-control num' value='$q'>
                    </td>
                    <td>
                    <input type='hidden' value='$prod_id' name='pq_prod[]'>
                    <input list='packaging_list' id='pk$i' name='packaging_bd[]' maxlength='50' style='background-color:transparent; border:transparent' required class='form-control' placeholder='Please type here...'>
                    </td>
                    <td>
                      <input type='text' maxlength='8' name='quantity_bd[]' id='quanbd1$i' style='text-align:right; background-color:transparent; border:transparent' required class='form-control num' value='0'>
                    </td>
                    <td>
                    <center>
                    <button id='' onclick='copyrow($i, $q, \"". $pack. "\")' type='button' class='btn btn-success btn-sm'><i class='fa fa-pencil'></i></button>
                    </center>
                    </td>
                  </tr>
              ";
              }
              echo "
              </tbody>
                </table>
                </td>
                </tr>
                <tr>
                  <td colspan='5'><button type='button' id='add_row' onclick='add_row1($i, $prod_id)' class='btn btn-success btn-sm' style='float:right; margin-top:2px; margin-right:10px'><i class='fa fa-plus'></i> &nbsp;Add New Row</button></td>
                </tr>
                <br><br>
              ";
          
          $this->bd_ctr = $i;
          $i++;
          }
      }
  } 

  public function show_pack_list(){
    include 'models/connection.php';
        $stmt = $con->prepare('SELECT `Packaging` FROM `tbl_packaging`');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($packaging);
        $pattern = '';
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $pattern .= $packaging.'|';
            }
        }

      return $pattern;
  }
}
?>