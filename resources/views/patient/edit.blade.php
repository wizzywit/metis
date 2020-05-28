@extends('layouts.frontLayout.patientLayout.design')
@section('styles')
<style>
    .text-danger {
        color: red;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />
@endsection

@section('content')

<!-- /navbar -->
<div class="wrapper">
   <div class="container">
       <div class="row">
           <div class="span3">
               @include('layouts.frontLayout.patientLayout.sidebar')
           </div>
           <!--/.span3-->
           <div class="span9">
            <div class="content">

                <div class="module">
                    <div class="module-head">
                        <h3>Edit Profile</h3>
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

                        <form id="formValid" class="form-horizontal row-fluid" action="{{route('patient.edit.profile')}}" method="post">
                                @csrf


                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Name</label>
                                    <div class="controls">
                                        <input value="{{Auth::guard('web')->user()->name}}" name="name" type="text"  class="span8" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Phone</label>
                                    <div class="controls">
                                        <input value="{{Auth::guard('web')->user()->phone}}" name="phone" type="text"  class="span8" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Date of Birth</label>
                                    <div class="controls">
                                        <input value="{{Auth::guard('web')->user()->dob}}" name="dob" type="text" id="datepicker" class="span8" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Gender</label>
                                    <div class="controls">
                                        <select name="sex" id="sex" tabindex="1" class="span8" required>
                                            <option value="M" @if(Auth::guard('web')->user()->sex == 'M') selected @endif>Male</option>
                                            <option value="F" @if(Auth::guard('web')->user()->sex == 'F') selected @endif>Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" class="btn btn-success">Update</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<script>
    $(function(){
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
        },
        messages: {
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

    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        iconsLibrary: 'fontawesome',
        icons: {
            rightIcon: '<span class="icon icon-home"></span>'
        }
    });
    });

</script>
@endsection
