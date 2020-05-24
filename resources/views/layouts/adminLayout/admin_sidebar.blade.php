<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('admin')}}" class="brand-link">
      <img src="{{ asset('images/admin/admin-logo.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Metis Technologies</span>
      <p></p>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('js/admin_js/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{url('admin')}}" class="d-block">Hello Admin</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!-- <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li> -->
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin') ? 'active' : ''}}">
              <i class="nav-icon fas fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.doctors') }}" class="nav-link {{ request()->is('admin/doctors*') || request()->is('admin/doctor*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-user-md"></i>
              <p>
                Doctors
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.patients') }}" class="nav-link {{ request()->is('admin/patients*') || request()->is('admin/patient*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-procedures"></i>
              <p>
                Patients
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.appointments') }}" class="nav-link {{ request()->is('admin/appointments*') || request()->is('admin/appointment*') ? 'active' : ''}}">
              <i class="nav-icon far fa-calendar-check"></i>
              <p>
                Appointments
                <span class="badge badge-info right">{{App\Appointment::get()->count()}}</span>
              </p>
            </a>
          </li>
          <li class="nav-header">Accout Settings</li>
          <li class="nav-item">
            <a href="{{ route('admin.password.form') }}" class="nav-link {{ request()->is('admin/setting/password*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-key"></i>
              <p>
                Change Password
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
