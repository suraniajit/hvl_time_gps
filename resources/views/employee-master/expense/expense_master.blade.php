{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Expense Management')

{{-- vendor styles --}}
@section('vendor-style')
 
@endsection


{{-- page content --}}
@section('content')

<div class="card">
    <div class="card-content">
        <h5 class="title-color"><span>Expense Status</span></h5>
        {{csrf_field()}}


        <form id="formEditValidateAdmin" action="{{ route('expense.updateByAccount', $edit_details->id) }}" method="POST" enctype="multipart/form-data">

            <div class="row">
                <div class="input-field col s3">
                    <input type="hidden" name="expense_type" value="{{$edit_details->expense_type}}">

                    <select data-error=".errorTxt1" disabled="">
                        <option disabled="" >Select Expense Type*</option>
                        <option value="0" data-id="0" {{$edit_details->expense_type == 0 ? 'selected' : ''}}>Cash</option>
                        <option value="1" data-id="1" {{$edit_details->expense_type == 1 ? 'selected' : ''}}>Mileage</option>
                    </select>
                    <label>Select Expense Type* </label>
                    <div class="errorTxt1"></div>
                </div>
                 
                <div class="input-field col s3">
                    <select name="is_active" data-error=".errorTxt2">
                        <option disabled=""> Status</option>
                        <option value="0" {{$edit_details->is_active == 0 ? 'selected' : ''}}>Active</option>
                        <option value="1" {{$edit_details->is_active == 1 ? 'selected' : ''}}>Inactive</option>
                    </select>
                    <label>Status </label>
                    <div class="errorTxt2"></div>
                </div>
                <div class="input-field  col s3" style="display: none;">
                    <select name="payment_method_id" id="payment_method_id" class="payment_method_id" data-error=".errorTxt15">
                        <option  disabled="" >Payment Method*</option>
                        @foreach($payment_method_master as $payment)
                        <option value="{{$payment->id}}" {{$payment->id == $edit_details->payment_method_id ? 'selected' : ''}}>{{$payment->name}}</option>

                        @endforeach
                    </select>
                    <label>Payment Method* </label>
                    <div class="errorTxt15"></div>
                </div>

                <div class="input-field  col s3" style="display: none;">
                    <select name="payment_status_id_cash" id="payment_status_id" class="payment_status_id" data-error=".errorTxt7" placeholder>
                        <option disabled="" >Payment Status*</option>
                        @foreach($payment_status_master as $payment_status)
                        <option value="{{$payment_status->id}}" {{$payment_status->id == $edit_details->payment_status_id? 'selected' : ''}}>{{$payment_status->name}}</option>

                        @endforeach
                    </select>
                    <label>Payment Status* </label>
                    <div class="errorTxt16"></div>
                </div>
            </div>
            <!--            <div class="row">
                            <div class="col s12 display-flex justify-content-end form-action">
                                <button type="submit" class="btn btn-small indigo waves-light mr-1">
                                    Update
                                </button>
                                <button type="reset" class="btn btn-small indigo waves-light mr-1" onclick="goBack();">
                                    <i class="material-icons right">settings_backup_restore</i>Cancel
                                </button>                </div>
                        </div>-->
            <br>
        </form>
        <div class="input-field col s9">
            <div class="row">
                @include('employee-master.expense._edit_cashFlow')
                @include('employee-master.expense._edit_mileageFlow')
            </div>
        </div>
        <div class="col s3">
            <div class="row">
                <h4 class="card-title">Uploaded Expense Documents</h4>
                <?php foreach ($edit_details_file as $key => $files) { ?>
                    <div class="input-field col s3" style="text-align: center;">
                        @include('employee-master.expense.__file_extension')
                     </div>
                <?php } ?> 
            </div>
        </div>
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

@include('employee-master.expense.ejs')
@endsection

{{-- page scripts --}}
@section('page-script')
<script src="{{asset('js/scripts/form-file-uploads.js')}}"></script>
@endsection