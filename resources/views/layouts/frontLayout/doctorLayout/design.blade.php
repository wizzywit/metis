<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metis | Doctor</title>
    <link type="text/css" href="{{ asset('css/front_css/patient/bootstrap.min.css') }}" rel="stylesheet">
    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/front_img/favicon.png') }}">
    <!-- Place favicon.ico in the root directory -->
    <link type="text/css" href="{{ asset('css/front_css/patient/bootstrap-responsive.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('css/front_css/patient/theme.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('images/front_img/patient/icons/css/font-awesome.css') }}" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
        rel='stylesheet'>
        @yield('styles')
</head>
<body>

@include('layouts.frontLayout.doctorLayout.header')

@yield('content')

@include('layouts.frontLayout.doctorLayout.footer')

    <script src="{{ asset('js/front_js/patient_js/jquery-1.9.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/front_js/patient_js/jquery-ui-1.10.1.custom.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/front_js/patient_js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/front_js/patient_js/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
    @yield('scripts')
</body>
</html>
