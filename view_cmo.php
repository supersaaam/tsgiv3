<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];

    include 'models/cmo_cust_model.php';
    $cmo_cust = new CMO_Cust();
?>
    <form action='models/cmo_cust_model.php?id=<?php echo $id; ?>' method='post'>
<?php
    $cmo_cust->show_form($id);
?>
    </form>
<?php
}
?>

                        <datalist id="cmo_list">
                          <?php
                          $cmo_cust->show_data_dl();
                          ?>
                        </datalist>