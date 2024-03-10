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
            <li class="breadcrumb-item active"><a href="{{route('expense')}}">Expense </a></li>
        </ul>
    </div>
</div>
<section>

    <div class="card">
        <div class="card-body p-4">
            <header>
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="h3 display">  Expense History Master
                            <?php
                            if ($emp_id) {
                                echo ': <span style="color: #0091ea"> ' . app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $emp_id, 'name');
                            }
                            ?>
                            <?php
//                            $total_exp_report = DB::table('api_expenses')
//                                    ->where('api_expenses.is_user', '=', $emp_id)
//                                    ->where('api_expenses.is_save', '=', '1')
//                                    ->groupBy('api_expenses.combination_name')
//                                    ->get();
//                            $total_report = DB::table('api_expenses')
//                                    ->where('api_expenses.is_user', '=', $emp_id)
//                                    ->where('api_expenses.is_save', '=', '1')
//                                    ->get();
//                            echo ' || Total Group (' . count($total_exp_report) . ')';
//                            echo ' || Total Expance (' . count($total_report) . ')';
                            ?>

                        </h2>
                        <span>Report Name : <?php echo $report_name; ?></span>
                    </div>
                    <div class="col-md-4">
                        <a class="btn btn-primary rounded-pill pull-right mr-2 " data-toggle="modal" data-target="#modal_download">
                            <span class="fa fa-download fa-lg"></span> Download
                        </a>
                    </div>
                </div>
            </header>
            @include('employee-master.expense.report.expense_histroy.dashboard.dashboard_step_3')

            @include('employee-master.expense.report.expense_histroy._from_step_3')
            @include('employee-master.expense.report.expense_histroy._filter')
            <div class="table-responsive">
                <table id="page-length-option" class="table table-striped table-hover multiselect">
                    @include('employee-master.expense.report.expense_histroy._comman_head')
                    <tbody>
                        <?php foreach ($expenses_details as $key => $detaile) { ?>


                            <tr>

                                <td width="2%"> <center>{{$key+1}}</center> </td>
                        <td>
                            <?php echo $detaile->combination_name; ?>

                        </td>

                        <td><?php echo $detaile->date_search; ?></td>

                        <td width="10%">
                            <span class="task-cat green" style="color: green;font-weight: 500;">
                                INR <?php echo ($detaile->expense_type == 0) ? $detaile->total_amount_cash : $detaile->total_amount_mile; ?>
                            </span>
                        </td>
                        <td>
                            <span class="task-cat cyan" style="color: blue;font-weight: 500;"> 
                                INR <?php echo $detaile->settlement_amount; ?> 
                            </span>

                        </td>
                        <td width="10%">
                            <span class="task-cat red" style="color: red;font-weight: 500;">
                                INR 
                                <?php
                                if ($detaile->payment_status_id == 4) {
                                    $cliem_amount = ($detaile->expense_type == 0) ? $detaile->total_amount_cash : $detaile->total_amount_mile;
                                    echo ($cliem_amount - $detaile->settlement_amount);
                                } else {
                                    echo ($detaile->reject_amount);
                                }
                                ?>

                            </span>
                        </td>
                        <td>
                            <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('payment_status', 'id', $detaile->payment_status_id, 'name'); ?>
                        </td>
                        

                        <td>
                            <?php if ($detaile->is_process == 0) { ?>
                                -
                            <?php } else if ($detaile->is_process == 12) { ?>
                                Partially Approved from Account
                            <?php } else if ($detaile->is_process == 1) { ?>
                                Accept from Manager
                            <?php } else if ($detaile->is_process == 2) { ?>
                                Reject from Manager
                            <?php } else if ($detaile->is_process == 3) { ?>
                                Accepted from Account
                            <?php } else if ($detaile->is_process == 4) { ?>
                                Reject from Account
                            <?php } else if ($detaile->is_process == 5) { ?>
                                Accept from Admin
                            <?php } else if ($detaile->is_process == 6) { ?>
                                Reject from Admin
                            <?php } else { ?>
                                None
                            <?php } ?>
                            <?php
                            echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $detaile->action_by_user_id, 'name');
                            echo ' - (' . $detaile->account_action_date . ')';
                            ?>
                        </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('employee-master.expense.report.expense_histroy._popup_donload_modle')
</section>
@endsection

{{-- page script --}}
@section('page-script')

<script>
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



