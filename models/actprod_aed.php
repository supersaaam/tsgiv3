<?php
if(isset($_POST['update'])){ //update record
    include 'connection.php';
    $id = $_GET['id'];
    $price = $_POST['price'];
    $min = $_POST['min'];
    $max = $_POST['max'];
    $stock = $_POST['stock'];
    $usdprice = $_POST['usdprice'];
    $pnum= $_POST['pnum'];
    $currency= $_POST['currency'];
    $description = $_POST['description'];
    
    $stmt = $con->prepare('UPDATE `tbl_tsgi_product` SET USDPrice=?, `Price`=?, `MinLevel`=?, `MaxLevel`=?, CurrentStock=?, PartNumber=?, Currency=?, ProductDescription=? WHERE `ProductID`=?');
    $stmt->bind_param('ddiiisssi', $usdprice, $price, $min, $max, $stock, $pnum, $currency, $description, $id);
    if($stmt->execute()){
        header('location: ../actual_product?edited');
    }
    else{
        header('location: ../actual_product?partnumber');
    }
}
elseif(isset($_POST['update_indent'])){ //update record
    include 'connection.php';
    $id = $_GET['id'];
    $price = $_POST['price'];
    $min = $_POST['min'];
    $max = $_POST['max'];
    $stock = $_POST['stock'];
    $usdprice = $_POST['usdprice'];
    $pnum= $_POST['pnum'];
    $currency= $_POST['currency'];
    $description = $_POST['description'];

    $stmt = $con->prepare('UPDATE `tbl_tsgi_product` SET USDPrice=?, `Price`=?, `MinLevel`=?, `MaxLevel`=?, CurrentStock=?, PartNumber=?, Currency=?, ProductDescription=? WHERE `ProductID`=?');
    $stmt->bind_param('ddiiisssi', $usdprice, $price, $min, $max, $stock, $pnum, $currency, $description, $id);
    if($stmt->execute()){
        header('location: ../indent_products?edited');
    }
    else{
        header('location: ../indent_products?partnumber');
    }
}
elseif(isset($_FILES['docs'])){
    
include 'connection.php';
if($_FILES['docs']['error'] == UPLOAD_ERR_OK){
    if($_FILES["docs"]["type"] == "image/gif"
	|| $_FILES["docs"]["type"] == "image/png"
	|| $_FILES["docs"]["type"] == "image/jpeg"
	|| $_FILES["docs"]["type"] == "image/jpg"
	|| $_FILES["docs"]["type"] == "image/pjpeg"){

        $pid = $_POST['prod_id'];
        $uploaddir = '../images/attachments/inventory/'.$pid;

        if(!file_exists($uploaddir)){
            mkdir($uploaddir);
        }

        $uploadfile = $uploaddir .'/'. basename($_FILES['docs']['name']);

   // Upload file
   move_uploaded_file($_FILES['docs']['tmp_name'], $uploadfile);
   
   //insert to database
   $stmt = $con->prepare('UPDATE `tbl_tsgi_product` SET `ImagePath`=? WHERE `ProductID`=?');
   $title = basename($_FILES['docs']['name']);
   $stmt->bind_param('si', $uploadfile, $pid);
   $stmt->execute();
   
 }
 header('location: ../actual_product?image_success');
}
else{
 header('location: ../actual_product?image_error');
}

}
elseif(isset($_GET['remove_photo'])){
    
    include 'connection.php';
    $pid = $_GET['remove_photo'];
    
    //insert to database
   $stmt = $con->prepare('UPDATE `tbl_tsgi_product` SET `ImagePath`=NULL WHERE `ProductID`=?');
   $stmt->bind_param('i', $pid);
   $stmt->execute();
   
   header('location: ../actual_product?image_removed');
}
?>