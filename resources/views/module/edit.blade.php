{{-- extend layout --}}
@extends('app.layout')


{{-- page title --}}
@php $pagetitle = ($table_name == 'Rating')?'Geographical Segment':ucfirst($table_name); @endphp
@section('title', $pagetitle.' | HVL')

{{-- page content --}}
@section('content')
    @php $table_name = str_replace('_', ' ', $table_name) @endphp
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('/modules/module/'.$table_name)}}">@if($table_name == 'LeadSource')
                            Lead Source
                        @elseif($table_name == 'LeadStatus')
                            Lead Status
                        @elseif($table_name == 'activitystatus')
                            Activity Status
                        @elseif($table_name == 'activitytype')
                            Activity Type
                        @elseif($table_name == 'Rating')
                                Geographical Segment
                        @else
                            {{ucfirst($table_name)}}
                        @endif </a></li>
                <li class="breadcrumb-item ">Update @if($table_name == 'LeadSource')
                        Lead Source
                    @elseif($table_name == 'LeadStatus')
                        Lead Status
                    @elseif($table_name == 'activitystatus')
                        Activity Status
                    @elseif($table_name == 'activitytype')
                        Activity Type
                    @elseif($table_name == 'Rating')
                                Geographical Segment
                    @else
                        {{ucfirst($table_name)}}
                    @endif </li>
            </ul>
        </div>
    </div>
    <!--Basic Card-->
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body p-4">

                    <header>
                        <div class="row">
                            <div class="col-md-7">
                                <h2 class="h3 display"> Update @if($table_name == 'LeadSource')
                                        Lead Source
                                    @elseif($table_name == 'LeadStatus')
                                        Lead Status
                                    @elseif($table_name == 'activitystatus')
                                        Activity Status
                                    @elseif($table_name == 'activitytype')
                                        Activity Type
                                    @elseif($table_name == 'Rating')
                                        Geographical Segment
                                    @else
                                        {{ucfirst($table_name)}}
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

                    <form action="
                          @if($table_name === 'employees')
                    {{ route('employees.update') }}
                    @else
                    {{ route('modules.module.update') }}
                    @endif" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="table_name" value="{{ str_replace(' ', '_', $table_name) }}">
                        @if(isset($table_data))
                            <input type="hidden" name="id" value="{{ $table_data->id }}"> @endif
                        <div class="row">
                            @include('module.form')
                        </div>


                        <div class="row mt-4 pull-right">
                            <div class="col-sm-12 ">
                                <button type="submit" name="action" class="btn btn-primary">
                                    <i class="fa fa-save"></i>
                                    Update
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
