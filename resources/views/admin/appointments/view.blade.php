@extends('layouts.adminLayout.admin_design')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Appointment Information</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">View Appointment</li>
            </ol>
            </div>
        </div>
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
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container bootstrap snippet">
            <div class="panel-body inf-content">
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-6">
                        <strong>INFORMATION</strong><br><br>
                        <div class="table-responsive">
                        <table class="table table-condensed table-responsive table-user-information">
                            <tbody>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                            Patient Name
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$appointment->patient->name}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                            Patient Email
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$appointment->patient->email}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                            Patient Phone Number
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$appointment->patient->name}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                            Doctor Name
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$appointment->doctor->name}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                            Doctor Email
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$appointment->doctor->email}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                            Doctor Phone
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$appointment->doctor->phone}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                            Date
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$appointment->date}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                            Start Time
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$appointment->start_time}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                            End Time
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$appointment->end_time}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-calendar text-primary"></span>
                                            Scheduled
                                        </strong>
                                    </td>
                                    <td>
                                        @if($appointment->scheduled == 1)
                                        <i class="fa fa-check-circle text-success" aria-hidden="true"></i>
                                        @else
                                        <i class="fas fa-times-circle text-danger" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-cloud text-primary"></span>
                                            Hospital
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$appointment->doctor->hospital}}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-bookmark text-primary"></span>
                                            Symptoms
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$appointment->symptoms}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-calendar text-primary"></span>
                                            Created By
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$appointment->created_at}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-calendar text-primary"></span>
                                            Updated
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                         {{$appointment->updated_at}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div>
                            <a href="{{url('admin/appointments/')}}" type="button" class="btn btn-block btn-success btn-xs">Back to Appointments's List</a>
                        </div>
                </div>
            </div>
    </section>
</div>
@endsection
