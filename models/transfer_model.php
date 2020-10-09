<?php
include 'transfer_aed.php';

class Transfer {
  /**
   * @var string
   */
  public $from = '';
  /**
   * @var string
   */
  public $to = '';
  /**
   * @var mixed
   */
  public $line;
  /**
   * @var mixed
   */
  public $remarks;
  /**
   * @var mixed
   */
  public $date;

  public function show_data() {
    include 'connection.php';

    $con1 = new mysqli($server, $user, $pw, $db);
    $con2 = new mysqli($server, $user, $pw, $db);

    $stmt = $con->prepare('SELECT `TransferID`, `TransferDate`, `FromWarehouse`, `ToWarehouse`, ShippingLine FROM `tbl_transfer` ORDER BY TransferID DESC');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $date, $from, $to, $line);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        $date = date_format(date_create($date), 'F j, Y');

        //get from
        $from_q = $con1->prepare('SELECT `WarehouseName` FROM `tbl_warehouse` WHERE WarehouseID=?');
        $from_q->bind_param('i', $from);
        $from_q->execute();
        $from_q->store_result();
        $from_q->bind_result($from);
        $from_q->fetch();

        //get to
        $to_q = $con2->prepare('SELECT `WarehouseName` FROM `tbl_warehouse` WHERE WarehouseID=?');
        $to_q->bind_param('i', $to);
        $to_q->execute();
        $to_q->store_result();
        $to_q->bind_result($to);
        $to_q->fetch();
        echo "
                    <tr>
                        <td>$id</td>
                        <td>$date</td>
                        <td>$from</td>
                        <td>$to</td>
                        <td>$line</td>
                        <td>
                        <center>
                            <a href='javascript:void(0);' data-href='view_transfer?id=$id' class='openView'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i> &nbsp;View Details</button></a>
                        </center>
                        </td>
                    </tr>
                ";
      }
    }
  }

  /**
   * @param $id
   */
  public function show_data_tp($id) {
    include 'connection.php';

    $stmt = $con->prepare('SELECT TP_ID, `ProductCode`, `Quantity`, t.Remarks, tp.Remarks, tp.QuantityRem, tp.Action FROM `tbl_transferred_prod` tp JOIN tbl_transfer t ON tp.TransferID=t.TransferID WHERE tp.TransferID=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($tpid, $code, $q, $r, $rem, $qr, $a);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        echo "
                <tr>
                <td>$code</td>
                <td>$q</td>";

        if ($r == 'NO') {
          echo "
                    <td>
                    <input type='hidden' name='tpid[]' value='$tpid'>
                    <input type='text' name='rem[]' class='form-control' maxlength='100'>
                    </td>
                    <td>
                    <select class='form-control' name='action[]'>
                         <option value='Returned to Inventory'>
                         Returned to Inventory</option>
                         <option value='Expired'>Expired</option>
                    </select>
                    </td>
                    <td>
                    <input type='number' class='form-control' name='q[]' max='1000000' min='1'>
                    </td>";
        } else {
          echo "
                    <td>$rem</td>
                    <td>$a</td>
                    <td>$qr</td>";
        }

        echo '
                </tr>
                ';
      }
    }
  }

  /**
   * @param $id
   */
  public function show_data_stf($id) {
    include 'connection.php';

    $stmt = $con->prepare('SELECT `ProductCode`, `Quantity`, Remarks, `Action`, QuantityRem FROM `tbl_transferred_prod` WHERE TransferID=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($code, $q, $r, $a, $qr);
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        echo "
                <tr>
                <td><center>$q</center></td>
                <td><center>$code</center></td>
                <td>$a</td>
                <td>$qr</td>
                <td>$r</td>
                </tr>
                ";
      }
    }
  }

  /**
   * @param $id
   */
  public function set_data($id) {
    include 'connection.php';

    $stmt = $con->prepare('SELECT `TransferDate`, `FromWarehouse`, `ToWarehouse`, ShippingLine, Remarks FROM `tbl_transfer` WHERE TransferID=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($date, $from, $to, $line, $r);
    $stmt->fetch();

    $con1 = new mysqli($server, $user, $pw, $db);
    $con2 = new mysqli($server, $user, $pw, $db);

    //get from
    $from_q = $con1->prepare('SELECT `WarehouseName` FROM `tbl_warehouse` WHERE WarehouseID=?');
    $from_q->bind_param('i', $from);
    $from_q->execute();
    $from_q->store_result();
    $from_q->bind_result($from);
    $from_q->fetch();

    //get to
    $to_q = $con2->prepare('SELECT `WarehouseName` FROM `tbl_warehouse` WHERE WarehouseID=?');
    $to_q->bind_param('i', $to);
    $to_q->execute();
    $to_q->store_result();
    $to_q->bind_result($to);
    $to_q->fetch();

    $this->from    = $from;
    $this->to      = $to;
    $this->date    = date_format(date_create($date), 'F j, Y');
    $this->line    = $line;
    $this->remarks = $r;
  }
}
?>
