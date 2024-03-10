<div class="card-panel">
    <?php
    $account_expances = DB::table('employees')
            ->select('employees.user_id as user_id', 'api_expenses.*')
            ->where('employees.account_id', '=', Auth::id())
            ->where('api_expenses.is_save', '=', 1)
            ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
            ->groupBy('api_expenses.combination_name')
            ->get();
    ?>
    <div>
        <h4 class="title-color"><span>Account Approve Action</span></h4>
        <div style="text-align:center;">
            <table class="display striped">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Employee Name</th>
                        <th>Combination of Expense</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($account_expances as $key => $account_detaile) {
                        $em_name_account = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $account_detaile->user_id, 'name');
                        $getCountValueFromTable = DB::table('api_expenses')->where('combination_name', '=', $account_detaile->combination_name)->count();
                        ?>
                        <tr>
                            <td width="2%"> <center>{{$key+1}}</center> </td>
                    <td><?php echo $em_name_account; ?></td>
                    <td>
                        <?php
                        if (isset($account_detaile->combination_name)) {
                            echo $account_detaile->combination_name . ' (' . $getCountValueFromTable . ')';
                        } else {
                            echo 'default' . ' (' . $getCountValueFromTable . ')';
                        }
                        ?>
                    </td>
                    <td>

                        <a class="modal-trigger" href="#moda_account_all_exp_account{{$account_detaile->id}}" >
                            <i class="material-icons dp48">all_inclusive</i>
                        </a>
                        <div id="moda_account_all_exp_account{{$account_detaile->id}}" class="modal fade">
                            <br>
                            <div class="modal-content "> 
                                <h4>Account : List of Expense<span style="font-size: 13px;color: blue;"> [{{$account_detaile->combination_name}}] #{{$em_name_account}}</span>
                                    <button class="btn close manager_close" data-dismiss="modal" aria-label="Close" style="float: right;" onclick="closer('moda_account_all_exp_account{{$account_detaile->id}}');" >
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </h4>
                                <div style="text-align:center;">
                                    <table class="display striped">


                                        @include('user-profile.expance.account._if_head_account')
                                        <tbody>
                                            <?php
                                            $expances_account_comi = DB::table('employees')
                                                    ->select('employees.user_id as user_id', 'api_expenses.*')
                                                    ->where('api_expenses.is_process', '!=', 2)
                                                    ->where('api_expenses.combination_name', '=', $account_detaile->combination_name)
                                                    ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
                                                    ->get();
                                            foreach ($expances_account_comi as $key => $account_detaile) {
                                                ?>
                                                @include('user-profile.expance.account._if_account_details')
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <a class="modal-trigger" href="#moda_action_account{{$account_detaile->id}}">
                            <span class="material-icons">call_to_action</span>
                        </a>
                        <div id="moda_action_account{{$account_detaile->id}}" class="modal">
                            <div class="modal-content">
                                <h4>Account Action <span style="font-size: 13px;color: blue;"># {{$em_name_account}}</span>
                                    <button class="btn close" data-dismiss="modal" aria-label="Close" style="float: right;" onclick="closer('moda_action_account{{$account_detaile->id}}');" >
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </h4>
                                <form method="POST" enctype="multipart/form-data" id="formEditValidateManager" action="{{ route('expense.multi_updateByAcount', $account_detaile->id) }}" >
                                    <div class="row">
                                        <div style="text-align:center;">
                                            <table class="display striped">
                                                @include('user-profile.expance.account._else_head_account')
                                                <tbody>
                                                    <?php foreach ($expances_account_comi as $key => $account_detaile) { ?>
                                                        <?php if (($account_detaile->is_process == '3') || ($account_detaile->is_process == '0') || ($account_detaile->is_process == '5') || ($account_detaile->is_process == '6')) { ?>
                                                        <?php } else { ?>
                                                        <input type="hidden" name="expances_ids[]" value="{{$account_detaile->id}}">
                                                        @include('user-profile.expance.account._else_account_details')
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <div class="col s12 display-flex justify-content-end form-action">
                                            <button class="btn btn-small indigo waves-light mr-1" type="submit">Update Action  
                                                <i class="material-icons right">save</i>
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>



                    </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
