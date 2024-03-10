@extends('app.layout')

{{-- page title --}}
@section('title','Zone To Customer Management | HVL')

@section('vendor-style')

@endsection
@section('content')
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{route('branch-customer')}}">Zone wise Customers </a></li>
            <li class="breadcrumb-item ">Add Zone wise Customers </li>
        </ul>
    </div>
</div>
<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-4">
                <header>
                    <div class="row">
                        <div class="col-md-7">
                            <h2 class="h3 display"> Add Zone wise Customers</h2>
                        </div>
                    </div>

                </header>
                <form action="{{route('branch-customer.store')}}" method="post" id="" enctype="multipart/form-data">

                    {{csrf_field()}}
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-3" style="margin-bottom: 1px;">
                            <label>Zone <span class="text-danger">*</span> </label>
                            <select name="zone_id" id="zone" class="form-control"  required data-error=".errorTx3" autocomplete="off" autofocus="off">
                                <option disabled="" selected="">Select Zone</option>
                                @if(!empty($branchs))
                                @foreach($branchs as $details)
                                <option value="{{$details->id}}">{{$details->Name}}</option>
                                @endforeach
                                @endif
                            </select>
                            <div class="errorTxt3"></div>
                        </div>

                        <div class="form-group col-sm-6 col-md-3" style="margin-bottom: 1px;">
                            <label>Branch <span class="text-danger">*</span> </label>
                            <select name="branch_id[]" id="branch_id" class="form-control select " multiple  required data-error=".errorTxt1" autocomplete="off" autofocus="off">

                            </select>
                            <a id="get_cust" class="btn btn-primary rounded" style="margin-left: 60px;
                               margin-top: 11px;">Get Customer</a>
                            <div class="errorTxt1"></div>
                        </div>

                        <div class="form-group col-sm-6 col-md-3 customer_div" style="margin-bottom: 1px;">
                            <label>Customer <span class="text-danger">*</span> </label>
                            <select name="customer_id[]" id="cust_id" class="form-control select " multiple  required data-error=".errorTxt24" autocomplete="off" autofocus="off">

                            </select>
                            <div class="errorTxt24"></div>
                        </div>

                        <div class="form-group col-sm-6 col-md-3 emp_div" style="margin-bottom: 1px;">

                            <label>Employee <span class="text-danger">*</span></label>
                            <select name="employee_id[]" id="employee_id" class="form-control" multiple required data-error=".errorTxt25" autocomplete="off" autofocus="off">
                                @if(empty($employee_id))
                                @foreach($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->Name}}</option>
                                @endforeach
                                @endif
                            </select>
                            <div class="errorTxt25"></div>
                        </div>


                    </div>
                    <div class="row mt-4 pull-right">
                        <div class="col-sm-12 ">
                            <button class="btn btn-primary mr-2" type="submit" name="action">
                                <i class="fa fa-save"></i>
                                Save
                            </button>
                            <button type="reset" class="btn btn-secondary  mb-1">
                                <i class="fa fa-arrow-circle-left"></i>
                                <a href="{{url()->previous()}}" class="text-white">Cancel</a>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('page-script')
<script type="text/javascript">
    $(document).ready(function () {

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
        $('#employee_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            maxHeight: 450,
            buttonWidth: 250,
        });
        var categCheck = $('.select').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            maxHeight: 450,
            buttonWidth: 250,
        });
        var branchCheck = $('#branch_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            maxHeight: 450,
            buttonWidth: 250,
        });

        $('.customer_div').hide();
        $('.emp_div').hide();

        $('#zone').change(function () {
            var eid = $(this).val();
            if (eid == '') {
                alert('Please Select Branch.!');
                return false;
            }
            if (eid) {
                $.ajax({
                    type: "get",
                    url: "/branch-customer/getbranch",
                    data: {
                        eid: eid
                    },
                    success: function (res)
                    {
                        if (res)
                        {
                            $("#branch_id").empty();
                            $.each(res, function (key, value) {
                                var opt = $('<option />', {
                                    value: value.id,
                                    text: value.Name
                                });
                                opt.appendTo(branchCheck);
                                branchCheck.multiselect('rebuild');
                            });
                        }
                    }
                });
            }
        });


        $('#get_cust').click(function () {
            $('.customer_div').show();
            $('.emp_div').show();
            var eids = $('#branch_id').val();
            if (eids == '') {
                alert('Please Select Branch.!');
                return false;
            }
            if (eids) {
                $.ajax({
                    type: "post",
                    url: "/branch-customer/getbranchcustomer",
                    data: {
                        eids: eids
                    },
                    success: function (res)
                    {
                        if (res)
                        {
//                            console.log(res);
                            $("#cust_id").empty();
                            for (var i = 0; i < res.length; i++)
                            {
                                $.each(res[i], function (key, value) {
                                    var opt = $('<option />', {
                                        value: value.id,
                                        text: value.customer_name
                                    });
                                    opt.appendTo(categCheck);
                                    categCheck.multiselect('rebuild');
                                });
                            }
                        }
                    }
                });
            }
        });
    });


</script>
@endsection
