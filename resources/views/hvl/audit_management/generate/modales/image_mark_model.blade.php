<div class="modal fade bd-example-modal-lg " id="image_mark_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Mark Pad</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <input type="hidden" value="" id="temp_id">
                    <div id="image-pad" class="signature-pad">
                        <div class="signature-pad--body">
                        <canvas width="460" id="canvas_id" style="touch-action: none; user-select: none;" height="373"></canvas>
                        </div>
                        <div class="signature-pad--footer">
                        <div class="description">Mark above</div>
                            <div>
                                <a  href='javascript:;' class="btn btn-success" class=" clear" data-action="clear">Clear</a>
                                <a  href='javascript:;' class="btn btn-success" data-action="change-color">Change color</a>
                                <a  href='javascript:;' class="btn btn-success" data-action="change-width">Change width</a>
                                <a  href='javascript:;' class="btn btn-success" data-action="undo">Undo</a>
                            </div>
                            <div>
                                <a  href='javascript:;'  class="btn btn-success save" data-action="save-jpg">Upload</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
