<!doctype html>
<html lang="ar" dir="rtl" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>إنشاء حساب</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assetslogin/images/favicon.ico') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assetslogin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assetslogin/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assetslogin/css/app.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assetslogin/css/custom.min.css') }}" rel="stylesheet">

    <!-- Custom RTL CSS with JannaLT Font -->
    <style>
        /* Import JannaLT Font */
        @font-face {
            font-family: 'JannaLT';
            src: url('{{ asset("assetslogin/fonts/JannaLT.woff2") }}') format('woff2'),
                 url('{{ asset("assetslogin/fonts/JannaLT.woff") }}') format('woff');
            font-weight: normal;
            font-style: normal;
        }
        /* Apply JannaLT globally */
        body {
            font-family: 'JannaLT', sans-serif;
        }
        /* Align all form labels to the right in RTL */
        html[dir="rtl"] .form-label {
            text-align: right;
        }
        /* Align input placeholder text to the right in RTL */
        html[dir="rtl"] input::placeholder {
            text-align: right;
        }
        /* Adjust the password toggle icon position for RTL */
        html[dir="rtl"] .password-addon {
            right: auto !important;
            left: 0 !important;
        }
    </style>
</head>

<body>
    <div class="auth-page-wrapper pt-5">
        <!-- Auth particle background -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>
            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- Main Content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4 card-bg-fill">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <a href="/" class="d-inline-block auth-logo">
                                        <img src="{{ asset('assetslogin/images/logo.png') }}" alt="" height="120">
                                    </a>
                                    <h5 class="text-primary mt-3">إنشاء حساب جديد</h5>
                                </div>

                                <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                                    @csrf

                                    <!-- Name -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label text-end">الاسم <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                            id="name" name="name" placeholder="أدخل الاسم" 
                                            value="{{ old('name') }}" required dir="rtl">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label text-end">البريد الإلكتروني <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                            id="email" name="email" placeholder="أدخل البريد الإلكتروني" 
                                            value="{{ old('email') }}" required dir="rtl">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- CIN -->
                                    <div class="mb-3">
                                        <label for="cin" class="form-label text-end">رقم الهوية <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('cin') is-invalid @enderror" 
                                            id="cin" name="cin" placeholder="دخل رقم الهوية" 
                                            value="{{ old('cin') }}" required dir="rtl">
                                        @error('cin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label class="form-label text-end">كلمة المرور <span class="text-danger">*</span></label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                name="password" placeholder="أدخل كلمة المرور" 
                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required dir="rtl">
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                type="button" id="password-addon">
                                                <i class="ri-eye-fill align-middle"></i>
                                            </button>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="mb-3">
                                        <label class="form-label text-end">تأكيد كلمة المرور <span class="text-danger">*</span></label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password" class="form-control" 
                                                name="password_confirmation" placeholder="أكد كلمة المرور" required dir="rtl">
                                        </div>
                                    </div>

                                    <!-- Password Requirements -->
                                    <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                        <h5 class="fs-13">يجب أن تحتوي كلمة المرور على:</h5>
                                        <p id="pass-length" class="invalid fs-12 mb-2">حد أدنى <b>8 أحرف</b></p>
                                        <p id="pass-lower" class="invalid fs-12 mb-2">حرف صغير واحد على الأقل (a-z)</p>
                                        <p id="pass-upper" class="invalid fs-12 mb-2">حرف كبير واحد على الأقل (A-Z)</p>
                                        <p id="pass-number" class="invalid fs-12 mb-0">رقم واحد على الأقل (0-9)</p>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit">تسجيل</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <p class="mb-0">هل لديك حساب بالفعل؟ 
                                <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline">تسجيل الدخول</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy; <script>document.write(new Date().getFullYear())</script>  <a href="https://www.onpc.com.tn" target="_blank">الديوان الوطني للحماية المدنية</a>. </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('assetslogin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assetslogin/libs/particles.js/particles.js') }}"></script>
    <script src="{{ asset('assetslogin/js/pages/particles.app.js') }}"></script>
    <script src="{{ asset('assetslogin/js/pages/passowrd-create.init.js') }}"></script>
</body>

</html>
