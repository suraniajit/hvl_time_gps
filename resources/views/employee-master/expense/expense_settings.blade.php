zfz{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Expense Setting Management')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/dropify/css/dropify.min.css')}}">
<script src="{{asset('js/ajax/jquery.min.js')}}"></script>

@endsection


{{-- page content --}}
@section('content')

<div class="card">
    <div class="card-content">
        <h5 class="title-color"><span> Admin Expense Action</span></h5>

        <form id="formEditValidate" action="{{ route('expense.expense_settings_update', 'hherp') }}" method="POST" enctype="multipart/form-data" onsubmit="return(submitFrm());">
            {{csrf_field()}}

            <h6 class="title-color">
                <span>

                </span>
            </h6>
            <div class="row">
                <div class="input-field col s4">
                    <select name="combined_submission" required="">
                        <option disabled="" selected="">Expense Setting</option>
                        <option value="1" {{$expense_settings=='1' ? 'selected' : ''}} >Single Expense Submission</option>
                        <option value="2" {{$expense_settings=='2' ? 'selected' : ''}} >Multiple Expense Submission</option>
                    </select>
                    <label>Expense Setting </label>
                </div>
            </div>
            <div class="row">
                <div class="col s12 display-flex justify-content-end form-action">
                    <button type="submit" class="btn btn-small indigo waves-light mr-1">
                        Save
                    </button>
                    <button type="reset" class="btn btn-small indigo waves-light mr-1" onclick="goBack();">
                        <i class="material-icons right">settings_backup_restore</i>Cancel
                    </button>                
                </div>
            </div>
            <br>
        </form>
    </div>
</div>
@endsection

{{-- vendor script --}}
@section('vendor-script')

<script src="{{asset('js/ajax/angular.min.js')}}"></script>
<script src="{{asset('js/materialize.js')}}"></script>
<script src="{{asset('js/ajax/jquery.validate.min.js')}}"></script>
<script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
<script src="{{asset('js/scripts/form-select2.js')}}"></script>
<script src="{{asset('js/expense/edit.js')}}"></script>
<script src="{{asset('vendors/dropify/js/dropify.min.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-script')
<script src="{{asset('js/scripts/form-file-uploads.js')}}"></script>
@endsection