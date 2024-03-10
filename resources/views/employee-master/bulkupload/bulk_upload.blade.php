{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Employee Management')

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
        <h5 class="title-color"><span>Employee – Bulk Upload</span></h5>

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

            <div class="card-alert card red" id="message">
                <div class="card-content">
                    <p>{{$error}}</p>
                </div>
                <button type="button" class="close green-text close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @endforeach
            @endif

        </div>
        <br>
        <form class="form-horizontal well" action="{{route('empbulk.bulkupload.save')}}"
              method="post" name="upload_excel" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="file" required name="excel_file" class="form-control-file">

                <a href="{{asset('bulkuplod-samples/sample-file-employee.xlsx')}}">Download : <u style="color: blue;">Sample File</u></a>

            </div>
            <br>
            <div class="col-md-5" style="color: red;font-size: 10px;">
                <strong> Note: </strong><br>
                1) Employee Name, Email ID,  Phone, Date of Birth (YYYY-MM-DD), Date of Appointment (YYYY-MM-DD),Date Of Increment (YYYY-MM-DD),Teams, Department, Designation, HR, Department Lead, Team Lead, Salary Type, Employee Type, Shift, Recruiter, Insurance
                are mandatory fields<br>
                2) Please download Sample file, put data according to that format and upload the same to avoid any issue<br>
            </div>
            <br>
            <div class="row">
                <div class="col s12 display-flex justify-content-start form-action">
                    <button type="submit" class="btn indigo  waves-light mr-1">
                        Upload Employees 
                    </button>
                </div>
            </div>
            <br>
        </form>
    </div>
</div>
@endsection

@section('vendor-script')

<script src="{{ asset('js/ajax/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/ajax/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('vendors/select2/select2.full.min.js') }}"></script>


<!-- END THEME  JS-->
<script src="{{ asset('js/scripts/data-tables.js') }}"></script>
<script src="https://cdn.datatables.net/colreorder/1.5.2/js/dataTables.colReorder.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>

<!-- BEGIN PAGE LEVEL JS-->
<script src="{{ asset('js/scripts/extra-components-sweetalert.js') }}"></script>
<!-- END PAGE LEVEL JS--><!-- BEGIN: Custom Page JS-->
<script src="{{ asset('js/scripts/form-select2.js') }}"></script>
<script src="{{ asset('js/scripts/ui-alerts.js') }}"></script>

<script src="{{ asset('js/download-table.js') }}"></script>
@endsection