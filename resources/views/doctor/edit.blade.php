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
                        <h3>Edit Profile</h3>
                    </div>
                    <div class="module-body">

                            @if($errors->any())
                                <div class="alert alert-error">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>
                                        <ul>
                                            @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </strong>
                                </div>
                            @endif
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

                        <form id="formValid" class="form-horizontal row-fluid" action="{{route('doctor.edit.profile')}}" method="post" enctype="multipart/form-data">
                                @csrf


                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Name</label>
                                    <div class="controls">
                                        <input value="{{Auth::guard('doctor')->user()->name}}" name="name" type="text"  class="span8" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Gender</label>
                                    <div class="controls">
                                        <select name="sex" id="sex" tabindex="1" class="span8" required>
                                            <option value="M" @if(Auth::guard('doctor')->user()->sex == 'M') selected @endif>Male</option>
                                            <option value="F" @if(Auth::guard('doctor')->user()->sex == 'F') selected @endif>Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Phone Number</label>
                                    <div class="controls">
                                        <input value="{{Auth::guard('doctor')->user()->phone}}" name="phone" type="text"  class="span8" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Speciality</label>
                                    <div class="controls">
                                        <input value="{{Auth::guard('doctor')->user()->speciality}}" name="speciality" type="text" class="span8" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Qualification</label>
                                    <div class="controls">
                                        <input value="{{Auth::guard('doctor')->user()->qualification}}" name="qualification" type="text" class="span8" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Hospital/Clinic name</label>
                                    <div class="controls">
                                        <input value="{{Auth::guard('doctor')->user()->hospital}}" name="hospital" type="text" class="span8" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Change Passport</label>
                                    <div class="controls">
                                        <input name="passport" type="file" class="span8" placeholder="Choose File">
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
            speciality: {
                required: true,
            },
            hospital: {
                required: true
            },
            qualification: {
                required: true
            },
            phone: {
                required: true,
                phonenu: true
            },
        },
        messages: {
        phone: {
            required: "Please enter a phone number",
        },
        name: {
            required: "Please enter your name",
        },
        speciality: {
            required: "Please enter doctor speciality",
        },
        hospital: {
            required: "Please Enter a hospital/clinic"
        },
        qualification: {
            required: "Please enter a qualification"
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
    });

</script>
@endsection
