@extends('layouts.frontLayout.patientLayout.design')
@section('styles')
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
                        <h3>Book an Appointment</h3>
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

                        <form class="form-horizontal row-fluid" action="{{route('book.now')}}" method="post">
                                @csrf
                                <input type="hidden" value="5000" name="price">

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Doctor</label>
                                    <div class="controls">
                                        <select name="doctor_id" id="doctor" tabindex="1" data-placeholder="Select here.." class="span8" required>
                                            <option value="">Select A Doctor..</option>
                                            @foreach($doctors as $doctor)
                                            <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Specialization</label>
                                    <div class="controls">
                                        <strong><span id="speciality"></span></strong>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Hospital</label>
                                    <div class="controls">
                                        <strong><span id="hospital"></span></strong>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Consultation Fee</label>
                                    <div class="controls">
                                        <span id="price">&#8358;5000</span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Appointment Date</label>
                                    <div class="controls">
                                        <input onkeydown="return false" name="date" type="text" id="datepicker" placeholder="Appointment Date.." class="span8" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Urgency Level</label>
                                    <div class="controls">
                                        <select name="urgency_level" id="urgency_level" tabindex="1" data-placeholder="Select here.." class="span8" required>
                                            <option value="" selected>Select Level...</option>
                                            <option value="1">LOW</option>
                                            <option value="2">MEDIUM</option>
                                            <option value="3">HIGH</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Describe Symptoms</label>
                                    <div class="controls">
                                        <textarea name="symptoms" class="span8" rows="5"></textarea>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" class="btn btn-primary">Book Now</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<script>
    $(function(){
        $('#doctor').change(function () {
        //do something
        var doctor_id = $('#doctor').val();
        if(doctor_id == ""){
            $('#speciality').text("");
            $('#hospital').text("");
            return false
        } else {
        $.ajax({
			type:'get',
			url:'{{route('doctor.get')}}',
			data:{doctor_id:doctor_id},
			success:function(res){
                var resp = JSON.parse(res);
                $('#speciality').text(resp.speciality);
                $('#hospital').text(resp.hospital);
			},
			error: function() {
				alert("Error");
			}
		})
        }

    })
    })
    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        iconsLibrary: 'fontawesome',
        icons: {
            rightIcon: '<span class="icon icon-home"></span>'
        }
    });
</script>
@endsection
