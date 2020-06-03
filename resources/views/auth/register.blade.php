<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MetisPatient | Registration</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/front_img/favicon.png') }}">
    <!-- Place favicon.ico in the root directory -->

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('js/admin_js/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front_css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('js/admin_js/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('js/admin_js/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('js/admin_js/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('js/admin_js/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('js/admin_js/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('js/admin_js/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('js/admin_js/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('js/admin_js/plugins/summernote/summernote-bs4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <br/>
                <h4 style="text-align: center; margin-top: 50px;"><img src="{{ asset('images/admin/logo1.png') }}" alt="" style="width:45px; "> Metis Technologies</h4>
            <br/>
            <br/>
            </div>
            <div class="card">
                <div class="card-header" style="text-align: center; "><h3>{{ __('Patient Registration') }}</h3></div>

                <div class="card-body">
                    <form role="form" id="quickForm" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Patient Full name">
                                    @error('name')
                                        <span style="color:red;">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <input onkeydown="return false" type="text" id="datepicker" name="dob" class="form-control" placeholder="2020-06-23">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select name="sex" class="form-control select2" style="width: 100%;">
                                            <option value="M" selected="selected">Male</option>
                                            <option value="F">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phone" class="form-control" placeholder="Phone number">
                            </div>

                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
                                @error('email')
                                    <span style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                        @error('password')
                                            <span style="color:red;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputPassword2">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" id="exampleInputPassword2" placeholder="Password">
                                    </div>
                                </div>
                            </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                            <div style="position: relative; float:right;">Already Have an Account? <a class="btn btn-outline-success" href="{{route('login')}}">Login</a></div>
                            <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset('js/admin_js/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('js/admin_js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('js/admin_js/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('js/admin_js/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('js/admin_js/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('js/admin_js/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('js/admin_js/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('js/admin_js/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('js/admin_js/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('js/admin_js/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('js/admin_js/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/admin_js/dist/js/adminlte.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('js/admin_js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>


<script type="text/javascript">
$(document).ready(function () {

    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        iconsLibrary: 'fontawesome',
        icons: {
            rightIcon: '<span class="fa fa-caret-down"></span>'
        }
    });

    bsCustomFileInput.init();
    jQuery.validator.addMethod("phonenu", function (value, element) {
        return this.optional(element) || /^[0]\d{10}$/.test(value);
    }, "Invalid Phone Number");

  $('#quickForm').validate({
      submitHandler: function(form) {
    // do other things for a valid form
    form.submit();
  },
    rules: {
        email: {
            required: true,
            email: true,
        },
        name: {
            required: true,
        },
        phone: {
            required: true,
            phonenu: true
        },
        dob: {
            required: true,
        },
        sex: {
            required: true,
        },
        password: {
            required: true,
            minlength: 8
        },
        password_confirmation: {
            required: true,
            minlength: 8,
            equalTo: "#exampleInputPassword1"
        },
        },
        messages: {
        email: {
            required: "Please enter a email address",
            email: "Please enter a vaild email address"
        },
        password: {
            required: "Please provide a password",
            minlength: "Your password must be at least 8 characters long"
        },
        password_confirmation: {
            required: "Please confirm password",
            minlength: "Your password must be at least 8 characters long",
            equalTo: "Password Mismatch"
        },
        phone: {
            required: "Please enter a phone number",
        },
        name: {
            required: "Please enter your name",
        },
        dob: {
            required: "Please enter your Date of Birth",
        },
        sex: {
            required: "Please select your gender",
        },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>

</body>
</html>
