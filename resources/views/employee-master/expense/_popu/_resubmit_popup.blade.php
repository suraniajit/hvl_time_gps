<div class="modal resubmited_popu" id="resubmited_popu{{$details_normal->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">
                    History Of Resubmit Expense# : <?php echo $details_normal->combination_name; ?>
                </h4>
                <button type="button" class="close" onclick="closer(resubmited_popu{{$details_normal->id}})">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="table-responsive"><table>
                        <tr>
                            <th>#ID</th>
                            <th>Process stage</th>
                            <th>Re-Claim Amount</th>
                            <th>Settlement Amount</th>
                            <th>Reject Amount</th>
                            <th>Note</th>
                            <th>Create time</th>
                        </tr>

                        <?php
                        $resubmit_popup = DB::table('api_expenses_resubmit')
                                        ->orderBy('api_expenses_resubmit.id', 'desc')
                                        ->where('is_user', '=', $details_normal->is_user)
                                        ->where('expance_id', '=', $details_normal->id)->get();

                        if (count($resubmit_popup) > 0) {
                            foreach ($resubmit_popup as $key => $resubmitdata) {
                                ?>
                                @include('employee-master.expense.__resubmit_popup')

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