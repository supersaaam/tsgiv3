<script>
window.print();
window.onfocus=function(){ window.close();}
</script>

<?php
include 'css.php';
include 'models/transfer_model.php';

$trans = new Transfer();
$id    = $_GET['id'];
$f_id  = sprintf('%06d', $id);
$trans->set_data($id);
?>

<body>

                <table id="example2" class="table">
                    <!-- table-bordered table-striped-->
                  <thead>
                    <tr>
                      <th colspan='6' style='text-align:right; font-size: 100%; font-weight: normal'>Stock Transfer Form<br><b>No. <?php echo $f_id; ?></b></th>
                    </tr>
                    <tr>
                      <th colspan='3' style='width:50%; font-size: 120%;'>Origin: <label style='font-weight:normal'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $trans->from; ?></label></th>
                      <th colspan='3' style='width:50%; font-size: 120%;'>Shipping Line: <label style='font-weight:normal'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $trans->line; ?></label></th>
                    </tr>
                    <tr>
                      <th colspan='3' style='width:50%; font-size: 120%;'>Destination: <label style='font-weight:normal'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $trans->to; ?></label></th>
                      <th colspan='3' style='width:50%; font-size: 120%;'>Date: <label style='font-weight:normal'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $trans->date; ?></label></th>
                    </tr>
                  </thead>
                </table>

                <table id="example2" class="table table-bordered table-striped">
                    <!-- table-bordered table-striped-->
                  <thead>
                    <tr>
                      <th rowspan='2' style='width:15%; text-align:center; vertical-align:middle'>Qty Transferred</th>
                      <th rowspan='2' style='width:30%; text-align:center; vertical-align:middle'>Product Code</th>
                      <th rowspan='2' style='width:15%; text-align:center; vertical-align:middle'>Remarks</th>
                      <th colspan='2' style='width:40%'><center>Receiving Remarks</center></th>
                    </tr>
                    <tr>
                            <th style=' text-align:center'>Qty</th>
                            <th style=' text-align:center'>Product Condition</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
$trans->show_data_stf($id);
?>
                  </tboy>
                </table>

                <table id="example2" class="table table-bordered">
                  <tbody>
                    <tr>
                        <td style='width:33.3%'>
                        Prepared by:
                        <br><br>
                        <hr style='width:99%;'>
                        <b style='text-align:left'>Sales Department</b>
                        <b style='float:right; margin-right:10px'>Date</b>
                        <br>
                        (Printed name and Signature)
                        </td>
                        <td style='width:33.3%'>
                        Released by:
                        <br><br>
                        <hr style='width:99%;'>
                        <b style='text-align:left'>Warehouse Personnel</b>
                        <b style='float:right; margin-right:10px'>Date</b>
                        <br>
                        (Printed name and Signature)
                        </td>
                        <td style='width:33.3%'>
                        Received by:
                        <br><br>
                        <hr style='width:99%;'>
                        <b style='text-align:left'>Warehouse Personnel</b>
                        <b style='float:right; margin-right:10px'>Date</b>
                        <br>
                        (Printed name and Signature)
                        </td>
                    </tr>
                  </tboy>
                </table>
</body>

<?php
include 'js.php';
?>
