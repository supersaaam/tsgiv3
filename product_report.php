<script>
    window.print();
</script>

<?php
include 'models/connection.php';
include 'css.php';

$supplier = $_POST['supplier'];
?>

<body>
                <center>
                  <h1>Inventory Report</h1>
<?php
$filter   = [];
$filter[] = '<h3>Supplier: ' . $supplier . '</h3>';

echo join('<br>', $filter);
?>
                </center>
                <br>

                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style='width: 15%'>Brand</th>
                            <th style='width: 20%'>Part Number</th>
                            <th style='width: 25%'>Description</th>
                            <th style='width: 10%'>Min</th>
                            <th style='width: 10%'>Max</th>
                            <th style='width: 10%'>Price</th>
                            <th style='width: 10%'>Current Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        
<?php

include 'models/connection.php';
$stmt     = $con->prepare('SELECT `ProductID`, s.CompanyName, `PartNumber`, `ProductDescription`, `Price`, `MinLevel`, `MaxLevel`, `CurrentStock` FROM `tbl_tsgi_product` p JOIN tbl_supplier s ON s.SupplierID=p.SupplierID WHERE Indent="NO" AND CurrentStock > 0 AND CompanyName LIKE ? ORDER BY s.CompanyName ASC');

$s = $supplier;
$supplier = '%' . $supplier . '%';
$stmt->bind_param('s', $supplier);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($pid, $brand, $pnum, $desc, $price, $min, $max, $stock);
if ($stmt->num_rows > 0) {
    
    $total_stocks = 0;
    
  while ($stmt->fetch()) {
 
    $price = number_format($price, 2);
    echo "
                                <tr>
                                    <td>$s</td>
                                    <td>$pnum</td>
                                    <td>$desc</td>
                                    <td>$min</td>
                                    <td>$max</td>
                                    <td>$price</td>
                                    <td>$stock</td>
                                </tr>
                                ";
                                
                                $total_stocks += $stock;
  }
}
?>
                    </tbody>
                    <tfoot>
                        <th colspan='6' style='text-align: right'>Total Stocks:</th>
                        <th><?php echo $total_stocks; ?></th>
                    </tfoot>
                </table>
</body>

<?php
include 'js.php';
?>
