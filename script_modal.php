<script>
  var last_id = 2;

  $('#inv_input').keydown(function(e) {
    if (e.keyCode == 32) {
        return false;
    }
});

  function add_row(){
    var newRow = "<tr id="+last_id+"><td><input list='products_list' maxlength='50'name='product[]' style='background-color:transparent; border:transparent' class='form-control' placeholder='Type here ...'></td><td><input list='packaging_list' maxlength='50' name='packaging[]' style='background-color:transparent; border:transparent' class='form-control' placeholder='Type here ...'></td><td><input type='text' maxlength='8' name='quantity[]' id='quan"+last_id+"' style='text-align:right; background-color:transparent; border:transparent' class='form-control num' placeholder='0'></td><td><select class='form-control' required name='unit[]'><option value='N/A' >N/A</option><option value='Vial' >Vial</option><option value='Kg' >Kg</option><option value='Liter' >Liter</option></select></td><td><input type='text' maxlength='8' name='price[]' step='any' id='price"+last_id+"' style='text-align:right; background-color:transparent; border:transparent' class='form-control' placeholder='0.00'></td><td><input type='text' name='total[]' id='total"+last_id+"' style='text-align:right; background-color:transparent; border:transparent' class='form-control tprice' readonly value='0.00'></td><td><center><button id='"+last_id+"' onclick='deleterow(this.id)' type='button' class='btn btn-danger btn-sm'><i class='fa fa-minus'></i></button></center></td></tr>";
    
    $("#prod_table").append(newRow);
   
      //Dynamically add functions from here

      add_function(last_id);

    last_id+=1;
  }
  
  var length = $("#modalTbl tr").length;
  length = parseInt(length) - 2;

$(document).ready(function() {
  for (i = 1; i <= length; i++){
      add_function(i);
    }
});

function deleterow(id){
  $("#"+id).remove();
  total();
}

function add_function(id){
      $('#quan'+id).keydown(function (e) {
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

        var x = $('#quan'+id).val();
        $('#quan'+id).val(Comma(x));

        multiply(id);
      });

      $('#price'+id).keydown(function (e) {
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
        
        var x = $('#price'+id).val();
        $('#price'+id).val(Comma(x));

        multiply(id);
      });

      $('#price'+id).keyup(function (e) {
        multiply(id);
      });

      $('#quan'+id).keyup(function (e) {
        multiply(id);
      });
}

function multiply(id){
  var quan_ = ($("#quan"+id).val()).replace(/\,/g,'');
  var price_ = ($("#price"+id).val()).replace(/\,/g,'');

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

  $("#total"+id).val(pr);

  total();
}

function format(n, sep, decimals) {
    sep = sep || "."; // Default to period as decimal separator
    decimals = decimals || 2; // Default to 2 decimals

    return n.toLocaleString().split(sep)[0]
        + sep
        + n.toFixed(decimals).split(sep)[1];
}

function total(){
 var sum = 0;
  
  $( ".tprice" ).each(function() {
    var x = $(this).val().replace(/\,/g,'');
    sum += parseFloat(x);;
  });

  var sum_ = format(sum);

  $("#total_price").val(sum_);
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
</script>