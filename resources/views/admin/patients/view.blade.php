@extends('layouts.adminLayout.admin_design')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Patient Information</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">View Patient</li>
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
                                            Name
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$patient->name}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-user  text-primary"></span>
                                            Gender
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$patient->sex}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-eye-open text-primary"></span>
                                            Email
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$patient->email}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-calendar text-primary"></span>
                                            Date of Birth
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$patient->dob}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-calendar text-primary"></span>
                                            Registered
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$patient->created_at}}
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
                                         {{$patient->updated_at}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div>
                            <a href="{{url('admin/patients/')}}" type="button" class="btn btn-block btn-success btn-xs">Back to Patient's List</a>
                        </div>
                </div>
            </div>
    </section>
</div>
@endsection
