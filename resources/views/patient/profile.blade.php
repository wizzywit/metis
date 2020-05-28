@extends('layouts.frontLayout.patientLayout.design')
@section('styles')
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
                        <h3>Your Profile</h3>
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

                        <form class="form-horizontal row-fluid">
                                @csrf
                                <div class="control-group">
                                    <label class="control-label">Patient Name:</label>
                                    <div class="controls">
                                        <h4><strong><span >@if(Auth::guard('web')->user()->sex == 'M')Mr. @else Miss. @endif {{Auth::guard('web')->user()->name}}</span></strong></h4>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Gender:</label>
                                    <div class="controls">
                                        <h4><strong><span >@if(Auth::guard('web')->user()->sex == 'M')Male @else Female @endif</span></strong></h4>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Date of Birth:</label>
                                    <div class="controls">
                                        <h4><strong><span >{{Auth::guard('web')->user()->dob}}</span></strong></h4>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Email:</label>
                                    <div class="controls">
                                        <h4><strong><span >{{Auth::guard('web')->user()->email}}</span></strong></h4>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Phone Number:</label>
                                    <div class="controls">
                                        <h4><strong><span >{{Auth::guard('web')->user()->phone}}</span></strong></h4>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Booked Appointments:</label>
                                    <div class="controls">
                                        <h4><strong><span >{{App\Appointment::where('patient_id',Auth::guard('web')->id())->count()}}</span></strong></h4>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Scheduled Appointments:</label>
                                    <div class="controls">
                                        <h4><strong><span >{{App\Appointment::where(['patient_id'=>Auth::guard('web')->id(),'scheduled'=>true])->count()}}</span></strong></h4>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <a href="{{route('patient.edit')}}" class="btn btn-primary">Edit Profile</a>
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
