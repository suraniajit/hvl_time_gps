{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Holiday  Management')

{{-- vendor styles --}}
@section('vendor-style')
<!-- BEGIN: VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/select.dataTables.min.css') }}">
<!--<link rel="stylesheet" type="text/css" href="{{ asset('css/datatable/responsive.dataTables.min.css') }}">-->

<link rel="stylesheet" type="text/css" href="{{ asset('css/datatable/colReorder.dataTables.min.css') }} ">
<link rel="stylesheet" type="text/css" href="{{ asset('css/datatable/buttons.dataTables.min.css') }} ">
<link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('vendors/select2/select2-materialize.css') }}" type="text/css">
<!-- END: VENDOR CSS-->

<!-- BEGIN: Page Level CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/form-select2.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-tables.css') }}">

@endsection

{{-- page content --}}
@section('content')

<div class="card">
    <div class="card-content">
        <h5 class="title-color">Holiday Bulk Upload : <a href="{{route('emp.edit', $emp_id)}}">{{$employee_name}}</a></h5> 

        <div class=" ">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show center-block" role="alert">
                <strong>{!! Session::get('success') !!} </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if($errors->any())
            @foreach ($errors->all() as $error)

                 <div class="card-content">
                    <p style="color: red;">{{$error}}</p>
                </div>
                
            </div>
            @endforeach
            @endif

        </div>
        <br>
        <form class="form-horizontal well" action="{{route('empbulk.holidaybulkupload.save')}}"
              method="post" name="upload_excel" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <input type="hidden" name="emp_id" id="emp_id" value="{{$emp_id}}">
                <div class="form-group">
                    <input type="file" required name="excel_file" class="form-control-file">

                    <a href="{{asset('bulkuplod-samples/sample-file-holidays.xlsx')}}">Download : <u style="color: blue;">Sample File</u></a>

                </div>

                <br>
                <div class=" ">
                    <div class="col-md-5" style="color: red;font-size: 10px;">
                        <strong> Note: </strong><br>
                        1) Holiday Type, Holiday Name, Date (YYYY-MM-DD) are mandatory fields<br>
                        2) Please download Sample file, put data according to that format and upload the same to avoid any issue
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 display-flex justify-content-start form-action">
                        <button type="submit" class="btn indigo  waves-light mr-1">
                            <i class="material-icons left">file_upload</i> Upload Holidays  
                        </button>
                        <a href="{{route('emp.holidayshow',['id'=>$emp_id])}}" class="btn indigo  waves-light mr-1">
                            <i class="material-icons left">visibility</i>
                            <span class="add-btn">Holidays Show</span>
                        </a>
                    </div>
                </div>
                <br>
            </div>
        </form>
    </div>
</div>
@endsection


@section('vendor-script')
<script src="{{ asset('js/scripts/ui-alerts.js') }}"></script>
@endsection