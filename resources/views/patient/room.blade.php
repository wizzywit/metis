@extends('layouts.frontLayout.patientLayout.design')
@section('styles')
<style>
    .text-danger {
        color: red;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                        <h3>Video Conference</h3>
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

                        <form id="formValid" class="form-horizontal row-fluid" method="post" action="{{route('patient.video.conference')}}">
                                @csrf
                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Select Meeting</label>
                                    <div class="controls">
                                        <select name="room" id="room" tabindex="1" class="span8" required>
                                            @if($appointments->count() == 0)
                                            <option value="">::No Scheduled Appointments::</option>
                                            @endif
                                            @foreach ($appointments as $appointment)
                                                <option value="{{$appointment->id}}">{{$appointment->room_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" class="btn btn-success">Join Video Conference</button>
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<script>

    $(function(){
        $('#formValid').validate({
                submitHandler: function(form) {
                    // do other things for a valid form
                    form.submit();
                },
                rules: {
                room: {
                    required: true,
                },
                },
                messages: {
                room: {
                    required: "Please enter a phone number",
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
