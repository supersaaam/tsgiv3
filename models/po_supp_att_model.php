<?php
if(isset($_FILES['docs'])){
include 'connection.php';
if($_FILES['docs']['error'] !== UPLOAD_ERR_OK){
    $countfiles = count($_FILES['docs']['name']);
 
  // Looping all files
 for($i=0;$i<$countfiles;$i++){
        
        $id = $_POST['id'];
        $uploaddir = '../images/po_supp_attachments/'.$id;

        if(!file_exists($uploaddir)){
            mkdir($uploaddir);
        }

        $uploadfile = $uploaddir .'/'. basename($_FILES['docs']['name'][$i]);

echo $_FILES['docs']['tmp_name'][$i];

   // Upload file
   move_uploaded_file($_FILES['docs']['tmp_name'][$i], $uploadfile);
   
   //insert to database
   $stmt = $con->prepare('INSERT INTO `tbl_tsgi_po_docs`(`PO_ID`, `DocumentPath`, `FileTitle`) VALUES (?, ?, ?)');
   $title = basename($_FILES['docs']['name'][$i]);
   $stmt->bind_param('iss', $id, $uploadfile, $title);
   $stmt->execute();
   
 }      
        echo"
        <script>window.location.href='../confirmed_po?po=$id&uploaded';</script>
        ";
}
else{
    //redirect to page -> not uploaded
    echo"
        <script>window.location.href='../confirmed_po?po=$id&not_uploaded';</script>
        ";
}
}
elseif(isset($_GET['delete'])){
    $id = $_GET['id'];
    $po_id = $_GET['po_id'];

    include 'connection.php';

    $stmt = $con->prepare('DELETE FROM `tbl_tsgi_po_docs` WHERE `PO_Docs_ID`=?');
    $stmt->bind_param('i', $id);
    if($stmt->execute()){
        echo"
        <script>window.location.href='../confirmed_po?po=$po_id&deleted';</script>
        ";
    }
}

class Attachment{
     public function show_data($id){
         include 'connection.php';

         $stmt = $con->prepare('SELECT `PO_Docs_ID`, `PO_ID`, `DocumentPath`, FileTitle FROM `tbl_tsgi_po_docs` WHERE PO_ID=?');
         $stmt->bind_param('i', $id);
         $stmt->execute();
         $stmt->store_result();
         $stmt->bind_result($id, $po_id, $docpath, $title);
         if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $docpath = substr($docpath, 3);
                echo "
                <tr>
                    <td><a href='$docpath' style='color: black; text-decoration: underline' target='_blank'>$title  </a><span class='pull-right' style='margin-right: 10%'>(Click file name to view..)</span></td>
                    <td><a href='models/po_supp_att_model.php?delete&id=$id&po_id=$po_id'><button class='btn btn-danger btn-sm'><i class='fa fa-trash'></i>&nbsp;&nbsp;Delete File</button></a></td>
                </tr>
                ";    
            }
         }
         else{
             echo "
             <tr>
                <td colspan='2'>
                    <center>No data to show...</center>
                </td>
             </tr>
             ";
         }
     }

} 
?>