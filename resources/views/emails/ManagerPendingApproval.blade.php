<!DOCTYPE html>
<html>
    <head>
        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #dddddd;
            }
        </style>
    </head>
    <body>
        Hello <?php echo $first_flowup['employee_name']; ?>, <br>
        <span style="margin-top: 5px;">
            <br>
            Please find below list of expense require action from your end.
        </span>
        <br>


        <table style="margin-top: 18px;">
            <tr>
                <th>Employee Name</th>
                <th>Report Name</th>
                <th>Report Submission Date</th>
                <th>Total Amount</th>
            </tr>
            <?php
            $pendding_list_ = DB::table('api_expenses')
                    ->select('api_expenses.spent_at',
                            'api_expenses.id',
                            'api_expenses.is_user',
                            'api_expenses.combination_name',
                            'api_expenses.combination_submit_date',
                             'api_expenses.def_claim_amount',
                    )
                    ->where('api_expenses.is_save', '=', 1)
                    ->whereIn('is_process', [0])
                    ->where('api_expenses.payment_status_id', '=', null)
                    ->whereIn('api_expenses.is_user', $manager_list_)
                    ->get();
            foreach ($pendding_list_ as $kry => $pendding) {
                ?>
                <tr>
                    <td><?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $pendding->is_user, 'Name'); ?></td>
                    <td><?php echo $pendding->combination_name; ?></td>
                    <td><?php echo $pendding->combination_submit_date; ?></td>
                    <td><?php echo 'INR ' . $pendding->def_claim_amount; ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <br>
        Thanks & Regards,<br>
        Account Team
    </body>
</html>

