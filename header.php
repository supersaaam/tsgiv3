<?php
include 'models/weblock_process.php';
?>

<header class="main-header">
  <!-- Logo -->
  <a href="./" class="logo">
    <!-- logo for regular state and mobile devices -->
    <span class="logo-mini"><img src="images/favicon-16x16.png" alt="" height="20px"></span>
    <span class="logo-lg"><b>Transcendo </b></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" style="height:50px">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="navbar-text" style="color:white;user-select:none">
          <img src="images/user-icon.png" class="user-image" alt="User Image">
          <span class="hidden-xs"><?php echo $_SESSION['name']; ?></span>
        </li>
        <li>
          <a href="models/logout_process.php">Sign Out &nbsp;&nbsp;<i class='fa fa-sign-out'></i></a>
        </li>
      </ul>
    </div>
  </nav>
</header>

<?php
include 'models/process_save_inv.php';
?>
