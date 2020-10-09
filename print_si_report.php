<style>
.pagebreak { page-break-before: always; } /* page-break-after works, as well */
</style>

<?php
include 'css.php';
include 'models/sales_order_model.php';

$filter = $_POST['filter_imp'];

if($filter == 'all'){
    $sql = "SELECT `SI_Number`, `DR_Number`, CompanyName, `Address`, DaysLabel, `PONumber`, `DateCreated`, `TotalAmount`, `Balance` FROM `tbl_sales_order` JOIN tbl_supplier ON tbl_supplier.SupplierID=tbl_sales_order.CustomerID JOIN tbl_terms ON tbl_terms.Term_ID=tbl_sales_order.Terms WHERE DR_Number IS NOT NULL AND SI_Number IS NOT NULL";
}
else{
    $col = $_POST['column'];
    $value = $_POST['value'];

    if($col == 'SI_Number'){
        $sql = "SELECT `SI_Number`, `DR_Number`, CompanyName, `Address`, DaysLabel, `PONumber`, `DateCreated`, `TotalAmount`, `Balance` FROM `tbl_sales_order` JOIN tbl_supplier ON tbl_supplier.SupplierID=tbl_sales_order.CustomerID JOIN tbl_terms ON tbl_terms.Term_ID=tbl_sales_order.Terms WHERE DR_Number IS NOT NULL AND SI_Number IS NOT NULL AND SI_Number='$value'";
    }
    elseif($col == 'DR_Number'){
        $sql = "SELECT `SI_Number`, `DR_Number`, CompanyName, `Address`, DaysLabel, `PONumber`, `DateCreated`, `TotalAmount`, `Balance` FROM `tbl_sales_order` JOIN tbl_supplier ON tbl_supplier.SupplierID=tbl_sales_order.CustomerID JOIN tbl_terms ON tbl_terms.Term_ID=tbl_sales_order.Terms WHERE DR_Number IS NOT NULL AND SI_Number IS NOT NULL AND DR_Number='$value'";
    }
    elseif($col == 'Company'){
        $sql = "SELECT `SI_Number`, `DR_Number`, CompanyName, `Address`, DaysLabel, `PONumber`, `DateCreated`, `TotalAmount`, `Balance` FROM `tbl_sales_order` JOIN tbl_supplier ON tbl_supplier.SupplierID=tbl_sales_order.CustomerID JOIN tbl_terms ON tbl_terms.Term_ID=tbl_sales_order.Terms WHERE DR_Number IS NOT NULL AND SI_Number IS NOT NULL AND CompanyName LIKE '%$value%'";
    }
}

$so = new Sales_Order();
?>

<body>
                <center><h1>Sales Invoice Report</h1></center>
                <br>

                  <tbody>
                  <?php
                    //TODO!!!!!!
                    
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
        document.location.href = 'sidr_records';
    }
</script>