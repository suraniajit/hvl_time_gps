<div class="modal fade" id="modal_report{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     @csrf
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Add Audit Report</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('activity.auditreport')}}" enctype="multipart/form-data">
                    <input type="hidden" name="activity_id" value="{{$data->id}}">
                    <div class="form-group col-sm-12 col-md-6">
                        <lable>Report File (only pdf and excel)</lable>
                        <input type="file" name="audit_report" id="audit_file" required class="form-control-file" accept=".pdf, .xls, .xlsx, .csv">
                        <p class="text-danger">Max File Size:<strong> 5MB</strong><br>Supported Format: <strong>.pdf, .xls, .xlsx, .csv</strong></p>
                        <br>
                        <input type="submit" class="btn btn-success rounded" value="Upload">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>