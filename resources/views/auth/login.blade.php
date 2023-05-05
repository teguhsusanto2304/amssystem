<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('template/backend') }}/images/favicon.ico"> 
        
        <!-- Bootstrap Css -->
        <link href="{{ asset('template/backend') }}/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('template/backend') }}/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('template/backend') }}/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    </head>
    <span class="tooltiptext">pendaftaran<br>admisi@ams.com / 123456</span>

    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="card-body pt-0">

                                <h3 class="text-center mt-5 mb-4">
                                    <a href="index.html" class="d-block auth-logo">
                                        <img src="{{ asset('template/backend') }}/images/logo-dark.png" alt="" height="30" class="auth-logo-dark">
                                        <img src="{{ asset('template/backend') }}/images/logo-light.png" alt="" height="30" class="auth-logo-light">
                                    </a>
                                </h3>
                                <div class="text-center">
                                    @include('layouts.component.alert-dismissible')
                                </div>
                                <div class="p-3">
                                    <h4 class="text-muted font-size-18 mb-1 text-center">Welcome Back !</h4>
                                    <p class="text-muted text-center">Sign in to continue to <b>AMS</p>
                                    <form class="user" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username">Email</label>
                                            <input name="email" required="" type="email" class="form-control form-control-user"
                                        id="exampleInputEmail" aria-describedby="emailHelp"
                                        placeholder="Enter Email Address...">
                                        
                                        </div>
                                        <div class="mb-3">
                                            <label for="userpassword">Password</label>
                                            <input name="password" required="" type="password" class="form-control form-control-user"
                                        id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <div class="mb-3 row mt-4">
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6 text-end">
                                                <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0 row">
                                            <div class="col-12 mt-4">
                                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <p>Don't have an account ?  <a class="small" href="{{ route('register') }}">Create an Account!</a></p>
                            © <script>document.write(new Date().getFullYear())</script> <b>Luber</b>Tech </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JAVASCRIPT -->
        <script src="{{ asset('template/backend') }}/libs/jquery/jquery.min.js"></script>
        <script src="{{ asset('template/backend') }}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('template/backend') }}/libs/metismenu/metisMenu.min.js"></script>
        <script src="{{ asset('template/backend') }}/libs/simplebar/simplebar.min.js"></script>
        <script src="{{ asset('template/backend') }}/libs/node-waves/waves.min.js"></script>
        <script src="{{ asset('template/backend') }}/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
        <!-- App js -->
        <script src="{{ asset('template/backend') }}/js/app.js"></script>
    </body>

</html>