<div class="horizontal-menu">
  <!-- Top Navbar -->
  <nav class="navbar top-navbar">
    <div class="container">
      <div class="navbar-content">
        <a href="#" class="navbar-brand">
        ح.م<span>.د.و</span>
        </a>
        <ul class="navbar-nav">
          <!-- Notification Dropdown -->
          <li class="nav-item dropdown">
              @include('partials.notifications')
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
                  <p class="tx-12 text-muted">{{ Auth::user()->cin }}</p>
                </div>
              </div>
              <ul class="list-unstyled p-1">
                <li class="dropdown-item py-2">
                  <a href="pages/general/profile.html" class="text-body ms-0">
                    <i class="me-2 icon-md" data-feather="user"></i>
                    <span>حساب</span>
                  </a>
                </li>
                <li class="dropdown-item py-2">
                  <a href="javascript:;" class="text-body ms-0">
                    <i class="me-2 icon-md" data-feather="edit"></i>
                    <span> تعديل حساب </span>
                  </a>
                </li>
                <li class="dropdown-item py-2">
                  <!-- Logout Form -->
                  <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-body ms-0" style="border: none; background: none; padding: 0; margin: 0;">
                      <i class="me-2 icon-md" data-feather="log-out"></i>
                      <span>تسجيل خروج</span>
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
            <i class="link-icon" data-feather="slack"></i>
            <span class="menu-title">الرئيسية</span>
          </a>
        </li>
        
        @if(Auth::user()->role == 0)
        <!-- hedha mte3 talab chhedet wiqaya -->
        <li class="nav-item">
          <a href="/prev" class="nav-link">
            <i class="link-icon" data-feather="file-text"></i>
            <span class="menu-title">شهادة وقاية</span>
          </a>
        </li>
        @endif

        <!-- hedha mte3 moutabe3et el mataleb -->
        @if(Auth::user()->role == 1 || Auth::user()->role == 2)
        <li class="nav-item">
          <a class="nav-link" href="/requestprev">
            <i class="link-icon" data-feather="layers"></i>
            <span class="menu-title">متابعة المطالب</span>
          </a>
        </li>
        @endif


        <!-- hedha mte3 el user management -->
        @if(Auth::user()->role == 2)
        <li class="nav-item">
          <a class="nav-link" href="/management">
            <i class="link-icon" data-feather="users"></i>
            <span class="menu-title">إدارة المستخدمين</span>
          </a>
        </li>
        @endif


        <!-- hedhy khaleha zeyda akeka -->
        <li class="nav-item">
          <a href="https://www.nobleui.com/html/documentation/docs.html" target="_blank" class="nav-link">
            <i class="link-icon" data-feather="hash"></i>
            <span class="menu-title">ONPC</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>
</div>
