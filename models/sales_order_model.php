<?php
include 'sales_order_aed.php';

class Sales_Order {
  /**
   * @var mixed
   */
  public $last_so;
  /**
   * @var mixed
   */
  public $name;
  /**
   * @var mixed
   */
  public $address;
  /**
   * @var mixed
   */
  public $terms;
  /**
   * @var mixed
   */
  public $total;
  /**
   * @var mixed
   */
  public $po;
  /**
   * @var mixed
   */
  public $deducted;
  /**
   * @var mixed
   */
  public $invoice;
  /**
   * @var mixed
   */
  public $dr;
  /**
   * @var mixed
   */
  public $balance;
  /**
   * @var mixed
   */
  public $custid;
  /**
   * @var mixed
   */
  public $totalx;
  /**
   * @var mixed
   */
  public $avg;
  /**
   * @var mixed
   */
  public $si_date;
  /**
   * @var mixed
   */
  public $dr_date;
  /**
   * @var mixed
   */
  public $bir;

  public function show_data_dl() {
    include 'models/connection.php';
    $stmt = $con->prepare('SELECT `SONumber` FROM `tbl_sales_order`');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($so);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        echo "
                <option value='$so'>
                ";
      }
    }
  }

  public function show_data_dl_si() {
    include 'models/connection.php';
    $stmt = $con->prepare('SELECT `SI_Number` FROM `tbl_sales_order`');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($si);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        echo "
                <option value='$si'>
                ";
      }
    }
  }

  public function show_data_dl_dr() {
    include 'models/connection.php';
    $stmt = $con->prepare('SELECT `DR_Number` FROM `tbl_sales_order`');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($dr);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        echo "
                <option value='$dr'>
                ";
      }
    }
  }

  /**
   * @param $sql
   */
  public function show_query_so($sql) {
    include 'models/connection.php';

    $stmt = $con->prepare($sql);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($so, $cname, $terms, $po, $date, $total, $reason);

    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        $date  = date_format(date_create($date), 'F j, Y');
        $total = number_format($total, 2);
        $so    = sprintf('%06d', $so);
        echo "
                <table id='example2' style='border: 2px solid black; ' class='table table-bordered table-striped'>
                <tbody>
                <tr>
                    <td style='width:25%'>
                    <b>SO Number:</b><br>
                    $so
                    </td>
                    <td style='width:25%'>
                    <b>Date Created:</b><br>
                    $date
                    </td>
                    <td style='width:25%'>
                    <b>PO Number:</b><br>
                    $po
                    </td>
                    <td style='width:25%'>
                    <b>Terms:</b><br>
                    $terms
                    </td>
                </tr>
                <tr>
                    <td colspan='2' style='width:50%'>
                    <b>Customer:</b><br>
                    $cname
                    </td>";

        $con2   = new mysqli($server, $user, $pw, $db);
        $cmo_so = $con2->prepare('SELECT `CMO_Name`, `Share` FROM `tbl_so_cmo` WHERE SONumber=?');
        $cmo_so->bind_param('i', $so);
        $cmo_so->execute();
        $cmo_so->store_result();
        $cmo_so->bind_result($cmoname, $cmoshare);
        if ($cmo_so->num_rows > 1) {
          echo "<td style='width:25%'>
                            <b>CMO (Share):</b>
                            ";
          while ($cmo_so->fetch()) {
            echo "
                                <br>
                                $cmoname ($cmoshare)
                                ";
          }
          echo '</td>';
        } else {
          $cmo_so->fetch();
          echo "
                            <td style='width:25%'>
                            <b>CMO:</b><br>
                            $cmoname
                            </td>
                            ";
        }

        echo "
                    <td style='width:25%'>
                    <b>Total Amount:</b><br>
                    $total
                    </td>
                </tr>
                <tr>
                        <td colspan='4'>&nbsp;</td>
                </tr>
                <tr>
                <td colspan='4'>
                    <table style='width:100%; margin: 0 auto' class='table table-bordered table-striped'>
                        <tr>
                            <th style='width:50%'><center>Product Code</center></th>
                            <th style='width:10%'><center>Quantity</center></th>
                            <th style='width:15%'><center>Price</center></th>
                            <th style='width:15%'><center>Total</center></th>
                            <th style='width:10%'><center>Remarks</center></th>
                        </tr>";

        $con1     = new mysqli($server, $user, $pw, $db);
        $imp_prod = $con1->prepare('SELECT `ProductCode`, `Quantity`, `Price`, `Amount`, `Remarks` FROM `tbl_so_product` WHERE SO_ID=?');
        $imp_prod->bind_param('i', $so);
        $imp_prod->execute();
        $imp_prod->store_result();
        $imp_prod->bind_result($pcode, $q, $p, $a, $r);
        while ($imp_prod->fetch()) {
          $p = number_format($p, 2);
          $a = number_format($a, 2);
          echo "
                            <tr>
                                <td>$pcode</td>
                                <td>$q</td>
                                <td>$p</td>
                                <td>$a</td>
                                <td>$r</td>
                            </tr>
                            ";
        }
        echo "
                    </table>
                </td>
                </tr>
                <tr>
                        <td colspan='4'>&nbsp;</td>
                </tr>
                </tbody>
                </table>
                <div class='pagebreak'> </div>
                ";
      }
    } else {
      echo '<center>No record to show... </center>';
    }
  }

  /**
   * @param $sql
   */
  public function show_query($sql) {
    include 'models/connection.php';

    $stmt = $con->prepare($sql);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($customerID, $name, $so, $si, $dr, $drd, $pr, $cr, $cdate, $amt);
    if ($stmt->num_rows > 0) {
      $i     = 0;
      $total = 0;
      while ($stmt->fetch()) {

        $drd   = date_format(date_create($drd), 'F j, Y');
        $cdate = date_format(date_create($cdate), 'F j, Y');
        $so    = sprintf('%06d', $so);
        $amt   = number_format($amt, 2);
        echo "
                <tr>
                <td>$name</td>
                <td>$so</td>
                <td>$si</td>
                <td>$dr</td>
                <td>$drd</td>
                <td>$pr/$cr</td>
                <td>$cdate</td>
                <td>$amt</td>
                <td>-</td>";

        //avg
        $con1 = new mysqli($server, $user, $pw, $db);
        $cnt  = $con1->prepare('SELECT COUNT(*) FROM tbl_sales_order so JOIN tbl_customers c ON c.CustomerID=so.CustomerID WHERE c.CompanyName=?');
        $cnt->bind_param('s', $name);
        $cnt->execute();
        $cnt->store_result();
        $cnt->bind_result($cntso);
        $cnt->fetch();
        $con1->close();

        $date1 = date_create($cdate);
        $date2 = date_create($drd);
        $diff  = date_diff($date2, $date1);
        $days  = $diff->format('%R%a');

        if ($days > 0) {
          $i++;
          $total += $days;
        }

        $con1 = new mysqli($server, $user, $pw, $db);
        $cntx = $con1->prepare('SELECT SUM(Balance) FROM tbl_sales_order so JOIN tbl_customers c ON c.CustomerID=so.CustomerID WHERE c.CompanyName=? AND Balance > 0');
        $cntx->bind_param('s', $name);
        $cntx->execute();
        $cntx->store_result();
        $cntx->bind_result($cntup);
        $cntx->fetch();
        $con1->close();

        $cntup = number_format($cntup, 2);
        echo "
                <td>$days</td>
                <td>$cntup</td>
                </tr>
                ";
      }

      $this->totalx = $total;
      $this->avg    = ($total / $i) + 30;
    }
  }

  /**
   * @param $id
   */
  public function set_data($id) {
    include 'connection.php';

    $stmt = $con->prepare('SELECT tbl_customers.CompanyName, `Address`, tbl_terms.DaysLabel, `PONumber`, TotalAmount, DeductedAmount, SI_Number, DR_Number, Balance, tbl_sales_order.CustomerID, SI_Date, DR_Date, BIRType FROM `tbl_sales_order` JOIN tbl_customers ON tbl_customers.CustomerID=tbl_sales_order.CustomerID JOIN tbl_terms ON tbl_terms.Term_ID=tbl_sales_order.Terms WHERE `SONumber`=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name, $address, $terms, $po, $ta, $d, $si, $dr, $bal, $custid, $si_date, $dr_date, $bir);
    $stmt->fetch();

    $this->name     = str_replace('"', '', $name);
    $this->address  = str_replace('"', '', $address);
    $this->terms    = $terms;
    $this->po       = $po;
    $this->total    = $ta;
    $this->deducted = $d;
    $this->balance  = $bal ?? $ta;
    $this->invoice  = $si;
    $this->dr       = $dr;
    $this->custid   = $custid;

    if ($dr_date == '0000-00-00') {
      $dr_date = '';
    }

    if ($si_date == '0000-00-00') {
      $si_date = '';
    }

    $this->dr_date = $dr_date;
    $this->si_date = $si_date;
    $this->bir     = $bir;
  }

  /**
   * @param $id
   */
  public function show_product($id) {
    include 'connection.php';

    $stmt = $con->prepare('SELECT `ProductCode`, `Quantity`, Price, Amount, Remarks FROM `tbl_so_product` WHERE `SO_ID`=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($code, $q, $p, $a, $r);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        $p = number_format($p, 2);
        $a = number_format($a, 2);
        echo "
                <tr>
                    <td>$code</td>
                    <td>$p</td>
                    <td>$q</td>
                    <td>$a</td>
                    <td>$r</td>
                </tr>
                ";
      }
    }
  }

  /**
   * @param $id
   */
  public function show_product_print($id) {
    include 'connection.php';

    $stmt = $con->prepare('SELECT `ProductCode`, `Quantity`, Price, Amount, Remarks FROM `tbl_so_product` WHERE `SO_ID`=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($code, $q, $p, $a, $r);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        $p = number_format($p, 2);
        $a = number_format($a, 2);
        echo "
                <tr>
                    <td style='width:20%'>$q</td>
                    <td style='width:55%'>$code</td>
                    <td style='width:13%'>$p</td>
                    <td style='width:12%'>$a</td>
                </tr>
                ";
      }
    }
  }

  /**
   * @param $id
   */
  public function show_product_print_dr($id) {
    include 'connection.php';

    $stmt = $con->prepare('SELECT `ProductCode`, `Quantity`, Price, Amount, Remarks FROM `tbl_so_product` WHERE `SO_ID`=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($code, $q, $p, $a, $r);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        $p = number_format($p, 2);
        $a = number_format($a, 2);
        echo "
                <tr>
                    <td style='width:30%'>$q</td>
                    <td style='width:70%'>$code</td>
                </tr>
                ";
      }
    }
  }

  /**
   * @param $id
   */
  public function show_deductions($id) {
    include 'connection.php';

    $stmt = $con->prepare('SELECT `Description`, Amount FROM `tbl_so_deductions` WHERE `SO_ID`=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($d, $a);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        $a = number_format($a, 2);
        echo "
                <tr>
                    <td>$d</td>
                    <td>$a</td>
                </tr>
                ";
      }
    } else {
      echo "
            <tr>
            <td colspan='2'><center>No deductions made...</center></td>
            </tr>
            ";
    }
  }

  /**
   * @param $id
   */
  public function show_unpaid_so($id) {
    include 'connection.php';

    $stmt = $con->prepare('SELECT `SONumber`, `SI_Number`, `DR_Number`, `TotalAmount`, `Balance`, DR_Countered FROM `tbl_sales_order` WHERE Balance > 0 AND CustomerID=(SELECT CustomerID FROM tbl_sales_order WHERE SONumber=?)');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($so, $si, $dr, $ta, $b, $drc);
    if ($stmt->num_rows > 0) {
      $total = 0;
      while ($stmt->fetch()) {
        $so = sprintf('%06d', $so);
        if ($si == null) {
          $si = '-';
        } else {
          $si = sprintf('%06d', $si);
        }
        if ($dr == null) {
          $dr = '-';
        } else {
          $dr = sprintf('%06d', $dr);
        }
        $total += $b;
        $paid = number_format($ta - $b, 2);
        $ta   = number_format($ta, 2);
        $b    = number_format($b, 2);

        date_default_timezone_set('Asia/Manila');
        $date1 = date_create(date('Y-m-d'));
        $date2 = date_create($drc);
        $diff  = date_diff($date2, $date1);
        $age   = $diff->format('%R%a days');

        $drc = date_format(date_create($drc), 'F j, Y');
        echo "
                <tr>
                    <td>$si</td>
                    <td>$dr</td>
                    <td>$drc</td>
                    <td>$ta</td>
                    <td>$paid</td>
                    <td>$b</td>
                    <td style='font-weight:bold; color: red'>$age</td>
                </tr>
                ";
      }
      $total = number_format($total, 2);
      echo "
            <tfoot>
            <tr>
                <td colspan='5' style='text-align: right'><b>Total Balance:</b></td>
                <td colspan='2'>$total</td>
            </tr>
            </tfoot>
            ";
    } else {
      echo "
            <tr>
                <td colspan='7' style='text-align: center'>No unpaid payment history...</td>
            </tr>
            ";
    }
  }

  public function get_last_so() {
    include 'connection.php';

    $stmt = $con->prepare('SELECT `SONumber` FROM `tbl_sales_order` ORDER BY SONumber DESC');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($so);
    $i = 0;
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        if ($i === 0) {
          $this->last_so = $so + 1;
          $i++;
        }
      }
    } else {
      $this->last_so = 1;
    }
  }

  public function show_data_verify() {
    include 'connection.php';

    $stmt = $con->prepare('SELECT `SONumber`, tbl_customers.CompanyName, tbl_terms.DaysLabel, `TotalAmount`, tbl_customers.RemainingBalance, tbl_sales_order.CustomerID FROM `tbl_sales_order` JOIN tbl_customers ON tbl_customers.CustomerID = tbl_sales_order.CustomerID JOIN tbl_terms ON tbl_terms.Term_ID = tbl_sales_order.Terms WHERE VerifiedStatus=?');
    $stat = 'NO';
    $stmt->bind_param('s', $stat);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($so, $cust, $terms, $amt, $bal, $custid);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        $cust = str_replace('"', '', $cust);
        $so_  = sprintf('%06d', $so);
        $amt  = number_format($amt, 2);
        if ($bal == NULL) {
          $bal = 0;
        }
        $bal = number_format($bal, 2);
        echo "
                <tr>
                    <td>$so_</td>
                    <td>$cust</td>
                    <td>$terms</td>
                    <td>$amt</td>
                    <td>$bal</td><td>
                    <center>
                    <a href='javascript:void(0);' data-href='view_so?so=$so&pending' class='view'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i> &nbsp;View Details</button></a>
                    ";

        echo "
                        <a href='javascript:void(0);' data-href='view_record?so=$so' class=' viewRec'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i> &nbsp;View Payment History</button></a>
                        ";

        echo '
                </center></td>
                </tr>
                ';
      }
    } else {
      echo "
            <tr>
            <td colspan='6'><center>No data to show...</center></td>
            </tr>
            ";
    }
  }

  public function show_data_all() {
    include 'connection.php';

    $stmt = $con->prepare('SELECT `SONumber`, tbl_customers.CompanyName, tbl_terms.DaysLabel, `TotalAmount`, tbl_customers.RemainingBalance, tbl_sales_order.CustomerID, `Address`, VerifiedStatus, NotedStatus, Reason FROM `tbl_sales_order` JOIN tbl_customers ON tbl_customers.CustomerID = tbl_sales_order.CustomerID JOIN tbl_terms ON tbl_terms.Term_ID = tbl_sales_order.Terms');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($so, $cust, $terms, $amt, $bal, $custid, $add, $vs, $ns, $reason);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        $cust = str_replace('"', '', $cust);
        $so_  = sprintf('%06d', $so);
        $amt  = number_format($amt, 2);

        /*
        stat
        //pending:
        //approved
        //disapproved
         */
        if ($vs == 'NO') {
          $stat = 'Pending';
        } elseif ($vs == 'YES' && $ns == 'YES') {
          $stat = 'Approved';
        } elseif ($ns == 'DISAPPROVED') {
          $stat = 'Disapproved - ' . $reason;
        }

        echo "
                <tr>
                    <td>$so_</td>
                    <td>$cust</td>
                    <td>$add</td>
                    <td>$terms</td>
                    <td>$amt</td>
                    <td>$stat</td>
                    <td>
                    <a href='javascript:void(0);' data-href='view_so?so=$so' class='view'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i> &nbsp;View Details</button></a>
                    </td>
                </tr>
                ";
      }
    }
  }

  public function show_data_sidr() {
    include 'connection.php';

    $stmt = $con->prepare('SELECT `SI_Number`, DR_Number, tbl_customers.CompanyName, `TotalAmount`, SI_Returned_Date,  DR_Returned_Date, DR_Countered, SONumber, Balance FROM `tbl_sales_order` JOIN tbl_customers ON tbl_customers.CustomerID = tbl_sales_order.CustomerID WHERE SI_Number IS NOT NULL AND DR_Number IS NOT NULL');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($si, $dr, $cust, $amt, $sid, $drd, $drc, $so, $bal);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        $cust = str_replace('"', '', $cust);
        $amt  = number_format($amt, 2);
        if ($bal <= 0) {
          $x = '(paid)';
        } else {
          $x = '';
        }

        echo "
                <tr>
                    <td>$si</td>
                    <td>$dr</td>
                    <td>$cust</td>
                    <td>$amt $x</td>
                    <td>
                    <center>";

        if ($sid == '0000-00-00') {
          echo "<input type='checkbox' id='$si' onclick='tick_si(\"" . $si . "\")'>";
        } else {
          echo date_format(date_create($sid), 'F j, Y');
        }

        echo
          '</center></td>
                    <td>
                    <center>';

        if ($drd == '0000-00-00') {
          echo "<input type='checkbox' id='$dr' onclick='tick_dr(\"" . $dr . "\")'>";
        } else {
          echo date_format(date_create($drd), 'F j, Y');
        }

        echo
          '</center>
                </td>
                    <td>';

        //check if DR_countered is NULL -> input date, Not null -> DR_Countered Date
        if ($drc != null) {
          $drc = date_format(date_create($drc), 'F j, Y');
          echo $drc;
        } else {
          echo "
                        <center>
                        <a href='javascript:void(0);' data-href='view_drc.php?dr=$dr' class='viewDrc'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-calendar'></i> &nbsp;DR Delivered</button></a>
                        </center>
                        ";
        }

        //buttons here
        echo
          '</td>
                    <td>';

        if ($drc != null) {
          echo "
                        <center>
                        <a href='javascript:void(0);' data-href='view_record_si.php?si=$si' class=' viewRec'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i> &nbsp;View Records</button></a>";

          if ($bal > 0.00) {
            echo " <a href='javascript:void(0);' data-href='view_cdm.php?c_so=$so' class='viewCdm'><button type='button' class='btn btn-primary btn-sm'><i class='fa fa-file'></i> &nbsp;Credit M.</button></a>
                            <a href='javascript:void(0);' data-href='view_cdm.php?d_so=$so' class='viewCdm'><button type='button' class='btn btn-warning btn-sm'><i class='fa fa-file'></i> &nbsp;Debit M.</button></a>
                            <a href='javascript:void(0);' data-href='view_cdm.php?r_so=$so' class='viewCdm'><button type='button' class='btn btn-default btn-sm'><i class='fa fa-file'></i> &nbsp;Rebates</button></a>
                            </center>


                            ";
          } else {
            echo " <button type='button' class='btn btn-primary disabled btn-sm'><i class='fa fa-file'></i> &nbsp;Credit M.</button>
                            <button type='button' disabled class='btn btn-warning btn-sm'><i class='fa fa-file'></i> &nbsp;Debit M.</button>
                            <button type='button' disabled class='btn btn-default btn-sm'><i class='fa fa-file'></i> &nbsp;Rebates</button>
                            </center>
                            ";
          }
        }

        echo '
                    </td>
                </tr>
                ';
      }
    } else {
      echo "
            <tr>
            <td colspan='8'><center>No data to show...</center></td>
            </tr>
            ";
    }
  }

  public function show_data_approve() {
    include 'connection.php';

    $stmt  = $con->prepare('SELECT `SONumber`, tbl_customers.CompanyName, tbl_terms.DaysLabel, `TotalAmount`, Remarks FROM `tbl_sales_order` JOIN tbl_customers ON tbl_customers.CustomerID = tbl_sales_order.CustomerID JOIN tbl_terms ON tbl_terms.Term_ID = tbl_sales_order.Terms WHERE VerifiedStatus=? AND NotedStatus=?');
    $stat  = 'YES';
    $noted = 'NO';
    $stmt->bind_param('ss', $stat, $noted);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($so, $cust, $terms, $amt, $remarks);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        $cust = str_replace('"', '', $cust);
        $so_  = sprintf('%06d', $so);
        $amt  = number_format($amt, 2);
        echo "
                <tr>
                    <td>$so_</td>
                    <td>$cust</td>
                    <td>$terms</td>
                    <td>$amt</td>
                    <td>$remarks</td>
                        <td>
                        <center>
                        <a href='javascript:void(0);' data-href='view_so?so=$so' class='view'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i> &nbsp;View Details</button></a>

                            <button type='button' id='$so' class='btn btn-primary btn-sm openView'><i class='fa fa-check'></i> &nbsp;Approve</button>
                            <a href='javascript:void(0);' data-href='view_disapprove.php?so=$so' class='disapprove'><button type='button' class='btn btn-warning btn-sm'><i class='fa fa-times'></i> &nbsp;Disapprove</button></a>
                        </center>
                        </td>

                </tr>
                ";
      }
    }
  }

  public function show_data_approved() {
    include 'connection.php';

    $stmt  = $con->prepare('SELECT `SONumber`, tbl_customers.CompanyName, `TotalAmount`, `DeductedAmount`, `DeductedStatus`, `DateCreated`, tbl_terms.DaysLabel FROM `tbl_sales_order` JOIN tbl_customers ON tbl_customers.CustomerID = tbl_sales_order.CustomerID JOIN tbl_terms ON tbl_terms.Term_ID=tbl_sales_order.Terms WHERE VerifiedStatus=? AND NotedStatus=?');
    $stat  = 'YES';
    $noted = 'YES';
    $stmt->bind_param('ss', $stat, $noted);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($so, $cust, $amt, $deduct, $dedstat, $date, $terms);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {

        $cust = str_replace('"', '', $cust);
        $so_  = sprintf('%06d', $so);
        if ($deduct == NULL) {
          $deduct = 0;
        }
        $ded_amt = $amt - $deduct;
        $date    = date_format(date_Create($date), 'F j, Y');

        $ded_amt = number_format($ded_amt, 2);
        $deduct  = number_format($deduct, 2);
        $amt     = number_format($amt, 2);

        echo "
                <tr>
                    <td>$so_</td>
                    <td>$cust</td>
                    <td>$amt</td>
                    <td>$terms</td>
                    <td>$date</td>
                        <td>
                        <center>
                    <a href='javascript:void(0);' data-href='view_so?so=$so&approved' class='view'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i> &nbsp;View Details</button></a>
                    </center>
                        </td>
                </tr>
                ";
      }
    } else {
      echo "
            <tr>
            <td colspan='6'><center>No data to show...</center></td>
            </tr>
            ";
    }
  }

  /**
   * @param $so
   */
  public function check_dr($so) {
    include 'connection.php';

    $stmt = $con->prepare('SELECT `DR_Number` FROM `tbl_sales_order` WHERE SONumber=?');
    $stmt->bind_param('i', $so);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($dr);
    $stmt->fetch();

    if ($dr != null) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * @param $so
   */
  public function check_si($so) {
    include 'connection.php';

    $stmt = $con->prepare('SELECT `SI_Number` FROM `tbl_sales_order` WHERE SONumber=?');
    $stmt->bind_param('i', $so);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($si);
    $stmt->fetch();

    if ($si != null) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * @param $so
   */
  public function check_credit($so) {
    include 'connection.php';

    $stmt = $con->prepare('SELECT `CreditStatus` FROM `tbl_sales_order` WHERE SONumber=?');
    $stmt->bind_param('i', $so);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($stat);
    $stmt->fetch();

    if ($stat == 'YES') {
      return true;
    } else {
      return false;
    }
  }

  /**
   * @param $so
   */
  public function check_debit($so) {
    include 'connection.php';

    $stmt = $con->prepare('SELECT `DebitStatus` FROM `tbl_sales_order` WHERE SONumber=?');
    $stmt->bind_param('i', $so);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($stat);
    $stmt->fetch();

    if ($stat == 'YES') {
      return true;
    } else {
      return false;
    }
  }

  public function show_data_disapproved() {
    include 'connection.php';

    $stmt  = $con->prepare('SELECT `SONumber`, tbl_customers.CompanyName, `TotalAmount`, `DeductedAmount`, `DeductedStatus`, Reason FROM `tbl_sales_order` JOIN tbl_customers ON tbl_customers.CustomerID = tbl_sales_order.CustomerID WHERE VerifiedStatus=? AND NotedStatus=?');
    $stat  = 'YES';
    $noted = 'DISAPPROVED';
    $stmt->bind_param('ss', $stat, $noted);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($so, $cust, $amt, $deduct, $dedstat, $reason);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {

        $cust = str_replace('"', '', $cust);
        $so_  = sprintf('%06d', $so);
        if ($deduct == NULL) {
          $deduct = 0;
        }
        $ded_amt = $amt - $deduct;

        $ded_amt = number_format($ded_amt, 2);
        $deduct  = number_format($deduct, 2);
        $amt     = number_format($amt, 2);

        echo "
                <tr>
                    <td>$so_</td>
                    <td>$cust</td>
                    <td>$amt</td>
                    <td>$deduct</td>
                    <td>$ded_amt</td>
                        <td>
                        $reason
                        </td>
                    <td>
                    <a href='javascript:void(0);' data-href='view_resend.php?so=$so_' class='resend'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-check'></i> &nbsp;Resend for Approval</button></a>
                    </td>
                </tr>
                ";
      }
    } else {
      echo "
            <tr>
            <td colspan='6'><center>No data to show...</center></td>
            </tr>
            ";
    }
  }

  public function pd_checks(){
    include 'connection.php';

    $stmt = $con->prepare('SELECT `PaymentID`, `BankName`, `CheckNumber`, `CheckDate`, `AmountReceived` FROM `tbl_payment` WHERE `PostDated`="YES" AND Cleared="NO"');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($pid, $bank, $cnum, $cdate, $amt);
    if($stmt->num_rows > 0){
      while($stmt->fetch()){
        $cdate = date_format(date_create($cdate), "F j, Y");
        $amt = number_format($amt, 2);
        
        echo "
        <tr>
          <td>$bank</td>
          <td>$cnum</td>
          <td>$cdate</td>
          <td>$amt</td>
          <td>
          <center>
            <a href='models/sales_order_aed.php?clear=$pid'><button class='btn btn-primary btn-sm'>Mark as Cleared</button></a>
          </center>
          </td>
        </tr>
        ";
      }
    }
  }

  public function show_payment_rec() {
    include 'connection.php';

    $stmt = $con->prepare('SELECT `SONumber`, tbl_customers.CompanyName, `Balance`, TotalAmount, DeductedAmount, SI_Number, DR_Number, CreditAmount, DebitAmount, RebateAmount, DR_Countered FROM `tbl_sales_order` JOIN tbl_customers ON tbl_customers.CustomerID = tbl_sales_order.CustomerID WHERE SI_Number IS NOT NULL AND DR_Number IS NOT NULL');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($so, $cust, $bal, $ta, $da, $si, $dr, $credit, $debit, $rebate, $drc);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        $cust   = str_replace('"', '', $cust);
        $so_    = sprintf('%06d', $so);
        $topay  = number_format(($ta - $da - $credit) + $debit, 2);
        $bal    = number_format($bal ?? $ta, 2);
        $credit = number_format($credit, 2);
        $debit  = number_format($debit, 2);
        $rebate = number_format($rebate, 2);
        $ta     = number_format($ta, 2);

        date_default_timezone_set('Asia/Manila');
        $date1 = date_create(date('Y-m-d'));
        $date2 = date_create($drc);
        $diff  = date_diff($date2, $date1);
        $age   = $diff->format('%R%a days');

        echo '
                <tr>
                    <td>' . str_pad($so, 6, '0', STR_PAD_LEFT) . "</td>
                    <td>$si</td>
                    <td>$dr</td>
                    <td>$cust</td>
                    <td>$ta</td>
                    <td>$rebate</td>
                    <td>$credit</td>
                    <td>$debit</td>
                    <td>" . ($bal == 0 ? 'PAID' : $bal) . "</td>
                    <td style='font-weight:bold; color: red'>" . ($bal != 0 ? $age : '') . '</td>
                        <td>
                        <center>
                        ' . ($bal != 0 ? "<a href='javascript:void(0);' data-href='view_payments?so=$so' class='view'><button type='button' id='$so' class='btn btn-primary btn-sm openView'><i class='fa fa-money'></i> &nbsp;Add Payment</button></a>" : "<a href='javascript:void(0);' data-href='view_record_si.php?si=$si' class=' viewRec'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i> &nbsp;View Records</button></a>") .
          '</center>
                        </td>
                </tr>
                ';
      }
    }
  }
}
?>
