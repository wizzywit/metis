@extends('layouts.adminLayout.admin_design')
@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.10.12/dist/sweetalert2.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('js/admin_js/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/admin_js/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/admin_js/plugins/datatables-select/css/select.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/admin_js/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Patients</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Patients</li>
            </ol>
          </div>
        </div>
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.patient.store") }}">Add Patient
                </a>
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

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">List of Patients Registered on The System</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S/N</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Date of Birth</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($patients as $patient)
                <tr>
                  <td>{{$patient->id}}</td>
                  <td>{{$patient->name}}
                  </td>
                  <td>{{$patient->email}}</td>
                  <td>{{$patient->phone}}</td>
                  <td>{{$patient->dob}}</td>
                  {{-- @if($patient->urgency_level == '3')
                  <td><i class="text-danger">HIGH</i></td>
                  @elseif($patient->urgency_level == '2')
                  <td><i class="text-warning">MEDIUM</i></td>
                  @else
                  <td><i class="text-success">LOW</i></td>
                  @endif --}}
                <td>
                    <a title="View Patient" href="{{url('admin/patient/'.$patient->id.'/view')}}"   class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a>
                    <button title="Delete Patient" onclick="deletePatient({{$patient->id}});" type="button" class="btn btn-danger btn-xs"><i class="fas fa-user-times"></i></button>
                    <a title="Edit Patient" href="{{url('admin/patient/'.$patient->id.'/edit')}}"   class="btn btn-primary btn-xs"><i class="fas fa-user-edit"></i></a>
                </td>
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.10.12/dist/sweetalert2.all.min.js"></script>
<!-- DataTables -->
<script src="{{ asset('js/admin_js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/datatables-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/admin_js/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<!-- page script -->
<script type="text/javascript">
    function deletePatient(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to Delete this Patient and all of its Information!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete!'
            }).then((result) => {
            if (result.value) {
                var url = "{{ route('admin.delete.patient',':id')}}";
                url = url.replace(':id',id);
                window.location.href = (url);
             }
            })
    }

  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
       dom: 'lBfrtip',
       buttons: [
           {
            extend: 'selectAll',
            text: 'Select All',
            className: 'btn btn-primary btn-flat btn-sm',

           },
           {
            extend: 'selectNone',
            text: 'Select None',
            className: 'btn bg-blue btn-flat btn-sm',

           },
           {
            extend: 'copy',
            text: 'Copy',
            className: 'btn btn-default btn-sm',

           },
           {
            extend: 'csv',
            text: 'CSV',
            className: 'btn btn-default btn-sm',

           },
           {
            extend: 'excel',
            text: 'Excel',
            className: 'btn btn-default btn-sm',

           },
           {
            extend: 'pdf',
            text: 'PDF',
            className: 'btn btn-default btn-sm',

           },
            {
                extend: 'print',
                text: 'Print',
                className: 'btn btn-success btn-flat btn-sm',
                exportOptions: {
                    modifier: {
                        selected: null
                    }
                }
            }
      ],
    //   select: true
    });
    // $('#example2').DataTable({
    //   "paging": true,
    //   "lengthChange": false,
    //   "searching": false,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": true,
    //   "responsive": true,
    //   "buttons": [
    //       'print'
    //   ]
    // });
  });
</script>
@endsection
