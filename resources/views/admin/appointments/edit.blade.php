
@extends('layouts.adminLayout.admin_design')
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Appointment</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.appointments')}}">Appointments</a></li>
              <li class="breadcrumb-item active">Edit</li>
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
                <h3 class="card-title">Edit Appointment</h3>
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
              <form role="form" id="quickForm" action="{{ route('admin.appointment.edit',$appointment->id) }}" method="post" >
              @csrf
              <input type="hidden" name="price" value="{{$appointment->price}}"/>
              <div class="card-body">
                  <div class="form-group">
                    <label>Patient Name</label>
                    <select name="patient_id" class="form-control select2" style="width: 100%;">
                      @foreach ($patients as $patient)
                        <option value="{{$patient->id}}" @if($appointment->patient->id == $patient->id) selected="selected" @endif>{{$patient->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Doctor Name</label>
                    <select name="doctor_id" class="form-control select2" style="width: 100%;">
                      @foreach ($doctors as $doctor)
                        <option value="{{$doctor->id}}" @if($appointment->doctor->id == $doctor->id) selected="selected" @endif>{{$doctor->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Describe Symptops</label>
                  <textarea name="symptoms" class="form-control" rows="3" placeholder="Enter Symptoms ...">{{$appointment->symptoms}}</textarea>
                  </div>
                  <div class="form-group">
                    <label>Urgency Level</label>
                    <select name="urgency_level" class="form-control select2" style="width: 100%;">
                        <option value="1" @if($appointment->urgency_level == "1") selected="selected" @endif>LOW</option>
                        <option value="2" @if($appointment->urgency_level == "2") selected="selected" @endif>MEDIUM</option>
                        <option value="3" @if($appointment->urgency_level == "3") selected="selected" @endif>HIGH</option>
                      </select>
                  </div>
                  <div class="form-group">
                    <label>Date</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input value="{{$appointment->date}}" id="datepicker" name="date" type="text" class="form-control">
                    </div>
                  </div>
                  <div class="bootstrap-timepicker">
                    <div class="form-group">
                      <label>Start Time</label>

                      <div class="input-group date" id="timepicker" data-target-input="nearest">
                        <input value="{{$appointment->start_time}}" name="start_time" id="start_time" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#start_time"/>
                        <div class="input-group-append" data-target="#start_time" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                        </div>
                        </div>
                      <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                  </div>
                  <div class="bootstrap-timepicker" id="e_time">
                    <div class="form-group">
                      <label>End Time</label>

                      <div class="input-group date" id="timepicker" data-target-input="nearest">
                        <input value="{{$appointment->end_time}}" name="end_time" id="end_time" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#end_time"/>
                        <div class="input-group-append" data-target="#end_time" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                        </div>
                        </div>
                      <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Edit</button>
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
    $( "#datepicker" ).datepicker({
        format: 'yyyy-mm-dd'
    });
    
    //Timepicker
    $('#start_time').datetimepicker({
      format: 'LT'
    })

    $('#end_time').datetimepicker({
      format: 'LT'
    })

    function minFromMidnight(tm){
        var ampm= tm.substr(-2)
        var clk = tm.substr(0, 5);
        array=clk.split(':');
        var m  = parseInt(array[1], 10);
        var h  = parseInt(array[0], 10);
        h += (ampm.match(/pm/i))? 12: 0;
        return h*60+m;
        }
    $('#quickForm').submit(function() {
        event.preventDefault();
        var startTime = $('#start_time').val();
        var endTime   = $('#end_time').val();
        st = minFromMidnight(startTime);
        et = minFromMidnight(endTime);
        if(st>et){
            $('#e_time').append('<span class="text-danger">End time must be greater than start time</span>');
            return false;
        } else if(startTime == "" || endTime == ""){
            $('#e_time').append('<span class="text-danger">Enter Schedule Start Time or End Time</span>');
            return false;
        }
        else if(et>st) {
            $('#quickForm').validate({
            submitHandler: function(form) {
            // do other things for a valid form
            form.submit();
        },
            rules: {
            patient_id: {
                required: true,
            },
            doctor_id: {
                required: true,
            },
            start_time: {
                required: true
            },
            date: {
                required: true
            },
            },
            messages: {
            patient_id: {
                required: "Please choose a patient",
            },
            doctor_id: {
                required: "Please choose a doctor",
            },
            start_time: {
                required: "Please enter your Appointment Start Time",
            },
            date: {
                required: "Please enter your Appointment Date",
            }
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
        }


    })
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
@endsection
