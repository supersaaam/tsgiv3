<?php
include 'connection.php';

if(isset($_POST['save_only']) || isset($_POST['save_print'])){
    //for saving

    //fetch all POST variables
    $date = $_POST['date'];
    $payee = $_POST['payee'];
    $company = $_POST['company'];
    $ap = $_POST['aprefnum'];
    $cnum = $_POST['checknumber'];
    $ewt = $_POST['ewt'];
    $bir = $_POST['bir'];

    //check payee
        //if existing in db -> get ID
        //else, save to db and get ID
        //FOR Payee
        $con2 = new mysqli($server, $user, $pw, $db);
        $con3 = new mysqli($server, $user, $pw, $db);

        $stmt_payee = $con->prepare('SELECT PayeeID FROM tbl_payee WHERE PayeeName=?');
        $stmt_payee->bind_param('s', $payee);
        $stmt_payee->execute();
        $stmt_payee->store_result();
        $stmt_payee->bind_result($payeeID);
        $stmt_payee->fetch();
            if($stmt_payee->num_rows == 0){
                //not existing -> save to DB
                $add = $con2->prepare('INSERT INTO `tbl_payee` (`PayeeName`) VALUES (?)');
                $add->bind_param('s', $payee);
                $add->execute();
                $add->close();

                //get ID
                $id = $con3->prepare('SELECT PayeeID FROM tbl_payee WHERE PayeeName=?');
                $id->bind_param('s', $payee);
                $id->execute();
                $id->store_result();
                $id->bind_result($payeeID);
                $id->fetch();
                $id->close();
            }
            $con2->close();
            $con3->close();
            $con->close();
    
    //check payee
        //if existing in db -> get ID
        //else, save to db and get ID
        //FOR Payee
        $con = new mysqli($server, $user, $pw, $db);
        $con2 = new mysqli($server, $user, $pw, $db);
        $con3 = new mysqli($server, $user, $pw, $db);

        $stmt_comp = $con->prepare('SELECT CompanyID FROM tbl_company WHERE CompanyName=?');
        $stmt_comp->bind_param('s', $company);
        $stmt_comp->execute();
        $stmt_comp->store_result();
        $stmt_comp->bind_result($compID);
        $stmt_comp->fetch();
            if($stmt_comp->num_rows == 0){
                //not existing -> save to DB
                $add = $con2->prepare('INSERT INTO `tbl_company` (`CompanyName`) VALUES (?)');
                $add->bind_param('s', $company);
                $add->execute();
                $add->close();

                //get ID
                $id = $con3->prepare('SELECT CompanyID FROM tbl_company WHERE CompanyName=?');
                $id->bind_param('s', $company);
                $id->execute();
                $id->store_result();
                $id->bind_result($compID);
                $id->fetch();
                $id->close();
            }
            $con2->close();
            $con3->close();
            $con->close();

    $tamount = $_POST['total_price'];

    //insert into tbl_ap
    $con = new mysqli($server, $user, $pw, $db);
    $ins = $con->prepare('INSERT INTO `tbl_ap`(`APRefNumber`, `CheckNumber`, `Date`, `Payee`, `Company`, `BIR`, `EWT`, `Total`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $ins->bind_param('sssiisdd', $ap, $cnum, $date, $payeeID, $compID, $bir, $ewt, $tamount);
    $ins->execute();
    $con->close();

    $con = new mysqli($server, $user, $pw, $db);
    $g_apid = $con->prepare('SELECT AP_ID FROM tbl_ap WHERE APRefNumber=?');
    $g_apid->bind_param('s', $ap);
    $g_apid->execute();
    $g_apid->store_result();
    $g_apid->bind_result($ap_id);
    $g_apid->fetch();
    $con->close();
    
    //insert into tbl_cv_ap
    $desc = $_POST['desc'];
    $amt = $_POST['amt'];
    $at = $_POST['acct'];

    foreach($desc as $k=> $d){
        if($d != null &&
        $amt[$k] != null &&
        $at[$k] != null){

            //check payee
        //if existing in db -> get ID
        //else, save to db and get ID
        //FOR Payee
        $con = new mysqli($server, $user, $pw, $db);
        $con2 = new mysqli($server, $user, $pw, $db);
        $con3 = new mysqli($server, $user, $pw, $db);

        $stmt_at = $con->prepare('SELECT AT_ID FROM tbl_account_title WHERE AccountTitle=?');
        $stmt_at->bind_param('s', $at[$k]);
        $stmt_at->execute();
        $stmt_at->store_result();
        $stmt_at->bind_result($at_id);
        $stmt_at->fetch();
            if($stmt_at->num_rows == 0){
                //not existing -> save to DB
                $add = $con2->prepare('INSERT INTO `tbl_account_title` (`AccountTitle`) VALUES (?)');
                $add->bind_param('s', $at[$k]);
                $add->execute();
                $add->close();

                //get ID
                $id = $con3->prepare('SELECT AT_ID FROM tbl_account_title WHERE AccountTitle=?');
                $id->bind_param('s', $at[$k]);
                $id->execute();
                $id->store_result();
                $id->bind_result($at_id);
                $id->fetch();
                $id->close();
            }
            $con2->close();
            $con3->close();
            $con->close();

            $con = new mysqli($server, $user, $pw, $db);
            $ins_ap = $con->prepare('INSERT INTO `tbl_ap_particular`(AP_ID, `Description`, `Amount`, `AccountTitle`) VALUES (?, ?, ?, ?)');
            $ins_ap->bind_param('isdi', $ap_id, $d, $amt[$k], $at_id);
            $ins_ap->execute();
            $con->close();
        }
    }
}

if(isset($_POST['save_print'])){
    //for printing
    header('location: ../print_cv.php?apref='.$ap);
}
elseif(isset($_POST['save_only'])){
    header('location: ../check?success');
}
elseif(isset($_GET['approve'])){
    $apid = $_GET['approve'];

    include 'connection.php';

    $stmt = $con->prepare('UPDATE `tbl_ap` SET `Status`="CONFIRMED" WHERE `AP_ID`=?');
    $stmt->bind_param('i', $apid);
    $stmt->execute();

    echo "
    <script>
    window.location.href = 'http://localhost/agrimatesystem/check_approval?approved';
    </script>
    ";
}
elseif(isset($_GET['cancel'])){
    $apid = $_GET['cancel'];

    include 'connection.php';

    $stmt = $con->prepare('UPDATE `tbl_ap` SET `Status`="CANCELLED" WHERE `AP_ID`=?');
    $stmt->bind_param('i', $apid);
    $stmt->execute();

    echo "
    <script>
    window.location.href = 'http://localhost/agrimatesystem/check_approval?cancelled';
    </script>
    ";

}
?>