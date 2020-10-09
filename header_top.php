<header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="" class="navbar-brand"><b>Agrimate</b> Inc.</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            
            <?php
            $request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

            if($_SESSION['redirection'] == 'sales' && $request_uri[0] == '/sales'){
            ?>

            <!-- User Account Menu -->
            <li class="dropdown tasks-menu">
              <!-- Menu Toggle Button -->
              <a href="all_so_records">
                <i class="fa fa-list"></i> &nbsp;&nbsp; SO Records
              </a>
            </li>
                
            <?php
            }
            elseif($_SESSION['redirection'] == 'sales' && $request_uri[0] == '/all_so_records'){
            ?>

              <!-- User Account Menu -->
            <li class="dropdown tasks-menu">
              <!-- Menu Toggle Button -->
              <a href="sales">
                <i class="fa fa-file"></i> &nbsp;&nbsp; Generate Sales Order
              </a>
            </li>

            <?php
            }
            elseif($_SESSION['redirection'] == 'finance' && $request_uri[0] == '/finance'){
              ?>
  
                <!-- User Account Menu -->
              <li class="dropdown tasks-menu">
                <!-- Menu Toggle Button -->
                <a href="check">
                  <i class="fa fa-file"></i> &nbsp;&nbsp; Generate Check Voucher
                </a>
              </li>
  
              <?php
              }
              elseif($_SESSION['redirection'] == 'finance' && $request_uri[0] == '/check'){
                ?>
    
                  <!-- User Account Menu -->
                <li class="dropdown tasks-menu">
                  <!-- Menu Toggle Button -->
                  <a href="finance">
                    <i class="fa fa-money"></i> &nbsp;&nbsp; Payments
                  </a>
                </li>
    
                <?php
                }
                elseif($_SESSION['redirection'] == 'so_records' && $request_uri[0] == '/all_so_records'){
                  ?>
      
                    <!-- User Account Menu -->
                  <li class="dropdown tasks-menu">
                    <!-- Menu Toggle Button -->
                    <a href="so_records">
                      <i class="fa fa-list"></i> &nbsp;&nbsp; Pending SOs
                    </a>
                  </li>

                  <!-- User Account Menu -->
                  <li class="dropdown tasks-menu">
                    <!-- Menu Toggle Button -->
                    <a href="payments">
                      <i class="fa fa-money"></i> &nbsp;&nbsp; Payments
                    </a>
                  </li>
      
                  <?php
                  }
                  elseif($_SESSION['redirection'] == 'so_records' && $request_uri[0] == '/payments'){
                    ?>
        
                      <!-- User Account Menu -->
                    <li class="dropdown tasks-menu">
                      <!-- Menu Toggle Button -->
                      <a href="so_records">
                        <i class="fa fa-list"></i> &nbsp;&nbsp; Pending SOs
                      </a>
                    </li>

                     <li class="dropdown tasks-menu">
                      <!-- Menu Toggle Button -->
                      <a href="all_so_records">
                        <i class="fa fa-list"></i> &nbsp;&nbsp; All SO Records
                      </a>
                    </li>
        
                    <?php
                    }
                    elseif($_SESSION['redirection'] == 'so_records' && $request_uri[0] == '/so_records'){
                      ?>
                    
                            <!-- User Account Menu -->
                    <li class="dropdown tasks-menu">
                      <!-- Menu Toggle Button -->
                      <a href="all_so_records">
                        <i class="fa fa-list"></i> &nbsp;&nbsp; All SO Records
                      </a>
                    </li>

                        <!-- User Account Menu -->
                    <li class="dropdown tasks-menu">
                      <!-- Menu Toggle Button -->
                      <a href="payments">
                        <i class="fa fa-money"></i> &nbsp;&nbsp; Payments
                      </a>
                    </li>
          
                      <?php
                      }
                      elseif($_SESSION['redirection'] == 'sidr_records' && $request_uri[0] == '/approved_records'){
                        ?>
                      
                              <!-- User Account Menu -->
                      <li class="dropdown tasks-menu">
                        <!-- Menu Toggle Button -->
                        <a href="sidr_records">
                          <i class="fa fa-folder"></i> &nbsp;&nbsp; Billing
                        </a>
                      </li>
  
                        <?php
                        }
                        elseif($_SESSION['redirection'] == 'sidr_records' && $request_uri[0] == '/sidr_records'){
                          ?>
                        
                                <!-- User Account Menu -->
                        <li class="dropdown tasks-menu">
                          <!-- Menu Toggle Button -->
                          <a href="approved_records">
                            <i class="fa fa-list"></i> &nbsp;&nbsp; Approved SOs
                          </a>
                        </li>
    
                          <?php
                          }
            ?>
            
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="../../dist/img/defimg.png" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"><?php echo $_SESSION['name']; ?></span>
              </a>
            </li>
            <li class="dropdown tasks-menu">
              <!-- Menu Toggle Button -->
              <a href="models/logout_process.php">
                <i class="fa fa-sign-out"></i>
              </a>
            </li>
            
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  