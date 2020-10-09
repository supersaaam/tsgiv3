<?php
if (isset($_POST['submit'])) {
  include 'connection.php';
  $con2 = new mysqli($server, $user, $pw, $db);
  $con3 = new mysqli($server, $user, $pw, $db);

  $so      = $_POST['so_num'];
  $cst     = $_POST['customer'];
  $cust    = '%' . $_POST['customer'] . '%';
  $address = $_POST['address'];

  //get ID of cust
  $stmt_cust = $con->prepare('SELECT CustomerID FROM tbl_customers WHERE CompanyName LIKE ?');
  $stmt_cust->bind_param('s', $cust);
  $stmt_cust->execute();
  $stmt_cust->store_result();
  $stmt_cust->bind_result($cust_id);
  $stmt_cust->fetch();
  if ($stmt_cust->num_rows == 0) {
    //not saved in DB
    //not existing -> save to DB
    $add = $con2->prepare('INSERT INTO `tbl_customers`(`CompanyName`, `CompanyAddress`) VALUES (?, ?)');
    $add->bind_param('ss', $cst, $address);
    $add->execute();
    $add->close();

    //get ID
    $id = $con3->prepare('SELECT CustomerID FROM tbl_customers WHERE CompanyName=?');
    $id->bind_param('s', $cst);
    $id->execute();
    $id->store_result();
    $id->bind_result($cust_id);
    $id->fetch();
    $id->close();
  }
  $con->close();
  $con2->close();
  $con3->close();

  $po    = $_POST['po_num'];
  $date  = date('Y-m-d', strtotime($_POST['date']));
  $terms = $_POST['terms'];

  $prod_code = $_POST['prod_code']; //array
  $quantity  = $_POST['quantity'];
  $price     = $_POST['price'];
  $amount    = $_POST['amount'];
  //$testing = $_POST['testing']; //on -> if checked

  $con  = new mysqli($server, $user, $pw, $db);
  $con2 = new mysqli($server, $user, $pw, $db);
  $con3 = new mysqli($server, $user, $pw, $db);
  //get ID if existing
  //add not existing
  $stmt_term = $con->prepare('SELECT Term_ID FROM tbl_terms WHERE DaysLabel=?');
  $stmt_term->bind_param('s', $terms);
  $stmt_term->execute();
  $stmt_term->store_result();
  $stmt_term->bind_result($t_id);
  $stmt_term->fetch();
  if ($stmt_term->num_rows == 0) {
    //not existing -> save to DB
    $add = $con2->prepare('INSERT INTO `tbl_terms` (`DaysLabel`) VALUES (?)');
    $add->bind_param('s', $terms);
    $add->execute();

    //get ID
    $id = $con3->prepare('SELECT Term_ID FROM tbl_terms WHERE DaysLabel=?');
    $id->bind_param('s', $terms);
    $id->execute();
    $id->store_result();
    $id->bind_result($t_id);
    $id->fetch();
  }
  $con2->close();
  $con3->close();
  $con->close();

  $warehouse   = $_POST['origin'];
  $instruction = $_POST['instruction'];
  $totalamt    = str_replace(',', '', $_POST['total_price']);

  $cmo2 = false;
  if ($_POST['cmo2'] != '') {
    //2 cmos
    $totalamt = str_replace(',', '', $amount[0]);
    $cmo2     = true;
  }

  //save to sales_order
  $con    = new mysqli($server, $user, $pw, $db);
  $ins_so = $con->prepare('INSERT INTO `tbl_sales_order`(`SONumber`, `CustomerID`, `Address`, `Terms`, `PONumber`, `DateCreated`, `TotalAmount`, `Balance`, `DeliveryInstructions`, `WarehouseID`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
  $ins_so->bind_param('iisissdsi', $so, $cust_id, $address, $t_id, $po, $date, $totalamt, $totalamt, $instruction, $warehouse);
  $ins_so->execute();
  $con->close();

  $cmo1 = $_POST['cmo1'];

  $con  = new mysqli($server, $user, $pw, $db);
  $con2 = new mysqli($server, $user, $pw, $db);
  $con3 = new mysqli($server, $user, $pw, $db);
  $con4 = new mysqli($server, $user, $pw, $db);
  $con5 = new mysqli($server, $user, $pw, $db);

  //check if CMOs exist
  $stmt_cmo1 = $con->prepare('SELECT CMO_ID FROM tbl_cmo WHERE FullName=?');
  $stmt_cmo1->bind_param('s', $cmo1);
  $stmt_cmo1->execute();
  $stmt_cmo1->store_result();
  $stmt_cmo1->bind_result($cmo_id);
  $stmt_cmo1->fetch();
  if ($stmt_cmo1->num_rows == 0) {
    //not existing -> save to DB
    $add = $con2->prepare('INSERT INTO `tbl_cmo` (`FullName`) VALUES (?)');
    $add->bind_param('s', $cmo1);
    $add->execute();
    $add->close();

    //get ID
    $id = $con3->prepare('SELECT CMO_ID FROM tbl_cmo WHERE FullName=?');
    $id->bind_param('s', $cmo1);
    $id->execute();
    $id->store_result();
    $id->bind_result($cmo_id);
    $id->fetch();
    $id->close();
  }

  //check if existing in cmo_cust
  $chk_cmocust = $con4->prepare('SELECT CMO_ID FROM tbl_cmo_cust WHERE CMO_ID=? AND CustomerID=?');
  $chk_cmocust->bind_param('ii', $cmo_id, $cust_id);
  $chk_cmocust->execute();
  $chk_cmocust->store_result();
  $chk_cmocust->bind_result($x);
  $chk_cmocust->fetch();
  if ($chk_cmocust->num_rows == 0) {
    //not existing -> save to DB
    $add = $con5->prepare('INSERT INTO `tbl_cmo_cust` (`CMO_ID`, CustomerID) VALUES (?, ?)');
    $add->bind_param('ii', $cmo_id, $cust_id);
    $add->execute();
    $add->close();
  }

  $con->close();
  $con2->close();
  $con3->close();
  $con4->close();
  $con5->close();

  $share1 = $_POST['share1'];

  $con     = new mysqli($server, $user, $pw, $db);
  $ins_cmo = $con->prepare('INSERT INTO `tbl_so_cmo`(`SONumber`, `CMO_Name`, `Share`) VALUES (?, ?, ?)');
  $ins_cmo->bind_param('isi', $so, $cmo1, $share1);
  $ins_cmo->execute();
  $con->close();

  //if 2 cmo
  if ($_POST['cmo2'] != '') {
    //save to so_cmo
    $cmo2 = $_POST['cmo2'];

    $con  = new mysqli($server, $user, $pw, $db);
    $con2 = new mysqli($server, $user, $pw, $db);
    $con3 = new mysqli($server, $user, $pw, $db);
    $con4 = new mysqli($server, $user, $pw, $db);
    $con5 = new mysqli($server, $user, $pw, $db);

    //check if CMOs exist
    $stmt_cmo2 = $con->prepare('SELECT CMO_ID FROM tbl_cmo WHERE FullName=?');
    $stmt_cmo2->bind_param('s', $cmo2);
    $stmt_cmo2->execute();
    $stmt_cmo2->store_result();
    $stmt_cmo2->bind_result($cmo_id2);
    $stmt_cmo2->fetch();
    if ($stmt_cmo2->num_rows == 0) {
      //not existing -> save to DB
      $add = $con2->prepare('INSERT INTO `tbl_cmo` (`FullName`) VALUES (?)');
      $add->bind_param('s', $cmo2);
      $add->execute();
      $add->close();

      //get ID
      $id = $con3->prepare('SELECT CMO_ID FROM tbl_cmo WHERE FullName=?');
      $id->bind_param('s', $cmo2);
      $id->execute();
      $id->store_result();
      $id->bind_result($cmo_id2);
      $id->fetch();
      $id->close();
    }

    //check if existing in cmo_cust
    $chk_cmocust2 = $con4->prepare('SELECT CMO_ID FROM tbl_cmo_cust WHERE CMO_ID=? AND CustomerID=?');
    $chk_cmocust2->bind_param('ii', $cmo_id2, $cust_id);
    $chk_cmocust2->execute();
    $chk_cmocust2->store_result();
    $chk_cmocust2->bind_result($x);
    $chk_cmocust2->fetch();
    if ($chk_cmocust2->num_rows == 0) {
      //not existing -> save to DB
      $add = $con5->prepare('INSERT INTO `tbl_cmo_cust` (`CMO_ID`, CustomerID) VALUES (?, ?)');
      $add->bind_param('ii', $cmo_id2, $cust_id);
      $add->execute();
      $add->close();
    }

    $con->close();
    $con2->close();
    $con3->close();
    $con4->close();
    $con5->close();

    $share2 = $_POST['share2'];

    $con      = new mysqli($server, $user, $pw, $db);
    $ins_cmo1 = $con->prepare('INSERT INTO `tbl_so_cmo`(`SONumber`, `CMO_Name`, `Share`) VALUES (?, ?, ?)');
    $ins_cmo1->bind_param('isi', $so, $cmo2, $share2);
    $ins_cmo1->execute();
    $con->close();
  }

  $i = 1;
  foreach ($prod_code as $key => $code) {
    if (
      $code != NULL &&
      $quantity[$key] != NULL &&
      $price[$key] != NULL &&
      $amount[$key] != NULL
    ) {
      //check if all values are not null
      if ($cmo2 && $i > 1) {
        //2 cmos -> only the first line should be saved
        break;
      }
      //save to so_product
      //for testing //YES in for_testing col -> so_product
      if (isset($_POST['testing'][$key])) {
        $remarks = 'for testing';
      } else {
        $remarks = null;
      }

      $con     = new mysqli($server, $user, $pw, $db);
      $ins_sop = $con->prepare('INSERT INTO `tbl_so_product`(`SO_ID`, `ProductCode`, `Quantity`, `Price`, `Amount`, `Remarks`) VALUES (?, ?, ?, ?, ?, ?)');

      $q = $quantity[$key];
      $a = str_replace(',', '', $amount[$key]);
      $p = $price[$key];

      $ins_sop->bind_param('isidds', $so, $code, $q, $p, $a, $remarks);
      $ins_sop->execute();
      $con->close();

      //deduct to stocks in selected depot
      $con = new mysqli($server, $user, $pw, $db);
      $ded = $con->prepare('UPDATE `tbl_product_depot` SET `CurrentStock`=CurrentStock-? WHERE `WarehouseID`=? AND `ProductCode`=?');
      $ded->bind_param('iis', $q, $warehouse, $code);
      $ded->execute();
      $con->close();
    }
    $i++;
  }

  header('location:../sales?success');
} elseif (isset($_GET['verify'])) {
  $id = $_GET['verify'];

  //update verified status as YES
  include 'connection.php';

  $stmt    = $con->prepare('UPDATE `tbl_sales_order` SET `VerifiedStatus`=?, Remarks=? WHERE `SONumber`=?');
  $stat    = 'YES';
  $remarks = 'No balance...';
  $stmt->bind_param('ssi', $stat, $remarks, $id);
  if ($stmt->execute()) {
    header('location: ../so_records?success');
  }
} elseif (isset($_GET['approve'])) {
  $id = $_GET['approve'];

  //update verified status as YES
  include 'connection.php';

  $stmt = $con->prepare('UPDATE `tbl_sales_order` SET `NotedStatus`=? WHERE `SONumber`=?');
  $stat = 'YES';
  $stmt->bind_param('si', $stat, $id);
  if ($stmt->execute()) {
    header('location: ../accounting?success');
  }
} elseif (isset($_POST['disapprove'])) {
  $id = $_GET['id'];
  $r  = $_POST['reason'];

  //update verified status as YES
  include 'connection.php';

  $stmt = $con->prepare('UPDATE `tbl_sales_order` SET `NotedStatus`=?, Reason=? WHERE `SONumber`=?');
  $stat = 'DISAPPROVED';
  $stmt->bind_param('ssi', $stat, $r, $id);
  if ($stmt->execute()) {
    header('location: ../accounting?disapproved');
  }
} elseif (isset($_GET['no_ded'])) {
  $id = $_GET['no_ded'];

  //update deducted status as YES
  include 'connection.php';

  $stmt = $con->prepare('UPDATE `tbl_sales_order` SET `DeductedStatus`=?, Balance=TotalAmount WHERE `SONumber`=?');
  $stat = 'YES';
  $stmt->bind_param('si', $stat, $id);
  $stmt->execute();
  $stmt->close();
  $con->close();

  //get cust id and rem bal
  $con   = new mysqli($server, $user, $pw, $db);
  $stmtx = $con->prepare('SELECT Balance, CustomerID FROM tbl_sales_order WHERE SONumber=?');
  $stmtx->bind_param('i', $id);
  $stmtx->execute();
  $stmtx->store_result();
  $stmtx->bind_result($bal, $custid);
  $stmtx->fetch();
  $stmtx->close();
  $con->close();

  //update cust table
  $con   = new mysqli($server, $user, $pw, $db);
  $stmty = $con->prepare('UPDATE `tbl_customers` SET `RemainingBalance`=RemainingBalance+? WHERE `CustomerID`=?');
  $stmty->bind_param('di', $bal, $custid);
  $stmty->execute();
  $stmty->close();
  $con->close();

  header('location: ../so_records?deducted');
} elseif (isset($_POST['deduction'])) {
  $desc = $_POST['desc'];
  $amt  = $_POST['amount'];
  $so   = $_POST['sonum'];
  $ded  = str_replace(',', '', $_POST['total']);

  foreach ($desc as $key => $d) {
    include 'connection.php';

    if ($d != NULL &&
      $amt[$key] != NULL) {

      $a = $amt[$key];

      //save deductions
      $stmt = $con->prepare('INSERT INTO `tbl_so_deductions`(`SO_ID`, `Description`, `Amount`) VALUES (?, ?, ?)');
      $stmt->bind_param('isd', $so, $d, $a);
      $stmt->execute();
      $stmt->close();
      $con->close();
    }
  }

  include 'connection.php';

  $stmtx = $con->prepare('UPDATE `tbl_sales_order` SET `DeductedStatus`=?, DeductedAmount=?, Balance=TotalAmount-DeductedAmount WHERE `SONumber`=?');
  $stat  = 'YES';
  $stmtx->bind_param('sdi', $stat, $ded, $so);
  $stmtx->execute();

  //get cust id and rem bal
  $con   = new mysqli($server, $user, $pw, $db);
  $stmty = $con->prepare('SELECT Balance, CustomerID FROM tbl_sales_order WHERE SONumber=?');
  $stmty->bind_param('i', $so);
  $stmty->execute();
  $stmty->store_result();
  $stmty->bind_result($bal, $custid);
  $stmty->fetch();
  $stmty->close();
  $con->close();

  //update cust table
  $con   = new mysqli($server, $user, $pw, $db);
  $stmtz = $con->prepare('UPDATE `tbl_customers` SET `RemainingBalance`=RemainingBalance+? WHERE `CustomerID`=?');
  $stmtz->bind_param('di', $bal, $custid);
  $stmtz->execute();
  $stmtz->close();
  $con->close();

  header('location: ../so_records?deductions');
} elseif (isset($_POST['remarks'])) {
  $so      = $_POST['so'];
  $remarks = $_POST['remarks_'];
  $stat    = 'YES';

  include 'connection.php';

  //update verified status and remarks
  $stmt = $con->prepare('UPDATE `tbl_sales_order` SET `VerifiedStatus`=?,`Remarks`=? WHERE `SONumber`=?');
  $stmt->bind_param('ssi', $stat, $remarks, $so);
  if ($stmt->execute()) {
    header('location: ../so_records?remarks');
  }
} elseif (isset($_POST['save_dr'])) {
  include 'connection.php';

  $so   = $_GET['so'];
  $dr   = $_POST['dr'];
  $date = $_POST['date'];

  $stmt = $con->prepare('UPDATE `tbl_sales_order` SET `DR_Number`=?, DR_Date=? WHERE `SONumber`=?');
  $stmt->bind_param('ssi', $dr, $date, $so);
  if ($stmt->execute()) {
    header('location: ../approved_records?dr');
  }
} elseif (isset($_POST['save_si'])) {
  include 'connection.php';

  $so   = $_GET['so'];
  $si   = $_POST['si'];
  $date = $_POST['date'];

  $stmt = $con->prepare('UPDATE `tbl_sales_order` SET `SI_Number`=?, SI_Date=?, Balance=TotalAmount WHERE `SONumber`=?');
  $stmt->bind_param('ssi', $si, $date, $so);
  $stmt->execute();
  $con->close();

  //get cust id and rem bal
  $con   = new mysqli($server, $user, $pw, $db);
  $stmty = $con->prepare('SELECT Balance, CustomerID FROM tbl_sales_order WHERE SONumber=?');
  $stmty->bind_param('i', $so);
  $stmty->execute();
  $stmty->store_result();
  $stmty->bind_result($bal, $custid);
  $stmty->fetch();
  $stmty->close();
  $con->close();

  //update cust table
  $con   = new mysqli($server, $user, $pw, $db);
  $stmtz = $con->prepare('UPDATE `tbl_customers` SET `RemainingBalance`=RemainingBalance+? WHERE `CustomerID`=?');
  $stmtz->bind_param('di', $bal, $custid);
  $stmtz->execute();
  $stmtz->close();
  $con->close();

  header('location: ../approved_records?si');
} elseif (isset($_POST['save_drc'])) {
  include 'connection.php';

  $dr   = $_GET['dr'];
  $date = $_POST['date'];

  $stmt = $con->prepare('UPDATE `tbl_sales_order` SET `DR_Countered`=? WHERE `DR_Number`=?');
  $stmt->bind_param('ss', $date, $dr);
  if ($stmt->execute()) {
    header('location: ../sidr_records?drc');
  }
} elseif (isset($_POST['save_sid'])) {
  include 'connection.php';

  $si_date = $_GET['si_date'];
  $date    = $_POST['date'];

  $stmt = $con->prepare('UPDATE `tbl_sales_order` SET `SI_Returned_Date`=? WHERE `SI_Number`=?');
  $stmt->bind_param('ss', $date, $si_date);
  if ($stmt->execute()) {
    header('location: ../sidr_records?sid');
  }
} elseif (isset($_POST['save_drd'])) {
  include 'connection.php';

  $dr_date = $_GET['dr_date'];
  $date    = $_POST['date'];

  $stmt = $con->prepare('UPDATE `tbl_sales_order` SET `DR_Returned_Date`=? WHERE `DR_Number`=?');
  $stmt->bind_param('ss', $date, $dr_date);
  if ($stmt->execute()) {
    header('location: ../sidr_records?drd');
  }
} elseif (isset($_POST['update_so'])) {
  $so      = $_POST['sonumber'];
  $si      = $_POST['si_number'];
  $si_date = $_POST['si_date'];
  $dr      = $_POST['dr_number'];
  $dr_date = $_POST['dr_date'];
  $bir     = $_POST['bir'];

  include 'connection.php';

  $stmt = $con->prepare('UPDATE `tbl_sales_order` SET `SI_Number`=?, `DR_Number`=?, `SI_Date`=?, `DR_Date`=?, BIRType=? WHERE `SONumber`=?');
  $stmt->bind_param('sssssi', $si, $dr, $si_date, $dr_date, $bir, $so);
  if ($stmt->execute()) {
    header('location: ../approved_records?saved_changes');
  }
}
elseif(isset($_POST['resend'])){
  $so = $_POST['so'];
  $r = $_POST['reason'];

  include 'connection.php';

  $stmt = $con->prepare('UPDATE `tbl_sales_order` SET `VerifiedStatus`="YES",`Remarks`=?,`NotedStatus`="NO" WHERE `SONumber`=?');
  $stmt->bind_param('si', $r, $so);
  if($stmt->execute()){
    header('location: ../disapproved_records?resent');
  }
}
elseif(isset($_GET['clear'])){
  $pid = $_GET['clear'];

  include 'connection.php';

  //get customerID, SONumber, Amount
  $stmt = $con->prepare('SELECT p.`SONumber`, `AmountReceived`, so.CustomerID FROM `tbl_payment` p JOIN tbl_sales_order so ON p.SONumber=so.SONumber WHERE PaymentID=?');
  $stmt->bind_param('i', $pid);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($so, $amt, $cid);
  $stmt->fetch();
  $stmt->close();
  $con->close();

  //deduct customer balance
  $con = new mysqli($server, $user, $pw, $db);
  $stmt = $con->prepare('UPDATE `tbl_customers` SET `RemainingBalance`=RemainingBalance-? WHERE CustomerID=?');
  $stmt->bind_param('di', $amt, $cid);
  $stmt->execute();
  $stmt->close();
  $con->close();

  //deduct so balance
  $con = new mysqli($server, $user, $pw, $db);
  $stmt = $con->prepare('UPDATE `tbl_sales_order` SET `Balance`=Balance-? WHERE `SONumber`=?');
  $stmt->bind_param('di', $amt, $so);
  $stmt->execute();
  $stmt->close();
  $con->close();

  $con = new mysqli($server, $user, $pw, $db);
  $stmt = $con->prepare('UPDATE `tbl_payment` SET Cleared="YES" WHERE `PaymentID`=?');
  $stmt->bind_param('i', $pid);
  $stmt->execute();
  $stmt->close();
  $con->close();

  header('location: ../payments?cleared');
}
?>
