<div class="horizontal-menu">
  <!-- Top Navbar -->
  <nav class="navbar top-navbar">
    <div class="container">
      <div class="navbar-content d-flex justify-content-between align-items-center">
        <!-- Left Section: Brand -->
        <a href="#" class="navbar-brand">
          ح.م<span>.د.و</span>
        </a>

        <!-- Center Section: Grade Display -->
        @if(Auth::check() && (Auth::user()->role == 1 || Auth::user()->role == 2))
          <div class="d-flex justify-content-center flex-grow-1">
            @if(Auth::user()->grade)
              <div class="grade-display p-2 px-4 d-flex align-items-center flex-wrap" style=" 
                @if(Auth::user()->role == 1)
                  background-color:rgb(255, 208, 245);
                @elseif(Auth::user()->role == 2)
                  background-color:rgb(255, 133, 133);
                @endif
                border-radius: 4px;
                max-width: fit-content; /* Ensure the width fits the content */
                height: fit-content; /* Ensure the height fits the content */
                gap: 18px; /* Add space between the image and text */
              ">
                <!-- Grade image: smaller and not rounded -->
                <img src="{{ asset(Auth::user()->grade->image_path) }}" alt="Grade Image" style="max-width: 28px; max-height: 28px;">
                <div class="grade-text">
                  @if(Auth::user()->role == 1)
                    جهوي 
                  @elseif(Auth::user()->role == 2)
                    مركزي 
                  @endif
                </div>
              </div>
            @endif
          </div>
        @endif



        <!-- Right Section: Notifications & Profile -->
        <div class="d-flex align-items-center">
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
                    @if(Auth::user()->role == 1)
                    <p class="tx-12 text-muted">{{ Auth::user()->governorate ? Auth::user()->governorate->name : '' }}</p>
                    @endif
                    <p class="tx-12 text-muted">{{ Auth::user()->email }}</p>
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
        <!-- طلبات شهادة وقاية وتكوين للعموم -->
        <li class="nav-item">
          <a href="/prev" class="nav-link">
            <i class="link-icon" data-feather="file-text"></i>
            <span class="menu-title">شهادة وقاية</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="/formation" class="nav-link">
            <i class="link-icon" data-feather="refresh-ccw"></i>
            <span class="menu-title">تكوين للعموم</span>
          </a>
        </li>
        @endif

        <!-- متابعة المطالب -->
        @if(Auth::user()->role == 1 || Auth::user()->role == 2)
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="link-icon" data-feather="layers"></i>
            <span class="menu-title">شهادة الوقاية</span>
            <i class="link-arrow"></i>
          </a>
          <div class="submenu">
            <ul class="submenu-item">
              <li class="nav-item"><a class="nav-link" href="/requestprev">متابعة المطالب</a></li>
              <li class="nav-item"><a class="nav-link" href="/scan">التحقق من شهادة</a></li>
            </ul>
          </div>
        </li>
        @endif

        @if(Auth::user()->role == 1 || Auth::user()->role == 2)
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="link-icon" data-feather="layers"></i>
            <span class="menu-title">التكوين و الرسكلة</span>
            <i class="link-arrow"></i>
          </a>
          <div class="submenu">
            <ul class="submenu-item">
              <li class="nav-item"><a class="nav-link" href="/requestformation">متابعة المطالب</a></li>
            </ul>
          </div>
        </li>
        @endif

        <!-- إدارة المستخدمين -->
        @if(Auth::user()->role == 2)
        <li class="nav-item">
          <a class="nav-link" href="/management">
            <i class="link-icon" data-feather="users"></i>
            <span class="menu-title">إدارة المستخدمين</span>
          </a>
        </li>
        @endif

        <!-- ONPC -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="link-icon" data-feather="hash"></i>
            <span class="menu-title">ONPC</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>
</div>