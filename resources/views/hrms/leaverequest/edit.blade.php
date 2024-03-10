{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page Title --}}
@section('title','Edit Leave Request')

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
            <h4 class="title-color">Edit Leave Request</h4>
            @foreach($leaverequest as $l)
            <form action="{{route('hrms.leaverequest.update',['id'=>$l->id])}}" method="post">
                @endforeach
                @csrf
                <div class="row">
                    <div class="col s6">
                        <label for="">Employee Name</label>
                        @foreach($leaverequest as $l)
                        <input type="text" placeholder="Enter Name" class="input-field" name="employee_name" value="{{$l->Name}}" disabled>
                        @endforeach
                    </div>

                    <div class="input-field col s6">
                        <select id="leave_type" name="leave_type">
                            <option value = "" >Select Leave Type</option>
                            @foreach($leavetype as $l)
                            @foreach($leaverequest as $ll)
                            <option value="{{$l->id}}" {{ $ll->leave_type==$l->id ? ' selected="" ' : '' }} >{{$l->Name}}</option>
                            @endforeach
                            @endforeach
                        </select>
                        <label for="leave_type">Select Leave Type</label>
                        @error('status')
                        <div class="alert alert-danger red-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col s4">
                        <label for="">From Date</label>
                        @foreach($leaverequest as $l)
                        <input type="text" placeholder="From Date" class="datepicker input-field" id="from_date" name="from_date" value="{{$l->from_date}}">
                        @endforeach
                        @error('from_date')
                        <div class="alert alert-danger red-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col s4">
                        <label for="">End Date</label>
                        @foreach($leaverequest as $l)
                        <input type="text" placeholder="End Date" class="datepicker input-field" id="end_date" name="end_date" value="{{$l->end_date}}">
                        @endforeach
                        @error('end_date')
                        <div class="alert alert-danger red-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-field col s4">
                        <label style="margin-top: -23px;">Total Days</label><br>
                        @foreach($leaverequest as $l)
                        <input type="hidden" id="total_days" name="total_days" value="{{$l->total_days}}">
                        <span id="result" class="green-text result">{{$l->total_days}}</span>
                        @endforeach
                    </div>
                </div>

                <div class="row">
                    <div class="col s6">
                        <label for="remark">Remark</label>
                        @foreach($leaverequest as $l)
                        <input type="text" placeholder="Enter Remark" class="input-field" name="remark" value="{{$l->remark}}">
                        @endforeach
                    </div>


                </div>



                <div class="row">
                    <div class="col s12 display-flex justify-content-end form-action">
                        <button type="submit" name="action" class="btn btn-color mr-1">Update
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
<script>
                        $(document).ready(function () {
                            $('#end_date').on('change', function () {
                                var from_date = $('#from_date').val();
                                var end_date = $('#end_date').val();
                                $.ajax
                                        ({
                                            type: "get",
    url: "{{route('date_difference')}}",
        data: {
            from_date: from_date,
            end_date: end_date
                                            },
                    success: function (msg)
                        {
                        $('#result').text(msg);
                        $('#total_days').val(msg);
                            },
                                        });

                            });
                        $('.datepicker').datepicker({
                        format: 'yyyy-mm-dd'
                            });
                        });
</script>
@endsection
