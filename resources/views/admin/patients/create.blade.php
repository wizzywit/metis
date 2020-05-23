
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
            <h1>Add Doctors</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.patients')}}">Patients</a></li>
              <li class="breadcrumb-item active">Create</li>
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
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add a Patient</h3>
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
              <form role="form" id="quickForm" action="{{ route('admin.patient.save') }}" method="post">
              @csrf
              <div class="card-body">
                  <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Patient Full name">
                  </div>
                  <div class="form-group">
                      <label>Gender</label>
                      <select name="sex" class="form-control select2" style="width: 100%;">
                        <option value="M" selected="selected">Male</option>
                        <option value="F">Female</option>
                      </select>
                  </div>
                  <div class="form-group">
                    <label>Date of Birth</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input id="datemask" name="dob" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask>
                    </div>
                    <!-- /.input group -->
                  </div>
                  {{-- <div class="form-group">
                        <label>Urgency Level</label>
                        <select name="sex" class="form-control select2" style="width: 100%;">
                            <option value="1" selected="selected">LOW</option>
                            <option value="2">MEDIUM</option>
                            <option value="3">HIGH</option>
                          </select>
                   </div> --}}
                  <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter Phone number">
                  </div>
                  {{-- <div class="form-group">
                    <label>Describe Symptops</label>
                    <textarea name="symptoms" class="form-control" rows="3" placeholder="Enter Symptoms ..."></textarea>
                  </div> --}}
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword2">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="exampleInputPassword2" placeholder="Password">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Add Patient</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
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
    $('#datemask').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });
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

