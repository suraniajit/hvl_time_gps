{{-- extend layout --}}
@extends('app.layout')

{{-- page title --}}
@section('title','Roles | HVL')
@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Role Management      </li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display">Role Management</h2>
                    </div>
                    <div class="col-md-5">
                        <a href="{{ route('role.all_view') }}" class="btn btn-primary pull-right rounded-pill mr-2">View All Assign Role</a>
{{--                        <a href="{{ route('role.assign') }}" class="btn btn-primary pull-right rounded-pill mr-2"> Assign Role</a>--}}
                        <a href="{{ url('roles/create') }}" class="btn btn-primary pull-right rounded-pill mr-2">Add Role</a>
                        @can('Access Role Bulkupload')
                            <a href="{{ route('admin.role_bulkupload.index') }}" class="btn btn-primary pull-right rounded-pill mr-2"><i class="fa fa-upload"></i>Upload Roles</a>
                        @endcan
                       
                   </div>
                </div>
            </header>

            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show center-block" role="alert">
                        <strong>{!! Session::get('success') !!} </strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                @endif
                <div class="card-body p-4">

                    <div class="table-responsive">
                        <table id="page-length-option" class="table table-striped table-hover multiselect">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Permissions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $key => $role)
                                    <tr>
                                        <td width="10%">
                                            <a href="{{ route('roles.view', $role->id) }}?rolname={{$role->name}}"
                                               class="p-2">
                                                <span class="fa fa-eye"></span>
                                            </a>
                                            <!--                                            <a href="{{ route('role.assign', ['id'=>$role->id]) }}"
                                                                                           class=""
                                                                                           data-position="top"
                                                                                           data-tooltip="Employees Assign">
                                                                                            <span class="material-icons left">accessibility</span>
                                                                                        </a>-->
                                            @if($role->name !== 'administrator')
                                            @can('Edit Role')
                                            <a href="{{ route('roles.edit', $role->id) }}"
                                               class="p-2">
                                                <span class="fa fa-edit"></span>
                                            </a>
                                            @endcan

                                                @if($role->name !== 'employees' && $role->name !== 'department' && $role->name !== 'designation' && $role->name !== 'team')
                                                @can('Delete Role')
                                                     <a href="" class="button" data-id="{{$role->id}}"><span class="fa fa-trash"></span></a>
                                                @endcan

                                                @endif
                                            @endif


                                        </td>
                                        <td width="1%">
                                            {{$key+1}}
                                        </td>
                                        <td width="10%">
                                            {{ ucfirst($role->name) }}
                                        </td>
                                        <td width="50%">
                                            @if($role->name === 'administrator')
                                            <span class="badge badge-info">All Permissions</span>
                                            @else
                                            @foreach($role->permissions as $per)
                                            <span class="badge badge-info">{{ $per->name }}</span>
                                            @endforeach
                                            @endif
                                        </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </section>
@endsection



{{-- page scripts --}}
@section('page-script')

<script>
$(document).ready(function () {
    $('#page-length-option').DataTable({
        "scrollX": true
    });
});

$(document).ready(function () {
    $(document).on('click', '.button', function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        swal({
                title: "Are you sure you want to delete? ",
                text: "You will not be able to recover this record!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "roles/" + id,
                        type: 'DELETE',
                        data: {
                            "_token": token,
                        },
                        success: function (result) {
                            swal({
                                title: "Record has been deleted!",
                                type: "success",
                            }, function () {
                                location.reload();
                            });
                        }
                    });
                }
            });
    });
});
</script>



@endsection
