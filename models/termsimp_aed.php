<?php
if(isset($_POST['save'])){ //new record
    include 'connection.php';

   $term = $_POST['term'];

    $stmt = $con->prepare('INSERT INTO `tbl_payment_terms`(`PaymentTerms`) VALUES (?)');
    $stmt->bind_param('s', $term);
    if($stmt->execute()){
        header('location: ../terms_imp?success');
    }
}
elseif(isset($_POST['update'])){ //update record
    include 'connection.php';

   $term = $_POST['term'];
   $id = $_GET['id'];

    $stmt = $con->prepare('UPDATE `tbl_payment_terms` SET `PaymentTerms`=? WHERE PT_ID=?');
    $stmt->bind_param('si', $term, $id);
    if($stmt->execute()){
        header('location: ../terms_imp?edited');
    }
}
elseif(isset($_GET['id_delete'])){
    include 'connection.php';

    $id = $_GET['id_delete'];
    $d = 'YES';
    $stmt = $con->prepare('UPDATE `tbl_payment_terms` SET `Deleted`=? WHERE PT_ID=?');
    $stmt->bind_param('si', $d, $id);
    if($stmt->execute()){
        header('location: ../terms_imp?deleted');
    }
}
?>