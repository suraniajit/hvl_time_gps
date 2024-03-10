{{-- extend layout --}}
@extends('app.layout')

{{-- page title --}}
@section('title','Manage Role')


{{--<style>--}}
{{--    .modal { width: 20% !important ; height: 55% !important ; }--}}
{{--</style>--}}

{{-- page content --}}
@section('content')
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/roles')}}">Roles </a></li>
                <li class="breadcrumb-item active">Manage Role</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display">Manage Role</h2>
                    </div>
                </div>
            </header>
            <div class="card">
                <div class="card-body p-4">
                    <?php if (count($getAllRoles_Details) > 0) { ?>
                    <div class="row">
                        <div class="col s12">
                            <table id="page-length-option" class="table table-striped table-hover multiselect">
                                <thead>
                                <tr>
                                    <th>
                                        <center>No</center>
                                    </th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($users as $key => $user)
                                    @if($user->email !== 'probsoltechnology@gmail.com')
                                    <tr>
                                        <td width="5%">
                                            <center>{{$key}}</center>
                                        </td>
                                        <td width="15%">
                                            {{ ucfirst($user->name) }}
                                        </td>
                                        <td width="25%">{{ $user->email }}</td>
                                        <td width="15%">
                                            @foreach($user->roles as $role)
                                                <span class=" badge badge-info">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php } else { ?>
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

    </section>
@endsection

{{-- vendor script --}}
@section('page-script')
    <script>
        $(document).ready(function () {
            $('#page-length-option').DataTable({
                "scrollX": true
            });
        });
    </script>
@endsection
