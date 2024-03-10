<?php

use App\Employee;
use App\Module;
use App\User;
?>{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title',ucfirst(substr($table_name, 0, -1)))

@section('content')

<div class="card">
    <div class="card-content">
        <div class="row">
            <div class="col s8">
                <h5>
                    {{ucfirst(substr($table_name, 0, -1)) }} Information
                </h5>
            </div>
            <div class="col s4">
                @can('Edit '.str_replace('_', ' ', $table_name))
                <a class="btn-floating activator waves-light green accent-0 z-depth-0 right"
                   data-tooltip="edit"
                   href="{{ route('modules.module.edit', [$table_name, $table_data->id]) }}">
                    <i class="material-icons">edit</i>
                </a>
                @endcan
            </div>
        </div>


        <div class="card-content">
            <div class="row">


                <div class="row">

{{--                    @if($table_name === 'employees')--}}
{{--                    @php $employees = \App\Employee::find($table_data->id) @endphp--}}
{{--                    <!--                    <div class="input-field col s4"> --}}
{{--                    --}}
{{--                                            <strong> Email </strong>: {{ $table_data->email }}--}}
{{--                    --}}
{{--                                        </div>-->--}}
{{--                    <!--                    <div class="input-field col s4"> --}}
{{--                                            <strong> Departments : </strong>--}}
{{--                                            @if(isset($employees->departments))--}}
{{--                                            @foreach($employees->departments as $dep)--}}
{{--                                            <a href="{{ route('modules.module.show', ['departments', $dep->id]) }}"--}}
{{--                                               class="collection-item">--}}
{{--                                                <span class="new badge gradient-45deg-light-blue-cyan"--}}
{{--                                                      data-badge-caption="{{ $dep->Name }}"></span>--}}
{{--                                            </a>--}}
{{--                                            @endforeach--}}
{{--                                            @endif--}}
{{--                                        </div>-->--}}

{{--                    @endif--}}


                    @if($table_name === 'departments')
                    @php $department = \App\Department::find($table_data->id) @endphp

                    <div class="input-field col s4">
                        <strong>  Employees:</strong> 
                        @foreach($department->employees as $emp)
                        <a href="{{ route('modules.module.show', ['employees', $emp->id]) }}"
                           class="collection-item">
                            <span class="new badge gradient-45deg-light-blue-cyan"
                                  data-badge-caption="{{ $emp->Name }}"></span>
                        </a>
                        @endforeach
                    </div>

                    @endif


                    <?php $i = 0; ?>
                    @foreach ($fields as $field)
                    @include('module._emp-detail')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-overlay"></div>
@endsection
