@extends('layouts.frontLayout.patientLayout.design')

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
                           <h3>
                               All Doctors</h3>
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
                           <div class="btn-group pull-right" data-toggle="buttons-radio">
                               <button type="button" class="btn">
                                   All</button>
                               <button type="button" class="btn">
                                   Male</button>
                               <button type="button" class="btn">
                                   Female</button>
                           </div>
                       </div>
                       <div class="module-body">
                           <div class="row-fluid">
                               @foreach($doctors as $doctor)
                               <div class="col-12">
                                   <div class="media user">
                                       <a class="media-avatar pull-left" href="#">
                                           <img src="{{ asset('images/doctors/'.$doctor->passport) }}">
                                       </a>
                                       <div class="media-body">
                                           <h3 class="media-title">
                                               Dr. {{$doctor->name}}
                                           </h3>
                                           <p>
                                               <strong>{{$doctor->hospital}}</strong><br/>
                                               <small class="muted">{{$doctor->speciality}}</small></p>
                                               <p class="muted">Consultation Fee: &#8358;5000</p>
                                           <div class="media-option btn-group shaded-icon">
                                               <button  class="btn btn-small" title="View Doctor Details">
                                                   <i class="icon-eye-open"></i>
                                               </button>
                                               <button class="btn btn-small" title="Book Appointment">
                                                   <i class="icon-bullhorn"></i>
                                               </button>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               @endforeach
                           </div>
                          
                           <br />
                           <div class="pagination pagination-centered">
                               <ul>
                                    {{$doctors->links()}}
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