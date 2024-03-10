<div class="table-responsive">
    <table id="page-length-option-combination" class="table table-striped table-hover multiselect">
        <thead>
            <tr>
                <th class="sorting_disabled" width="15%">Action</th>
                <th>#ID</th>
                <th>Report Name </th>
                <th>Total Claim Amount</th>
                <th>Total Settlement Amount</th>
                <th>Total Reject Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $expenses_details_combination = DB::table('employees')
                    ->select('employees.user_id as user_id', 'api_expenses.*')
                    ->where('api_expenses.is_user', '=', $emp_id)
                    ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
                    ->groupBy('api_expenses.combination_name')
                    ->get();
            foreach ($expenses_details_combination as $key => $details_combination) {
                ?>
                <tr>
                    <td width="15%">
                        <!--can('Read expense')-->

                        <a  href="{{ route('expense.view', $details_combination->id) }}"
                            class="tooltipped mr-2"
                            data-position="top"
                            data-tooltip="Edit">
                            <span class="fa fa-eye"></span>
                        </a>
                        <!--endcan-->
                    </td>
                    <td width="2%"> <center>{{$key+1}}</center> </td>

            <td>
                <?php
                if ($details_combination->is_save == '2') {
                    echo 'Drafted';
                } else {
                    echo $details_combination->combination_name;
                }
                ?>
            </td>
            <td>
                <span class="task-cat green" style="color: green;font-weight: 500;">
                    <?php
                    echo $details_combination->currency . ' ';
                    echo $claim_amount = DB::table('api_expenses')
                    ->where('api_expenses.is_user', '=', $details_combination->is_user)
                    ->where('api_expenses.is_save', '=', '1')
                    ->where('api_expenses.combination_name', '=', $details_combination->combination_name)
                    ->sum('api_expenses.claim_amount');
                    ?>
                </span>
            </td>
            <td>
                <span class="task-cat cyan" style="color: blue;font-weight: 500;"> 
                    <?php
                    echo $details_combination->currency . ' ';
                    echo $settlement_amount = DB::table('api_expenses')
                    ->where('api_expenses.is_user', '=', $details_combination->is_user)
                    ->where('api_expenses.is_save', '=', '1')
                    ->where('api_expenses.combination_name', '=', $details_combination->combination_name)
                    ->sum('api_expenses.settlement_amount');
                    ?>
                </span>
            </td>
            <td>
                <span class="task-cat red" style="color: red;font-weight: 500;">
                    <?php
                    // echo $details_combination->currency . ' '.($claim_amount-$settlement_amount);
                    echo $details_combination->currency . ' ';
                    echo $reject_amount = DB::table('api_expenses')
                    ->where('api_expenses.is_user', '=', $details_combination->is_user)
                    ->where('api_expenses.is_save', '=', '1')
                    ->where('api_expenses.combination_name', '=', $details_combination->combination_name)
                    ->sum('api_expenses.reject_amount');
                    ?>
                </span>
            </td>

            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>


<script>
    $(document).ready(function () {
        $('#page-length-option-combination').DataTable({
            "scrollX": true
        });
    });
</script>