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
                <h5 class="card-title mb-0">System Log Detail</h5>
            </div>
            <div class="card-body">
                <table class="table table-nowrap">
                    <tbody>
                        <tr>
                            <th><label for="nameInput" class="form-label">Action By</label></th>
                            <td>{{$logs->action_by}}</td>
                        </tr>
                        <tr>
                            <th><label for="nameInput" class="form-label">Module</label></th>
                            <td>{{$logs->module}}</td>
                        </tr>
                        <tr>
                            <th><label for="nameInput" class="form-label">Action</label></th>
                            <td>{{$logs->action}}</td>
                        </tr>
                        <tr>
                            <th><label for="nameInput" class="form-label">Date</label></th>
                            <td>{{$logs->created_at}}</td>
                        </tr>
                        @foreach( json_decode($logs->user_understand_data, TRUE) as $key=>$row )
                        <tr>
                            <th >{{ucwords(str_replace('_',' ',$key))}}</th>
                            <td >{{$row}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                    <div class="mb-3">
                        <a href="{{route('system_log view')}}" class="btn btn-primary pull-right rounded-pill">Back</a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--end row-->
@endsection
@section('js-stack')
 <!--datatable js-->
 {{-- <script src="../../../../cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
 <script src="../../../../cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
 <script src="../../../../cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
 <script src="../../../../cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
 <script src="../../../../cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
 <script src="../../../../cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
 <script src="../../../../cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
 <script src="../../../../cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
 <script src="../../../../cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 <script src="assets/js/pages/datatables.init.js"></script> --}}
@endsection


