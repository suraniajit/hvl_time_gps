<script src="https://hherp.probsoltech.com/js/ajax/jquery.min.js"></script>

<div class="card-panel">
    <?php
    //echo Auth::id();
    if (isset($to_date)) {
        $expances_combination = DB::table('employees')
                ->select('employees.user_id as user_id', 'api_expenses.*')
                ->where('employees.manager_id', '=', Auth::id())
                ->where('api_expenses.is_save', '=', 1)
                ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
                ->groupBy('api_expenses.combination_name')
                ->whereBetween('api_expenses.combination_submit_date', [$to_date, $from_date])
                ->orderBy('api_expenses.date_search', 'desc')
                ->get();
    } else {
        $expances_combination = DB::table('employees')
                ->select('employees.user_id as user_id', 'api_expenses.*')
                ->where('employees.manager_id', '=', Auth::id())
                ->where('api_expenses.is_save', '=', 1)
                ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
                ->groupBy('api_expenses.combination_name')
                ->orderBy('api_expenses.date_search', 'desc')
                ->get();
    }
    ?>
    <div>
        <div class="table-responsive">
            <table id="page-length-option_expance" class="table table-striped table-hover multiselect">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Employee Name</th>
                        <th>Report Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($expances_combination as $key => $expances_details) {
                        $em_name_manager = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $expances_details->user_id, 'name');
                        $getCountValueFromTable = DB::table('api_expenses')->where('is_user', '=', $expances_details->user_id)->where('combination_name', '=', $expances_details->combination_name)->count();
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
                            echo $expances_details->combination_name;
                        } else {
                            echo $expances_details->combination_name;
                        }
                        ?>
                    </td>
                    <td>
                        <?php
//                        echo $expances_details->is_process;
                        if ($expances_details->is_process != 0 || $expances_details->is_process != 1) {
                            ?>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#moda_all_exp_manager{{$expances_details->id}}">
                                Report History
                            </button>
                        <?php } ?>

                        <!-- The Modal -->
                        <div class="modal fade" id="moda_all_exp_manager{{$expances_details->id}}">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">
                                            Manager : List of Expense
                                        </h4>
                                        <button type="button" class="close" onclick="closer(moda_all_exp_manager{{$expances_details->id}})">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table id="page-length-option_account" class="table table-striped table-hover multiselect">
                                                @include('user-profile.expance.manger._if_head_expance')
                                                <tbody>
                                                    <?php
                                                    $expances_comi = DB::table('employees')
                                                            ->select('employees.user_id as user_id', 'api_expenses.*')
                                                            ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
                                                            ->whereNotIn('is_process', [12])
                                                            //->whereNotIn('is_save', [3])
                                                            ->where('employees.manager_id', '=', Auth::id())
                                                            ->where('api_expenses.combination_name', '=', $expances_details->combination_name)
                                                            ->orderBy('api_expenses.date_search', 'desc')
                                                            ->get();

                                                    foreach ($expances_comi as $key => $expances_details_ifcondi) {
                                                        ?>

                                                        @include('user-profile.expance.manger._if_expance_details')
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" onclick="closer(moda_all_exp_manager{{$expances_details->id}})">Close</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-------------------------------------------------------->

                        <?php
                        $expances_comi_ = DB::table('employees')
                                ->select('employees.user_id as user_id', 'api_expenses.*')
                                ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
                                ->whereIn('is_process', [0])
                                ->where('employees.manager_id', '=', Auth::id())
                                ->where('api_expenses.combination_name', '=', $expances_details->combination_name)
                                ->orderBy('api_expenses.date_search', 'desc')
                                ->get();

                        if (count($expances_comi_) != 0) {
                            ?>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#moda_action_manager{{$expances_details->id}}">
                                Pending Action (<?php echo count($expances_comi_); ?>)
                            </button>
                        <?php } ?>

                        <!-- The Modal -->
                        <div class="modal" id="moda_action_manager{{$expances_details->id}}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="POST" enctype="multipart/form-data" id="formEditValidateManager" action="{{ route('expense.multi_updateByManager', $expances_details->id) }}" onsubmit="return(submitFrm());" >
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Manager Action</h4>
                                            <button type="button" class="close" onclick="closer(moda_action_manager{{$expances_details->id}})">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="table-responsive">
                                                <table id="page-length-option" class="table table-striped table-hover multiselect">
                                                    @include('user-profile.expance.manger._else_head_expance')
                                                    <tbody>
                                                        <?php
                                                        $expances_comi_update = DB::table('employees')
                                                                ->select('employees.user_id as user_id', 'api_expenses.*')
                                                                ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
                                                                ->whereNotIn('is_process', [12, 11])
                                                                ->whereNotIn('is_save', [3])
                                                                ->where('employees.manager_id', '=', Auth::id())
                                                                ->where('api_expenses.combination_name', '=', $expances_details->combination_name)
                                                                ->orderBy('api_expenses.date_search', 'desc')
                                                                ->get();

                                                        foreach ($expances_comi_update as $key => $expances_details) {
                                                            ?>

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

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button class="btn btn-danger mr-1" type="submit">Update Action</button>
                                            <!--<button type="button" class="btn btn-danger"  onclick="closer(moda_action_manager{{$expances_details->id}})">Close</button>-->
                                        </div>
                                    </form>
                                </div>
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


<script>
    $(document).ready(function () {
    $('#page-length-option_expance').DataTable({
    "scrollX": true
    });
    });
    function submitFrm() {
    $("#load").css({"visibility": ""});
    }

</script>
