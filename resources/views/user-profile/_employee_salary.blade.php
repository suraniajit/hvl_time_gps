<div class="card-panel">

    <div>
        <h4 class="title-color"><span>employee salary details</span></h4>
        <?php
        $GetAttendaceBonesDetails = DB::table('payroll_allowance')
                ->where('id', '=', 1)
                ->get();
        $to_date = $GetAttendaceBonesDetails[0]->start_effective_date;
        $from_date = $GetAttendaceBonesDetails[0]->end_effective_date;
        $displaySalaryEmp = app('App\Http\Controllers\payroll\PayrollController')->displaySalaryEmp(Session::get('user_id'));
        ?>
        @include('payroll._master')
    </div>
</div>


