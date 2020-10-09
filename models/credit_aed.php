<?php
include 'connection.php';

if(isset($_POST['save_only']) || isset($_POST['save_print'])){
    //for saving

    //fetch all POST variables
    $date = $_POST['date'];
    $so = $_GET['so'];
    $memonumber = $_POST['memonumber'];
    $tamount = $_POST['total_price'];

    //update SO
    $con = new mysqli($server, $user, $pw, $db);
    $ins = $con->prepare('UPDATE tbl_sales_order SET CreditStatus=?, CreditAmount=CreditAmount+?, Balance=Balance-? WHERE SONumber=?');
    $s = 'YES';
    $ins->bind_param('sddi', $s, $tamount, $tamount, $so);
    $ins->execute();
    $con->close();
    
    //insert into tbl_credit
    $con = new mysqli($server, $user, $pw, $db);
    $ins_c = $con->prepare('INSERT INTO `tbl_credit`(`MemoNumber`, `SONumber`, `CreditDate`, `Total`) VALUES (?, ?,?,?)');
    $ins_c->bind_param('iisd', $memonumber, $so, $date, $tamount);
    $ins_c->execute();
    $con->close();

    //update balance customer
    $custid = $_POST['custid'];
    $con = new mysqli($server, $user, $pw, $db);
    $upd_c = $con->prepare('UPDATE tbl_customers SET RemainingBalance=RemainingBalance-? WHERE CustomerID=?');
    $upd_c->bind_param('di', $tamount, $custid);
    $upd_c->execute();
    $con->close();
    
    //insert into tbl_credit_bd
    $q = $_POST['q'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $amt = $_POST['amt'];

    foreach($desc as $k=> $d){
        if($d != null){

            $con = new mysqli($server, $user, $pw, $db);
            $ins_ap = $con->prepare('INSERT INTO `tbl_credit_bd`(`MemoNumber`, `Quantity`, `Description`, `UnitPrice`, `Amount`) VALUES (?, ?, ?, ?, ?)');
            $ins_ap->bind_param('iisdd', $memonumber, $q[$k], $d, $price[$k], $amt[$k]);
            $ins_ap->execute();
            $con->close();
        }
    }
}

if(isset($_POST['save_print'])){
    //for printing
    header('location: ../print_cmemo.php?mn='.$memonumber);
}
elseif(isset($_POST['save_only'])){
    header('location: ../sidr_records?success');
}
?>