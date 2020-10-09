<script>
window.print();
window.onfocus=function(){ window.close();}
</script>

<?php
include 'css.php';
include 'models/sales_order_model.php';

$filter = $_POST['filter_cmo'];

if ($filter == 'all') {
  $sql = 'SELECT c.CustomerID, CompanyName, so.SONumber, so.SI_Number, so.DR_Number, so.DR_Date, p.PR_Number, p.CR_Number, p.CheckDate, p.AmountReceived FROM tbl_sales_order so JOIN tbl_customers c ON c.CustomerID=so.CustomerID JOIN tbl_payment p ON p.SONumber=so.SONumber';
} else {
  $value = $_POST['value'];
  $sql   = "SELECT c.CustomerID, CompanyName, so.SONumber, so.SI_Number, so.DR_Number, so.DR_Date, p.PR_Number, p.CR_Number, p.CheckDate, p.AmountReceived FROM tbl_sales_order so JOIN tbl_customers c ON c.CustomerID=so.CustomerID JOIN tbl_payment p ON p.SONumber=so.SONumber WHERE CompanyName='$value'";
}

$so = new Sales_Order();
?>

<body>
                <center><h1>Customer Collection Report</h1></center>
                <br>

                <table id="example2" class="table table-bordered table-striped">
                    <!-- table-bordered table-striped-->
                  <thead>
                    <tr>
                      <th style='width:16%; text-align:center; vertical-align:middle'>Customer Name</th>
                      <th style='width:8%; text-align:center; vertical-align:middle'>CMO Name</th>
                      <th style='width:8%; text-align:center; vertical-align:middle'>SO Number</th>
                      <th style='width:8%; text-align:center; vertical-align:middle'>SI Number</th>
                      <th style='width:8%; text-align:center; vertical-align:middle'>DR Number</th>
                      <th style='width:8%; text-align:center; vertical-align:middle'>DR Date</th>
                      <th style='width:8%; text-align:center; vertical-align:middle'>PR/CR</th>
                      <th style='width:8%; text-align:center; vertical-align:middle'>Check Dep Date</th>
                      <th style='width:8%; text-align:center; vertical-align:middle'>Amount Paid</th>
                      <th style='width:8%; text-align:center; vertical-align:middle'>Post Dated Amt</th>
                      <th style='width:8%; text-align:center; vertical-align:middle'>Col Days</th>
                      <th style='width:12%; text-align:center; vertical-align:middle'>Total Amt of Unpaid Rec</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
$so->show_query($sql);
?>

                  <tr>
                  <td colspan='9'><b style='float:right; font-weight:bold'>Total Collection Days:</b></td>
                  <td colspan='2'><?php echo $so->totalx; ?></td>
                  </tr>
                  <tr>
                  <td colspan='9'><b style='float:right; font-weight:bold'>Average Collection Days:</b></td>
                  <td colspan='2'><?php echo $so->avg; ?></td>
                  </tr>
                  </tbody>
                  <tfoot>
                  </tfoot>
                </table>


</body>

<?php
include 'js.php';
?>
