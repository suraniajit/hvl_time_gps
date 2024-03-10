@extends('app.layout')

{{-- page title --}}
@section('title','Account Management | HVL')

@section('vendor-style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.rawgit.com/jonthornton/jquery-timepicker/3e0b283a/jquery.timepicker.min.css">
<script src="https://cdn.rawgit.com/jonthornton/jquery-timepicker/3e0b283a/jquery.timepicker.min.js"></script>
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
            <li class="breadcrumb-item active"><a href="{{route('account')}}">Account Master</a></li>
            <li class="breadcrumb-item ">Add Expense</li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-body p-4">
            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display">Account Management</h2>
                    </div>
                </div>
            </header>
            <form id="formValidateEmployee" action="{{route('account.store')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <br>
                <h5 class="card-title">
                    Account Details 
                </h5>
                <div class="row">
                    <div class=" col-md-3">
                        <div class="input-field">
                            <label>Employee Name* </label>
                            <select class="form-control select" name="emp_id" id="emp_id">
                                <option  disabled="">Employee Name</option>
                                @foreach($employee_master as $employee)
                                <option value="{{$employee->user_id}}" >{{$employee->Name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class=" col-md-7" style="    float: right;">
                        <div class="row">
                             <div class="form-group col-sm-6 col-md-3">
                            </div>
                            <div class="form-group col-sm-6 col-md-3">
                                <label>Manager Name* </label>
                                <select class="form-control select manager_id" name="manager_id" id="manager_id">
                                    <option  disabled="">Manager Name</option>
                                    @foreach($employee_master as $employee)
                                    <option value="{{$employee->user_id}}" >{{$employee->Name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-6 col-md-3">
                                <label>Account list* </label>
                                <select class=" form-control select account_id" name="account_id" id="account_id" >
                                    <option  disabled="">Account list</option>
                                    @foreach($employee_master as $employee)
                                    <option value="{{$employee->user_id}}" >{{$employee->Name}}</option>
                                    @endforeach
                                </select>

                            </div>
<!--                            <div class="form-group col-sm-6 col-md-3">
                                <label>Note </label>
                                <input type="text" name="note" placeholder="Note" class="form-control">
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="row" style="text-align: end;">
                    <div class="col s12 display-flex justify-content-end form-action">
                        <button class="btn btn-primary mr-2" type="submit" name="is_save" value="1" >Submit 
                            <i class="fa fa-save"></i>
                        </button>
                        <button type="reset" class="btn btn-secondary  mb-1">
                            <i class="fa fa-arrow-circle-left"></i>
                            <a href="{{url()->previous()}}" class="text-white">Cancel</a>
                        </button>            
                    </div>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>


@endsection

{{-- page scripts --}}
@section('page-script')

@endsection