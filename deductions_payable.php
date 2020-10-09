<?php
include 'models/importation_model.php';

$imp = new Importation();
$id = $_GET['inv'];
$imp->set_data($id);
?>
              <!-- /.card-header -->
              <div class="card-body">
                <form role="form" action="models/payable_model.php" method="post" id="imp_form">
                  
                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th style='width:50%'>Description</th>
                      <th style='width:50%'>Amount</th>
                    </tr>
                  </thead>
                  <tbody id="prod_table">
                      <tr>
                        <td>
                        <input name="desc[]" maxlength='30' type='text' style="background-color:transparent; border:transparent" class="form-control" required placeholder="Type description here ...">
                      </td>
                      <td>
                        <input onkeypress='total()' id='amt1' name="amount[]" min='0' step='any' type='number' style="background-color:transparent; border:transparent" class="form-control" required placeholder="Type amount here ...">
                      </td>
                    </tr>
                    <tr>
                        <td>
                        <input name="desc[]" maxlength='30' type='text' style="background-color:transparent; border:transparent" class="form-control" placeholder="Type description here ...">
                      </td>
                      <td>
                        <input name="amount[]" min='0' onkeypress='total()' id='amt2' step='any' type='number' style="background-color:transparent; border:transparent" class="form-control" placeholder="Type amount here ...">
                      </td>
                    </tr>
                    <tr>
                        <td>
                        <input name="desc[]" maxlength='30' type='text' style="background-color:transparent; border:transparent" class="form-control" placeholder="Type description here ...">
                      </td>
                      <td>
                        <input name="amount[]" min='0' onkeypress='total()' id='amt3' step='any' type='number' style="background-color:transparent; border:transparent" class="form-control" placeholder="Type amount here ...">
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                  <th style='text-align:right'>Total</th>
                  <td><input name="total" type='text' style="background-color:transparent; border:transparent" class="form-control" id='total' readonly value='0.00'></td>
                  </tfoot>
                </table>
                <button type="button" onclick="add_row()" class="btn btn-success btn-sm" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-plus'></i> &nbsp;Add New Row</button>
                
                <div style="clear:both; height:15px;"></div>
                
                <input type='hidden' name='inv' value='<?php echo $id; ?>'>
                <button type="submit" name="deduction" id="print_dr" class="btn btn-primary" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Deductions</button>
                

              </form>
              </div>
              <!-- /.card-body -->

<script>
function save_no_ded(id){
  window.location.href='models/payable_model.php?no_ded='+id;
}

var last_id = 4;

function add_row(){
  var newRow = "<tr><td><input name='desc[]' maxlength='30' type='text' style='background-color:transparent; border:transparent' class='form-control' placeholder='Type description here ...'></td><td><input name='amount[]' onkeypress='total()' id='amt"+last_id+"' min='0' step='any' type='number' style='background-color:transparent; border:transparent' class='form-control amt' placeholder='Type amount here ...'></td></tr>";
  
  $("#prod_table").append(newRow);

  add_function(last_id);
  
  last_id +=1;
}
  
$(document).ready(function() {
  var length = $("#example2 > tbody > tr").length

  for (i = 1; i <= length + 1; i++){
      add_function(i);
    }
});

function add_function(id){
$("#amt"+id).on('keyup', function(){
  var length = $("#example2 > tbody > tr").length
  var sum = 0;

  for (i = 1; i <= length; i++){
    var x = $("#amt"+i).val();
    
    if(isNaN(x) || x == ''){
       x = 0;
    }

    sum += parseFloat(x);
  }
sumx = format(sum);

$("#total").val(sumx);
});
}

function format(n, sep, decimals) {
    sep = sep || "."; // Default to period as decimal separator
    decimals = decimals || 2; // Default to 2 decimals

    return n.toLocaleString().split(sep)[0]
        + sep
        + n.toFixed(decimals).split(sep)[1];
}
</script>