@extends('new_themes.master');

{{-- page title --}}
@section('title','Dashboard | Asset Management')
@section('css-stack')
{{-- <!--datatable css-->
<link rel="stylesheet" href="../../../../cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<!--datatable responsive css-->
<link rel="stylesheet" href="../../../../cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
<link rel="stylesheet" href="../../../../cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css"> --}}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            
            <div class="card-header">
                <div class="row">
                    <div class="col-10">
                        <h5 class="card-title mb-0">Activity Log</h5>        
                    </div>
                    <div class="col-2">
                        <a href="{{route('activity.index')}}" class="btn btn-primary pull-right rounded-pill">Back To Potal</a>
                    </div>
                </div>
                
            
            </div>
            <div class="card-body">
                <table id="fixed-header" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Date & Time </th>
                            <th>Activity By</th>
                            <th>Module</th>
                            <th>Activity</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $key=>$log)
                        <tr>
                            <td>{{$log->id}}</td>
                            <td>{{$log->created_at}}</td>
                            <td>{{$log->action_by}}</td>
                            <td>{{$log->module}}</td>
                            <td>{{$log->action}}</td>
                            <td>
                                <a href="{{route('system_log detail',[$log->id])}}">
                                    <i class="ri-eye-line"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$logs->links()}}
            </div>
        </div>
    </div>
</div><!--end row-->
@endsection
@section('js-stack')

@endsection


