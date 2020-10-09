<?php
if(isset($_FILES['docs'])){
include 'connection.php';
if($_FILES['docs']['error'] !== UPLOAD_ERR_OK){
    $countfiles = count($_FILES['docs']['name']);
 
  // Looping all files
 for($i=0;$i<$countfiles;$i++){
        
        $id = $_POST['id'];
        $uploaddir = '../images/attachments/'.$id;

        if(!file_exists($uploaddir)){
            mkdir($uploaddir);
        }

        $uploadfile = $uploaddir .'/'. basename($_FILES['docs']['name'][$i]);

echo $_FILES['docs']['tmp_name'][$i];

   // Upload file
   move_uploaded_file($_FILES['docs']['tmp_name'][$i], $uploadfile);
   
   //insert to database
   $stmt = $con->prepare('INSERT INTO `tbl_tsgi_so_docs`(`SO_ID`, `DocumentPath`, `FileTitle`) VALUES (?, ?, ?)');
   $title = basename($_FILES['docs']['name'][$i]);
   $stmt->bind_param('iss', $id, $uploadfile, $title);
   $stmt->execute();
   
 }      
        echo"
        <script>window.location.href='../po_details?id=$id&uploaded';</script>
        ";
}
else{
    //redirect to page -> not uploaded
    echo"
        <script>window.location.href='../po_details?id=$id&not_uploaded';</script>
        ";
}
}
elseif(isset($_GET['delete'])){
    $id = $_GET['id'];
    $so_id = $_GET['so_id'];

    include 'connection.php';

    $stmt = $con->prepare('DELETE FROM `tbl_tsgi_so_docs` WHERE `SO_Docs_ID`=?');
    $stmt->bind_param('i', $id);
    if($stmt->execute()){
        echo"
        <script>window.location.href='../po_details?id=$so_id&deleted';</script>
        ";
    }
}

class Attachment{
     public function show_data($id){
         include 'connection.php';

         $stmt = $con->prepare('SELECT `SO_Docs_ID`, `SO_ID`, `DocumentPath`, FileTitle FROM `tbl_tsgi_so_docs` WHERE SO_ID=?');
         $stmt->bind_param('i', $id);
         $stmt->execute();
         $stmt->store_result();
         $stmt->bind_result($id, $so_id, $docpath, $title);
         if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $docpath = substr($docpath, 3);
                echo "
                <tr>
                    <td><a href='$docpath' style='color: black; text-decoration: underline' target='_blank'>$title  </a><span class='pull-right' style='margin-right: 10%'>(Click file name to view..)</span></td>
                    <td><a href='models/po_attachment_model.php?delete&id=$id&so_id=$so_id'><button class='btn btn-danger btn-sm'><i class='fa fa-trash'></i>&nbsp;&nbsp;Delete File</button></a></td>
                </tr>
                ";    
            }
         }
     }

     public function show_data_($id){
        include 'connection.php';

        $stmt = $con->prepare('SELECT `ImpDocs_ID`, `ProformaInvNo`, `DocumentPath`, FileTitle FROM `tbl_imp_docs` WHERE ProformaInvNo=?');
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $invnum, $docpath, $title);
        if($stmt->num_rows > 0){
           while($stmt->fetch()){
               $docpath = substr($docpath, 3);
               echo "
               <tr>
                   <td><a href='$docpath' style='color: black; text-decoration: underline' target='_blank'>$title  </a><span class='pull-right' style='margin-right: 10%'>(Click file name to view..)</span></td>
                   <td><button disabled class='btn btn-danger btn-sm'><i class='fa fa-trash'></i>&nbsp;&nbsp;Delete File</button></td>
               </tr>
               ";    
           }
        }
    }
} 
?>