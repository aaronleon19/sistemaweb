<header class="main-header">
  <!-- Logo -->
  <a href="home.php" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>L</b>O<b>L</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>SIS-ASIS</b> 2022</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Navegacion </span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <div class="navigation">
          <div class="userBx">
            <div class="imgBx">
            <img src="<?php echo (!empty($user['photo'])) ? '../images/'.$user['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
            </div>
            <p class="username"><?php echo $user['firstname'].' '.$user['lastname']; ?></p>
          </div>
          <div class="menuToggle"></div>
          <ul class="menu">
            
            <li><a href="#profile" data-toggle="modal"  id="admin_profile">
                <ion-icon name="settings-outline"></ion-icon> Actualizar
              </a></li> 
            <li><a href="logout.php" >
                <ion-icon name="log-out-outline"></ion-icon> Cerrar Sesión
              </a></li>
          </ul>
        </div>
      </ul>
    </div>
  </nav>
</header>
<?php include 'includes/profile_modal.php'; ?>