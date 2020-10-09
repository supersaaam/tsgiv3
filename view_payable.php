<?php
include 'models/payable_model.php';
$py = new Payable();

$pid = $_GET['pid'];
$py->get_balance($pid);
$bal = $py->bal;
?>

              <!-- /.card-header -->
              <div class="card-body">
                <form role="form" action="models/payable_model.php" method="post" id="imp_form">
                  <!-- text input -->
                  <div class="col-md-6" style="float:left;">

                  <div class="form-group" style='float:left; width:48%; margin-right: 2%'>
                    <label>Balance </label>
                    <input type='text' style='font-weight: bold' step='any' min='1' readonly value='<?php echo $_GET['amt']; ?>' required name="" id='' class="form-control">
                  </div>

                  <div class="form-group" style='float:left; width:48%; margin-left: 2%'>
                    <label>Date Paid</label>
                    <input type="date" required name="date_paid" id='dte' class="form-control">
                  </div>

                  <div class="form-group" style='float:left; width:48%; margin-right: 2%'>
                    <label>Amount Paid</label>
                    <input type='number' step='any' min='1' required name="paid" id='amtpaid' class="form-control" placeholder='Type input here...'>
                  </div>

                  <div class="form-group" style='float:left; width:48%; margin-left: 2%'>
                    <label>Bank Charges</label>
                    <input type='number' id='charges' min='0' step='any' required name="charge" class="form-control" placeholder='Type input here...'>
                </div>
                  </div>

                  <div class="col-md-6" style="float:left;">

                  <div class="form-group" style='float:left; width:73%; margin-right: 2%'>
                    <label>Bank</label>
                    <input type='hidden' name='pid' value='<?php echo $pid; ?>'>
                    <input type='text' maxlength='50' required name="bank" class="form-control" placeholder='Type input here...'>
                  </div>

                  <div class="form-group"  style='float:left; width:23%; margin-left: 2%'>
                    <label>Currency</label>
                    <input type='text' maxlength='50' required name="" class="form-control" readonly value='<?php echo $_GET['currency']; ?>'>
                  </div>

                  <div class="form-group" style='float:left; width:48%; margin-right: 2%'>
                    <label>Rate</label>
                    <input type="number" min='0' id='rate' step='any' required name="rate" id='' class="form-control" placeholder='Type input here...'>
                </div>

                  <div class="form-group" style='float:left; width:48%; margin-left: 2%'>
                    <label>PHP Amount</label>
                    <input type='hidden' id='php_nc'>
                    <input type='text' required name="phpamt" class="form-control" id='php' readonly value='0'>
                  </div>
                  </div>

                <button type="submit" onclick='return check()' name="payment" id="print_dr" class="btn btn-success" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Payment</button>
                </form>

                </div>
              <!-- /.card-body -->

<script>
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();

if(dd<10) {
    dd = '0'+dd
}

if(mm<10) {
    mm = '0'+mm
}

today = yyyy + '-' + mm + '-' + dd;
$("#dte").val(today);

$("#amtpaid").on('keyup', function(){
    var amtpaid = $('#amtpaid').val();
    var charges = $("#charges").val();
    var rate = $("#rate").val();


    if(amtpaid == '' || isNaN(amtpaid)){
        amtpaid = 0;
    }

    if(charges == '' || isNaN(charges)){
        charges = 0;
    }

    if(rate == '' || isNaN(rate)){
        rate = 0;
    }

    var phpx = (parseFloat(charges)+parseFloat(amtpaid)) * rate;
    var php = format(phpx);

    $("#php_nc").val(phpx);
    $("#php").val(php);
});

$("#charges").on('keyup', function(){
    var amtpaid = $('#amtpaid').val();
    var charges = $("#charges").val();
    var rate = $("#rate").val();


    if(amtpaid == '' || isNaN(amtpaid)){
        amtpaid = 0;
    }

    if(charges == '' || isNaN(charges)){
        charges = 0;
    }

    if(rate == '' || isNaN(rate)){
        rate = 0;
    }

    var phpx = (parseFloat(charges)+parseFloat(amtpaid)) * rate;
    var php = format(phpx);

    $("#php_nc").val(phpx);
    $("#php").val(php);
});

$("#rate").on('keyup', function(){
    var amtpaid = $('#amtpaid').val();
    var charges = $("#charges").val();
    var rate = $("#rate").val();


    if(amtpaid == '' || isNaN(amtpaid)){
        amtpaid = 0;
    }

    if(charges == '' || isNaN(charges)){
        charges = 0;
    }

    if(rate == '' || isNaN(rate)){
        rate = 0;
    }


    var phpx = (parseFloat(charges)+parseFloat(amtpaid)) * rate;
    var php = format(phpx);

    $("#php_nc").val(phpx);
    $("#php").val(php);
});

function format(n, sep, decimals) {
    sep = sep || "."; // Default to period as decimal separator
    decimals = decimals || 2; // Default to 2 decimals

    return n.toLocaleString().split(sep)[0]
        + sep
        + n.toFixed(decimals).split(sep)[1];
}

function check(){
    var bal = parseFloat(<?php echo $bal; ?>);
    var amt = parseFloat($("#amtpaid").val());
    // var amt = parseFloat($("#php_nc").val());

    if(amt > bal){
        swal('Validation', 'The amount you are entering is greater than the remaining balance of '+bal.toFixed(2), 'warning');
        return false;
    }
}
</script>
