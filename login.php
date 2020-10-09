<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Transcendo | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <?php
    include 'css.php';
  ?>
</head>
<body class="hold-transition login-page" style='background-image: url("images/bg.jpg"); background-size: cover; max-height: 100px'>
<div class="login-box">
  <br>
  <br>
  <br>
  <br>
  <div class="login-logo">
    <a href="#" style='background-color: rgb(255,250,250, 0.5)'><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Transcendo</b> Admin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="models/login_process.php" method="post">
      <div class="form-group has-feedback">
        <input required type="text" name='username' maxlength='20' class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input required type="password" name='password' maxlength='20' class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4" style='float:right'>
          <button type="submit" name='submit' class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<?php
include 'js.php';

if(isset($_GET['error'])){
?>

  <script>
    swal('Oops', 'Please check your username and password.', 'error'); 
    history.pushState(null, "", "login");
  </script>
        
<?php
}
?>

</body>
</html>