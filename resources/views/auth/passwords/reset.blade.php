<!DOCTYPE html>
<html lang="en">
<head>
	<title>Metis Technologies</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
        <!-- <link rel="manifest" href="site.webmanifest"> -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/front_img/favicon.png') }}">
        <!-- Place favicon.ico in the root directory -->
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('js/front_js/login/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/front_fonts/login/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/front_fonts/login/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('js/front_js/login/vendor/animate/animate.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('js/front_js/login/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('js/front_js/login/vendor/animsition/css/animsition.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('js/front_js/login/vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('js/front_js/login/vendor/daterangepicker/daterangepicker.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/front_css/login/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/front_css/login/main.css') }}">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				<form class="login100-form validate-form flex-sb flex-w" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
					<span class="login100-form-title p-b-32">
                        <img src="{{ asset('images/admin/logo1.png') }}" alt="" style="width:45px; "><br/> 
                        Reset Password
                        <br/>
                        <br/>
                        <p>
                            Forgot Password? No problem, Enter your Email Below
                        </p>
					</span>

					<span class="txt1 p-b-11">
						Email
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Email is required">
						<input class="input100  @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}">
                        <span class="focus-input100"></span>
                        @error('email')
                            <span class="alert-validate" style="color:red;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</div>
					
					<span class="txt1 p-b-11">
						Password
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100  @error('password') is-invalid @enderror" type="password" name="password" >
                        <span class="focus-input100"></span>
                        
                        @error('password')
                            <span class="alert-validate" style="color:red;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <span class="txt1 p-b-11">
						Confirm Password
					</span>
					<div class="wrap-input100 validate-input m-b-12">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100  @error('password') is-invalid @enderror" type="password" name="password_confirmation" >
                        <span class="focus-input100"></span>
                        
                        @error('password')
                            <span class="alert-validate" style="color:red;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Reset Password
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="{{ asset('js/front_js/login/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('js/front_js/login/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('js/front_js/login/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('js/front_js/login/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('js/front_js/login/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('js/front_js/login/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('js/front_js/login/vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('js/front_js/login/vendor/countdowntime/countdowntime.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('js/front_js/login/main.js') }}"></script>

</body>
</html>