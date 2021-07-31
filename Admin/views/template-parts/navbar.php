<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/system-admin/" class="nav-link">Home</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown user-menu">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <img src="/assets/admin/img/profile.png" class="user-image img-circle elevation-1" alt="User Image">
        <span class="d-none d-md-inline"><?php echo \Core\Session::get('user')['first_name'].' '.\Core\Session::get('user')['last_name'];?></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <!-- User image -->
        <li class="user-header bg-primary">
          <img src="/assets/admin/img/profile.png" class="img-circle elevation-2" alt="User Image">

          <p>
            <?php echo \Core\Session::get('user')['first_name'].' '.\Core\Session::get('user')['last_name'];?>
            <small><?php echo ucfirst(\Core\Session::get('user')['type']);?></small>
          </p>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
          <a href="/system-admin/admins/update/<?php echo \Core\Session::get('user')['ID'];?>" class="btn btn-default btn-flat">Profile</a>
          <a href="/system-admin/logout/" class="btn btn-default btn-flat float-right">Sign out</a>
        </li>
      </ul>
    </li>
  </ul>
</nav>
<!-- /.navbar -->