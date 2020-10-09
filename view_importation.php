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
                <form role="form" action="models/importation_model.php" method="post" id="imp_form">
                  <!-- text input -->
                  <div class="col-md-6" style="float:left; padding-right: 30px">

                  <div class="col-md-12">
                  <span id="inv_val1">&nbsp;</span>
                  </div>

                   <!--HIDDEN-->
                   <input type="hidden" required name="prof_inv_no_original" value='<?php echo $imp->invnum; ?>'>
                    <!--HIDDEN-->

                  <div class="form-group" style='float:left; width:48%; margin-right:2%'>
                    <label>Proforma Inv. No.</label>
                    <input type="text" required name="prof_inv_no" maxlength="20" class="form-control" id="inv_input1" onkeyup="loading('inv_val1')" value='<?php echo $imp->invnum; ?>'>
                  </div>
                  
                  <div class="form-group"  style='float:left; width:48%; margin-left:2%'>
                    <label>Date</label>
                    <input type="date" required name="prof_inv_date" class="form-control" value='<?php echo $imp->profdate; ?>'>
                  </div>

                  <div class="form-group"  style='float:left; width:48%; margin-right:2%'>
                    <label>Commercial Inv. No.</label>
                    <input type="text" name="comm_inv_no" maxlength="20" class="form-control" id="" value='<?php echo $imp->comminv; ?>'>
                  </div>
                 
                  <div class="form-group"  style='float:left; width:48%; margin-left:2%'>
                    <label>Date</label>
                    <input type="date" name="comm_inv_date" class="form-control" value='<?php echo $imp->commdate; ?>'>
                  </div>
                  
                  <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>
                  
                  <div class="form-group">
                    <label>Supplier</label>
                    <input list="suppliers_list" required name="supplier" class="form-control" value='<?php echo $imp->supplier; ?>'>
                  </div>

                  <div class="form-group">
                    <label>Payment Term</label>
                     <input list="term_list" required name="term" class="form-control" maxlength="50"  value='<?php echo $term_sel = $imp->term; ?>'>
                  </div>
                  
                  <div class="form-group" style='float:left; width:73%; margin-right:2%'>
                    <label>Origin</label>
                    <input list="origin_list" required name="origin" class="form-control"  maxlength="50" value='<?php echo $imp->origin; ?>'>
                  </div>

                  <div class="form-group" style='float:left; width:23%; margin-left:2%'>
                    <label>Currency</label>

                      <?php
                      $curr = $imp->currency;
                      function selected_c($stat){
                          $status = $GLOBALS['curr'];
                          if($status == $stat){
                            return 'selected';
                          }
                      }
                      ?>

                    <select class="form-control" required name="currency">
                      <option value="PHP" <?php echo selected_c('PHP'); ?>>PHP</option>
                      <option value="EURO" <?php echo selected_c('EURO'); ?>>EURO</option>
                      <option value="USD" <?php echo selected_c('USD'); ?>>USD</option>
                    </select>
                  </div>
                  
                  </div>
                  
                  <div class="col-md-6" style="float:left; padding-left: 30px">
                  
                  <!-- textarea -->
                  <div class="form-group">
                    <label>Special Reminders</label>
                    <textarea class="form-control" name="reminder" maxlength="200" rows="5" style="resize:none" placeholder="Input special reminder ..."><?php echo $imp->reminders; ?></textarea>
                  </div>

                  
                  <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>
                  
                  
                  <!-- For Editing Record Only-->
                  <div class="form-group">
                    <label>Delivery Status</label>
                    <input type="hidden" class="form-control" id="del_stat_bd" value='DELIVERED' readonly>
                    <select class="form-control" id="del_stat" name="status">
                      
                      <?php
                      $statusx = $imp->status;
                      function selected($stat){
                          $status = $GLOBALS['statusx'];
                          if($status == $stat){
                            return 'selected';
                          }
                      }
                      ?>
                      <option value="ORDERED" <?php echo selected('ORDERED'); ?>>Ordered</option>
                      <option value="SAILING" <?php echo selected('SAILING'); ?>>Sailing</option>
                      <option value="DELAYED" <?php echo selected('DELAYED'); ?>>Delayed</option>
                      <option value="ARRIVED PORT" <?php echo selected('ARRIVED PORT'); ?>>Arrived Port</option>
                      <option value="ON TRANSIT" <?php echo selected('ON TRANSIT'); ?>>On Transit</option>
                      <option value="DELIVERED" <?php echo selected('DELIVERED'); ?>>Delivered</option>
                    </select>

                  </div>

                  <div class="form-group">
                    <label>Delivered Date</label>
                    <input type="date" name="del_date" class="form-control" id="date_input" readonly value='<?php echo $imp->deldate; ?>'>
                  </div>
                  </div>

                <div style="clear:both; height:15px;"></div>
                <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>

                <table id="modalEdit" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th style='width:28%'>Product</th>
                      <th style='width:20%'>Pkg</th>
                      <th style='width:7%'>Qty</th>
                      <th style='width:11%'>Unit</th>
                      <th style='width:12%'>Price</th>
                      <th style='width:17%'>Total</th>
                      <th style='width:5%'></th>
                    </tr>
                  </thead>
                  <tbody id="prod_table1">
                      <?php
                      $imp_prod->show_data($id);
                      ?>
                  </tbody>
                  <tfoot>
                    <th colspan="4" style="text-align:right">Total Price: </th>     
                    <th colspan="2" style="text-align:right" id=""><input type="text" name="total_price" id='total_price1' style="text-align:right; background-color:transparent; border:transparent" class="form-control" readonly value='<?php echo number_format($imp->total,2); ?>'></th>
                  </tfoot>
                </table>
                <button type="button" id="add_row" onclick="add_row1()" class="btn btn-success btn-sm" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-plus'></i> &nbsp;Add New Row</button>
                <br><br>
                <button type="submit" name="edit_imp" id="submit_new1" class="btn btn-primary" style="float:right; margin-top:2px; margin-right:10px; margin-bottom:20px"><i class='fa fa-save'></i> &nbsp;Save Changes</button>
              </form>
              </div>
              <!-- /.card-body -->

<script>
   var last_id1 = <?php echo $imp_prod->ctr; ?>;
  
  function add_row1(){
    var newRow = "<tr id="+last_id1+"><td><input list='products_list' maxlength='50'name='product[]' style='background-color:transparent; border:transparent' class='form-control' placeholder='Type here ...'></td><td><input list='packaging_list' maxlength='50' name='packaging[]' style='background-color:transparent; border:transparent' class='form-control' placeholder='Type here ...'></td><td><input type='text' maxlength='8' name='quantity[]' id='quan1"+last_id1+"' style='text-align:right; background-color:transparent; border:transparent' class='form-control num' placeholder='0'></td><td><select class='form-control' required name='unit[]'><option value='N/A' >N/A</option><option value='Vial' >Vial</option><option value='Kg' >Kg</option><option value='Liter' >Liter</option></select></td><td><input type='text' maxlength='8' name='price[]' step='any' id='price1"+last_id1+"' style='text-align:right; background-color:transparent; border:transparent' class='form-control' placeholder='0.00'></td><td><input type='text' name='total[]' id='total1"+last_id1+"' style='text-align:right; background-color:transparent; border:transparent' class='form-control tprice1' value='0.00'></td><td><center><button id='"+last_id1+"' onclick='deleterow(this.id)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td></tr>";
    
    $("#prod_table1").append(newRow);
   
      //Dynamically add functions from here

      add_function1(last_id1);

    last_id1+=1;    
  }
  
  function deleterow(id){
    $("#"+id).remove();
    total1();
  }
  
  var length1 = $("#modalEdit tr").length;
  length1 = parseInt(length1) - 2;

$(document).ready(function() {
  for (i = 1; i <= length1; i++){
      add_function1(i);
    }
});

function add_function1(id){
      $('#quan1'+id).keydown(function (e) {
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

         var x = $('#quan1'+id).val();
        $('#quan1'+id).val(Comma(x));

        multiply1(id);
      });

      $('#price1'+id).keydown(function (e) {
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

         var x = $('#price1'+id).val();
        $('#price1'+id).val(Comma(x));

        multiply1(id);
      });

      $('#price1'+id).keyup(function (e) {
        multiply1(id);
      });

      $('#quan1'+id).keyup(function (e) {
        multiply1(id);
      });
}

function multiply1(id){
  var quan_ = ($("#quan1"+id).val()).replace(/\,/g,'');
  var price_ = ($("#price1"+id).val()).replace(/\,/g,'');

  var quan = parseFloat(quan_);
  var price = parseFloat(price_);

  if(isNaN(quan)){
    quan = 0;
  }

  if(isNaN(price)){
    price = 0;
  }

  var prod = quan * price;
  var pr = format(prod);

  $("#total1"+id).val(pr);

  total1();
}

function format(n, sep, decimals) {
    sep = sep || "."; // Default to period as decimal separator
    decimals = decimals || 2; // Default to 2 decimals

    return n.toLocaleString().split(sep)[0]
        + sep
        + n.toFixed(decimals).split(sep)[1];
}

function total1(){
  var sum = 0;
  
  $( ".tprice1" ).each(function() {
    var x = $(this).val().replace(/\,/g,'');
    sum += parseFloat(x);;
  });

  var sum_ = format(sum);

  $("#total_price1").val(sum_);
}

function Comma(Num) { //function to add commas to textboxes
        Num += '';
        Num = Num.replace(',', '');
        x = Num.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        return x1 + x2;
    }

/*
Functions for keypresses
*/
//setup before functions
var typingTimer;                //timer identifier
var doneTypingInterval = 2000;  //time in ms, 5 second for example
var $input_inv1 = $('#inv_input1');


//on keyup, start the countdown
$input_inv1 .on('keyup', function () {
  clearTimeout(typingTimer);
  typingTimer = setTimeout(validate_inv1, doneTypingInterval);
});


function validate_inv1() {
    var str = $("#inv_input1").val();
		
		var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	        if (this.readyState == 4 && this.status == 200) {
			
            document.getElementById("inv_val1").innerHTML = this.responseText;
					
			if(this.responseText == "Invoice number already exists."){
                $("#inv_val1").attr("style", "color: red; font-weight: bold");
				$("#submit_new1").attr("disabled", true);
			}
			else{
				$("#inv_val1").attr("style", "color: green; font-weight: bold");
				$("#submit_new1").attr("disabled", false);
			}
	        }
	        };
	    xmlhttp.open("GET", "ajax/ajax_invoice.php?num=" + str, true);
	    xmlhttp.send();
	}

$("#startDatePicker1").change(function(){
    document.getElementById("endDatePicker1").min = $(this).val(); 
});

$("#endDatePicker1").change(function(){
  document.getElementById("endDatePicker1").min = $('#startDatePicker1').val();
});

$("#del_stat").change(function(){
   if($(this).val() == "DELIVERED"){
     breakdown();
   }
   else{
     //set value to null
     $("#date_input").val("YYYY-MM-DD");
     //disable
     $("#date_input").prop("readonly", true);
     $("#date_input").attr('required', true);
   }
});

function disable(stat){
    if(stat === 'DELIVERED'){
      $('#imp_form input, select, textarea').attr('readonly', 'readonly');
      $("#del_stat").hide();
      $("#submit_new1").hide();
      $("#add_row").hide();
      $("#del_stat_bd").attr("type", "text");
    }
}

function breakdown(){
 swal("Reminder", "Marking this as delivered will make it available for breakdown. Do you wish to continue?", "warning");
 $("#date_input").attr("readonly", false);
}

$(document).ready(function(){
    disable('<?php echo $imp->status; ?>');
});

</script>