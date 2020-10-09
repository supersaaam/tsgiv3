<?php
include 'models/transfer_model.php';

$trans = new Transfer();
$id = $_GET['id'];
$trans->set_data($id);
$r = $trans->remarks;
?>
              <!-- /.card-header -->
              <form action='models/transfer_model.php?id_rem=<?php echo $id; ?>' method='post'>
              <div class="card-body">
              <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th style='width:39%'>Product Code</th>
                      <th style='width:7%'>Quantity</th>
                      <th style='width:25%'>Remarks</th>
                      <th style='width:22%'>Action</th>
                      <th style='width:7%'>Quantity</th>
                    </tr>
                  </thead>
                  <tbody id="">
                      <?php
                      $trans->show_data_tp($id);
                      ?>
                  </tbody>
                </table>
                <br>
               <a href='print_stf?id=<?php echo $id; ?>' target='_blank'><button type="button" id="" class="btn btn-primary" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-print'></i> &nbsp;Print</button></a>
               
               <?php
               if($r == 'NO'){
               ?>
                      <button type="submit" id="save_rem" name='save_rem' class="btn btn-success" style="float:right; margin-top:2px; margin-right:5px"><i class='fa fa-save'></i> &nbsp;Save Remarks</button>

                      <button type="button" id="<?php echo $id; ?>" class="btn btn-warning clearBtn" style="float:right; margin-top:2px; margin-right:5px"><i class='fa fa-check'></i> &nbsp;Cleared</button>
               <?php
               }
               ?>
              </div>
              </form>

<script>
    $('.clearBtn').on('click', function () {
      var id = $(this).attr('id');

      swal({
        title: "Are you sure?",
        text: "You are about to mark this transfer record as cleared. Proceed?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, proceed",
        cancelButtonText: "No, cancel",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm) {
        if (isConfirm) {
          window.location.href = 'models/transfer_model.php?id_clear='+id;
        } else {
          swal.close();
        }
      });
   });
</script>