<?php
include 'payment_aed.php';

class Payment{
    public $sum;

  public function show_data($id){
      include 'connection.php';

      $stmt = $con->prepare('SELECT `PR_Number`, `CR_Number`, `BankName`, `CheckNumber`, `DateReceived`, `AmountReceived` FROM `tbl_payment` p JOIN tbl_sales_order so ON p.SONumber=so.SONumber  WHERE so.SI_Number=?');
      $stmt->bind_param('s', $id);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($pr, $cr, $bank, $check, $date, $amt);
      if($stmt->num_rows > 0){
        while($stmt->fetch()){
            $date = date_format(date_create($date), 'F j, Y');
            $amt = number_format($amt, 2);
            echo "
            <tr>
            <td>$pr</td>
            <td>$cr</td>
            <td>$bank</td>
            <td>$check</td>
            <td>$date</td>
            <td>$amt</td>
            </tr>
            ";
        }
      }
      else{
          echo "
          <tr>
          <td colspan='6'><center>No payment transactions yet...</center></td>
          </tr>
          ";
      }
  }

  public function show_misc($id){
    include 'connection.php';

    $stmt = $con->prepare('SELECT `Description`, `Amount` FROM tbl_misc_payment mp JOIN tbl_misc m ON m.MiscID=mp.MiscID JOIN tbl_payment p ON p.PaymentID=mp.PaymentID JOIN tbl_sales_order so ON so.SONumber=p.SONumber WHERE so.SI_Number=?');
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($d, $amt);
    if($stmt->num_rows > 0){
      while($stmt->fetch()){
          $amt = number_format($amt, 2);
          echo "
          <tr>
          <td>$d</td>
          <td>$amt</td>
          </tr>
          ";
      }
    }
    else{
        echo "
        <tr>
        <td colspan='2'><center>No payment transactions yet...</center></td>
        </tr>
        ";
    }
}
  
  public function get_total_payment($id){
      include 'connection.php';

      $stmt = $con->prepare('SELECT SUM(AmountReceived) FROM `tbl_payment` p JOIN tbl_sales_order so ON p.SONumber=so.SONumber  WHERE so.SI_Number=?');
      $stmt->bind_param('s', $id);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($sum);
      $stmt->fetch();

      $this->sum = number_format($sum,2);
  }
}
?>