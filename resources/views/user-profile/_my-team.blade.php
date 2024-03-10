<style>
    .modal {
        display: none;
        position: fixed;
        left: 0;
        right: 0;
        background-color: #fafafa;
        padding: 0;
        max-height: 90%;
        width: 87%;
        height: 85%;
        margin: auto;
        overflow-y: auto;
        border-radius: 2px;
        will-change: top, opacity;
    }
</style>
<div class="card-panel">

    <h4 class="title-color"><span>My Team</span></h4>
    <?php
    $expances_hr = DB::table('employees')
            ->select('*')
            ->where('employees.manager_id', '=', Auth::id())
            ->orderBy('employees.manager_id', 'DESC')
            ->get();

    if (count($expances_hr) > 0) {
        ?>

        <div style="text-align:center;">
            <table class="display striped">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Employee Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expances_hr as $key=>$details_hr)
                    <tr>
                        <td width="2%">
                <center>{{$key+1}}</center>
                </td>
                <td>
                    <?php
                    echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $details_hr->user_id, 'name');
                    ?>
                </td>
                <td>
                    <?php if ($details_hr->employee_status == 0) { ?>
                        Active
                    <?php } else { ?>
                        Inactive
                    <?php } ?>
                </td>
                @endforeach
                </tbody>
            </table>
        </div>

    <?php } else { ?>

        <div class="row">
            <div class="col 12">
                <h6>Record not found</h6>
            </div>
        </div>
    <?php } ?>

</div>