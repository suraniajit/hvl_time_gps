{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page Title --}}
@section('title','Create Leave Request')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/materialize.min.css')}}">
@endsection

<style>
    .datepicker-select{
        width: 100%;
    }
</style>

@section('content')
<div class="container">
    <div class="card">
        <div class="card-content">
            <h4 class="title-color">Create Leave Request</h4>
            <form action="{{route('hrms.leaverequest.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col s6">
                        <label for="">Employee Name</label>
                        @foreach($emp as $e)
                        <input type="text" placeholder="Enter Name" class="input-field" name="emp_name" value="{{$e->full_Name}}" disabled>
                        <input type="hidden" name="employee_id" value="{{$e->user_id}}">
                        @endforeach
                        <input type="hidden" name="department_lead_id" value="{{$dep}}">
                        <input type="hidden" name="is_confirm" value="{{$is_confirm}}">
                        <input type="hidden" name="emp_date" value="{{$emp_date}}">

                    </div>

                    <div class="input-field col s6">
                        <select id="leave_type" name="leave_type" data-error=".errorTxt6">
                            <option value = "" >Select Leave Type</option>
                            @foreach($leavetype as $leave)
                            <option value="{{$leave->id}}" >{{$leave->leavetype_name}}</option>
                            @endforeach
                        </select>
                        <label for="leave_type">Select Leave Type</label>
                        @error('leave_type')
                        <div class="alert alert-danger red-text">{{ $message }}</div>
                        @enderror

                    </div>
                </div>

                <div class="row">
                    <div class="col s4">
                        <label for="">From Date</label>
                        <input type="text" placeholder="From Date" class="datepicker input-field" id="from_date" name="from_date">
                        @error('from_date')
                        <div class="alert alert-danger red-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col s4">
                        <label for="">End Date</label>
                        <input type="text" placeholder="End Date" class="datepicker input-field" id="end_date" name="end_date">
                        @error('end_date')
                        <div class="alert alert-danger red-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-field col s4">
                        <input type="hidden" id="total_days" name="total_days">
                        <label style="margin-top: -23px;">Total Days</label><br>
                        <span id="result" class="green-text result"></span>
                    </div>

                </div>

                <div class="row">
                    <div class="col s12">
                        <label for="remark">Remark</label>
                        <input type="text" placeholder="Enter Remark" class="input-field" name="remark">
                        @error('remark')
                        <div class="alert alert-danger red-text">{{ $message }}</div>
                        @enderror
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
</div>
@endsection

{{-- vendor script --}}
@section('vendor-script')
<script src="{{asset('js/ajax/jquery.min.js')}}"></script>
<script src="{{asset('js/ajax/angular.min.js')}}"></script>
<script src="{{asset('js/materialize.js')}}"></script>

@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/hrms/leaverequest/create.js')}}"></script>
@endsection
