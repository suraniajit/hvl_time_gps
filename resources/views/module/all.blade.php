{{-- extend layout --}}
@extends('app.layout')

{{-- page Title --}}
@section('title', 'Manage Modules')

{{-- vendor styles --}}
@section('vendor-style')
    <!-- BEGIN: VENDOR CSS-->

@endsection



{{-- page content --}}
@section('content')

    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Modules</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display">Manage Modules</h2>
                    </div>
                    <div class="col-md-5">
                        {{--                            @can('Create Module')--}}
                        <a href="{{ route('module.create') }}" class="btn btn-primary pull-right rounded-pill ">Create
                            Module</a>
                        {{--                                <!--@endcan-->--}}
                    </div>
                </div>
            </header>
            <div class="card">
                <div class="card-body p-4">

                    @if (session('success'))
                        <div class="card-alert card gradient-45deg-green-teal" id="msg">
                            <div class="card-content white-text">
                                <p>
                                    <i class="material-icons">check</i> SUCCESS : {{ session('success') }}
                                </p>
                            </div>
                            <button type="button" class="close white-text" data-dismiss="alert"
                                    aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="page-length-option" class="table table-striped table-hover multiselect">
                            <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Name</th>
                                <!--<th>Parent Module</th>-->
                                <th>Modified Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($modules as $key => $module)
                                @can('Access '.$module->name)
                                    <tr>
                                        <td width="6%">{{ $key+1 }}</td>
                                        <td>
                                            <b>
                                                <a href="{{ route('modules.module', str_replace('_', '%20', $module->name)) }}">
                                                    {{ ucfirst($module->name) }}
                                                </a></b>
                                        </td>
                                        <!--<td>-->
                                        <!--    {{ $module->path }}-->
                                        <!--</td>-->
                                        <td>{{ date('d M, Y', strtotime($module->updated_at)) }}</td>
                                        <td width="6%">
                                            @can('Edit Module')
                                                <a href="{{ route('module.edit', $module->id) }}"
                                                   class="mb-6 btn-floating  waves-light cyan">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('Delete Module')
                                                @if($module->name !== 'employees' and $module->name !== 'departments' and $module->name !== 'designations' and $module->name !== 'teams' and $module->name !== 'CompanyType' and $module->name !== 'LeadStatus' and $module->name !== 'LeadSource' and $module->name !== 'Industry' and $module->name !== 'Rating' and $module->name !== 'Branch'  and $module->name !== 'activitytype' and $module->name !== 'activitystatus'  )

                                                        <a href="" class="button" data-id="{{ $module->id }}"
                                                           data-name="{{$module->name}}">
                                                            <span class="fa fa-trash"></span>
                                                        </a>
                                                @endif
                                            @endcan
                                        </td>
                                    </tr>
                                @endcan
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

            $(document).on('click', '.button', function (e) {
                e.preventDefault();
                var id = $(this).data("id");
                var name = $(this).data("name");
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
                                url: "/module/" + id,
                                type: 'DELETE',
                                data: {
                                    "id": id,
                                    "name": name,
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
    </script>
@endsection


