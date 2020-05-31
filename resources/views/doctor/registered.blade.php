<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MetisDoctor | Registration</title>
    <link type="text/css" href="{{ asset('css/front_css/patient/bootstrap.min.css') }}" rel="stylesheet">
    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/front_img/favicon.png') }}">
    <!-- Place favicon.ico in the root directory -->
    <link type="text/css" href="{{ asset('css/front_css/patient/bootstrap-responsive.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('css/front_css/patient/theme.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('images/front_img/patient/icons/css/font-awesome.css') }}" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
        rel='stylesheet'>
</head>
<body>
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                <i class="icon-reorder shaded"></i></a><a class="brand" href="{{url('patient/')}}">
                    <img src="{{ asset('images/admin/logo1.png') }}" alt="" style="width:30px; "><strong> Metis Technologies</strong>
                </a>
                <div class="nav-collapse collapse navbar-inverse-collapse">
                    <ul class="nav pull-right">
                        <li><a href="#">Congratulations </a></li>
                    </ul>
                </div>
                <!-- /.nav-collapse -->
            </div>
        </div>
        <!-- /navbar-inner -->
    </div>
    <!-- /navbar -->

    <div class="wrapper" style="height: 70vh">
        <div class="container">
            <div class="row">
                Congratulations Doc. You have Successfully registered into the system,<br/>
                Please Contact Admin to Activate Your Account To <a href="{{route('doctor.login')}}">Login</a>.<br/>
                <br/>
                <br/>
                <a class="btn btn-success" href="{{url('/')}}">Return Home</a>
            </div>
        </div>
    </div>

<div class="footer navbar-fixed-bottom" >
    <div class="container">
        <b class="copyright">&copy; 2019 Metis Technologies - </b>All rights reserved. Powered By <a href="https://wizzwit.github.io">Wizzywit</a>
    </div>
</div>
    <script src="{{ asset('js/front_js/patient_js/jquery-1.9.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/front_js/patient_js/jquery-ui-1.10.1.custom.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/front_js/patient_js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/front_js/patient_js/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
</body>
</html>
