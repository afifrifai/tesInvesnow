
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <form action="{{ route('logout') }}" method="post">
            @csrf 
            <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-sign-out-alt"></i> Log Out</a></button>
        </form>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li> -->
    </ul>