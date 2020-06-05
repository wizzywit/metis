@extends('layouts.frontLayout.doctorLayout.design')
@section('styles')
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
                        <h3>Appointment Details</h3>
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

                        <form class="form-horizontal row-fluid" method="POST" action="{{route('doctor.video.conference')}}">
                                @csrf
                        <input type="hidden" value="{{$appointment->id}}" name="room">
                                <div class="control-group">
                                    <label class="control-label">Meeting Name:</label>
                                    <div class="controls">
                                        <h4><strong><span >{{$appointment->room_name}}</span></strong></h4>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Patient Name:</label>
                                    <div class="controls">
                                    <h4><strong><span >{{$appointment->patient->name}}</span></strong></h4>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Patient Email</label>
                                    <div class="controls">
                                        <h4><strong><span >{{$appointment->patient->email}}</span></strong></h4>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Patient Phone:</label>
                                    <div class="controls">
                                        <h4><strong><span >{{$appointment->patient->phone}}</span></strong></h4>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Symptoms:</label>
                                    <div class="controls">
                                        <h4><strong><span >{{$appointment->symptoms}}</span></strong></h4>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Date:</label>
                                    <div class="controls">
                                        <h4><strong><span >{{$appointment->date}}</span></strong></h4>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Start Time</label>
                                    <div class="controls">
                                        <h4><strong><span >{{$appointment->start_time}}</span></strong></h4>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">End Time</label>
                                    <div class="controls">
                                        <h4><strong><span >{{$appointment->end_time}}</span></strong></h4>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" class="btn btn-primary">Begin Meeting</button>
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

@endsection
