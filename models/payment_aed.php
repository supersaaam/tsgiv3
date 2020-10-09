<?php
include 'connection.php';

if(isset($_POST['save'])){
    $so = $_POST['so'];
    $pr = $_POST['pr'];
    $cr = $_POST['cr'];
    $pr_d = $_POST['pr_date'];
    $cr_d = $_POST['cr_date'];
    $bank = $_POST['bank'];
    $d_rec = $_POST['date_rec'];
    $d_dep = $_POST['date_dep'];
    $cnum = $_POST['check'];
    $cdate = $_POST['check_date'];
    $amt = $_POST['amt_rec'];
    $custid = $_POST['customerid'];
    $totalmisc = $_POST['total_price'];
    $pd = $_POST['post_dated'];
    
    if($pd == 'YES'){
        $cleared = 'NO';
    }
    else{
        $cleared = 'YES';
    }

    $stmt = $con->prepare('INSERT INTO `tbl_payment`(`SONumber`, `PR_Number`, `PR_Date`, `CR_Number`, `CR_Date`, `BankName`, `CheckNumber`, `CheckDate`, `DateDeposited`, `DateReceived`, `AmountReceived`, PostDated, Cleared) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('isssssssssdss', $so, $pr, $pr_d, $cr, $cr_d, $bank, $cnum, $cdate, $d_dep, $d_rec, $amt, $pd, $cleared);
    $stmt->execute();
    $stmt->close();
    $con->close();
    
    if($pd == 'NO'){
        $amt = $amt + $totalmisc;
    }
    else{
        $amt = $totalmisc;
    }

        //deduct customer balance
        $con = new mysqli($server, $user, $pw, $db);
        $stmt = $con->prepare('UPDATE `tbl_customers` SET `RemainingBalance`=RemainingBalance-? WHERE CustomerID=?');
        $stmt->bind_param('di', $amt, $custid);
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


    //for miscellaneous
    $misc = $_POST['misc'];
    $misc_amt = $_POST['amount'];

    //get ID of payment
    $con = new mysqli($server, $user, $pw, $db);
    $lpid = $con->prepare('SELECT PaymentID FROM tbl_payment ORDER BY PaymentID DESC LIMIT 1');
    $lpid->execute();
    $lpid->store_result();
    $lpid->bind_result($pid);
    $lpid->fetch();
    $con->close();

    foreach($misc as $k => $m){
        if($m != null &&
        $misc_amt[$k] != null){
            
        //check if it exists in DB
        $con = new mysqli($server, $user, $pw, $db);
        $con2 = new mysqli($server, $user, $pw, $db);
        $con3 = new mysqli($server, $user, $pw, $db);
        //get ID if existing
        //add not existing
        $stmt_m = $con->prepare('SELECT MiscID FROM tbl_misc WHERE `Description`=?');
        $stmt_m->bind_param('s', $m);
        $stmt_m->execute();
        $stmt_m->store_result();
        $stmt_m->bind_result($mid);
        $stmt_m->fetch();
            if($stmt_m->num_rows == 0){
                //not existing -> save to DB
                $add = $con2->prepare('INSERT INTO `tbl_misc` (`Description`) VALUES (?)');
                $add->bind_param('s', $m);
                $add->execute();

                //get ID
                $id = $con3->prepare('SELECT MiscID FROM tbl_misc WHERE `Description`=?');
                $id->bind_param('s', $m);
                $id->execute();
                $id->store_result();
                $id->bind_result($mid);
                $id->fetch();
            }
            $con2->close();
            $con3->close();
            $con->close();

            $a = $misc_amt[$k];

            //insert to misc_payments
            $con = new mysqli($server, $user, $pw, $db);
            $ins = $con->prepare('INSERT INTO `tbl_misc_payment`(`MiscID`, `PaymentID`, `Amount`) VALUES (?, ?, ?)');
            $ins->bind_param('iid', $mid, $pid, $a);
            $ins->execute();
        }
    }

    header('location: ../payments?success');
}   
?>