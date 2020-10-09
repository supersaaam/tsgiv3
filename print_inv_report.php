<script>
// window.print();
// window.onfocus=function(){ window.close();}
</script>

<?php
include 'models/connection.php';
include 'css.php';

$warehouse = $_GET['warehouse'] ?? null;
$prodcode  = $_GET['prodcode'] ?? null;
$month_year = $_GET['month_year'] ?? null;
?>

<body>
                <center>
                  <h1>Inventory Report</h1>
<?php
$filter = [];

if ($warehouse) {
  $filter[] = '<small>Warehouse: ' . $warehouse . '</small>';
}
if ($prodcode) {
  $filter[] = '<small>Product Code: ' . $prodcode . '</small>';
}
if ($month_year) {
  $filter[] = '<small>For: '. $month_year .'</small>';
}

echo join('<br>', $filter);
?>
                </center>
                <br>

                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style='width: 33%'></th>
                            <th style='width: 33%'>Added</th>
                            <th style='width: 34%'>Deducted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            getBeginningInv($warehouse, $prodcode, $month_year);
                            getImportation($prodcode, $month_year);
                            getTransferAdded($warehouse, $prodcode, $month_year);
                            getTransferDeducted($warehouse, $prodcode, $month_year);
                            getSOs($warehouse, $prodcode, $month_year);
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan='2' style='text-align: right'><b>Total</b></td>
                            <td id='total'></td>
                        </tr>
                    </tfoot>
                </table>
</body>

<?php
include 'js.php';

function getBeginningInv($wh, $prodcode, $asof){
    include 'models/connection.php';

    $stmt = $con->prepare('SELECT `CurrentStock` FROM `tbl_actual_prod_beg_inv` ap JOIN tbl_warehouse w ON w.WarehouseID=ap.WarehouseID WHERE w.WarehouseName=? AND ProductCode=? AND AsOfMonth=?');
    $stmt->bind_param('sss', $wh, $prodcode, $asof);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($stock);
    if($stmt->num_rows > 0){
        while($stmt->fetch()){
            echo "
            <tr>
                <td>Beginning Inventory</td>
                <td class='add'>$stock</td>
                <td></td>
            </tr>
            ";
        }
    }
}

function getImportation($prodcode, $month_year){
    include 'models/connection.php';

    //

    $month_year = date_format(date_create($month_year), "Y-m-d");
    $month_year_lastDay = date_format(date_create($month_year), "Y-m-t");
    $stmt = $con->prepare('SELECT SUM(ib.`Quantity`) FROM `tbl_imp_breakdown` ib JOIN tbl_imp_product ip ON ip.ImpProd_ID=ib.Imp_ProdID JOIN tbl_importation i ON i.ProformaInvNo=ip.ProformaInvNo WHERE ib.ProductCode=? AND i.DeliveredDate BETWEEN ? AND ?');
    $stmt->bind_param('sss', $prodcode, $month_year, $month_year_lastDay);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($stock);
    if($stmt->num_rows > 0){
        while($stmt->fetch()){
            if ($stock == null){
                $stock = 0;
            }

            echo "
            <tr>
                <td>Importation</td>
                <td class='add'>$stock</td>
                <td></td>
            </tr>
            ";
        }
    }
}

function  getTransferAdded($wh, $prodcode, $month_year){
    include 'models/connection.php';
    
    $month_year = date_format(date_create($month_year), "Y-m-d");
    $month_year_lastDay = date_format(date_create($month_year), "Y-m-t");
    
    $stmt = $con->prepare('SELECT `Quantity`-`QuantityRem` as Q, t.TransferID, t.FromWarehouse, t.ToWarehouse FROM `tbl_transferred_prod` tp JOIN tbl_transfer t ON t.TransferID=tp.TransferID WHERE (t.TransferDate BETWEEN ? AND ?) AND t.ToWarehouse=? AND tp.ProductCode =?');
    $stmt->bind_param('ssis', $month_year, $month_year_lastDay, $wh, $prodcode);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($stock, $tid, $from, $to);
    if($stmt->num_rows > 0){
        while($stmt->fetch()){
            $tid = sprintf('%06d', $tid);
            echo "
            <tr>
                <td>TOS #$tid ("; 
                
                echo getWarehouseName($from);
                echo "-";
                echo getWarehouseName($to);

                echo ")</td>
                <td class='add'>$stock</td>
                <td></td>
            </tr>
            ";
        }
    }   
}

function  getTransferDeducted($wh, $prodcode, $month_year){
    include 'models/connection.php';
    
    $month_year = date_format(date_create($month_year), "Y-m-d");
    $month_year_lastDay = date_format(date_create($month_year), "Y-m-t");
    
    $stmt = $con->prepare('SELECT `Quantity`-`QuantityRem` as Q, t.TransferID, t.FromWarehouse, t.ToWarehouse FROM `tbl_transferred_prod` tp JOIN tbl_transfer t ON t.TransferID=tp.TransferID WHERE (t.TransferDate BETWEEN ? AND ?) AND t.FromWarehouse=? AND tp.ProductCode =?');
    $stmt->bind_param('ssis', $month_year, $month_year_lastDay, $wh, $prodcode);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($stock, $tid, $from, $to);
    if($stmt->num_rows > 0){
        while($stmt->fetch()){
            $tid = sprintf('%06d', $tid);
            echo "
            <tr>
                <td>TOS #$tid ("; 
                
                echo getWarehouseName($from);
                echo "-";
                echo getWarehouseName($to);

                echo ")</td>
                <td></td>
                <td class='diff'>$stock</td>
            </tr>
            ";
        }
    }   
}

function getSOs($warehouse, $prodcode, $month_year){
    include 'models/connection.php';
    
    $month_year = date_format(date_create($month_year), "Y-m-d");
    $month_year_lastDay = date_format(date_create($month_year), "Y-m-t");
    
    $stmt = $con->prepare('SELECT `Quantity`, so.DR_Number, c.CompanyName FROM `tbl_so_product` sop JOIN tbl_sales_order so ON so.SONumber=sop.SO_ID JOIN tbl_customers c ON c.CustomerID=so.CustomerID WHERE so.WarehouseID=? AND (so.DR_Date BETWEEN ? AND ?) AND sop.ProductCode = ?');
    $stmt->bind_param('isss', $wh, $month_year, $month_year_lastDay, $prodcode);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($stock, $dr, $company);
    if($stmt->num_rows > 0){
        while($stmt->fetch()){
                $company = strtoupper($company);
                $words = preg_split("/\s+/", str_replace('"', "", $company));

                $acronym = "";
                foreach ($words as $w) {
                    $acronym .= $w[0];
                }

            echo "
            <tr>
                <td>DR #$dr $acronym</td>
                <td></td>
                <td class='diff'>$stock</td>
            </tr>
            ";
        }
    }    
}

function getWarehouseName($id) {
    global $con;
    return $con->query("SELECT WarehouseName FROM tbl_warehouse WHERE WarehouseID='{$id}'")->fetch_assoc()['WarehouseName'];
  }
?>

<script>
var sum = 0;
var diff = 0;
$('.add').each(function(){
    sum += parseFloat($(this).html());  // Or this.innerHTML, this.innerText
});

$('.diff').each(function(){
    diff += parseFloat($(this).html());  // Or this.innerHTML, this.innerText
});

var total = sum - diff;
$("#total").html(total);
</script>

