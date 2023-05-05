<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>@yield('title') | Lubertech</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- Sweet Alert-->
        <link href="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" /> 

        <!-- Bootstrap Css -->
        <link href="{{ asset('assets') }}/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets') }}/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets') }}/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    
    <body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="colored"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">
        @include('layouts.backend.navbar')
        @include('layouts.backend.sidebar')
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="page-title-box">
                                    <h4>@yield('title')</h4>
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">@yield('subtitle')</li>
                                        </ol>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        @yield('content')
                        
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
            
                @include('layouts.backend.footer')
            </div>            
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->


        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets') }}/libs/jquery/jquery.min.js"></script>
        <script src="{{ asset('assets') }}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets') }}/libs/metismenu/metisMenu.min.js"></script>
        <script src="{{ asset('assets') }}/libs/simplebar/simplebar.min.js"></script>
        <script src="{{ asset('assets') }}/libs/node-waves/waves.min.js"></script>
        <script src="{{ asset('assets') }}/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

        <!--Morris Chart-->
        <script src="{{ asset('assets') }}/libs/morris.js/morris.min.js"></script>
        <script src="{{ asset('assets') }}/libs/raphael/raphael.min.js"></script>

        <script src="{{ asset('assets') }}/js/pages/dashboard.init.js"></script>

                <!-- Sweet Alerts js -->
                <script src="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.js"></script>

                <!-- Sweet alert init js-->
                <script src="{{ asset('assets') }}/js/pages/sweet-alerts.init.js"></script>

        <script src="{{ asset('assets') }}/js/app.js"></script>

    </body>

</html>