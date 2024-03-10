<div class="modal fade bd-example-modal-xl" id="audit_general_entry" tabindex="-1" role="dialog" aria-labelledby="audit_general_entryTitle" aria-hidden="true">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Entry</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="container-fluid">
                        <div class="row add_time_gallery_list">
                        
                        </div>
                    </div>
                    <div class="form-group col-sm-6 col-md-12">
                        <label class="label pull-right" data-toggle="tooltip" title="Upload Image">
                            <img class="rounded" id="avatar" height="40px" src="{{asset('asset/img/upload_button.png')}}" alt="Image">
                            <input type="file" class="sr-only" id="add_input" name="image" accept="image/*">
                        </label>
                    </div>
                    
                    <div class="form-group col-sm-6 col-md-6">
                        <label>Description<span class="text-danger">*</span></label>
                        <textarea name="schedule_notes" id="description" style="height: 47px;" class="form-control" data-error=".errorTxtScheduleTime"></textarea>
                        <div class="errorTxtScheduleNote text-danger"></div>
                    </div>
                    <div class="form-group col-sm-6 col-md-6">
                        <label>Observation<span class="text-danger">*</span></label>
                        <textarea name="schedule_notes" id="observation" style="height: 47px;" class="form-control" data-error=".errorTxtScheduleTime"></textarea>
                        <div class="errorTxtScheduleNote text-danger"></div>
                    </div>
                    <div class="form-group col-sm-6 col-md-6">
                        <label>Action Taken By Hvl<span class="text-danger">*</span></label>
                        <textarea name="schedule_notes" style="height: 47px;" id="risk" class="form-control" data-error=".errorTxtScheduleTime"></textarea>
                        <div class="errorTxtScheduleNote text-danger"></div>
                    </div>
                    <div class="form-group col-sm-6 col-md-6">
                        <label>Action Taken By Client<span class="text-danger">*</span></label>
                        <textarea name="schedule_notes" id="action" style="height: 47px;" class="form-control" data-error=".errorTxtScheduleTime"></textarea>
                        <div class="errorTxtScheduleNote text-danger"></div>
                    </div>
                    <div id="add_form_data">
                            
                    </div>
                </div>
             </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input type="submit" id="save_audit_general" class="btn btn-primary" value="Save">
            </div>
        </div>
    </div>
</div>