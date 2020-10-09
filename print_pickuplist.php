<html>
<style>
@media print {

    html, body {
      height:100vh; 
      margin: 0 !important; 
      padding: 0 !important;
      overflow: hidden;
    }

}
</style>

<?php
include 'css.php';

$so = $_GET['so'];

date_default_timezone_set('Asia/Manila');
$today = date('F j, Y');
session_start();
?>

<body>
    <center>
    <h2>Pick List</h2>
    <h5><b>Date:</b> <?php echo $today; ?></h5>
    <h5><b>PO Reference:</b> <?php echo $_POST['poref']; ?></h5>
    <h5><b>Company:</b> <?php echo $_POST['company']; ?></h5>
    <h5><b>Printed by:</b> <?php echo $_SESSION['name']; ?></h5>
    </center>
    <br>
	<table class="table table-bordered table-striped">
	    <?php
	    if(isset($_POST['submit_dr'])){
	    ?>
	    
	    <thead>
	        <tr>
	        <th style='width: 75%'>Description</th>
	        <th style='width: 25%'>Quantity</th>
	        </tr>
	    </thead>
	    <tbody>
	        <?php
	        $product = $_POST['product'];
	        
	        foreach($product as $k=>$p){
	            $qty_dr = $_POST['qty_dr'][$k];
	            
	            if($qty_dr > 0){
    	            echo "
    	            <tr>
    	                <td>$p</td>
    	                <td>$qty_dr</td>
    	            </tr>
    	            ";
	            }
	        }
	        ?>
	    </tbody>
	    
	    <?php
	    }
	   else{
	    ?>
	    
	    <thead>
	        <tr>
	        <th style='width: 40%'>Description</th>
	        <th style='width: 40%'>Picture</th>
	        <th style='width: 20%'>Quantity</th>
	        </tr>
	    </thead>
	    <tbody>
	        <?php
	        $product = $_POST['product'];
	        
	        foreach($product as $k=>$p){
	            $qty_dr = $_POST['qty_dr'][$k];
	            $pid = $_POST['productID'][$k];
	            
	            include 'models/connection.php';
	            
	            $stmt = $con->prepare('SELECT `ImagePath` FROM `tbl_tsgi_product` WHERE ProductID=?');
	            $stmt->bind_param('i', $pid);
	            $stmt->execute();
	            $stmt->store_result();
	            $stmt->bind_result($img);
	            $stmt->fetch();
	            $stmt->close();
	            $con->close();
	            
	            if($img == NULL){
	                $img = 'No picture yet';
	            }
	            else{
	                $img = substr($img, 3);
	            }
	            
	            if($qty_dr > 0){
                    echo "
    	            <tr>
    	                <td>$p</td>
    	                <td>
    	                <center>";
    	                
    	                if($img == 'No picture yet'){
    	                    echo $img;
    	                }
    	                else{
    	                    echo "<img src='$img' style='width: 80%; margin: 0 auto; height: auto'>";    
    	                }
                        
                        echo "
                        </center>
                        </td>
    	                <td>$qty_dr</td>
    	            </tr>
    	            ";
	            }
	        }
	        ?>
	    </tbody>
	    
	    
	    <?php
	    }
	    ?>
	</table>


</body>
</html>

<?php
include 'js.php';
?>


<script>
    window.print();
    
    setTimeout("closePrintView()", 1000);
    function closePrintView() {
        document.location.href = 'po_details?id=<?php echo $so; ?>';
    }
</script>
