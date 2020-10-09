<?php
include 'connection.php';

if(isset($_POST['save_only'])){
    //for saving

    //fetch all POST variables
    $date = $_POST['date'];
    $so = $_GET['so'];
    $tamount = $_POST['total_price'];

    //update SO
    $con = new mysqli($server, $user, $pw, $db);
    $ins = $con->prepare('UPDATE tbl_sales_order SET RebateAmount=RebateAmount+?, Balance=Balance-? WHERE SONumber=?');
    $ins->bind_param('ddi', $tamount, $tamount, $so);
    $ins->execute();
    $con->close();
    
    //insert into tbl_credit
    $con = new mysqli($server, $user, $pw, $db);
    $ins_c = $con->prepare('INSERT INTO `tbl_rebate`(`SONumber`, `RebateDate`, `Total`) VALUES (?,?,?)');
    $ins_c->bind_param('isd', $so, $date, $tamount);
    $ins_c->execute();
    $con->close();

    //get RebateNumber
    $con = new mysqli($server, $user, $pw, $db);
    $get_c = $con->prepare('SELECT `RebateNumber` FROM `tbl_rebate` ORDER BY RebateNumber DESC LIMIT 1');
    $get_c->execute();
    $get_c->store_result();
    $get_c->bind_result($rnum);
    $get_c->fetch();
    $get_c->close();
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
            $ins_ap = $con->prepare('INSERT INTO `tbl_rebate_bd`(`RebateNumber`, `Quantity`, `Description`, `UnitPrice`, `Amount`) VALUES (?, ?, ?, ?, ?)');
            $ins_ap->bind_param('iisdd', $rnum, $q[$k], $d, $price[$k], $amt[$k]);
            $ins_ap->execute();
            $con->close();
        }
    }

    header('location: ../sidr_records?success_rebate');
}
   

?>