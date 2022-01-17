
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <?php 
          $user = Auth::user();
          $roles = $user->getRoles();
          ?>
          <li class="nav-item">
            <a href="{{ route('user') }}" class="nav-link {{ (Route::currentRouteName() == 'user') ? 'active' : '' }}">
              <i class="nav-icon far fa-user"></i>
              <p>
                User
              </p>
            </a>
          </li>
          @if(in_array('superadmin', $roles))
          <li class="nav-item">
            <a href="{{ route('komda') }}" class="nav-link {{ (Route::currentRouteName() == 'komda') ? 'active' : '' }}">
              <i class="nav-icon far fa-file-alt"></i>
              <p>
                Komda
              </p>
            </a>
          </li>
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->