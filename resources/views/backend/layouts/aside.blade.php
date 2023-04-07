<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="/" class="d-block">{{ ucwords(auth()->user()->name) }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Admin Dashboard -->
          <li class="nav-item menu-open mb-2">
            <a href="/" class="nav-link @yield('home-active')">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <!-- Company -->
          <li class="nav-item menu-open mb-2">
            <a href="{{ route('company.index') }}" class="nav-link @yield('company-active')">
              <i class="nav-icon fas fa-building"></i>
              <p>Company</p>
            </a>
          </li>
           <!-- Employee -->
           <li class="nav-item menu-open">
            <a href="{{ route('employee.index') }}" class="nav-link @yield('employee-active')">
              <i class="nav-icon fas fa-users"></i>
              <p>Employee</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>