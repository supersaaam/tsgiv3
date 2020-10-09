<?php
include 'models/importation_model.php';
include 'models/imp_prod_model.php';
include 'models/terms_imp_model.php';

$imp = new Importation();
$imp_prod = new Imp_Prod();
$t_imp = new Terms_Imp();
$id = $_GET['inv'];
$imp->set_data($id);
?>
              <!-- /.card-header -->
              <div class="card-body">
                <form role="form" action="models/breakdown_model.php" method="post" id="imp_form">
                      <?php
                      $imp_prod->show_data_bd($id);
                      ?>
                </table>
                <br>
                <input type='hidden' value='<?php echo $id; ?>' name='invnum'>
                <div style='width:200px; float:right; clear:both; margin-bottom:15px'>
                <small><b>NOTE: </b>Make sure to review all your inputs before submitting. This will be recorded to your inventory.</small>
                </div>
               <button type="submit" name="submit_bd" id="submit_new1" class="btn btn-primary" style="clear:both;float:right; margin-top:2px; margin-right:10px"><i class='fa fa-archive'></i> &nbsp;Save to Inventory</button>
              </form>
              </div>
              <!-- /.card-body -->

<script>
    function copyrow(i, q, pack){
        $("#quanbd1"+i).val(q);
        $("#pk"+i).val(pack);
    }

  function add_row1(id, idx){
    var newRow = "<tr id='tr"+id+"'><td colspan='3'></td><td><input type='hidden' value='"+idx+"' name='pq_prod[]'><input list='packaging_list' name='packaging_bd[]' maxlength='50' style='background-color:transparent; border:transparent' class='form-control' placeholder='Please type here...'></td><td><input type='text' maxlength='8' name='quantity_bd[]' style='text-align:right; background-color:transparent; border:transparent' class='form-control num' value='0'></td><td><center><button id='"+id+"' onclick='deleterow(this.id)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td></tr>";
    
    $("#addrow"+id).append(newRow);

    $('.num').keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
  }

  $('.num').keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

function deleterow(id){
  $("#tr"+id).remove();
}      
</script>