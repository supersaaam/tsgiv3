<?php
class PR{
     public function show_pr(){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT pr.PR_Number, `BrandID`, pr.SO_Number FROM tbl_pr_bd bd JOIN tbl_pr pr ON pr.PR_Number=bd.PR_Number WHERE pr.Status="PENDING" GROUP BY BrandID');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($prnum, $brand, $so);
        
        $prcnt = 0;
        
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                
                $con1 = new mysqli($server, $user, $pw, $db);
                $con2 = new mysqli($server, $user, $pw, $db);
                
                $stmt2 = $con2->prepare('SELECT `CompanyName` FROM tbl_supplier WHERE SupplierID=?');
                $stmt2->bind_param('i', $brand);
                $stmt2->execute();
                $stmt2->store_result();
                $stmt2->bind_result($com);
                $stmt2->fetch();
                $stmt2->close();
                $con2->close();
                
                $stmt1 = $con1->prepare('SELECT `PR_BD`, s.CompanyName, p.ProductDescription, `QtyRequested`, p.USDPrice, p.PartNumber, pr.SO_Number, Purpose FROM tbl_pr_bd bd JOIN tbl_supplier s ON s.SupplierID=bd.BrandID JOIN tbl_tsgi_product p ON p.ProductID=bd.ProductID JOIN tbl_pr pr ON pr.PR_Number=bd.PR_Number WHERE bd.Status="PENDING" AND bd.BrandID=? AND s.Revision IS NULL');
                $stmt1->bind_param('i', $brand);
                $stmt1->execute();
                $stmt1->store_result();
                $stmt1->bind_result($prbd, $company, $prod, $q, $p, $pnum, $so_, $purpose);
                if($stmt1->num_rows > 0){
         
         $prcnt++;
         
   echo "
    
    <!-- Content Header (Page header) -->
    <section class='content-header'>
      <h1>
      Pending Purchase Requests to $com
      </h1>
    </section>

    <!-- Main content -->
    <section class='content'>
    <div class='box'>
    <div class='box-body'>
              <table id='example2' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <th style='width:5%'>Item No.</th>
                  <th style='width:10%'>Purpose</th>
                  <th style='width:13%'>Part Num</th>
                  <th style='width:20%'>Product Description</th>
                  <th style='width:8%'>Qty</th>
                  <th style='width:22%'>Price/Unit</th>
                  <th style='width:22%'>Line Total</th>
                </tr>
                </thead>
                <tbody>
   ";
                    $i = 1;
                    while($stmt1->fetch()){
                        $lt = $q * $p;
                        echo "
                        <tr>
                            <td>$i</td>
                            <td>$purpose</td>
                            <td>$pnum</td>
                            <td>$prod</td>
                            <td>$q</td>
                            <td>$p</td>
                            <td>$lt</td>
                        </tr>
                        ";
                        
                        $i++;
                    }
    
    echo "
     </tbody>
              </table>

                
                <button class='btn btn-danger' data-toggle='modal' data-target='#revise$brand' style='float:right; margin-top:30px; margin-right:20px; margin-bottom: 10px'><i class='fa fa-times'></i>&nbsp; Revise PR</button>
                
                <a href='models/pr_aed.php?brand=$brand'><button type='button' name='submit' class='btn btn-success' style='float:right; margin-top:30px; margin-right:20px; margin-bottom: 10px'><i class='fa fa-check'></i> &nbsp;Approve PR</button></a>
                
                
            </div>
            </div>
    </section>
    <!-- /.content -->  
    ";
    
    echo "
    
    <div id='revise$brand' class='modal fade' role='dialog'>
		  <div class='modal-dialog'>
	     	    <form action='models/pr_aed.php' method='post'>
		    <!-- Modal content-->
		    <div class='modal-content'>
		      <div class='modal-header'>
		        <button type='button' class='close' data-dismiss='modal'>&times;</button>
		        <h4 class='modal-title'>Revision</h4>
		      </div>
		      <div class='modal-body'>
		      	<div class='form-group'>
	                    <label>Instructions for revision</label>
	                    <input type='hidden' name='brand' value='$brand'>
	                    <textarea name='remarks' required class='form-control' rows='6' style='resize:none'></textarea>
	                  </div>		      
		      </div>
		      <div class='modal-footer'>
		        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
		        <button type='submit' name='revise' class='btn btn-primary'>Submit</button>
		      </div>
		    </div>
		    </form>
		  </div>
		</div>
            ";
    
                }
                $stmt1->close();
                $con1->close();
                
            }
        }
        $stmt->close();
        $con->close();
        
        $this->prcnt = $prcnt;
        
    }
    
     public function show_pr_revise(){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT pr.PR_Number, `BrandID`, pr.SO_Number FROM tbl_pr_bd bd JOIN tbl_pr pr ON pr.PR_Number=bd.PR_Number WHERE pr.Status="PENDING" GROUP BY BrandID');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($prnum, $brand, $so);
        
        $prcnt = 0;
        
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                
                $con1 = new mysqli($server, $user, $pw, $db);
                $con2 = new mysqli($server, $user, $pw, $db);
                
                $stmt2 = $con2->prepare('SELECT `CompanyName` FROM tbl_supplier WHERE SupplierID=?');
                $stmt2->bind_param('i', $brand);
                $stmt2->execute();
                $stmt2->store_result();
                $stmt2->bind_result($com);
                $stmt2->fetch();
                $stmt2->close();
                $con2->close();
                
                $stmt1 = $con1->prepare('SELECT `PR_BD`, s.CompanyName, p.ProductDescription, `QtyRequested`, p.USDPrice, p.PartNumber, pr.SO_Number, s.Revision, Purpose FROM tbl_pr_bd bd JOIN tbl_supplier s ON s.SupplierID=bd.BrandID JOIN tbl_tsgi_product p ON p.ProductID=bd.ProductID JOIN tbl_pr pr ON pr.PR_Number=bd.PR_Number WHERE bd.Status="PENDING" AND bd.BrandID=? AND s.Revision IS NOT NULL');
                $stmt1->bind_param('i', $brand);
                $stmt1->execute();
                $stmt1->store_result();
                $stmt1->bind_result($prbd, $company, $prod, $q, $p, $pnum, $so_, $revs, $purpose);
                if($stmt1->num_rows > 0){

$prcnt++;

   echo "
    
    <!-- Content Header (Page header) -->
    <section class='content-header'>
      <h1>
       Purchase Requests to $com (For Revision)
      </h1>
    </section>

    <!-- Main content -->
    <section class='content'>
    <div class='box'>
    <div class='box-body'>
              <table id='example2' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <th style='width:5%'>Item No.</th>
                  <th style='width:10%'>Purpose</th>
                  <th style='width:13%'>Part Number</th>
                  <th style='width:33%'>Product Description</th>
                  <th style='width:8%'>Qty</th>
                  <th style='width:22%'>Price/Unit</th>
                  <th style='width:22%'>Line Total</th>
                </tr>
                </thead>
                <tbody>
   ";
                    $i = 1;
                    while($stmt1->fetch()){
                        $lt = $q * $p;
                        echo "
                        <tr>
                            <td>$i</td>
                            <td>$purpose</td>
                            <td>$pnum</td>
                            <td>$prod</td>
                            <td>$q</td>
                            <td>$p</td>
                            <td>$lt</td>
                        </tr>
                        ";
                        
                        $i++;
                    }
    
    echo "
     </tbody>
              </table>
                <br>
                <b>Revisions:</b>
                <br>
                <span>$revs</span>
                
                <a href='edit_pr?brand=$brand'><button class='btn btn-warning' data-toggle='modal' data-target='#revise$brand' style='float:right; margin-top:30px; margin-right:20px; margin-bottom: 10px'><i class='fa fa-edit'></i>&nbsp; Edit PR</button></a>
                
                
            </div>
            </div>
    </section>
    <!-- /.content -->  
    ";
    
                }
                $stmt1->close();
                $con1->close();
                
            }
        }
        $stmt->close();
        $con->close();
        
        $this->prcnt = $prcnt;
    }
    
    public function show_pr_approved(){
        include 'connection.php';
        
        $stmt = $con->prepare('SELECT pr.PR_Number, `BrandID`, pr.SO_Number FROM tbl_pr_bd bd JOIN tbl_pr pr ON pr.PR_Number=bd.PR_Number WHERE pr.Status="PENDING" GROUP BY BrandID');
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($prnum, $brand, $so);
        
        $prcnt = 0;
        
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                
                $con1 = new mysqli($server, $user, $pw, $db);
                $con2 = new mysqli($server, $user, $pw, $db);
                
                $stmt2 = $con2->prepare('SELECT `CompanyName` FROM tbl_supplier WHERE SupplierID=?');
                $stmt2->bind_param('i', $brand);
                $stmt2->execute();
                $stmt2->store_result();
                $stmt2->bind_result($com);
                $stmt2->fetch();
                $stmt2->close();
                $con2->close();
                
                $stmt1 = $con1->prepare('SELECT `PR_BD`, s.CompanyName, p.ProductDescription, `QtyRequested`, p.USDPrice, p.PartNumber, pr.SO_Number, Purpose FROM tbl_pr_bd bd JOIN tbl_supplier s ON s.SupplierID=bd.BrandID JOIN tbl_tsgi_product p ON p.ProductID=bd.ProductID JOIN tbl_pr pr ON pr.PR_Number=bd.PR_Number WHERE bd.Status="APPROVED" AND bd.BrandID=?');
                $stmt1->bind_param('i', $brand);
                $stmt1->execute();
                $stmt1->store_result();
                $stmt1->bind_result($prbd, $company, $prod, $q, $p, $pnum, $so_, $purpose);
                if($stmt1->num_rows > 0){
               
               $prcnt++;
   echo "
    
    <!-- Content Header (Page header) -->
    <section class='content-header'>
      <h1>
      Approved Purchase Requests to $com
      </h1>
    </section>

    <!-- Main content -->
    <section class='content'>
    <div class='box'>
    <div class='box-body'>
              <table id='example2' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <th style='width:5%'>Item No.</th>
                  <th style='width:10%'>Purpose</th>
                  <th style='width:13%'>Part Number</th>
                  <th style='width:20%'>Product Description</th>
                  <th style='width:8%'>Qty</th>
                  <th style='width:22%'>Price/Unit</th>
                  <th style='width:22%'>Line Total</th>
                </tr>
                </thead>
                <tbody>
   ";
                    $i = 1;
                    while($stmt1->fetch()){
                        $lt = $q * $p;
                        echo "
                        <tr>
                            <td>$i</td>
                            <td>$purpose</td>
                            <td>$pnum</td>
                            <td>$prod</td>
                            <td>$q</td>
                            <td>$p</td>
                            <td>$lt</td>
                        </tr>
                        ";
                        
                        $i++;
                    }
    
    echo "
     </tbody>
              </table>

                <a href='pr_po?brand=$brand'><button type='button'  name='submit' class='btn btn-success' style='float:right; margin-top:30px; margin-right:20px; margin-bottom: 10px'><i class='fa fa-file'></i> &nbsp;Send for PO</button></a>
                
            </div>
            </div>
    </section>
    <!-- /.content -->  
    ";
    
                }
                $stmt1->close();
                $con1->close();
                
            }
        }
        $stmt->close();
        $con->close();
        
        $this->prcnt = $prcnt;
        
    }
    
    public function show_pr_revise_bd($brand){
        include 'connection.php';
        
                $con1 = new mysqli($server, $user, $pw, $db);
                $con2 = new mysqli($server, $user, $pw, $db);
                
                $stmt2 = $con2->prepare('SELECT `CompanyName` FROM tbl_supplier WHERE SupplierID=?');
                $stmt2->bind_param('i', $brand);
                $stmt2->execute();
                $stmt2->store_result();
                $stmt2->bind_result($com);
                $stmt2->fetch();
                $stmt2->close();
                $con2->close();
                
                $stmt1 = $con1->prepare('SELECT `PR_BD`, s.CompanyName, p.ProductDescription, `QtyRequested`, p.USDPrice, p.PartNumber, pr.SO_Number, s.Revision, p.ProductID FROM tbl_pr_bd bd JOIN tbl_supplier s ON s.SupplierID=bd.BrandID JOIN tbl_tsgi_product p ON p.ProductID=bd.ProductID JOIN tbl_pr pr ON pr.PR_Number=bd.PR_Number WHERE bd.Status="PENDING" AND bd.BrandID=? AND s.Revision IS NOT NULL');
                $stmt1->bind_param('i', $brand);
                $stmt1->execute();
                $stmt1->store_result();
                $stmt1->bind_result($prbd, $company, $prod, $q, $p, $pnum, $so_, $revs, $pid);
                if($stmt1->num_rows > 0){
                  $i = 1;
                  $prbd_ = '';
                
                  while($stmt1->fetch()){
                     
                    $prbd_ .= $prbd.',';
                     
                    echo "
                    <tr id='tr$i'>
                      <td>
                          <input class='counter' id='$i' type='hidden'>
                          <input type='hidden' name='brand[]' id='brand_$i' value='$com'>
                          <input list='brand_list' id='brand$i' maxlength='50' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...' value='$com'>
                        </td>
                        <td>
                          <input type='hidden' name='productID[]' id='productID$i' value='$pid'>
                          <input id='product$i' name='product[]' readonly maxlength='200' title='Refer to the data list...' style='background-color:transparent; border:transparent; width:95%' class='form-control' required placeholder='Type here ...' value='$prod'>
                        </td>
                        <td>
                          <input type='text' name='ourpartnum[]' id='ourpartnum$i' style='text-align:right; background-color:transparent; border:transparent; width:100%' class='form-control' value='$pnum'>
                        </td>
                        <td>
                          <input type='number' name='quantity[]' id='quan$i' style='text-align:right; background-color:transparent; border:transparent; width:100%' required class='form-control' value='$q'>
                        </td>
                        <td><center><button onclick='deleterow($i)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td>
                      </tr>
                        ";
                        
                        $i++;
                    }
                }
                $stmt1->close();
                $con->close();
                
                $this->rows = $i;
                $this->prbd_ = $prbd_;
    }            
}
?>

















