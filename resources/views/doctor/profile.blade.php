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
                                    <label class="control-label">
                                        <a class="media-avatar pull-left" href="#">
                                            <img src="{{ asset('images/doctors/'.Auth::guard('doctor')->user()->passport) }}">
                                        </a>
                                    </label>
                                    <div class="controls">
                                        <h4><strong><span >@if(Auth::guard('doctor')->user()->sex == 'M')Mr. @else Miss. @endif {{Auth::guard('doctor')->user()->name}}</span></strong></h4>
                                        <p><span ><strong>Speciality:</strong>  {{Auth::guard('doctor')->user()->speciality}}</span></p>
                                        <p><span ><strong>Qualification:</strong>  {{Auth::guard('doctor')->user()->qualification}}</span></p>
                                        <p><span ><strong>Hospital:</strong> {{Auth::guard('doctor')->user()->hospital}}</span></p>
                                        <hr>
                                        <p><span ><strong>Email:</strong> {{Auth::guard('doctor')->user()->email}}</span></p>
                                        <p><span ><strong>Contact:</strong> {{Auth::guard('doctor')->user()->phone}}</span></p>
                                        <p>About me goes here</p>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Appointment Count:</label>
                                    <div class="controls">
                                        <h4><strong><span >{{App\Appointment::where('doctor_id',Auth::guard('doctor')->id())->count()}}</span></strong></h4>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Scheduled Appointments:</label>
                                    <div class="controls">
                                        <h4><strong><span >{{App\Appointment::where(['doctor_id'=>Auth::guard('doctor')->id(),'scheduled'=>true])->count()}}</span></strong></h4>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <a href="{{route('doctor.edit')}}" class="btn btn-primary">Edit Profile</a>
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
