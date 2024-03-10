@extends('app.layout')

@section('title','View Roles')


@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                <li class="breadcrumb-item "><a href="{{url('/roles')}}">Roles Management</a></li>
                <li class="breadcrumb-item active">View Roles</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display">View Role</h2>
                    </div>
                    <div class="col-md-5 ">
                        <h2 class="h3 display rounded-pill badge badge-info p-2 pull-right">
                            <?php
                            if (!empty($_GET['rolname'])) {
                            ?>
                            Role: <?php echo ucfirst($_GET['rolname']); ?>
                            <?php
                            }
                            ?></h2>
                    </div>
                </div>
            </header>
            <div class="card">
                <div class="card-body p-4">
                    <div class="row">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="card-alert card gradient-45deg-red-pink">
                                    <div class="card-content white-text">
                                        <p>
                                            <i class="material-icons">error</i>{{ $error }}
                                        </p>
                                    </div>
                                    <button type="button" class="close white-text" data-dismiss="alert"
                                            aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>


        <?php if (count($getAllRoles_Details) > 0) { ?>
                    <div class="table-responsive">
                        <table id="page-length-option" class="table table-striped table-hover multiselect">
                            <thead>
                                <tr>
                                    <th> <center>No</center></th>
                            <th>Name</th>

                            <th>Email</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($getAllRoles_Details as $key => $user)
                                    @if($user->email !== 'probsoltechnology@gmail.com')
                                        <tr>
                                            <td width="5%"><center>{{$key}}</center></td>
                                            <td width="25%">{{ ucfirst($user->name) }}</td>
                                            <td width="25%">{{ $user->email }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
        <?php } else { ?>
            <div class="card-body">
                <div class="row center">
                    <h6>
                        <strong>
                            No one has been assigned this role
                        </strong>
                    </h6>
                </div>
            </div>
        <?php } ?>





    </div>

</div>
</div>


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
                    $('.delete-record-click').click(function () {
                        var id = $(this).data("id");
                        var token = $("meta[name='csrf-token']").attr("content");

                        swal({
                                title: "Are you sure? ",
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

