<script>
window.print();
window.onfocus=function(){ window.close();}
</script>

<?php
include 'css.php';
include 'models/actual_prod_model.php';

$filter = $_POST['filter'];

if($filter == 'all'){
    $sql = "SELECT WarehouseName, ap.ProductCode, CurrentStock, CriticalLevel FROM tbl_product_depot pd JOIN tbl_warehouse w ON w.WarehouseID=pd.WarehouseID JOIN tbl_actual_product ap ON ap.ProductCode=pd.ProductCode";
}
else{
    $col = $_POST['column'];
    $value = $_POST['value'];

    if($col == 'Warehouse'){
        $sql = "SELECT WarehouseName, ap.ProductCode, CurrentStock, CriticalLevel FROM tbl_product_depot pd JOIN tbl_warehouse w ON w.WarehouseID=pd.WarehouseID JOIN tbl_actual_product ap ON ap.ProductCode=pd.ProductCode WHERE WarehouseName='$value'";
    }
    elseif($col == 'Product Code'){
        $sql = "SELECT WarehouseName, ap.ProductCode, CurrentStock, CriticalLevel FROM tbl_product_depot pd JOIN tbl_warehouse w ON w.WarehouseID=pd.WarehouseID JOIN tbl_actual_product ap ON ap.ProductCode=pd.ProductCode WHERE ap.ProductCode='$value'";
    }
    else{
        $sql = "SELECT WarehouseName, ap.ProductCode, CurrentStock, CriticalLevel FROM tbl_product_depot pd JOIN tbl_warehouse w ON w.WarehouseID=pd.WarehouseID JOIN tbl_actual_product ap ON ap.ProductCode=pd.ProductCode WHERE ap.CriticalLevel > pd.CurrentStock";
    }
}

$ap = new Actual_Prod();
?>

<body>
                <center><h1>Inventory Report</h1></center>
                <br>

                <table id="example2" class="table table-bordered table-striped">
                    <!-- table-bordered table-striped-->
                  <thead>
                    <tr>
                      <th style='width:20%; text-align:center; vertical-align:middle'>Warehouse</th>
                      <th style='width:50%; text-align:center; vertical-align:middle'>Product Code</th>
                      <th  style='width:15%; text-align:center; vertical-align:middle'>Current Stock</th>
                      <th  style='width:15%'><center>Critical Level</center></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $ap->show_query($sql);
                  ?>
                  </tbody>
                </table>

                
</body>

<?php
include 'js.php';
?>
