<script>
// window.print();
// window.onfocus=function(){ window.close();}
</script>

<?php
include 'models/connection.php';
include 'css.php';

$warehouse = $_GET['warehouse'] ?? null;
$prodcode  = $_GET['prodcode'] ?? null;
$date      = $_GET['date'] ? explode(' - ', $_GET['date']) : null;

if ($date) {
  $timestamp[0] = strtotime($date[0]);
  $timestamp[1] = strtotime($date[1]);
}
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
if ($date) {
  $filter[] = '<small>From: ' . date('F d, Y', $timestamp[0]) . ' To: ' . date('F d, Y', $timestamp[1]) . '</small>';
}

echo join('<br>', $filter);
?>
                </center>
                <br>

                <table id="example2" class="table table-bordered table-striped">
                    <!-- table-bordered table-striped-->
                  <thead>
                    <tr>
                      <th style='text-align:center; vertical-align:middle'>STF#</th>
<?php
if ($warehouse):
?>
                      <th d style='text-align:center; vertical-align:middle'>Product Code</th>
<?php
elseif ($prodcode):
?>
                      <th d style='text-align:center; vertical-align:middle'>Origin</th>
<?php
else:
?>
                      <th d style='text-align:center; vertical-align:middle'>Product Code</th>
                      <th align="center">Origin</th>
<?php endif;?>
                      <th style='text-align:center; vertical-align:middle'>Destination</th>
                      <th style='text-align:center; vertical-align:middle'>Qty</th>
                      <th style='text-align:center'>Transfer Date</center></th>
                    </tr>
                  </thead>
                  <tbody>
<?php
$result = $con->query('SELECT * FROM tbl_transfer JOIN tbl_transferred_prod ON tbl_transfer.TransferID=tbl_transferred_prod.TransferID');
while ($row = $result->fetch_assoc()) {
  $fromWarehouse   = getWarehouseName($row['FromWarehouse']);
  $currentProdcode = $row['ProductCode'];
  $transferDate    = strtotime($row['TransferDate']);

  if ($date && !($transferDate >= $timestamp[0] && $transferDate <= $timestamp[1])) {
    continue;
  } else if ($warehouse && $fromWarehouse != $warehouse) {
    continue;
  } else if ($prodcode && $prodcode != $currentProdcode) {
    continue;
  }
  ?>
                    <tr>
                      <td align="right"><?php echo $row['TransferID']; ?></td>
<?php
if ($warehouse):
  ?>
                      <td align="center"><?php echo $row['ProductCode']; ?></td>
<?php
elseif ($prodcode):
  ?>
                      <td align="center"><?php echo getWarehouseName($row['FromWarehouse']); ?></td>
<?php
else:
  ?>
                      <td align="center"><?php echo $row['ProductCode']; ?></td>
                      <td align="center"><?php echo getWarehouseName($row['FromWarehouse']); ?></td>
<?php endif;?>
                      <td align="center"><?php echo getWarehouseName($row['ToWarehouse']); ?></td>
                      <td align="right"><?php echo $row['Quantity']; ?></td>
                      <td align="center"><?php echo date('F d, Y', $transferDate); ?></td>
                    </tr>
<?php
}
?>
                  </tbody>
                </table>


</body>

<?php
include 'js.php';
?>

<?php
/**
 * @param $id
 * @return mixed
 */
function getWarehouseName($id) {
  global $con;
  return $con->query("SELECT WarehouseName FROM tbl_warehouse WHERE WarehouseID='{$id}'")->fetch_assoc()['WarehouseName'];
}
?>
