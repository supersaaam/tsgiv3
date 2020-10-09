<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Transcendo  | Records Module</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <?php
include 'css.php';
?>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php
include 'header.php';
include 'aside.php';

//Models
include 'models/user_model.php';
include 'models/customer_model.php';
include 'models/cmo_model.php';
include 'models/supplier_model.php';
include 'models/warehouse_model.php';
include 'models/product_model.php';
include 'models/packaging_model.php';
include 'models/payee_model.php';
include 'models/account_title_model.php';
include 'models/terms_imp_model.php';
include 'models/company_model.php';
include 'models/terms_sm_model.php';
include 'models/origin_model.php';
include 'models/actual_prod_model.php';

$user      = new User();
$customer  = new Customer();
$act       = new Account_Title();
$cmo       = new CMO();
$supplier  = new Supplier();
$warehouse = new Warehouse();
$product   = new Product();
$packaging = new Packaging();
$payee     = new Payee();
$t_imp     = new Terms_Imp();
$t_sm      = new Terms_SM();
$origin    = new Origin();
$cmp       = new Company();
$ap        = new Actual_Prod();
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Records Management</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- put all contents inside -->
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?php echo $user->count(); ?></h3>
                <p><b>User Accounts</b></p>
              </div>
              <div class="icon">
                <i class="fa fa-user"></i>
              </div>
              
              <?php
              if($_SESSION['access'] == 'Admin'){
              ?>
                  <a href="user" class="small-box-footer">See All <i class="fa fa-arrow-circle-right"></i></a>
              <?php
              }
              else{
            ?>
              <a class="small-box-footer">&nbsp;</a>
              <?php
              }
              ?>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3><?php echo $customer->count(); ?></h3>
                <p><b>Customer Records</b></p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
              <a href="customer" class="small-box-footer">See All <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner" style="color:white">
                <h3><?php echo $cmo->count(); ?></h3>
                <p><b>Agent Records</b></p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
              <a href="cmo" class="small-box-footer" ><span style="color:white">See All <i class="fa fa-arrow-circle-right"></i></span></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?php echo $supplier->count(); ?></h3>
                <p><b>Principal Records</b></p>
              </div>
              <div class="icon">
                <i class="fa fa-truck"></i>
              </div>
              <a href="supplier" class="small-box-footer">See All <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?php echo $act->count(); ?></h3>
                <p><b>Account Title Records</b></p>
              </div>
              <div class="icon">
                <i class="fa fa-file"></i>
              </div>
              <a href="account_title" class="small-box-footer">See All <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-green" >
              <div class="inner" style="color:white">
                <h3><?php echo $payee->count(); ?></h3>
                <p><b>Payee Records</b></p>
              </div>
              <div class="icon">
                <i class="fa fa-money"></i>
              </div>
              <a href="payee" class="small-box-footer">See All <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner" style="color:white">
                <h3><?php echo $t_imp->count(); ?></h3>
                <p><b>Terms (Importation)</b></p>
              </div>
              <div class="icon">
                <i class="fa fa-list-alt"></i>
              </div>
              <a href="terms_imp" class="small-box-footer">See All <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner" style="color:white">
                <h3><?php echo $t_sm->count(); ?></h3>
                <p><b>Terms (Sales Order)</b></p>
              </div>
              <div class="icon">
                <i class="fa fa-list-alt"></i>
              </div>
              <a href="terms_sm" class="small-box-footer">See All <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <!-- /.row -->
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner" style="color:white">
                <h3><?php echo $ap->count_local(); ?></h3>
                <p><b>Local Product Records</b></p>
              </div>
              <div class="icon">
                <i class="fa fa-archive"></i>
              </div>
              <a href="local_products" class="small-box-footer">See All <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-green" >
              <div class="inner" style="color:white">
                <h3><?php echo $ap->count_indent(); ?></h3>
                <p><b>Indent Product Records</b></p>
              </div>
              <div class="icon">
                <i class="fa fa-archive"></i>
              </div>
              <a href="indent_products" class="small-box-footer">See All <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
          <?php
          if($_SESSION['access'] == 'Admin' || $_SESSION['access'] == 'Customer' || $_SESSION['access'] == 'Finance') {
          ?>
          
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner" style="color:white">
                <h3><?php echo $ap->count(); ?></h3>
                <p><b>Actual Inventory Records</b></p>
              </div>
              <div class="icon">
                <i class="fa fa-archive"></i>
              </div>
              <a href="actual_product" class="small-box-footer">See All <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
          <?php
          }
          ?>
          
        </div>

    </section>
    <!-- /.content -->
  </div>

  <?php
include 'footer.php';
?>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php
include 'js.php';
?>

</body>
</html>
