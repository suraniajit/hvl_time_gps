<div class="modal fade" id="audit_general_gallery" tabindex="-1" role="dialog" aria-labelledby="audit_general_entryTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Gallery</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row gallery_list">
                        No Images Found
                        </div>
                    </div>
                    <input type="hidden" id="crop_image_path" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <label class="label" data-toggle="tooltip" title="Upload Image">
                        <img class="rounded" id="avatar" height="40px" src="{{asset('asset/img/upload_button.png')}}" alt="Image">
                        <input type="file" class="sr-only" id="input" name="image" accept="image/*">
                    </label>
                </div>
            </div>
        </div>
    </div>
    