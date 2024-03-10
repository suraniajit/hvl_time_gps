{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title',$table_name.' Master')


@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/page-users.css') }}">
@endsection

@section('content')

<div class="card">
    <div class="card-content">
        <div class="row">
            <div class="col s8">

                <h5 class="media-heading">
                    <span class="users-view-username grey-text">{{ $table_data->Name }}</span>

                </h5>

            </div>
            <div class="col s4">
                @can('Edit '.str_replace('_', ' ', $table_name))

                <a class="btn-floating activator  waves-light red accent-0 z-depth-0 right"
                   data-tooltip="edit"
                   href="{{ route('modules.module.edit', [$table_name, $table_data->id]) }}">
                    <i class="material-icons">edit</i>
                </a>
                @endcan
            </div>
        </div>



        <div class="row">
            <h6 class="mb-2 mt-2">{{ ucfirst($table_name) }} Information </h6>

            @if($table_name === 'employees')
            @php $employees = \App\Employee::find($table_data->id) @endphp
            
            <table class="striped">
                <tbody>
                    <tr>
                        <td>Email</td>
                        <td class="users-view-username">{{ $table_data->email }}</td>
                    </tr>
                    <tr>
                        <td>Departments</td>
                        <td>
                            @if(isset($employees->departments))
                            @foreach($employees->departments as $dep)
                            <a href="{{ route('modules.module.show', ['departments', $dep->id]) }}"
                               class="collection-item">
                                <span class="new badge gradient-45deg-light-blue-cyan"
                                      data-badge-caption="{{ $dep->Name }}"></span>
                            </a>
                            @endforeach
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Teams</td>
                        <td>
                            @if(isset($employees->teams))
                            @foreach($employees->teams as $team)
                            <a href="{{ route('modules.module.show', ['teams', $team->id]) }}"
                               class="collection-item">
                                <span class="new badge gradient-45deg-light-blue-cyan"
                                      data-badge-caption="{{ $team->Name }}"></span>
                            </a>
                            @endforeach
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Designations</td>
                        <td>
                            @if(isset($employees->designations))
                            @foreach($employees->designations as $des)
                            <a href="{{ route('modules.module.show', ['designations', $des->id]) }}"
                               class="collection-item">
                                <span class="new badge gradient-45deg-light-blue-cyan"
                                      data-badge-caption="{{ $des->Name }}"></span>
                            </a>
                            @endforeach
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            @endif

            @if($table_name === 'departments')
            @php $department = \App\Department::find($table_data->id) @endphp
            <table class="striped">
                <tbody>
                    <tr>
                        <td>Employees</td>
                        <td class="users-view-username">
                            @foreach($department->employees as $emp)
                            <a href="{{ route('modules.module.show', ['employees', $emp->id]) }}"
                               class="collection-item">
                                <span class="new badge gradient-45deg-light-blue-cyan"
                                      data-badge-caption="{{ $emp->Name }}"></span>
                            </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            @endif

            @if($table_name === 'teams')
            @php $team = \App\Team::find($table_data->id) @endphp
            <table class="striped">
                <tbody>
                    <tr>
                        <td>Employees</td>
                        <td class="users-view-username">
                            @foreach($team->employees as $emp)
                            <a href="{{ route('modules.module.show', ['employees', $emp->id]) }}"
                               class="collection-item">
                                <span class="new badge gradient-45deg-light-blue-cyan"
                                      data-badge-caption="{{ $emp->Name }}"></span>
                            </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            @endif

            @if($table_name === 'designations')
            @php $designation = \App\Designation::find($table_data->id) @endphp
            <table class="striped">
                <tbody>
                    <tr>
                        <td>Employees</td>
                        <td class="users-view-username">
                            @foreach($designation->employees as $emp)
                            <a href="{{ route('modules.module.show', ['employees', $emp->id]) }}"
                               class="collection-item">
                                <span class="new badge gradient-45deg-light-blue-cyan"
                                      data-badge-caption="{{ $emp->Name }}"></span>
                            </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            @endif

            @foreach($fields as $field)
            @foreach(json_decode($field->form) as $item)
            @if ($item->type !== 'section')
            @php $f = str_replace(' ', '_', $item->label); @endphp
            <table class="striped">
                <tbody>
                    <tr>
                        <td>{{ $item->label }}</td>
                        <td class="users-view-username">{{ $table_data->$f }}</td>
                    </tr>
                </tbody>
            </table>
            @else
            <h6 class="mb-2 mt-2">{{ $item->label }}</h6>
            @endif
            @endforeach
            @endforeach
        </div>
    </div>
    <!-- </div> -->
</div>
</div>
<!-- users view card details ends -->

<!-- users view ends -->

<div class="content-overlay"></div>
</div>
@endsection
