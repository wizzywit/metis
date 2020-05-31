<?php
$id = 1;
?>
@extends('layouts.frontLayout.doctorLayout.design')
@section('styles')
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
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
                        <h3>Booked Appointments</h3>
                    </div>
                    <div class="module-body table">
                        <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Patient Name</th>
                                    <th>Symptoms</th>
                                    <th>Date</th>
                                    <th>Scheduled</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                <tr class="odd gradeX">
                                    <td>{{$id++}}</td>
                                    <td>{{$appointment->patient->name}}</td>
                                    <td>{{$appointment->symptoms}}</td>
                                    <td>{{$appointment->date}}</td>
                                    <td class="center">
                                        @if($appointment->scheduled == true)
                                        {{$appointment->scheduled}}
                                        @else
                                        <i class="fa fa-times-circle fa-lg text-warning" ></i>
                                        @endif
                                    </td>
                                    <td class="center">
                                        @if($appointment->scheduled == true)
                                        <button class="btn btn-primary" disabled>Scheduled</button>
                                        <a href="#" class="btn btn-success">View Schedule</a>
                                        @else
                                        <a href="{{route('doctor.schedule.request',$appointment->id)}}" class="btn btn-success">Schedule</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!--/.module-->
               </div>
               <!--/.content-->
           </div>
           <!--/.span9-->
       </div>
   </div>
   <!--/.container-->
</div>
@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        $('.datatable-1').dataTable();
        $('.dataTables_paginate').addClass("btn-group datatable-pagination");
        $('.dataTables_paginate > a').wrapInner('<span />');
        $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
        $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
    } );
</script>

@endsection
