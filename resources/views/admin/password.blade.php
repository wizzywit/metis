
@extends('layouts.adminLayout.admin_design')
@section('styles')
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Password Setting</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Change Password</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Change Password</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              @if (count($errors) > 0)
              <div class="alert alert-danger alert-block alert-dismissible fade show " role="alert">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif

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
              <form class="form-horizontal" role="form" id="quickForm" action="{{ route('admin.password.change') }}" method="post">
              @csrf
              <div class="card-body">
                <div class="form-group row">
                  <label for="exampleInputPassword1" class="col-sm-3 col-form-label">Old Password</label>
                  <div class="col-sm-9">
                    <input type="password" name="current_password" class="form-control" id="exampleInputPassword" placeholder="Password">
                    <span id="chkpwd"></span>
                  </div>
                </div>
                  <div class="form-group row">
                    <label for="exampleInputPassword1" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Confirm Password</label>
                    <div class="col-sm-9">
                        <input type="password" name="password_confirmation" class="form-control" id="exampleInputPassword2" placeholder="Password">
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

@section('scripts')
<!-- jquery-validation -->
<script src="{{ asset('js/admin_js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- InputMask -->
<script src="{{asset('js/admin_js/plugins/moment/moment.min.js') }}"></script>
<script src="{{asset('js/admin_js/plugins/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>


<script type="text/javascript">
$(document).ready(function () {

    var typingTimer;
	var doneTypingInterval = 1000;
	$('#exampleInputPassword1').on('keyup', function () {
		clearTimeout(typingTimer);
			if ($('#exampleInputPassword').val()) {
				typingTimer = setTimeout(doneTyping, doneTypingInterval);
			}
	});
	  function doneTyping () {
		//do something
		var current_pwd = $('#exampleInputPassword').val();
		// alert(current_pwd);
		$.ajax({
			type:'get',
			url:'{{route('admin.password.confirm')}}',
			data:{current_pwd:current_pwd},
			success:function(res){
				// alert(res);
				if(res == 'true'){
					$('#chkpwd').html("<font color='green'>Current Password is Correct</font>");
				} else {
					$('#chkpwd').html("<font color='red'>Current Password is Incorrect</font>");
				}
			},
			error: function() {
				alert("Error");
			}
		})
	  }

  $('#quickForm').validate({
      submitHandler: function(form) {
    // do other things for a valid form
    form.submit();
  },
    rules: {
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
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 8 characters long"
      },
      password_confirmation: {
        required: "Please confirm password",
        minlength: "Your password must be at least 8 characters long",
        equalTo: "Password Mismatch"
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
@endsection

