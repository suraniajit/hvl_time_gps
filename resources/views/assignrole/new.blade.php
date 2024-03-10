{{-- extend layout --}}
@extends('app.layout')

{{-- page title --}}
@section('title','Assign Assets')


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
                <li class="breadcrumb-item ">Assign Role</li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body p-4">
                    <header>
                        <div class="row">
                            <div class="col-md-7">
                                <h2 class="h3 display"> Assign Role </h2>
                            </div>
                        </div>

                    </header>
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
                    @if (session('success'))
                        <div class="card-alert card gradient-45deg-green-teal">
                            <div class="card-content white-text">
                                <p>
                                    <i class="fa fa-check-circle"></i> SUCCESS : {{ session('success') }}
                                </p>
                            </div>
                            <button type="button" class="close text-white" data-dismiss="alert"
                                    aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                </div>

                <form id="assignrole" action="{{ route('role.assign.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="col s12">
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-4">
                                <label> Role <span class="text-danger">*</span></label>
                                <select class="form-control" multiple="multiple" name="roles[]" id="roles">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-12 col-md-4">
                                <label> Select Employees <span class="text-danger">*</span></label>
                                <select class="form-control" multiple="multiple" name="employees[]" id="employees_select">
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->Name }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4 pull-right">
                        <div class="col-sm-12 ">
                            <button class="btn btn-primary mr-2" type="submit" name="action">
                                <i class="fa fa-save"></i>
                                Save
                            </button>
                            <button type="reset" class="btn btn-secondary  mb-1">
                                <i class="fa fa-arrow-circle-left"></i>
                                <a href="{{url()->previous()}}" class="text-white">Cancel</a>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection

{{-- page scripts --}}
@section('page-script')

    <script>
        $(document).ready(function () {
            // script for validation in create page
            $("#assignrole").validate({
                rules: {
                    "roles[]": {
                        required: true,
                    },
                },
                messages: {
                    "roles[]": {
                        required: "Please Select Role",
                    },
                },
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    var placement = $(element).data('error');
                    if (placement) {
                        $(placement).append(error)
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            $('#roles,#employees_select').multiselect({
                includeSelectAllOption: true,

            });

        });
    </script>
@endsection
