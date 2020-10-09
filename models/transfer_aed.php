<?php
include 'connection.php';

if (isset($_POST['submit'])) {
  $orig = $_POST['origin'];
  $dest = $_POST['destination'];
  $line = $_POST['shipline'];

  $prod_code = $_POST['prod_code']; //array
  $qty       = $_POST['quantity'];

  $date = $_POST['date'];

  //save to trans tbl
  $rec = $con->prepare('INSERT INTO `tbl_transfer`(`TransferDate`, `FromWarehouse`, `ToWarehouse`, ShippingLine) VALUES (?,?,?,?)');
  $rec->bind_param('siis', $date, $orig, $dest, $line);
  $rec->execute();
  $con->close();

  foreach ($prod_code as $key => $code) {
    if (
      $code != NULL &&
      $qty[$key] != NULL
    ) {
      $q = $qty[$key];

      //subtract from origin
      $con  = new mysqli($server, $user, $pw, $db);
      $stmt = $con->prepare('UPDATE `tbl_product_depot` SET `CurrentStock`=CurrentStock - ? WHERE `WarehouseID`=? AND `ProductCode`=?');
      $stmt->bind_param('iis', $q, $orig, $code);
      $stmt->execute();
      $stmt->close();
      $con->close();

      //to destination:
      $con  = new mysqli($server, $user, $pw, $db);
      $con1 = new mysqli($server, $user, $pw, $db);

      //check if prod code exists in the destination
      $destx = $con->prepare('SELECT `ProdDepot_ID` FROM `tbl_product_depot` WHERE `WarehouseID`=? AND `ProductCode`=?');
      $destx->bind_param('is', $dest, $code);
      $destx->execute();
      $destx->store_result();
      $destx->bind_result($pd_id);
      $destx->fetch();
      if ($destx->num_rows == 0) {
        //not existing
        $ins = $con1->prepare('INSERT INTO `tbl_product_depot`(`WarehouseID`, `ProductCode`, `CurrentStock`) VALUES (?, ?, ?)');
        $ins->bind_param('isi', $dest, $code, $q);
        $ins->execute();
      } else {
        //existing
        $upd = $con1->prepare('UPDATE `tbl_product_depot` SET `CurrentStock`=CurrentStock+? WHERE `ProdDepot_ID`=?');
        $upd->bind_param('ii', $q, $pd_id);
        $upd->execute();
      }

      $con->close();
      $con1->close();

      //get transfer_id
      $con   = new mysqli($server, $user, $pw, $db);
      $getID = $con->prepare('SELECT `TransferID` FROM `tbl_transfer` ORDER BY TransferID DESC');
      $getID->execute();
      $getID->store_result();
      $getID->bind_result($tid);
      $getID->fetch();
      $con->close();

      //save to trans_prod tbl
      $con    = new mysqli($server, $user, $pw, $db);
      $ins_tp = $con->prepare('INSERT INTO `tbl_transferred_prod`(`TransferID`, `ProductCode`, `Quantity`) VALUES (?, ?, ?)');
      $ins_tp->bind_param('isi', $tid, $code, $q);
      $ins_tp->execute();
    }
  }

  header('location: ../inv_transfer?transferred&id=' . $tid);
} elseif (isset($_GET['id_clear'])) {
  $id = $_GET['id_clear'];

  $stmt = $con->prepare('UPDATE `tbl_transfer` SET `Remarks`=? WHERE `TransferID`=?');
  $r    = 'YES';
  $stmt->bind_param('si', $r, $id);
  $stmt->execute();
  header('location: ../inv_transfer?remarks');
} elseif (isset($_POST['save_rem'])) {
  $id     = $_GET['id_rem'];
  $rem    = $_POST['rem']; //array
  $qrem   = $_POST['q'];
  $action = $_POST['action'];
  $tpid   = $_POST['tpid'];

  //update transfer_tbl remarks to YES
  $stmt = $con->prepare('UPDATE `tbl_transfer` SET `Remarks`=? WHERE `TransferID`=?');
  $rx   = 'YES';
  $stmt->bind_param('si', $rx, $id);
  $stmt->execute();
  $stmt->close();
  $con->close();

  foreach ($rem as $k => $r) {
    if ($r != null &&
      $qrem[$k] != null &&
      $action[$k] != null &&
      $tpid[$k] != null) {

      $a = $action[$k];
      $q = $qrem[$k];
      $t = $tpid[$k];

      //update transferred_prod_tbl
      include 'connection.php';
      $stmt = $con->prepare('UPDATE `tbl_transferred_prod` SET `Remarks`=?,`Action`=?,`QuantityRem`=? WHERE `TP_ID`=?');
      $stmt->bind_param('ssii', $r, $a, $q, $t);
      $stmt->execute();
      $stmt->close();
      $con->close();

      //if action is Returned to inventory -> update inventory
      if ($a == 'Returned to Inventory') {
        //get product code and warehouse
        include 'connection.php';
        $stmt = $con->prepare('SELECT `ProductCode`, t.FromWarehouse, t.ToWarehouse FROM `tbl_transferred_prod` tp JOIN tbl_transfer t ON tp.TransferID=t.TransferID WHERE TP_ID=?');
        $stmt->bind_param('i', $t);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($code, $whid, $to_whid);
        $stmt->fetch();
        $stmt->close();
        $con->close();

        //then update stock from inventory_warehouse tbl
        include 'connection.php';
        $stmt = $con->prepare('UPDATE `tbl_product_depot` SET `CurrentStock`=CurrentStock+? WHERE `WarehouseID`=? AND `ProductCode`=?');
        $stmt->bind_param('iis', $q, $whid, $code);
        $stmt->execute();
        $stmt->close();
        $con->close();

        //then update stock from inventory_warehouse tbl
        include 'connection.php';
        $stmt = $con->prepare('UPDATE `tbl_product_depot` SET `CurrentStock`=CurrentStock-? WHERE `WarehouseID`=? AND `ProductCode`=?');
        $stmt->bind_param('iis', $q, $to_whid, $code);
        $stmt->execute();
        $stmt->close();
        $con->close();
      }
    }
  }

  header('location: ../inv_transfer?remarks');
}
?>
