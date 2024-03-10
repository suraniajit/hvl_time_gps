{{-- layout extend --}}

@extends('layouts.contentLayoutMaster')

{{-- page Title --}}
@section('title','Country Managment')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/materialize.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/form-select2.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/dropify/css/dropify.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('js/ajax/jquery-datetimepicker/jquery.datetimepicker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('js/ajax/jquery-datetimepicker/jquery.datetimepicker.min.css')}}">
@endsection


{{-- page content --}}
@section('content')

<div class="card">
    <div class="card-content">
        <h5 class="title-color"><span>Create Country</span></h5>
        <form id="formValidate" action="{{route('hrms.country.store')}}" method="post">
            {{csrf_field()}}
            <div class="row">
                <div class="input-field col s6">
                    <label for="">Country Name </label>
                    <input type="text" name="country_name" id="country_name" placeholder="Enter Country Name" data-error=".errorTxt1" autocomplete="off" autofocus="off"  >
                    <div class="errorTxt1"></div>
                </div>

                <div class="input-field col s6">
                    <select id="is_active" name="is_active" data-error=".errorTxt2">
                        <option value = "" disabled="" >Select Status</option>
                        <option value = "0" selected="">Active</option>
                        <option value = "1">Inactive</option>
                    </select>
                    <label>Select Status</label>
                    <div class="errorTxt2"></div>
                </div>
            </div>

            <div class="row">
                <div class="col s12 display-flex justify-content-end form-action">
                    <button type="submit" name="action" class="btn btn-color mr-1">Save
                        <i class="material-icons right">send</i>
                    </button>
                    <button type="reset" class="btn btn-color mb-1" onclick="goBack();">
                        <i class="material-icons right">settings_backup_restore</i>Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>  

@endsection

{{-- vendor script --}}
@section('vendor-script')
<script src="{{asset('js/ajax/jquery.min.js')}}"></script>
<script src="{{asset('js/materialize.js')}}"></script>
<script src="{{asset('js/ajax/jquery.validate.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')

<script src="{{asset('js/hrms/country/create.js')}}"></script>

@endsection
