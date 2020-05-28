<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Metis Technologies</title>
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

</head>

<body>
<!-- form itself end-->
<div id="test-form" class="white-popup-block">
    <div class="popup_box ">
        <div class="popup_inner">
             <h4 style="margin-top: 70px;"><img src="{{ asset('images/admin/logo1.png') }}" alt="" style="width:45px; "> Metis Technologies</h4>
            <br/>
            <br/>
            <h3 style="margin-top: -50px;">Patient Registration Form</h3>
            <form id="formValid" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="row">
                    <div class="col-xl-12 form-group">
                        <input name="name" type="text" placeholder="Full Name">
                        @error('name')
                            <span style="color:red;">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                        
                    </div>
                    <div class="col-xl-6 form-group">
                        <input name="dob" id="datepicker" placeholder="Date of Birth">
                    </div>
                    <div class="col-xl-6 form-group">
                        <select name="sex" class="form-select wide" id="default-select" class="">
                            <option value="" data-display="Gender">Gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                    <div class="col-xl-12 form-group">
                        <input name="phone" type="text"  placeholder="Phone no.">
                    </div>
                    <div class="col-xl-12 form-group">
                        <input id="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" type="email"  placeholder="Email">
                        @error('email')
                            <span style="color:red;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-xl-6 form-group">
                        <input id="password" name="password" type="password"  placeholder="Password" class="@error('password') is-invalid @enderror">
                        @error('password')
                            <span style="color:red;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-xl-6 form-group">
                        <input id="password-confirm" name="password_confirmation" type="password"  placeholder="Confirm Password">
                    </div>
                    <div class="col-xl-12 form-group">
                        <button type="submit" class="boxed-btn3">Register</button>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-1">
                        <p><a class="btn btn-outline-dark" role="button" href="{{route('login')}}"> Login Instead</a></p>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- form itself end -->

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

<!-- jquery-validation -->
<script src="{{ asset('js/admin_js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script src="{{ asset('js/front_js/main.js') }}"></script>
<script>
    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        iconsLibrary: 'fontawesome',
        icons: {
            rightIcon: '<span class="fa fa-caret-down"></span>'
        }
    });
$(document).ready(function() {

    $('#formValid').submit(function() {
            event.preventDefault();
            jQuery.validator.addMethod("phonenu", function (value, element) {
            return this.optional(element) || /^[0]\d{10}$/.test(value);
            }, "Invalid Phone Number");

        $('#formValid').validate({
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
            equalTo: "#password"
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

    })
    
});
</script>
</body>

</html>