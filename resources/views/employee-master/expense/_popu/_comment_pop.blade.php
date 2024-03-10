<div class="modal" id="notehistory{{$detaile->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">
                    Commnucation Of Expance# : <?php echo $detaile->combination_name; ?>
                </h4>
                <button type="button" class="close" onclick="closer(notehistory{{$detaile->id}})">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="table-responsive"><table>
                        <tr>
                            <th>#ID</th>
                            <th>Action Taken by</th>
                            <th>Note Taken admin</th>
                            <th>Note Taken Manager</th>
                            <th>Create time</th>
                        </tr>
                        <?php
                        $expenses_action_log = DB::table('api_expenses_action_log')
                                        ->orderBy('api_expenses_action_log.id', 'desc')
                                        ->where('action_by_user_id', '=', $detaile->is_user)
                                        ->where('emp_id', '=', $detaile->id)->get();

                        if (count($expenses_action_log) > 0) {
                            foreach ($expenses_action_log as $key => $action_log) {
                                ?>
                                <tr>

                                    <td>{{$key+=1}}</td>
                                    <td>{{$action_log->action_by}}</td>
                                    <td>{{$action_log->note_by_admin}}</td>
                                    <td>{{$action_log->note_by_manager}}</td>
                                    <td>{{$action_log->created_at}}</td>
                                </tr>

                                <?php
                            }
                        }
                        ?>  

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>