{{-- layout --}}
@extends('app.layout')

{{-- page title --}}
@section('title','Expense Management')
@section('vendor-style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endsection
@section('content') 
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{route('expense')}}">Expense History Master</a></li>
        </ul>
    </div>
</div>
<section>
    <div class="card">
        <div class="card-body p-4">
            <header>
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="h3 display"> Expense History Master
                            <?php
//                            $total_exp_report = DB::table('api_expenses')
//                                    ->where('api_expenses.is_user', '=', $detaile->is_user)
//                                    ->where('api_expenses.is_save', '=', '1')
//                                    ->whereIn('is_process', [3])
//                                    ->whereIn('payment_status_id', [4])
//                                    ->groupBy('api_expenses.combination_name')
//                                    ->get();
//                            $total_report = DB::table('api_expenses')
//                                    ->where('api_expenses.is_user', '=', $detaile->is_user)
//                                    ->where('api_expenses.is_save', '=', '1')
//                                    ->whereIn('is_process', [3])
//                                    ->whereIn('payment_status_id', [4])
//                                    ->get();
//                                        echo ' (' . count($total_exp_report) . ')';
//                                        echo ' - (' . count($total_report) . ')';
                            ?>
                        </h2>
                    </div>
                    <div class="col-md-4" style="display: none;">
                        <a class="btn btn-primary rounded-pill pull-right mr-2 " data-toggle="modal" data-target="#modal_download" >
                            <span class="fa fa-download fa-lg"></span> Download
                        </a>
                    </div>
                </div>
            </header>

            @include('employee-master.expense.report.expense_histroy._from_step_1')
            @include('employee-master.expense.report.expense_histroy._filter')
            <div class="container-fluid">
                <div class="table-responsive">
                    <table id="page-length-option" class="table table-striped table-hover multiselect">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Employee Name</th>
                                <th>Total Claim Amount</th>
                                <th>Total Settlement Amount</th>
                                <th>Total Reject Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses_details as $key => $detaile)
                            <tr>
                                <td width="2%"> <center>{{$key+1}}</center> </td>
                        <td>
                            <u>
                                <strong>
                                    <a href="/report_history_details/{{$detaile->is_user}}"
                                       class="tooltipped mr-2"
                                       data-position="top"
                                       data-tooltip="view all Expense">
                                           <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $detaile->is_user, 'name'); ?>


                                    </a>
                                </strong>
                            </u>
                        </td>
                        <td>INR 
                            <?php
                            echo $claim_amount = DB::table('api_expenses')
                            ->where('api_expenses.is_user', '=', $detaile->is_user)
                            ->where('api_expenses.is_save', '=', '1')
                            ->whereIn('is_process', [3, 12])
                            ->whereIn('payment_status_id', [4])
                            ->sum('api_expenses.claim_amount');
                            ?>
                        </td>
                        <td>INR 
                            <?php
                            echo $settlement_amount = DB::table('api_expenses')
                            ->where('api_expenses.is_user', '=', $detaile->is_user)
                            ->where('api_expenses.is_save', '=', '1')
                            ->whereIn('is_process', [3, 12])
                            ->whereIn('payment_status_id', [4])
                            ->sum('api_expenses.settlement_amount');
                            ?>
                        </td>
                        <td>INR 
                            <?php
                            $purchases = DB::table('api_expenses')
                                    ->where('api_expenses.is_user', '=', $detaile->is_user)
                                    ->where('api_expenses.is_save', '=', '1')
                                    ->whereIn('is_process', [3, 12])
                                    ->whereIn('payment_status_id', [4])
                                    ->sum('api_expenses.reject_amount');

                            echo $purchases;
                            ?>
                        </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
    @include('employee-master.expense.report.expense_histroy._popup_donload_modle')
</section>
@endsection

{{-- page script --}}
@section('page-script')
<script>

function DownloadExcelFile() {
        var form = document.createElement("form");
        var branch = document.createElement("input"); 
        var customers_id = document.createElement("input"); 
        var search_start_date = document.createElement("input"); 
        var search_end_date = document.createElement("input");
        var search_status = document.createElement("input");
        var data_limit = document.createElement("input"); 
        var is_today = document.createElement("input");
        
        document.body.appendChild(form);
        form.method = "POST";
        form.action = "{{route('expense_history.report_history_download')}}";
            branch.name="branch";
            customers_id.name = "customers_id";
            search_start_date.name="search_start_date";
            search_end_date.name="search_end_date";
            data_limit.name="data_limit";
            is_today.name = "is_today";
            search_status.name="search_status";

            branch.value=$('#branch').val();
            customers_id.value = $('#customer_id').val();
            search_start_date.value=$('#s_date').val();
            search_end_date.value= $('#e_date').val();
            is_today.value = ($('#today_checkbox').prop('checked')==true)?1:0;
            data_limit.value = ($('#data_limit').prop('checked')==true)?1:0;
            search_status.value = $('#status_id').val();

            form.appendChild(branch); 
            form.appendChild(customers_id); 
            form.appendChild(search_start_date); 
            form.appendChild(search_end_date);
            form.appendChild(data_limit);
            form.appendChild(is_today);
            form.appendChild(search_status);
            form.submit();
    }


    $("#download_lead_button").click( function() {
        DownloadExcelFile();
    });
$(document).ready(function () {
   
    
    $('#page-length-option').DataTable({
        "scrollX": true
    });
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
});
</script>

@include('employee-master.expense.report.expense_histroy._popup_donload_modle_js')
@endsection


