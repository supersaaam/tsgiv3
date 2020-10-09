<style>
.pagebreak { page-break-before: always; } /* page-break-after works, as well */
</style>

<?php
include 'css.php';
include 'models/sales_order_model.php';

$filter = $_POST['filter'];

if($filter == 'all'){
    $sql = "SELECT `SONumber`, c.CompanyName, t.DaysLabel, `PONumber`, `DateCreated`, `TotalAmount`, `Reason` FROM tbl_sales_order so JOIN tbl_customers c ON c.CustomerID=so.CustomerID JOIN tbl_terms t ON t.Term_ID=so.Terms";
}
else{
    $col = $_POST['column'];
    $value = $_POST['value'];

    if($col == 'SO Number'){
        $sql = "SELECT `SONumber`, c.CompanyName, t.DaysLabel, `PONumber`, `DateCreated`, `TotalAmount`, `Reason` FROM tbl_sales_order so JOIN tbl_customers c ON c.CustomerID=so.CustomerID JOIN tbl_terms t ON t.Term_ID=so.Terms WHERE SONumber=$value";
    }
    elseif($col == 'Status'){
        if($value == 'Approved'){
            $sql = "SELECT `SONumber`, c.CompanyName, t.DaysLabel, `PONumber`, `DateCreated`, `TotalAmount`, `Reason` FROM tbl_sales_order so JOIN tbl_customers c ON c.CustomerID=so.CustomerID JOIN tbl_terms t ON t.Term_ID=so.Terms WHERE so.NotedStatus='YES'";
        }
        elseif($value == 'Pending'){
            $sql = "SELECT `SONumber`, c.CompanyName, t.DaysLabel, `PONumber`, `DateCreated`, `TotalAmount`, `Reason` FROM tbl_sales_order so JOIN tbl_customers c ON c.CustomerID=so.CustomerID JOIN tbl_terms t ON t.Term_ID=so.Terms WHERE VerifiedStatus='NO'";
        }
        elseif($value == 'Disapproved'){
            $sql = "SELECT `SONumber`, c.CompanyName, t.DaysLabel, `PONumber`, `DateCreated`, `TotalAmount`, `Reason` FROM tbl_sales_order so JOIN tbl_customers c ON c.CustomerID=so.CustomerID JOIN tbl_terms t ON t.Term_ID=so.Terms WHERE NotedStatus='DISAPPROVED'";
        }
    }
    elseif($col == 'Customer'){
        $sql = "SELECT `SONumber`, c.CompanyName, t.DaysLabel, `PONumber`, `DateCreated`, `TotalAmount`, `Reason` FROM tbl_sales_order so JOIN tbl_customers c ON c.CustomerID=so.CustomerID JOIN tbl_terms t ON t.Term_ID=so.Terms WHERE c.CompanyName LIKE '%$value%'";
    }
}

$so = new Sales_Order();
?>

<body>
                <center><h1>Sales Order Report</h1></center>
                <br>

                  <tbody>
                  <?php
                    $so->show_query_so($sql);
                  ?>

                
</body>

<?php
include 'js.php';
?>

<script>
    window.print();
        setTimeout("closePrintView()", 1000);
    function closePrintView() {
        document.location.href = 'all_so_records';
    }
</script>

