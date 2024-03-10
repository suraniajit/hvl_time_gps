{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Employee Management')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
<script src="{{asset('js/ajax/jquery.min.js')}}"></script>
<style>
    .error{
        text-transform: capitalize;
        position: relative;
        top: 0rem;
        left: 0rem;
        font-size: 0.8rem;
        color: red;
        transform: translateY(0%);
    }
</style>
@endsection


{{-- page content --}}
@section('content')

<div class="card">
    <div class="card-content">
        <h5 class="title-color"><span>Accounts Employee</span></h5>

        @if(!empty($account_master->manager_id))
        <form id="formValidateEmployee" action="{{route('account.store')}}" method="post" enctype="multipart/form-data">
            @else
            <form id="formEditValidate" action="{{ route('account.update', $account_master->id) }}" method="POST" enctype="multipart/form-data">
                @endif
                {{csrf_field()}}
                <br>

                @include('employee-master.account._from')

                <div class="row">
                    <div class="col s12 display-flex justify-content-end form-action">
                        <button type="submit" class="btn btn-small indigo waves-light mr-1">
                            Save
                        </button>
                        <button type="reset" class="btn btn-small indigo waves-light mr-1" onclick="goBack();">
                            <i class="material-icons right">settings_backup_restore</i>Cancel
                        </button>                </div>
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

@endsection

{{-- page scripts --}}
@section('page-script')



@endsection