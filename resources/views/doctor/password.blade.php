@extends('layouts.frontLayout.doctorLayout.design')
@section('styles')
<style>
    .text-danger {
        color: red;
    }
</style>
@endsection

@section('content')

<!-- /navbar -->
<div class="wrapper">
   <div class="container">
       <div class="row">
           <div class="span3">
               @include('layouts.frontLayout.doctorLayout.sidebar')
           </div>
           <!--/.span3-->
           <div class="span9">
            <div class="content">

                <div class="module">
                    <div class="module-head">
                        <h3>Change Password</h3>
                    </div>
                    <div class="module-body">
                            @if(Session::has('flash_message_success'))
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{session('flash_message_success')}}</strong>
                            </div>
                            @endif
                            @if(Session::has('flash_message_error'))
                            <div class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{session('flash_message_error')}}</strong>
                            </div>
                            @endif
                            @if(Session::has('flash_message'))
                            <div class="alert">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{session('flash_message')}}</strong>
                            </div>
                            @endif

                            <br />

                        <form class="form-horizontal row-fluid" id="quickForm" action="{{ route('doctor.password.change') }}" method="post">
                                @csrf

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Old Password</label>
                                    <div class="controls">
                                        <input name="current_password" id="exampleInputPassword" type="password" class="span8" required>
                                        <span id="chkpwd"></span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">New Password</label>
                                    <div class="controls">
                                        <input id="exampleInputPassword1" name="password" type="password" class="span8" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Confirm Password</label>
                                    <div class="controls">
                                        <input id="exampleInputPassword2" name="password_confirmation" type="password" class="span8" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" class="btn btn-success">Change Password</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>



            </div><!--/.content-->
               <!--/.content-->
           </div>
           <!--/.span9-->
       </div>
   </div>
   <!--/.container-->
</div>
@endsection

@section('scripts')
<!-- jquery-validation -->
<script src="{{ asset('js/admin_js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
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
        url:'{{route('doctor.password.confirm')}}',
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
  error.addClass('text-danger');
  element.closest('.controls').append(error);
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
