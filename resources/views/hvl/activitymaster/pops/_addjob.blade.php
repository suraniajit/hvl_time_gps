<div class="modal fade" id="modal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     @csrf
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Add Job Cards</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('activity.addbefore_pic')}}" enctype="multipart/form-data">
                    <input type="hidden" name="activity_id" value="{{$data->id}}">
                    <div class="form-group col-sm-12 col-md-12">
                        <lable>Before Image</lable>
                        <input type="file" name="before_pic[]" id="before_file{{$data->id}}" accept=".jpg, .png, .jpeg" required class="form-control-file before_file" multiple>
                        <p class="text-danger">Max File Size:<strong> 3MB</strong><br>Supported Format: <strong>.jpg .png .jpeg</strong></p>
                    </div>
                    <br>
                    <div class="form-group col-sm-12 col-md-12">
                        <lable>After Image</lable>
                        <input type="file" name="after_pic[]" id="after_file{{$data->id}}" accept=".jpg, .png, .jpeg" class="form-control-file after_file" multiple>
                        <p class="text-danger">Max File Size:<strong> 3MB</strong><br>Supported Format: <strong>.jpg .png .jpeg</strong></p>
                    </div>
                    <div class="form-group col-sm-12 col-md-6">
                        <input type="submit" class="btn btn-success rounded" value="Upload">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
