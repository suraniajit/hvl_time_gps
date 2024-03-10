@extends('app.layout')

@php $module_name = str_replace('_', ' ', $module_name) @endphp

@php $pagetitle = ($module_name == 'Rating')?'Geographical Segment':ucfirst($module_name); @endphp
@section('title', $pagetitle.' | HVL')

@section('vendor-style')

@endsection

@section('content')
    <!--Basic Card-->
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">
                    <a href="{{ url('/modules/module/'.$module_name)}}">@if($module_name == 'LeadSource')
                            Lead Source
                        @elseif($module_name == 'LeadStatus')
                            Lead Status
                        @elseif($module_name == 'activitystatus')
                            Activity Status
                        @elseif($module_name == 'activitytype')
                            Activity Type
                        @elseif($module_name == 'Rating')
                            Geographical Segment
                       @else
                            {{ucfirst($module_name)}}
                        @endif
                    </a></li>
                <li class="breadcrumb-item "> Add New @if($module_name == 'LeadSource')
                        Lead Source
                    @elseif($module_name == 'LeadStatus')
                        Lead Status
                    @elseif($module_name == 'activitystatus')
                        Activity Status
                    @elseif($module_name == 'activitytype')
                        Activity Type
                    @elseif($module_name == 'Rating')
                            Geographical Segment
                    @else
                        {{ucfirst($module_name)}}
                    @endif </li>
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
                                <h2 class="h3 display"> Add @if($module_name == 'LeadSource')
                                        Lead Source
                                    @elseif($module_name == 'LeadStatus')
                                        Lead Status
                                    @elseif($module_name == 'activitystatus')
                                        Activity Status
                                    @elseif($module_name == 'activitytype')
                                        Activity Type
                                    @elseif($module_name == 'Rating')
                                        Geographical Segment
                                    @else
                                        {{ucfirst($module_name)}}
                                    @endif</h2>
                            </div>
                        </div>
                    </header>

                    @if ($errors->any())
                        <div class="card-alert card gradient-45deg-red-pink">
                            <div class="card-content white-text">
                                @foreach ($errors->all() as $error)
                                    <p>
                                        {{ $error }}
                                    </p>
                                @endforeach
                            </div>
                            <button type="button" class="close white-text" data-dismiss="alert"
                                    aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>

                        </div>
                    @endif

                    <form action="@if($module_name === 'employees')
                    {{ route('employees.store') }}
                    @else
                    {{ route('modules.module.store') }}
                    @endif" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="table_name" value="{{ str_replace(' ', '_', $module_name) }}">

                        <div class="row">
                            @include('module.createform')
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
        </div>
    </section>

@endsection


{{-- page scripts --}}
@section('page-script')
    <script>
        $('.dynamic_datepicker').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true,
            todayHighlight: true,

        });

        $('.selecpicker').multiselect({
            includeSelectAllOption: true,
        });

        $(document).ready(function () {
            $('input.maxlength, textarea.maxlength').characterCounter();
        });
    </script>
@endsection
