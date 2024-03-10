{{-- layout extend --}}
@extends('app.layout')


{{-- page title --}}
@section('title','Expense Management')

{{-- vendor styles --}}
@section('vendor-style')
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


@section('content')
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{route('expense')}}">Expense Master</a></li>
        </ul>
    </div>
</div>
<?php // if (Auth::id() == '1') { ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body p-4">
            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display">Expense Action History</h2>
                    </div>
                </div>
            </header>
            <div class="row">
                <div class="input-field col s3">
                    <label>Employee Name </label>
                    <select name="employee_id" class="employee_id form-control select"" disabled="" >
                        <option disabled="" value="0">Employee Name</option>
                        @foreach($employee_master as $employee)
                        <option value="{{$employee->user_id}}" {{$employee->user_id == $edit_details->is_user ? 'selected' : ''}}>{{$employee->Name}}</option>
                        @endforeach
                    </select>
                    <div class="employee_id_error"></div>
                </div>
                <div class="input-field col s3">
                    <label>Payment Status </label>
                    <select name="payment_status_id" id="payment_status_id" class="payment_status_id form-control select"" disabled="">
                        <option disabled="" value="0">Payment Status</option>
                        @foreach($payment_status_master as $payment_status)
                        <option value="{{$payment_status->id}}" {{$payment_status->id == $edit_details->payment_status_id ? 'selected' : ''}}>{{$payment_status->name}}</option>
                        @endforeach
                    </select>
                    <div class="payment_status_id_error"></div>
                </div>
                <div class="input-field col s4">
                    <label>Action Status </label>
                    <select name="is_status_admin" disabled="" class="form-control select"">
                        <option disabled="" selected="">Action Status</option>
                        <option value="0" {{$edit_details->is_process == 0 ? 'selected' : ''}} > </option>
                        <option value="1" {{$edit_details->is_process == 1 ? 'selected' : ''}} >Accept from Manager</option>
                        <option value="2" {{$edit_details->is_process == 2 ? 'selected' : ''}} >Reject from Manager</option>
                        <option value="3" {{$edit_details->is_process == 3 ? 'selected' : ''}} >Accept from Accountant</option>
                        <option value="4" {{$edit_details->is_process == 4 ? 'selected' : ''}} >Reject from Accountant</option>
                        <option value="5" {{$edit_details->is_process == 5 ? 'selected' : ''}} >Accept from Admin</option>
                        <option value="6" {{$edit_details->is_process == 6 ? 'selected' : ''}} >Reject from Admin</option>
                    </select>
                </div>
            </div>
            <div class=" ">
                <?php
                $expenses_history = DB::table('api_expenses_action_log')
                        ->where('emp_id', '=', $edit_details->id)
                        ->where('is_process', '!=', 0)
                        ->orderBy('api_expenses_action_log.id', 'DESC')
                        ->get();
                ?>
                <?php if (count($expenses_history) > 0) { ?>
                    <h6 class="title-color"><span>Transaction History </span> </h6>
                    @include('user-profile.__expance_history')
                <?php } ?>
            </div>
            <?php // } ?>
        </div>
    </div>
</div>

@endsection


{{-- page scripts --}}
@section('page-script')
@include('employee-master.expense.ejs')
<script src="{{asset('js/scripts/form-file-uploads.js')}}"></script>
@endsection