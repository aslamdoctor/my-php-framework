<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/system-admin/" class="brand-link">
    <img src="/assets/admin/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Job Board Media</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="/system-admin/clients/" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Client Users
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/system-admin/locations/" class="nav-link <?php echo (isset($active_nav) && $active_nav=='locations') ? 'active' : '';?>">
            <i class="nav-icon fas fa-map-marker-alt"></i>
            <p>
              Locations
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/system-admin/jobs-by-email/" class="nav-link">
            <i class="nav-icon fas fa-mail-bulk"></i>
            <p>
              Jobs By E-mail
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/system-admin/banners/" class="nav-link">
            <i class="nav-icon far fa-images"></i>
            <p>
              Banners
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/system-admin/logos/" class="nav-link">
            <i class="nav-icon fas fa-shapes"></i>
            <p>
              Logos
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/system-admin/mass-mailer/" class="nav-link">
            <i class="nav-icon fas fa-envelope"></i>
            <p>
              Mass Mailer
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/system-admin/agencies/" class="nav-link">
            <i class="nav-icon far fa-building"></i>
            <p>
              Agency
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/system-admin/admin-users/" class="nav-link <?php echo (isset($active_nav) && $active_nav=='admins') ? 'active' : '';?>">
            <i class="nav-icon fas fa-user-shield"></i>
            <p>
              Admin Users
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>