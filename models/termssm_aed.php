<?php
if(isset($_POST['save'])){ //new record
    include 'connection.php';

   $term = $_POST['term'];
   $days = $_POST['days'];

    $stmt = $con->prepare('INSERT INTO `tbl_terms`(`DaysLabel`, `Days`) VALUES (?, ?)');
    $stmt->bind_param('si', $term, $days);
    if($stmt->execute()){
        header('location: ../terms_sm?success');
    }
}
elseif(isset($_POST['update'])){ //update record
    include 'connection.php';

   $term = $_POST['term'];
   $days = $_POST['days'];
   $id = $_GET['id'];

    $stmt = $con->prepare('UPDATE `tbl_terms` SET `DaysLabel`=?,`Days`=? WHERE `Term_ID`=?');
    $stmt->bind_param('sii', $term, $days, $id);
    if($stmt->execute()){
        header('location: ../terms_sm?edited');
    }
}
elseif(isset($_GET['id_delete'])){
    include 'connection.php';

    $id = $_GET['id_delete'];
    $d = 'YES';
    $stmt = $con->prepare('UPDATE `tbl_terms` SET `Deleted`=? WHERE Term_ID=?');
    $stmt->bind_param('si', $d, $id);
    if($stmt->execute()){
        header('location: ../terms_sm?deleted');
    }
}
?>