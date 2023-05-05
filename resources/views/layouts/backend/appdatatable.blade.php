<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>@yield('title') | Lubertech</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets') }}/images/favicon.ico">

                <!-- DataTables -->
                <link href="{{ asset('assets') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
                <link href="{{ asset('assets') }}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        
                <!-- Responsive datatable examples -->
                <link href="{{ asset('assets') }}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 
                
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
        <!-- JAVASCRIPT -->
<script src="{{ asset('assets') }}/libs/jquery/jquery.min.js"></script>
<script src="{{ asset('assets') }}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets') }}/libs/metismenu/metisMenu.min.js"></script>
<script src="{{ asset('assets') }}/libs/simplebar/simplebar.min.js"></script>
<script src="{{ asset('assets') }}/libs/node-waves/waves.min.js"></script>
<script src="{{ asset('assets') }}/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

<!-- Required datatable js -->
<script src="{{ asset('assets') }}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.2.1/js/dataTables.fixedColumns.min.js"></script>
<!-- Buttons examples -->
<script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('assets') }}/libs/jszip/jszip.min.js"></script>
<script src="{{ asset('assets') }}/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="{{ asset('assets') }}/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="{{ asset('assets') }}/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<!-- Datatable init js -->
<script src="{{ asset('assets') }}/js/pages/datatables.init.js"></script>

<!-- App js -->
<script src="{{ asset('assets') }}/js/app.js"></script>

    </body>

</html>