<?php
include 'check_aed.php';

class Check{
    public $nxt_cnum;
    public $payee;
    public $date;
    public $amount;

    public function show_query($sql){
        include 'models/connection.php';

        $stmt = $con->prepare($sql);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($apid, $apref, $cnum, $date, $payee, $company, $bir, $total, $ewt);

        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $date = date_format(date_create($date), "F j, Y");
                $total = number_format($total,2);
                $ewt = number_format($ewt,2);
                echo "
                <table id='example2' style='border: 2px solid black; ' class='table table-bordered table-striped'>
                <tbody>
                <tr>
                    <td style='width:50%'>
                    <b>Payee Name:</b><br>
                    $payee
                    </td>
                    <td style='width:25%'>
                    <b>AP Reference Number:</b><br>
                    $apref
                    </td>
                    <td style='width:25%'>
                    <b>Check Number:</b><br>
                    $cnum
                </tr>
                <tr>
                    <td style='width:50%'>
                    <b>Company:</b><br>
                    $company
                    </td>
                    <td style='width:25%'>
                    <b>Date:</b><br>
                    $date
                    </td>
                    <td style='width:25%'>
                    <b>EWT:</b> &nbsp;&nbsp;&nbsp;$ewt<br>
                    $bir
                    </td>
                </tr>
                <tr>
                        <td colspan='3'>&nbsp;</td>
                </tr>
                <tr>
                <td colspan='3'>
                    <table style='width:100%; margin: 0 auto' class='table table-bordered table-striped'>
                        <tr>
                            <th style='width:50%'><center>Description</center></th>
                            <th style='width:25%'><center>Amount</center></th>
                            <th style='width:25%'><center>Account Title</center></th>
                        </tr>";
                
                        $con1 = new mysqli($server, $user, $pw, $db);
                        $imp_prod = $con1->prepare('SELECT `Description`, `Amount`, a.AccountTitle FROM `tbl_ap_particular` ap JOIN tbl_account_title a ON a.AT_ID=ap.AccountTitle WHERE `AP_ID`=?');
                        $imp_prod->bind_param('i', $apid);
                        $imp_prod->execute();
                        $imp_prod->store_result();
                        $imp_prod->bind_result($desc, $pamt, $atitle);
                        while($imp_prod->fetch()){
                            $pamt = number_format($pamt, 2);
                            echo "
                            <tr>
                                <td>$desc</td>
                                <td>$pamt</td>
                                <td>$atitle</td>
                            </tr>
                            ";
                        }
                echo "
                    <tr>
                        <td style='text-align: right; font-weight: bold'>Total Amount:</td>
                        <td colspan='2' style='text-align: left'>$total</td>
                    </tr>
                    </table>
                </td>
                </tr>
                <tr>
                        <td colspan='3'>&nbsp;</td>
                </tr>
                </tbody>
                </table>
                <div class='pagebreak'> </div>
                ";
            }
        }
        else{
            echo "<center>No record to show... </center>";
        }
    }

    public function set_data($id){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `PayeeName`, `Date`, `Total` FROM `tbl_ap` cv JOIN tbl_payee p ON cv.Payee=p.PayeeID WHERE AP_ID=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($payee, $date, $amount);
        $stmt->fetch();

        $this->payee = $payee;
        $this->date = $date;
        $this->amount = $amount;
    }

    public function show_data_dl(){
        include 'models/connection.php';
        $stmt = $con->prepare('SELECT `APRefNumber` FROM `tbl_ap`');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($apref);
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                echo "
                <option value='$apref'>
                ";
            }
        }
    }

    public function show_data_cvap($id){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `AP_RefNumber`, `Description`, `EWT`, `Amount` FROM `tbl_cv_ap` WHERE CheckNumber=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($apref, $desc, $ewt, $amt);
        while($stmt->fetch()){
            $amt = number_format($amt, 2);
            if($ewt == 0.00){
                $ewt = '';
            }
            echo "
            <tr>
            <td>$apref</td>
            <td colspan='3'>$desc</td>
            <td>$ewt</td>
            <td>$amt</td>
            </tr>
            ";
        }
    }

      public function show_data(){
          include 'models/connection.php';

          $stmt = $con->prepare('SELECT `AP_ID`, `APRefNumber`, `CheckNumber`, `Date`, p.PayeeName, c.CompanyName, `BIR`, Total, EWT, `Status` FROM tbl_ap ap JOIN tbl_payee p ON p.PayeeID=ap.Payee JOIN tbl_company c ON c.CompanyID=ap.Company WHERE `Status`!="CANCELLED"');
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($apid, $apref, $chknum, $date, $payee, $company, $bir, $camount, $ewt, $status);
          if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $date = date_format(date_create($date), "F j, Y");
                $camount = number_format($camount, 2);
                $ewt = number_format($ewt, 2);
                echo "
                 <tr>
                 <td>$apref</td>
                 <td>$chknum</td>
                 <td>$date</td>
                 <td>$payee</td>
                 <td>$company</td>
                 <td>$bir</td>
                 <td>$ewt</td>
                 <td>$camount</td>
                 <td>
                 <center>
                 <a href='javascript:void(0);' data-href='view_check.php?apid=$apid' class='print'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> &nbsp;View Details</button></a> ";

                if($status == 'CONFIRMED'){

                 echo "<a href='print_cv.php?apref=$apref'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-print'></i> &nbsp;Print</button></a>
                 </center>
                 </td>
                 </tr>
                 ";

                }
                else{
                    
                echo "<a href='print_cv.php?apref=$apref'><button type='button' class='btn btn-success btn-sm' disabled><i class='fa fa-print'></i> &nbsp;Print</button></a>
                    </center>
                    </td>
                    </tr>
                    ";

                }
            }
          }
      }

      public function show_data_for_approval(){
        include 'models/connection.php';

        $stmt = $con->prepare('SELECT `AP_ID`, `APRefNumber`, `CheckNumber`, `Date`, p.PayeeName, c.CompanyName, `BIR`, Total, EWT, `Status` FROM tbl_ap ap JOIN tbl_payee p ON p.PayeeID=ap.Payee JOIN tbl_company c ON c.CompanyID=ap.Company WHERE `Status`="PENDING"');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($apid, $apref, $chknum, $date, $payee, $company, $bir, $camount, $ewt, $status);
        if($stmt->num_rows > 0){
          while($stmt->fetch()){
              $date = date_format(date_create($date), "F j, Y");
              $camount = number_format($camount, 2);
              $ewt = number_format($ewt, 2);
              echo "
               <tr>
               <td>$apref</td>
               <td>$chknum</td>
               <td>$date</td>
               <td>$payee</td>
               <td>$company</td>
               <td>$bir</td>
               <td>$ewt</td>
               <td>$camount</td>
               <td>
               <center>
               <a href='javascript:void(0);' data-href='view_check.php?apid=$apid' class='print'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> &nbsp;View Details</button></a>
               <a href='models/check_aed.php?approve=$apid'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-check'></i> &nbsp;Approve</button></a>
               <a href='models/check_aed.php?cancel=$apid'><button type='button' class='btn btn-danger btn-sm'><i class='fa fa-times'></i> &nbsp;Cancel</button></a>
               </center>
               </td>
               </tr>
               ";
          }
        }
    }

      public function get_last_id(){
          include 'models/connection.php';

          $stmt = $con->prepare('SELECT AP_ID FROM tbl_ap ORDER BY AP_ID DESC');
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($cnum);
          $stmt->fetch();

          $cnum+= 1;

          $this->nxt_cnum = $cnum;
          
      }
}
?>