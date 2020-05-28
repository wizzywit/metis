<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Metis</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">   

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/front_img/favicon.png') }}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('css/front_css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front_css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front_css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front_css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front_css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front_css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front_css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front_css/gijgo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front_css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front_css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front_css/style.css') }}">
    <!-- <link rel="stylesheet" href="css/responsive.css') }}"> -->

    @yield('styles')
</head>

<body>

@include('layouts.frontLayout.header')

@yield('content')

@include('layouts.frontLayout.footer')

<!-- JS here -->
<script src="{{ asset('js/front_js/vendor/modernizr-3.5.0.min.js') }}"></script>
<script src="{{ asset('js/front_js/vendor/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('js/front_js/popper.min.js') }}"></script>
<script src="{{ asset('js/front_js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/front_js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/front_js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('js/front_js/ajax-form.js') }}"></script>
<script src="{{ asset('js/front_js/waypoints.min.js') }}"></script>
<script src="{{ asset('js/front_js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('js/front_js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('js/front_js/scrollIt.js') }}"></script>
<script src="{{ asset('js/front_js/jquery.scrollUp.min.js') }}"></script>
<script src="{{ asset('js/front_js/wow.min.js') }}"></script>
<script src="{{ asset('js/front_js/nice-select.min.js') }}"></script>
<script src="{{ asset('js/front_js/jquery.slicknav.min.js') }}"></script>
<script src="{{ asset('js/front_js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/front_js/plugins.js') }}"></script>
<script src="{{ asset('js/front_js/gijgo.min.js') }}"></script>
<!--contact js-->
<script src="{{ asset('js/front_js/contact.js') }}"></script>
<script src="{{ asset('js/front_js/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ asset('js/front_js/jquery.form.js') }}"></script>
<script src="{{ asset('js/front_js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/front_js/mail-script.js') }}"></script>
@yield('scripts')

<script src="{{ asset('js/front_js/main.js') }}"></script>
<script>
    $('#datepicker').datepicker({
        iconsLibrary: 'fontawesome',
        icons: {
            rightIcon: '<span class="fa fa-caret-down"></span>'
        }
    });
    $('#datepicker2').datepicker({
        iconsLibrary: 'fontawesome',
        icons: {
            rightIcon: '<span class="fa fa-caret-down"></span>'
        }

    });
$(document).ready(function() {
// $('.js-example-basic-multiple').select2();
});
</script>
</body>

</html>