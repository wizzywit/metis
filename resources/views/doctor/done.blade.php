@extends('layouts.frontLayout.doctorLayout.design')

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
                           <h3>
                               Concluded Appointments</h3>
                       </div>
                       <div class="module-option clearfix">
                           <form>
                           <div class="input-append pull-left">
                               <input type="text" class="span3" placeholder="Filter by name...">
                               <button type="submit" class="btn">
                                   <i class="icon-search"></i>
                               </button>
                           </div>
                           </form>
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
                           <div class="row-fluid">
                               @if($appointments->count() == 0)
                               <div>
                                    <p style="display: flex; align-content: center; justify-content: center;">No Concluded Appointments</p>
                               </div>
                               @endif
                               @foreach($appointments as $appointment)
                               <div class="col-12">
                                <div class="media user">
                                    <div class="pull-left">
                                     <p><strong>Meeting Name</strong><br/>
                                         {{$appointment->room_name}}
                                     </p>
                                    </div>
                                    <div class="media-body">
                                        <h3 class="media-title">
                                            Patient: {{$appointment->patient->name}}
                                        </h3>
                                        <p>
                                             <strong>Symptoms: {{$appointment->symptoms}}</strong><br/>
                                            <strong>Start Time: {{$appointment->start_time}}</strong><br/>
                                            <small class="muted">End Time: {{$appointment->end_time}}</small></p>
                                        <div class="media-option btn-group shaded-icon">
                                            <a href="{{route('doctor.appointment.delete',$appointment->id)}}" class="btn btn-small btn-danger" title="Begin">Delete Appointment
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <hr />
                               @endforeach
                           </div>

                           <br />
                           <div class="pagination pagination-centered">
                               <ul>
                               </ul>
                           </div>
                       </div>
                   </div>
               </div>
               <!--/.content-->
           </div>
           <!--/.span9-->
       </div>
   </div>
   <!--/.container-->
</div>
@endsection
