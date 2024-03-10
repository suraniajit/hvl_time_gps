<div class="card-panel">
    <?php
    $account_expances = DB::table('employees')
            ->select('employees.user_id as user_id', 'api_expenses.*')
            ->where('employees.account_id', '=', Auth::id())
            ->where('api_expenses.is_save', '=', 1)
            ->whereNotIn('is_process', [2])
            ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
            ->groupBy('api_expenses.combination_name')
            ->get();
    ?>
    <div>

        <div style="text-align:center;">
            <div class="table-responsive">
                <table id="page-length-option_account" class="table table-striped table-hover multiselect">
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
                        foreach ($account_expances as $key => $account_detaile) {
                            $em_name_account = app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $account_detaile->user_id, 'name');
                            $getCountValueFromTable = DB::table('api_expenses')->where('is_user', '=', $account_detaile->user_id)->where('combination_name', '=', $account_detaile->combination_name)->count();
                            ?>
                            <tr>
                                <td width="2%"> <center>{{$key+1}}</center> </td>
                        <td><?php echo $em_name_account; ?></td>
                        <td>
                            <?php
                            // if (isset($account_detaile->combination_name)) {
                            //     echo $account_detaile->combination_name . ' (' . $getCountValueFromTable . ')';
                            // } else {
                            //     echo 'default' . ' (' . $getCountValueFromTable . ')';
                            // }
                            if (isset($account_detaile->combination_name)) {
                                echo $account_detaile->combination_name;
                            } else {
                                echo $account_detaile->combination_name;
                            }
                            ?>
                        </td>
                        <td>


<?php 

//0) expance create by emp 1) accepted from HR 2) Reject from HR 3) accepted from account 4) Reject from account 5) accepted from Admin 6) Reject from admin 

//echo $account_detaile->is_process;

                            if(($account_detaile->is_process!='1') || ($account_detaile->is_process=='3')||$account_detaile->is_process=='4'||$account_detaile->is_process=='5'){ ?>
                             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#moda_account_all_exp_account{{$account_detaile->id}}">
                               View
                            </button>
                            <?php }else if(($account_detaile->is_process==0)||($account_detaile->is_process==1)){ ?>
                      
                            <?php }else{ ?>
                           
                            <?php } ?>

                            <!-- The Modal -->
                            <div class="modal" id="moda_account_all_exp_account{{$account_detaile->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">
                                                Account : List of Expense 
                                            </h4>
                                            <button type="button" class="close" onclick="closer(moda_account_all_exp_account{{$account_detaile->id}})">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="table-responsive">
                                                <table id="page-length-option_account" class="table table-striped table-hover multiselect">


                                                    @include('user-profile.expance.account._if_head_account')
                                                    <tbody>
                                                        <?php
                                                        $expances_account_comi = DB::table('employees')
                                                                ->select('employees.user_id as user_id', 'api_expenses.*')
                                                                // ->where('api_expenses.is_process', '!=', 2)
                                                                  ->where('employees.account_id', '=', Auth::id())
                                                                ->where('api_expenses.combination_name', '=', $account_detaile->combination_name)
                                                                // ->whereNotIn('is_process', [3, 5])
                                                              
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

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" onclick="closer(moda_account_all_exp_account{{$account_detaile->id}})">Close</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                         <?php
                            $expances_account_comi_ = DB::table('employees')
                                    ->select('employees.user_id as user_id', 'api_expenses.*')
                                  
                                    ->where('api_expenses.combination_name', '=', $account_detaile->combination_name)
                                    ->whereIn('is_process', [0,1,3,11])
                                    ->where('employees.account_id', '=', Auth::id())
                                    ->join('api_expenses', 'api_expenses.is_user', '=', 'employees.user_id')
                                    ->get();
                            if (count($expances_account_comi_) == '0'  && $account_detaile->is_process!='5') {
                                if($account_detaile->is_process!='4'){
                                ?>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#moda_action_account{{$account_detaile->id}}">
                                  Action
                                </button>
                        <?php } }
                            
//                             echo '**'.$account_detaile->is_process;
                            if(($account_detaile->is_process=='2')||($account_detaile->is_process=='1')||($account_detaile->is_process=='11')){
                                ?>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#moda_action_account{{$account_detaile->id}}">
                                    Action 
                                </button>
                                <?php
                            }
                            ?>

                            <!-- The Modal -->
                            <div class="modal pop_" id="moda_action_account{{$account_detaile->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form method="POST" enctype="multipart/form-data" id="formEditValidateManager" action="{{ route('expense.multi_updateByAcount', $account_detaile->id) }}" >
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">
                                                    Account Action#
                                                </h4>
                                                <button type="button" class="close" onclick="closer(moda_action_account{{$account_detaile->id}})">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table id="page-length-option_account" class="table table-striped table-hover multiselect">
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

                                            <!-- Modal footer -->
                                            <div class="modal-footer">

                                                <button class="btn btn-danger mr-1" type="submit">Update Action</button>
                                                <button type="button" class="btn btn-danger" onclick="closer(moda_action_account{{$account_detaile->id}})">Close</button>
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
</div>




<script type="text/javascript">
    $(document).ready(function () {
        $('#page-length-option_account').DataTable({
            "scrollX": true
        });
    });
</script>
