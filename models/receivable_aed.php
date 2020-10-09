<?php
include 'connection.php';

if(isset($_POST['save'])){
    $customer= $_POST['customer'];
    $si_date = $_POST['si_date'];
    $si_number = $_POST['si_number'];
    $gross = $_POST['gross'];
    
    //update SO
    $con = new mysqli($server, $user, $pw, $db);
    $net = $gross/1.12;
    $vat = $gross-$net;
    $ins = $con->prepare('INSERT INTO `tbl_receivable`(`Company`, `SIDate`, `SINumber`, `GrossSale`, `NetSale`, `VAT`) VALUES (?, ?, ?, ?, ?, ?)');
    $ins->bind_param('sssddd', $customer, $si_date, $si_number, $gross, $net, $vat);
    $ins->execute();
    $con->close();
    
    header('location: ../receivable_monitoring?success');
}
elseif(isset($_GET['id_paid'])){
    include 'connection.php';

    $id = $_GET['id_paid'];
    $d = 'PAID';
    $stmt = $con->prepare('UPDATE `tbl_receivable` SET `Status`=? WHERE `ReceivableID`=?');
    $stmt->bind_param('si', $d, $id);
    if($stmt->execute()){
        header('location: ../receivable_monitoring?paid');
    }
}
elseif(isset($_GET['id_delete'])){
    include 'connection.php';

    $id = $_GET['id_delete'];
    $d = 'YES';
    $stmt = $con->prepare('UPDATE `tbl_receivable` SET `DelStatus`=? WHERE `ReceivableID`=?');
    $stmt->bind_param('si', $d, $id);
    if($stmt->execute()){
        header('location: ../receivable_monitoring?deleted');
    }
}
elseif(isset($_POST['submitCtr'])){
    include 'connection.php';

    $id = $_POST['id'];
    $date = $_POST['ctrDate'];
    $stmt = $con->prepare('UPDATE `tbl_receivable` SET `CounteredDate`=? WHERE  `ReceivableID`=?');
    $stmt->bind_param('si', $date, $id);
    if($stmt->execute()){
        header('location: ../receivable_monitoring?ctrDate');
    }
}

elseif(isset($_POST['submitDue'])){
    include 'connection.php';

    $id = $_POST['id'];
    $date = $_POST['dueDate'];
    $stmt = $con->prepare('UPDATE `tbl_receivable` SET `DueDate`=? WHERE  `ReceivableID`=?');
    $stmt->bind_param('si', $date, $id);
    if($stmt->execute()){
        header('location: ../receivable_monitoring?dueDate');
    }
}

elseif(isset($_POST['submitRemarks'])){
    include 'connection.php';

    $id = $_POST['id'];
    $r = $_POST['remarks'];
    $stmt = $con->prepare('UPDATE `tbl_receivable` SET `Remarks`=? WHERE  `ReceivableID`=?');
    $stmt->bind_param('si', $r, $id);
    if($stmt->execute()){
        header('location: ../receivable_monitoring?remarks');
    }
}


?>