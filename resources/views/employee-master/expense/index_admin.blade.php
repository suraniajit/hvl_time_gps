@include('employee-master.expense.admin_filter.dashboard.master_dashboard')
<div class="container-fluid">
    <div class="table-responsive">
        <table id="page-length-option_admin_main" class="table table-striped table-hover multiselect">
            <thead>
                <tr>

                    <th class="sorting_disabled" width="10%">Action</th>
                    <th>#ID</th>
                    <th>Emp. Name</th>
                    <th>Total Claim Amount</th>
                    <th>Total Settlement Amount</th>
                    <th>Total Reject Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses_details as $key => $detaile)
                <tr>

                    <td width="10%">
                        @can('Delete expense')
                        <a href="#"
                           class="tooltipped mr-2 delete-record-click"
                           data-position="top"
                           data-tooltip="Delete" data-id="{{$detaile->id}}">
                            <span class="fa fa-trash"></span>
                        </a>
                        @endcan
                        <a  href="/expense/index/{{$detaile->is_user}}"
                            class="tooltipped mr-2"
                            data-position="top"
                            data-tooltip="view all Expense">
                            <span class="fa fa-eye"></span>
                        </a>
                    </td>
                    <td width="2%"> <center>{{$key+1}}</center> </td>
            <td>
                <u>
                    <strong>
                        <a href="/expense/index/{{$detaile->is_user}}"
                           class="tooltipped mr-2"
                           data-position="top"
                           data-tooltip="view all Expense">
                               <?php echo  app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $detaile->is_user, 'name'); ?>
                        </a>
                    </strong>
                </u>
            </td>
            <td>
                <?php
                echo $detaile->currency . ' ';
                echo $claim_amount = DB::table('api_expenses')
                ->where('api_expenses.is_user', '=', $detaile->is_user)
                ->where('api_expenses.is_save', '=', '1')
                ->sum('api_expenses.claim_amount');
                ?>
            </td>
            <td>
                <?php
                echo $detaile->currency . ' ';
                echo $settlement_amount = DB::table('api_expenses')
                ->where('api_expenses.is_user', '=', $detaile->is_user)
                ->where('api_expenses.is_save', '=', '1')
                ->sum('api_expenses.settlement_amount');
                ?>
            </td>
            <td>
                <?php
                echo $detaile->currency . ' ';
                // echo ($claim_amount - $settlement_amount);
                                echo $purchases = DB::table('api_expenses')
                                ->where('api_expenses.is_user', '=', $detaile->is_user)
                                ->where('api_expenses.is_save', '=', '1')
                                ->sum('api_expenses.reject_amount');
                ?>
            </td>
            <td>
                <?php if ($detaile->is_active == 0) { ?>
                    Active
                <?php } else if ($detaile->is_active == 1) { ?>
                    inactive
                <?php } ?>
            </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>

<script>
    $(document).ready(function () {
        $('#page-length-option_admin_main').DataTable({
            "scrollX": true
        });
    });
</script>

