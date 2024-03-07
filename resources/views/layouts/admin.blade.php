<html lang="en" class="light">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href={{ asset("dist/images/dlight_logo.svg") }} rel="shortcut icon">
        <title>d.light - sms</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href={{ asset("dist/css/app.css") }} />
        <!-- END: CSS Assets-->
        <link rel="stylesheet" href="{{ asset('assets/data-tables/DT_bootstrap.css') }}" />
        <link href="http://demo.expertphp.in/css/jquery.ui.autocomplete.css" rel="stylesheet">
        @yield('styles')
    </head> 
    <body class="app">
    <div class="flex">
        <!-- BEGIN: Side Menu -->
        @include('layouts.partials.sidebar')
       <!-- BEGIN: Content -->
       <div class="content">
            <!-- BEGIN: Top Bar -->
            <div class="top-bar">
             @include('layouts.partials.navbar')
            </div>
            <div class="grid grid-cols-12 gap-6">               
            @yield('content')     
            </div>
       </div>
    </div>
    </body>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script>
    <script src={{asset("dist/js/app.js")}}></script>
    <!-- page-body-wrapper ends -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-circle-progress/js/circle-progress.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <!-- End custom js for this page -->

    <script src="{{ asset('js/gritter.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pulstate.js') }}" type="text/javascript"></script>
    <!-- end of modal -->
        
    <script class="include" type="text/javascript" src="{{ asset('js/jquery.dcjqaccordion.2.7.js') }}"></script>
    <script type="text/javascript" language="javascript" src="{{ asset('assets/advanced-datatable/media/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/assets/data-tables/DT_bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/slidebars.min.js') }}"></script>
    <script src="{{ asset('assets/js/dynamic_table_init.js') }}"></script>
    <script src="{{ asset('assets/js/bootbox.min.js') }}"></script>
@yield('scripts')
</html>