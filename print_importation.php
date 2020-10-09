<style>
.pagebreak { page-break-before: always; } /* page-break-after works, as well */
</style>

<?php
include 'css.php';
include 'models/importation_model.php';

$filter = $_POST['filter_imp'];

if ($filter == 'all') {
  $sql = 'SELECT `ProformaInvNo`, `ProformaInvDate`, `CompanyName`, `DeliveryStatus`, `DeliveredDate`, `Total`, `Balance` FROM `tbl_importation` i JOIN tbl_supplier s ON s.SupplierID=i.SupplierID';
} else {
  $col   = $_POST['column'];
  $value = $_POST['value'];

  if ($col == 'Supplier') {
    $sql = "SELECT `ProformaInvNo`, `ProformaInvDate`, `CompanyName`, `DeliveryStatus`, `DeliveredDate`, `Total`, `Balance` FROM `tbl_importation` i JOIN tbl_supplier s ON s.SupplierID=i.SupplierID WHERE CompanyName='$value'";
  } elseif ($col == 'Delivery Status') {
    $sql = "SELECT `ProformaInvNo`, `ProformaInvDate`, `CompanyName`, `DeliveryStatus`, `DeliveredDate`, `Total`, `Balance` FROM `tbl_importation` i JOIN tbl_supplier s ON s.SupplierID=i.SupplierID WHERE DeliveryStatus='$value'";
  } elseif ($col == 'Proforma Invoice') {
    $sql = "SELECT `ProformaInvNo`, `ProformaInvDate`, `CompanyName`, `DeliveryStatus`, `DeliveredDate`, `Total`, `Balance` FROM `tbl_importation` i JOIN tbl_supplier s ON s.SupplierID=i.SupplierID WHERE ProformaInvNo='$value'";
  } elseif ($col == 'Proforma Invoice Date') {
    $value = date('Y-m-d', strtotime($value));
    $sql   = "SELECT `ProformaInvNo`, `ProformaInvDate`, `CompanyName`, `DeliveryStatus`, `DeliveredDate`, `Total`, `Balance` FROM `tbl_importation` i JOIN tbl_supplier s ON s.SupplierID=i.SupplierID WHERE ProformaInvDate='$value'";
  } elseif ($col == 'Origin') {
    $sql = "SELECT `ProformaInvNo`, `ProformaInvDate`, `CompanyName`, `DeliveryStatus`, `DeliveredDate`, `Total`, `Balance` FROM `tbl_importation` i JOIN tbl_supplier s ON s.SupplierID=i.SupplierID WHERE Origin='$value'";
  }
}

$imp = new Importation();
?>

<body>
                <center><h1>Importation Report</h1></center>
                <br>

                  <tbody>
                  <?php
$imp->show_query($sql);
?>


</body>

<?php
include 'js.php';
?>

<script>
    window.print();
        setTimeout("closePrintView()", 1000);
    function closePrintView() {
        document.location.href = 'importation';
    }
</script>
