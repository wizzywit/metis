<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MetisAdmin | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('js/admin_js/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('js/admin_js/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('js/admin_js/dist/css/adminlte.min.css') }}">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
@if(Session::has('flash_message_error'))
	<div class="alert alert-danger alert-block alert-dismissible fade show " role="alert">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>{!! session('flash_message_error') !!}</strong>
	</div>
@endif
@if(Session::has('flash_message_success'))
	<div class="alert alert-success alert-block alert-dismissible fade show " role="alert">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>{!! session('flash_message_success') !!}</strong>
	</div>
@endif
  <div class="login-logo" style="margin-top:-70px;">
    <a href="{{ url('admin/') }}"><img src="{{ asset('images/admin/logo.png') }}" style="width:300px; height:232px"></a>
  </div>
  <!-- /.login-logo -->
  <div class="card" style="margin-top:-70px;">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><strong>MetisAdmin</strong></p>
      <form method="post" action="{{ route('admin.login.submit') }}">
        @csrf
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
      @if(Route::has('admin.password.update'))
        <a href="{{route('admin.password.update') }}">I forgot my password</a>
      @endif
      </p>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<script src="{{ asset('js/admin_js/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/admin_js/dist/js/adminlte.min.js') }}"></script>



</body>
</html>

