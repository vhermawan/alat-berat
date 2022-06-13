<header class="topbar" data-navbarbg="skin6">
  <nav class="navbar top-navbar navbar-expand-md">
    <div class="navbar-header" data-logobg="skin6">
      <!-- This is for the sidebar toggle which is visible on mobile only -->
      <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
              class="ti-menu ti-close"></i></a>
      <!-- ============================================================== -->
      <!-- Logo -->
      <!-- ============================================================== -->
      <div class="navbar-brand">
          <!-- Logo icon -->
          <a href="/admin">
              <!-- Logo text -->
              <span class="logo-text">
                  <!-- dark Logo text -->
                  <img src="{{url('/')}}/template/assets/images/sirat.png" />
              </span>
          </a>
      </div>
      <!-- ============================================================== -->
      <!-- End Logo -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Toggle which is visible on mobile only -->
      <!-- ============================================================== -->
      <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
          data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
          aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
    </div>
    <!-- ============================================================== -->
    <!-- End Logo -->
    <!-- ============================================================== -->
    <div class="navbar-collapse collapse" id="navbarSupportedContent">
      <!-- ============================================================== -->
      <!-- toggle and nav items -->
      <!-- ============================================================== -->
      <ul class="navbar-nav float-left mr-auto ml-3 pl-1">

      </ul>
      <!-- ============================================================== -->
      <!-- Right side toggle and nav items -->
      <!-- ============================================================== -->
      <ul class="navbar-nav float-right">
        <!-- ============================================================== -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="ml-2 d-none d-lg-inline-block">
                <span>Halo, {{ Auth::user()->email }}</span>
                <i data-feather="chevron-down" class="svg-icon"></i>
                <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                  <a class="dropdown-item" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                       <i data-feather="log-in"></i> {{ __(' Logout') }}
                   </a>

                   <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                       @csrf
                   </form>
                </div>
            </span>
          </a>
        </li>
        <!-- ============================================================== -->
        <!-- User profile and search -->
        <!-- ============================================================== -->
      </ul>
    </div>
  </nav>
</header>
