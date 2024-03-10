<script src="https://hherp.probsoltech.com/js/ajax/jquery.min.js"></script>

<div class="card-panel">
    <?php
    $expances_combination = DB::table('employees')
            ->select('employees.user_id as user_id', 'api_expenses.*')
            ->where('employees.manager_id', '=', Auth::id())
            ->where('api_expenses.is_save', '=', 1)
            ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
            ->groupBy('api_expenses.combination_name')
            ->get();
    ?>
    <div>
        <h6 class="title-color"><span>Manager Expense Action</span></h6>
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
                foreach ($expances_combination as $key => $expances_details) {
                    $em_name_manager = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $expances_details->user_id, 'name');
                    $getCountValueFromTable = DB::table('api_expenses')->where('combination_name', '=', $expances_details->combination_name)->count();
                    ?>
                    <tr>
                        <td width="2%">
                <center>{{$key+1}}</center>
                </td>
                <td>
                    <?php echo $em_name_manager; ?>
                </td>  
                <td>
                    <?php
                    if (isset($expances_details->combination_name)) {
                        echo $expances_details->combination_name . ' (' . $getCountValueFromTable . ')';
                    } else {
                        echo 'default' . ' (' . $getCountValueFromTable . ')';
                    }
                    ?>
                </td>
                <td>
                    <a class="modal-trigger" href="#moda_all_exp_manager{{$expances_details->id}}" >
                        <i class="material-icons dp48">all_inclusive</i>
                    </a>
                    <div id="moda_all_exp_manager{{$expances_details->id}}" class="modal fade">
                        <br>
                        <div class="modal-content">
                            <h4>Manager : List of Expense <span style="font-size: 13px;color: blue;">[{{$expances_details->combination_name}}] #{{$em_name_manager}}</span>
                                <button class="btn close" data-dismiss="modal" aria-label="Close" style="float: right;" onclick="closer('moda_all_exp_manager{{$expances_details->id}}');" >
                                    <span aria-hidden="true">×</span>
                                </button>
                            </h4>

                            <div style="text-align:center;">

                                <table class="display striped">
                                    @include('user-profile.expance.manger._if_head_expance')
                                    <tbody>
                                        <?php
                                        $expances_comi = DB::table('employees')
                                                ->select('employees.user_id as user_id', 'api_expenses.*')
                                                ->where('api_expenses.combination_name', '=', $expances_details->combination_name)
                                                ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
                                                ->get();

                                        foreach ($expances_comi as $key => $expances_details) {
                                            ?>
                                            @include('user-profile.expance.manger._if_expance_details')
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>    
                    </div>


                    <a class="modal-trigger" href="#moda_action_manager{{$expances_details->id}}">
                        <span class="material-icons">call_to_action</span>
                    </a>
                    <div id="moda_action_manager{{$expances_details->id}}" class="modal">
                        <br>
                        <div class="modal-content">
                            <h4>Manager Action <span style="font-size: 13px;color: blue;"># {{$em_name_manager}}</span>
                                <button class="btn close" data-dismiss="modal" aria-label="Close" style="float: right;" onclick="closer('moda_action_manager{{$expances_details->id}}');" >
                                    <span aria-hidden="true">×</span>
                                </button>
                            </h4>
                            <form method="POST" enctype="multipart/form-data" id="formEditValidateManager" action="{{ route('expense.multi_updateByManager', $expances_details->id) }}" >
                                <div class="row">

                                    <div style="text-align:center;">

                                        <table class="display striped">
                                            @include('user-profile.expance.manger._else_head_expance')
                                            <tbody>
                                                <?php foreach ($expances_comi as $key => $expances_details) { ?>
                                                    <?php if (($expances_details->is_process == '1') || ($expances_details->is_process == '3') || ($expances_details->is_process == '5') || ($expances_details->is_process == '6')) { ?>
                                                    <?php } else { ?>
                                                    <input type="hidden" name="expances_ids[]" value="{{$expances_details->id}}">
                                                    @include('user-profile.expance.manger._else_expance_details')
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
