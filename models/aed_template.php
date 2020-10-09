<?php
if(isset($_POST['save'])){ //new record
    include 'connection.php';

   
    $stmt = $con->prepare('');
    $stmt->bind_param();
    if($stmt->execute()){
        header('location: ../customer?success');
    }
}
elseif(isset($_POST['update'])){ //update record
    include 'connection.php';

    

    $stmt = $con->prepare('');
    $stmt->bind_param();
    if($stmt->execute()){
        header('location: ../customer?edited');
    }
}
elseif(isset($_GET['id_delete'])){
    include 'connection.php';

    $id = $_GET['id_delete'];
    $d = 'YES';
    $stmt = $con->prepare('');
    $stmt->bind_param();
    if($stmt->execute()){
        header('location: ../customer?deleted');
    }
}
?>