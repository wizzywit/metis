@extends('layouts.frontLayout.doctorLayout.design')
@section('styles')
<style>
    .text-danger {
        color: red;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />
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
                        <h3>Schedule Appointment</h3>
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

                        <form id="formValid" class="form-horizontal row-fluid" action="{{route('doctor.schedule',$appointment->id)}}" method="post">
                                @csrf

                                <input type="hidden" value="{{$appointment->patient->email}}" name="email">
                                <input type="hidden" value="{{$appointment->patient->name}}" name="name">
                                <div class="control-group">
                                    <label class="control-label">Patient Name</label>
                                    <div class="controls">
                                        <strong><span>{{$appointment->patient->name}}</span></strong>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Patient Phone Number</label>
                                    <div class="controls">
                                        <strong><span>{{$appointment->patient->phone}}</span></strong>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Patient Email Address</label>
                                    <div class="controls">
                                        <strong><span>{{$appointment->patient->email}}</span></strong>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" >Patient Symptoms</label>
                                    <div class="controls">
                                        <strong><span>{{$appointment->symptoms}}</span></strong>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Urgency Level</label>
                                    <div class="controls">
                                        <strong><span>@if($appointment->urgency_level == '1') LOW @elseif($appointment->urgency_level == '2') MEDIUM @else HIGH @endif</span></strong>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="start_time">Room Name:</label>
                                    <div class="controls">
                                        <input  name="room_name" type="text" id="room_name" class="span8" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Appoitnment Date</label>
                                    <div class="controls">
                                        <input value="{{$appointment->date}}" name="date" type="text" id="datepicker" class="span8" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="start_time">Start Time</label>
                                    <div class="controls">
                                        <input  name="start_time" type="text" id="start_time" class="span8" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="end_time">End Time</label>
                                    <div class="controls">
                                        <input  name="end_time" type="text" id="end_time" class="span8" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" class="btn btn-success">Schedule Now</button>
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
    function minFromMidnight(tm){
        var clk = tm.substr(0, 5);
        array=clk.split(':');
        var m  = parseInt(array[1], 10);
        var h  = parseInt(array[0], 10);
        return h*60+m;
        }

    $(function(){
        flatpickr('#datepicker');
        flatpickr('#start_time',{
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:ss",
            time_24hr: true
        });
        flatpickr('#end_time',{
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:ss",
            time_24hr: true
        });

        $('#formValid').submit(function() {
             event.preventDefault();
            var startTime = $('#start_time').val();
            var endTime   = $('#end_time').val();
            st = minFromMidnight(startTime);
            et = minFromMidnight(endTime);

            // alert(st+ " "+et);

            if(st>et && endTime != ""){
            $('#end_time').closest('.controls').append('<span class="text-danger">End time must be greater than start time</span>');
            return false;
            } else if(startTime == ""){
                $('#start_time').closest('.controls').append('<span class="text-danger">Please Enter Schedule Start Time</span>');
                return false;
            }else if(st == et){
                $('#end_time').closest('.controls').append('<span class="text-danger">End Time and Start Time Cannot be Equal</span>');
                return false;
            } else if(et>st) {
                $('#formValid').validate({
                submitHandler: function(form) {
                    // do other things for a valid form
                    form.submit();
                },
                rules: {
                date: {
                    required: true,
                },
                start_time: {
                    required: true,
                },
                room_name: {
                    required: true,
                }
                },
                messages: {
                start_time: {
                    required: "Please enter a phone number",
                },
                date: {
                    required: "Please enter your Date of Birth",
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

            }


    });


    });

</script>
@endsection
