<?php
include 'css.php';
include 'models/credit_model.php';

$mn = $_GET['mn'];

$f_mn = sprintf('%06d', $mn);

$cr = new Credit();
$cr->set_data($mn);
?>

<body>

                <table id="example2" style='width:100%' >
                    <!-- table-bordered table-striped-->
                  <thead>
                    <tr>
                      <th colspan='6' style='text-align:right; font-size: 100%; font-weight: normal'>Memo Number<br><b><?php echo $f_mn; ?></b></th>
                    </tr>
                    <tr>
                    <td colspan='6'>&nbsp;</td>
                    </tr>
                    <tr>
                      <th colspan='3' style='width:70%; font-size: 100%;'>Credit to: <label style='font-weight:normal'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cr->company; ?></label></th>
                      <th colspan='3' style='width:30%; font-size: 100%;'>Credit Date: <label style='font-weight:normal'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date_format(date_create($cr->date), "F j, Y"); ?></label></th>
                    </tr>
                    <tr>
                      <th colspan='3' style='width:70%; font-size: 100%;'>&nbsp;</label></th>
                      <th colspan='3' style='width:70%; font-size: 100%;'>Invoice Number: <label style='font-weight:normal'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cr->inv; ?></label></th>
                    </tr>
                    <tr>
                      <th colspan='3' style='width:70%; font-size: 100%;'>&nbsp;</th>
                      <th colspan='3' style='width:30%; font-size: 100%;'>DR Number: <label style='font-weight:normal'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cr->dr; ?></label></th>
                    </tr>
                    
                    <tr>
                    <td colspan='6'>&nbsp;</td>
                    </tr>
                    
                  </thead>
                </table>

                <table id="example2" class="table table-bordered table-striped">
                    <!-- table-bordered table-striped-->
                  <thead>
                    <tr>
                      <th style='width:15%; text-align:center; vertical-align:middle'>Quantity</th>
                      <th colspan='3' style='width:55%; text-align:center; vertical-align:middle'>Description</th>
                      <th  style='width:15%; text-align:center; vertical-align:middle'>Unit Price</th>
                      <th  style='width:15%'><center>Amount</center></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $cr->show_data_cm($mn);
                  ?>
                  </tbody>
                </table>

                <table id="example2" class="table table-bordered">
                  <tbody>
                    <tr>
                    <td style='width:60%'>
                    Receiving Information:
                        <br><br><br
                        <b style='text-align:left'>(Printed Name and Signature)</b>
                        <b style='float:right; margin-right:10px'>Date Received</b>
                    </td>
                    <td style='width:40%;margin-left:50px'>
                    <b style='text-align:left'>TOTAL</b>
                        <b style='float:right; margin-right:10px'>PHP <?php echo number_format($cr->total,2); ?></b>
                        <br><br>
                        Issued by: Joanne V. Dela Cruz
                        <br><br>
                        Approved by: Bernadette R. Ordonez
                    </td>
                    </tr> 
                  </tbody>
                </table>
</body>

<?php
include 'js.php';
?>

<script>
    window.print();
        setTimeout("closePrintView()", 1000);
    function closePrintView() {
        document.location.href = 'sidr_records';
    }
</script>