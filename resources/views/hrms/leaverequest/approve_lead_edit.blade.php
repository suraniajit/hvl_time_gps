{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page Title --}}
@section('title','Edit Leave Request')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/materialize.min.css')}}">
@endsection



{{-- page content --}}
@section('content')
<div class="card">
    <div class="card-content">
        <h5 class="title-color"><span>Edit Leave Request</span></h5>
        @foreach($leaverequest as $l)

        <form action="{{route('hrms.leaverequest.lead.approve.update',['id'=>$l->id])}}" method="post">
            @endforeach
            @csrf
            <div class="row">
                <div class="input-field col s6">
                    <label for="">Employee Name</label>
                    @foreach($leaverequest as $l)
                    <input type="text" placeholder="Enter Name" class="input-field" name="employee_name"
                           value="{{$l->Name}}" disabled>
                    @endforeach
                </div>

                <div class="input-field col s4">
                    <select id="leave_type" name="leave_type" disabled>
                        <option value="">Leave Type</option>
                        @foreach($leavetype as $l)
                        @foreach($leaverequest as $ll)
                        <option value="{{$l->id}}" {{ $ll->leave_type==$l->id ? ' selected="" ' : '' }} >{{$l->Name}}</option>
                        @endforeach
                        @endforeach
                    </select>
                    <label for="leave_type">Leave Type</label>
                </div>
                <div class="input-field col s2">
                    <label style="margin-top: -23px;">Total Days</label><br>
                    @foreach($leaverequest as $l)
                    <input type="hidden" id="total_days" name="total_days" value="{{$l->total_days}}">
                    <span id="result" class="green-text result">{{$l->total_days}}</span>
                    @endforeach
                </div>
            </div>
            <div class="row">

                <div class="input-field col s2">
                    <label for="">From Date</label>
                    @foreach($leaverequest as $l)
                    <input type="text" placeholder="From Date" class="datepicker input-field"
                           id="from_date" name="from_date" value="{{$l->from_date}}" disabled>
                    @endforeach
                </div>

                <div class="input-field col s2">
                    <label for="">End Date</label>
                    @foreach($leaverequest as $l)
                    <input type="text" placeholder="End Date" class="datepicker input-field"
                           id="end_date" name="end_date" value="{{$l->end_date}}" disabled>
                    @endforeach
                </div>

                <div class="input-field col s8">
                    <label for="remark">Remark</label>
                    @foreach($leaverequest as $l)
                    <input type="text" placeholder="Enter Remark" class="input-field" name="remark" value="{{$l->remark}}" disabled>
                    @endforeach
                </div>
            </div>
            <div class="row">

                <div class="input-field col s4">
                    <select id="status" class="input-field" name="status" id="status">
                        <option value="0" disabled="" selected>Select Status</option>
                        <option value="4">Approve</option>
                        <option value="6">Reject</option>
                    </select>
                    <label>Select Status</label>
                    @error('status')
                    <div class="alert alert-danger red-text">{{ $message }}</div>
                    @enderror
                </div>
                <input type="hidden" name="reject_not_date" id="reject_not_date" value="<?php echo date("Y-d-m"); ?>"/>
                
                
                <div class="input-field col s4 rejectNot"  style="display: none;">
                    <label for="fn">Comment *</label>
                    <textarea name="reject_not"
                              id="reject_not"
                              placeholder="Enter Comment"
                              class="materialize-textarea" 
                              required=""></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col s12 display-flex justify-content-end form-action">
                    <button type="submit" name="action" class="btn btn-color mr-1">update
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
<script src="{{asset('js/ajax/angular.min.js')}}"></script>
<script src="{{asset('js/materialize.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script>
                        $(document).ready(function () {
                            $('.datepicker').datepicker({
                                format: 'yyyy-mm-dd'
                            });
                            $('#status').on('change', function () {
                                var html = '';
                                var values = $('#status :selected').val();
                                dynamic_field(values);

                                function dynamic_field(values) {
                                    html = '<label for="fn">Note *</label><textarea name="reject_not" id="reject_not" placeholder="Enter Comment" class="materialize-textarea" required=""></textarea>';
                                    //$(".rejectNot").hide();
                                    if (values == '6') {
                                        $(".rejectNot").show(html);
                                    }
                                    if (values == '4') {
                                        $(".rejectNot").show(html);
                                    }

                                }
                            });
                        });
</script>
@endsection
