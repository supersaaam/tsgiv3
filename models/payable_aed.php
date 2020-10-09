<?php
if(isset($_POST['save'])){ //new record
    include 'connection.php';

    $particular = $_POST['particular'];
    $accountnum = $_POST['accountnum'];
    $contactnum = $_POST['contactnum'];
    $duedate = $_POST['duedate'];
    $amount = $_POST['amount'];
    
    $stmt = $con->prepare('INSERT INTO `tbl_payable`(`Particular`, `AccountNumber`, `ContactNumber`, `DueDate`, `Amount`) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('ssssd', $particular, $accountnum, $contactnum, $duedate, $amount);
    if($stmt->execute()){
        header('location: ../payable_accounts?success');
    }
}
elseif(isset($_POST['save_pm'])){
    include 'connection.php';

    $particular = $_POST['particular'];
    $accountnum = $_POST['accountnum'];
    $contactnum = $_POST['contactnum'];
    $duedate = $_POST['duedate'];
    $amount = $_POST['amount'];
    
    $stmt = $con->prepare('INSERT INTO `tbl_payable_monitoring`(`Particular`, `AccountNumber`, `ContactNumber`, `DueDate`, `Amount`) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('ssssd', $particular, $accountnum, $contactnum, $duedate, $amount);
    if($stmt->execute()){
        header('location: ../payable_accounts?success_pm');
    }
}
elseif(isset($_POST['update'])){ //update record
    include 'connection.php';

    $id = $_GET['id'];
    
    $particular = $_POST['particular'];
    $accountnum = $_POST['accountnum'];
    $contactnum = $_POST['contactnum'];
    $duedate = $_POST['duedate'];
    $amount = $_POST['amount'];

    $stmt = $con->prepare('UPDATE `tbl_payable` SET `Particular`=?,`AccountNumber`=?,`ContactNumber`=?,`DueDate`=?,`Amount`=? WHERE `PayableID`=?');
    $stmt->bind_param('ssssdi', $particular, $accountnum, $contactnum, $duedate, $amount, $id);
    if($stmt->execute()){
        header('location: ../payable_accounts?edited');
    }
}
elseif(isset($_GET['id_delete'])){
    include 'connection.php';

    $id = $_GET['id_delete'];
    $d = 'YES';
    $stmt = $con->prepare('UPDATE `tbl_payable` SET `Deleted`=? WHERE `PayableID`=?');
    $stmt->bind_param('si', $d, $id);
    if($stmt->execute()){
        header('location: ../payable_accounts?deleted');
    }
}
elseif(isset($_GET['id_paid'])){
    include 'connection.php';

    $id = $_GET['id_paid'];
    $d = 'PAID';
    $stmt = $con->prepare('UPDATE `tbl_payable_monitoring` SET `Status`=? WHERE `PM_ID`=?');
    $stmt->bind_param('si', $d, $id);
    if($stmt->execute()){
        header('location: ../payable_monitoring?paid');
    }
}
?>