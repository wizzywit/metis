<?php

$id = 0;
?>
@extends('layouts.frontLayout.patientLayout.design')
@section('styles')
@endsection

@section('content')

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="span3">
                @include('layouts.frontLayout.patientLayout.sidebar')
            </div>


            <div class="span9">
                <div class="content">

                    <div class="module">
                        <div class="module-head">
                            <h3>Appointments</h3>
                        </div>
                        <div class="module-body">
                            <p>
                                <strong>Listing</strong>
                                -
                                <small>All Appointments</small>
                            </p>
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Doctor Name</th>
                                  <th>Hospital</th>
                                  <th>Symptoms</th>
                                  <th>Fee (&#8358;)</th>
                                  <th>Appointment Status</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($appointments as $appointment)
                                <tr>
                                  <td>{{$id++}}</td>
                                  <td>Dr. {{$appointment->doctor->name}}</td>
                                  <td>{{$appointment->doctor->hospital}}</td>
                                  <td>{{$appointment->symptoms}}</td>
                                  <td>{{$appointment->price}}</td>
                                  <td>
                                      @if($appointment->payed == 0)
                                      <i class="icon icon-check text-danger" aria-hidden="true"></i>
                                      <a style="margin-left: 10px" class="btn btn-primary" href="{{ route('book.now.instance',$appointment->id) }}"  onclick="event.preventDefault();
                                      document.getElementById('paynow-{{$appointment->id}}').submit();">Pay Now</a>
                                      <form id="paynow-{{$appointment->id}}" action="{{ route('book.now.instance',$appointment->id) }}" method="POST" style="display: none;">
                                        <input type="hidden" value="5000" name="price">
                                        @csrf
                                      </form>
                                      @else
                                      <i class="icon icon-check text-danger" aria-hidden="true"></i>
                                      <button style="margin-left: 10px" class="btn btn-info" disabled>Awaiting</button>
                                      @endif
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div><!--/.module-->

                <br />

                </div><!--/.content-->
            </div><!--/.span9-->
        </div>
    </div><!--/.container-->
</div><!--/.wrapper-->
@endsection

@section('scripts')
<script>
    $(function(){
        $(document).ready(function() {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		} );
    })
</script>
@endsection
