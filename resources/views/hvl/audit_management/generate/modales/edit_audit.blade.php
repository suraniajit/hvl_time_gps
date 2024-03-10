<div class="modal fade bd-example-modal-xl" id="audit_general_entry_edit" tabindex="-1" role="dialog" aria-labelledby="audit_general_entryTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Update Entry</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="container-fluid">
                        <div class="row edit_time_gallery_list">
                       
                        </div>
                    </div>
                    <div class="form-group col-sm-6 col-md-12">
                        <label class="label pull-right" data-toggle="tooltip" title="Upload Image">
                            <img class="rounded" id="avatar" height="40px" src="{{asset('asset/img/upload_button.png')}}" alt="Image">
                            <input type="file" class="sr-only" id="edit_input" name="image" accept="image/*">
                        </label>
                    </div>
                    <div class="form-group col-sm-6 col-md-6">
                        
                        <input type="hidden" name="generat_detail" id="generat_detail_id" value="">
                        <label>Description<span class="text-danger">*</span></label>
                        <textarea name="schedule_notes" id="description_id" style="height: 47px;" class="form-control" data-error=".errorTxtScheduleTime"></textarea>
                        <div class="errorTxtScheduleNote text-danger"></div>
                    </div>
                    <div class="form-group col-sm-6 col-md-6">
                        <label>Observation<span class="text-danger">*</span></label>
                        <textarea name="schedule_notes" id="observation_id" style="height: 47px;" class="form-control" data-error=".errorTxtScheduleTime"></textarea>
                        <div class="errorTxtScheduleNote text-danger"></div>
                    </div>
                    <div class="form-group col-sm-6 col-md-6">
                        <label>Action Taken By Hvl<span class="text-danger">*</span></label>
                        <textarea name="schedule_notes" style="height: 47px;" id="risk_id" class="form-control" data-error=".errorTxtScheduleTime"></textarea>
                        <div class="errorTxtScheduleNote text-danger"></div>
                    </div>
                    <div class="form-group col-sm-6 col-md-6">
                        <label>Action Taken By Client<span class="text-danger">*</span></label>
                        <textarea name="schedule_notes" id="action_id" style="height: 47px;" class="form-control" data-error=".errorTxtScheduleTime"></textarea>
                        <div class="errorTxtScheduleNote text-danger"></div>
                    </div>
                    <div id="edit_form_data">
                    </div>
                </div>                  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input type="submit" id="update_audit_general" class="btn btn-primary" value="Update">
            </div>
        </div>
    </div>
</div>