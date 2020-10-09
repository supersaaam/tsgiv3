<style>
.pagebreak { page-break-before: always; } /* page-break-after works, as well */
</style>

<?php
include 'css.php';
include 'models/check_model.php';

if(isset($_POST['filter'])){
  $filter = $_POST['filter'];

if($filter == 'all'){
    $sql = "SELECT AP_ID, `APRefNumber`, `CheckNumber`, `Date`, p.PayeeName, c.CompanyName, `BIR`, Total, EWT FROM tbl_ap ap JOIN tbl_payee p ON p.PayeeID=ap.Payee JOIN tbl_company c ON c.CompanyID=ap.Company";
}
else{
    $col = $_POST['column'];
    $value = $_POST['value'];

    if($col == 'AP Reference Number'){
        $sql = "SELECT AP_ID, `APRefNumber`, `CheckNumber`, `Date`, p.PayeeName, c.CompanyName, `BIR`, Total, EWT FROM tbl_ap ap JOIN tbl_payee p ON p.PayeeID=ap.Payee JOIN tbl_company c ON c.CompanyID=ap.Company WHERE APRefNumber='$value'";
    }
    elseif($col == 'BIR'){
        if($value == 'BIR'){
            $sql = "SELECT AP_ID, `APRefNumber`, `CheckNumber`, `Date`, p.PayeeName, c.CompanyName, `BIR`, Total, EWT FROM tbl_ap ap JOIN tbl_payee p ON p.PayeeID=ap.Payee JOIN tbl_company c ON c.CompanyID=ap.Company WHERE BIR='BIR'";
        }
        elseif($value == 'Non-BIR'){
            $sql = "SELECT AP_ID, `APRefNumber`, `CheckNumber`, `Date`, p.PayeeName, c.CompanyName, `BIR`, Total, EWT FROM tbl_ap ap JOIN tbl_payee p ON p.PayeeID=ap.Payee JOIN tbl_company c ON c.CompanyID=ap.Company WHERE BIR='Non-BIR'";
        }
    }
    elseif($col == 'Payee'){
        $sql = "SELECT AP_ID, `APRefNumber`, `CheckNumber`, `Date`, p.PayeeName, c.CompanyName, `BIR`, Total, EWT FROM tbl_ap ap JOIN tbl_payee p ON p.PayeeID=ap.Payee JOIN tbl_company c ON c.CompanyID=ap.Company WHERE p.PayeeName='$value'";
    }
    elseif($col == 'Company'){
      $sql = "SELECT AP_ID, `APRefNumber`, `CheckNumber`, `Date`, p.PayeeName, c.CompanyName, `BIR`, Total, EWT FROM tbl_ap ap JOIN tbl_payee p ON p.PayeeID=ap.Payee JOIN tbl_company c ON c.CompanyID=ap.Company WHERE c.CompanyName='$value'";
    }
}
}
else{
  $ap = $_GET['apref'];

  $sql = "SELECT AP_ID, `APRefNumber`, `CheckNumber`, `Date`, p.PayeeName, c.CompanyName, `BIR`, Total, EWT FROM tbl_ap ap JOIN tbl_payee p ON p.PayeeID=ap.Payee JOIN tbl_company c ON c.CompanyID=ap.Company WHERE APRefNumber='$ap'";
}

$ck = new Check();
?>

<body>
                <center><h1>Check Voucher</h1></center>
                <br>

                  <tbody>
                  <?php
                    $ck->show_query($sql);
                  ?>

                
</body>

<?php
include 'js.php';
?>

<script>
    window.print();
        setTimeout("closePrintView()", 1000);
    function closePrintView() {
        document.location.href = 'check';
    }
</script>