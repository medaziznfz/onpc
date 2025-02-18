<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>Sign In | Your Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assetslogin/images/favicon.ico') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assetslogin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assetslogin/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assetslogin/css/app.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assetslogin/css/custom.min.css') }}" rel="stylesheet">
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
                                        <img src="{{ asset('assetslogin/images/logo-light.png') }}" alt="" height="20">
                                    </a>
                                    <h5 class="text-primary mt-3">Welcome Back!</h5>
                                    <p class="text-muted">Sign in to continue to your account</p>
                                </div>

                                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                                    @csrf

                                    <!-- Login (Email/CIN) -->
                                    <div class="mb-3">
                                        <label for="login" class="form-label">Email or CIN <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('login') is-invalid @enderror" 
                                               id="login" 
                                               name="login" 
                                               placeholder="Enter email or CIN"
                                               value="{{ old('login') }}" 
                                               required 
                                               autofocus>
                                        @error('login')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3">
                                        <div class="float-end">
                                            <a href="{{ route('password.request') }}" class="text-muted">Forgot password?</a>
                                        </div>
                                        <label class="form-label">Password <span class="text-danger">*</span></label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   name="password" 
                                                   placeholder="Enter password" 
                                                   required>
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                    type="button" 
                                                    id="password-addon">
                                                <i class="ri-eye-fill align-middle"></i>
                                            </button>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Remember Me -->
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="remember" 
                                               id="remember" 
                                               {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">Remember me</label>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit">Sign In</button>
                                    </div>

                                    <!-- Social Login (optional) -->
                                    <div class="mt-4 text-center">
                                        <div class="signin-other-title">
                                            <h5 class="fs-13 mb-4 title">Sign In with</h5>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-icon waves-effect waves-light">
                                                <i class="ri-facebook-fill fs-16"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-icon waves-effect waves-light">
                                                <i class="ri-google-fill fs-16"></i>
                                            </button>
                                            <button type="button" class="btn btn-dark btn-icon waves-effect waves-light">
                                                <i class="ri-github-fill fs-16"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <p class="mb-0">Don't have an account? 
                                <a href="{{ route('register') }}" class="fw-semibold text-primary text-decoration-underline"> Sign Up</a>
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
                            <p class="mb-0 text-muted">&copy; 
                                <script>document.write(new Date().getFullYear())</script> Your Application. All rights reserved.
                            </p>
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
    <script src="{{ asset('assetslogin/js/pages/password-addon.init.js') }}"></script>
    
    <!-- Password Visibility Toggle -->
    <script>
        document.getElementById('password-addon').addEventListener('click', function() {
            const passwordInput = document.querySelector('[name="password"]');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('ri-eye-off-fill');
        });
    </script>
</body>
</html>