@extends('app.layout')

{{-- page title --}}
@section('title','User Management | HVL')

@section('content')

<section>
    <div class="container-fluid">
        <header>
            <div class="row">
                <div class="col-md-7">
                    <h2 class="h3 display">User's Management</h2>
                </div>
                <div class="col-md-5">
                    @can('Create leads')
                    <a href="{{url('/users/create')}}" class="btn btn-primary pull-right rounded-pill">Add User</a>
                    @endcan 
                </div>
            </div>

        </header>

        <!-- Page Length Options -->
        <div class="card">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show center-block" role="alert">
                <strong>{!! \Session::get('success') !!} </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @endif
            <div class="card-body">
                <div class="table-responsive">
                    <table id="page-length-option" class="table table-striped table-hover multiselect">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $user)
                            @if($user->id != 1)
                            <tr>
                                <td width="6%">
                                    @if( (!$user->hasRole(['Admin'])))
                                    @can('Edit User')
                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="tooltipped mr-10"
                                       data-tooltip="Edit">
                                        <span class="fa fa-edit"></span>
                                    </a>
                                    @endcan

                                    @can('Delete User')
                                    @if($user->id != 1)

                                    <a href="" class="button" data-id="{{ $user->id }}">
                                        <span class="fa fa-trash"></span>
                                    </a>
                                    @endif
                                    @endcan
                                    @endif
                                </td>
                                <td width="5%"><center>{{$loop->iteration - 1}}</center></td>
                        <td width="25%"> {{ $user->name }}</td>
                        <td width="25%">{{ $user->email }}</td>
                        <td> {{ implode(",",$user->getRoleNames()->toArray())}} </td>
                        </tr>
                        @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@section('page-script')
<script>
    $(document).ready(function () {
        $('#page-length-option').DataTable({
            "scrollX": true
        });
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
                                url: "users/" + id,
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
