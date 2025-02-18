<div class="horizontal-menu">
  <!-- Top Navbar -->
  <nav class="navbar top-navbar">
    <div class="container">
      <div class="navbar-content">
        <a href="#" class="navbar-brand">
          Noble<span>UI</span>
        </a>
        <ul class="navbar-nav">
          <!-- Notification Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i data-feather="bell"></i>
              <div class="indicator">
                <div class="circle"></div>
              </div>
            </a>
            <div class="dropdown-menu p-0" aria-labelledby="notificationDropdown">
              <div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
                <p>6 New Notifications</p>
                <a href="javascript:;" class="text-muted">Clear all</a>
              </div>
              <div class="p-1">
                <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                  <div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                    <i class="icon-sm text-white" data-feather="gift"></i>
                  </div>
                  <div class="flex-grow-1 me-2">
                    <p>New Order Recieved</p>
                    <p class="tx-12 text-muted">30 min ago</p>
                  </div>
                </a>
                <!-- Additional notification items can be added here -->
              </div>
              <div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
                <a href="javascript:;">View all</a>
              </div>
            </div>
          </li>
          <!-- Profile Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img class="wd-30 ht-30 rounded-circle" src="{{ asset('assets/images/users/player.png') }}" alt="profile">
            </a>
            <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
              <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                <div class="mb-3">
                  <img class="wd-80 ht-80 rounded-circle" src="{{ asset('assets/images/users/player.png') }}" alt="">
                </div>
                <div class="text-center">
                  <p class="tx-16 fw-bolder">{{ Auth::user()->name }}</p>
                  <p class="tx-12 text-muted">{{ Auth::user()->email }}</p>
                  <!-- Display CIN under email -->
                  <p class="tx-12 text-muted">{{ Auth::user()->cin ?? '' }}</p>
                </div>
              </div>
              <ul class="list-unstyled p-1">
                <li class="dropdown-item py-2">
                  <a href="pages/general/profile.html" class="text-body ms-0">
                    <i class="me-2 icon-md" data-feather="user"></i>
                    <span>Profile</span>
                  </a>
                </li>
                <li class="dropdown-item py-2">
                  <a href="javascript:;" class="text-body ms-0">
                    <i class="me-2 icon-md" data-feather="edit"></i>
                    <span>Edit Profile</span>
                  </a>
                </li>
                <li class="dropdown-item py-2">
                  <a href="javascript:;" class="text-body ms-0">
                    <i class="me-2 icon-md" data-feather="repeat"></i>
                    <span>Switch User</span>
                  </a>
                </li>
                <li class="dropdown-item py-2">
                  <!-- Logout Form -->
                  <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-body ms-0" style="border: none; background: none; padding: 0; margin: 0;">
                      <i class="me-2 icon-md" data-feather="log-out"></i>
                      <span>Log Out</span>
                    </button>
                  </form>
                </li>
              </ul>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
          <i data-feather="menu"></i>
        </button>
      </div>
    </div>
  </nav>

  <!-- Bottom Navbar -->
  <nav class="bottom-navbar">
    <div class="container">
      <ul class="nav page-navigation">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="link-icon" data-feather="box"></i>
            <span class="menu-title">Dashboard</span>
          </a>
        </li>
        
        
        
        
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="link-icon" data-feather="smile"></i>
            <span class="menu-title">Icons</span>
            <i class="link-arrow"></i>
          </a>
          <div class="submenu">
            <ul class="submenu-item">
              <li class="nav-item"><a class="nav-link" href="pages/icons/feather-icons.html">Feather Icons</a></li>
              <li class="nav-item"><a class="nav-link" href="pages/icons/flag-icons.html">Flag Icons</a></li>
              <li class="nav-item"><a class="nav-link" href="pages/icons/mdi-icons.html">Mdi Icons</a></li>
            </ul>
          </div>
        </li>

        {{-- Conditionally show Prevention nav item for role == 1 --}}
        @if(Auth::user()->role == 0)
        <li class="nav-item">
          <a class="nav-link" href="/">
            <i class="link-icon" data-feather="shield"></i>
            <span class="menu-title">Prevention</span>
            <i class="link-arrow"></i>
          </a>
          <div class="submenu">
            <ul class="submenu-item">
              <li class="nav-item"><a class="nav-link" href="pages/icons/feather-icons.html">Feather Icons</a></li>
              <li class="nav-item"><a class="nav-link" href="pages/icons/flag-icons.html">Flag Icons</a></li>
              <li class="nav-item"><a class="nav-link" href="pages/icons/mdi-icons.html">Mdi Icons</a></li>
            </ul>
          </div>
        </li>
        @endif
        
        <li class="nav-item">
          <a href="https://www.nobleui.com/html/documentation/docs.html" target="_blank" class="nav-link">
            <i class="link-icon" data-feather="hash"></i>
            <span class="menu-title">Documentation</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>
</div>
