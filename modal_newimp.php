<style>
.loader {
  border: 4px solid #f3f3f3;
  border-radius: 50%;
  border-top: 4px solid #3498db;
  width: 12px;
  height: 12px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><b>Add New Record</b>
        <button type="button" id="closemodal" class="close" data-dismiss="modal">&times;</button>
        </h4>
      </div>
      <div class="modal-body"id="modalbody">

        <!-- /.card-header -->
        <div class="card-body">
                <form role="form" action="models/importation_model.php" method="post" id="form_imp">
                  <!-- text input -->
                  <div class="col-md-6" style="float:left; padding-right: 30px">

                  <div class="col-md-12">
                  <span id="inv_val">&nbsp;</span>
                  </div>

                  <div class="form-group" style='float:left; width:48%; margin-right:2%'>
                    <label>Proforma Inv. No.</label>
                    <input type="text" required name="prof_inv_no" maxlength="20" class="form-control" id="inv_input" onkeyup="loading('inv_val')" placeholder="Please type here ...">
                  </div>

                  <div class="form-group" style='float:left; width:48%; margin-left:2%'>
                    <label>Date</label>
                    <input type="date" required name="prof_inv_date" class="form-control">
                  </div>

                  <div class="form-group"  style='float:left; width:48%; margin-right:2%'>
                    <label>Commercial Inv. No.</label>
                    <input type="text" name="comm_inv_no" maxlength="20" class="form-control" id="" placeholder="Please type here ...">
                  </div>

                  <div class="form-group" style='float:left; width:48%; margin-left:2%'>
                    <label>Date</label>
                    <input type="date" name="comm_inv_date" class="form-control">
                  </div>

                  <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>

                  <div class="form-group">
                    <label>Supplier</label>
                    <input list="suppliers_list" required name="supplier"  maxlength="100" class="form-control" placeholder="Please input supplier name ...">
                  </div>

                  <div class="form-group" style='float:left; width:73%; margin-right:2%'>
                    <label>Origin</label>
                    <input list="origin_list" required name="origin" class="form-control"  maxlength="50" placeholder="Please input country of origin ...">
                  </div>

                  <div class="form-group" style='float:left; width:23%; margin-left:2%'>
                    <label>Currency</label>
                    <select class="form-control" required name="currency">
                      <option value="PHP" >PHP</option>
                      <option value="EURO" >EURO</option>
                      <option value="USD" >USD</option>
                    </select>
                  </div>

                  </div>

                  <div class="col-md-6" style="float:left; padding-left: 30px">

                  <!-- textarea -->
                  <div class="form-group">
                    <label>Special Reminders</label>
                    <textarea class="form-control" name="reminder" maxlength="200" rows="5" style="resize:none" placeholder="Input special reminder ..."></textarea>
                  </div>

                  <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>
                  <div class="form-group">
                    <label>Payment Term</label>
                    <input list="term_list" required name="term" class="form-control" maxlength="50" placeholder="Please input payment terms ...">
                  </div>
                  </div>

                <div style="clear:both; height:15px;"></div>
                <div style="clear:both; height:5px; margin-bottom: 25px; background-color:#88a6d8; border-radius:10px"></div>

                <table id="modalTbl" style='width:100%' class="table table-bordered table-striped">
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
                  <tbody id="prod_table">
                      <td>
                        <input list="products_list" name="product[]" maxlength='50' style="background-color:transparent; border:transparent" class="form-control" required placeholder="Type here ...">
                      </td>
                      <td>
                        <input list="packaging_list" name="packaging[]" maxlength='50' style="background-color:transparent; border:transparent" class="form-control" required placeholder="Type here ...">
                      </td>
                      <td>
                        <input type="text" maxlength='8' name="quantity[]" id='quan1' style="text-align:right; background-color:transparent; border:transparent" required class="form-control num" placeholder='0'>
                      </td>
                      <td>
                      <select class="form-control" required name="unit[]">
                        <option value="N/A" >N/A</option>
                        <option value="Vial" >Vial</option>
                        <option value="Kg" >Kg</option>
                        <option value="Liter" >Liter</option>
                      </select>
                      </td>
                      <td>
                        <input type="text" maxlength='8' name="price[]" step="any" id='price1' style="text-align:right; background-color:transparent; border:transparent" required class="form-control" placeholder='0.00'>
                      </td>
                      <td>
                        <input type="text" name="total[]" id='total1' style="text-align:right; background-color:transparent; border:transparent" class="form-control tprice" required readonly value='0.00'>
                      </td>
                      <td>

                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <th colspan="4" style="text-align:right">Total Price: </th>
                    <th colspan="2" style="text-align:right" id=""><input type="text" name="total_price" id='total_price' style="text-align:right; background-color:transparent; border:transparent" class="form-control" readonly value='0.00'></th>
                  </tfoot>
                </table>
                <button type="button" onclick="add_row()" class="btn btn-success btn-sm" style="float:right; margin-top:2px; margin-right:10px"><i class='fa fa-plus'></i> &nbsp;Add New Row</button>
                <br><br>
                <button type="submit" disabled id="submit_new" name="save_imp" class="btn btn-primary" style="float:right; margin-top:2px; margin-bottom: 20px; margin-right:10px"><i class='fa fa-save'></i> &nbsp;Save Record</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
      </div>
    </div>

  </div>
</div>
