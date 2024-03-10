<div class="modal fade bd-example-modal-lg " id="SignatureModal" tabindex="-1" role="dialog" style="z-index:2000" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Signature Pad</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="signature-pad" class="signature-pad">
                        <div class="signature-pad--body">
                        <canvas width="460" style="touch-action: none; user-select: none;" height="373"></canvas>
                        </div>
                        <div class="signature-pad--footer">
                        <div class="description">Sign above</div>
                        <div>
                                <a  href='javascript:;' class="btn btn-success" class=" clear" data-action="signature-pad-clear">Clear</a>
                                <a  href='javascript:;' class="btn btn-success" data-action="signature-pad-change-color">Change color</a>
                                <a  href='javascript:;' class="btn btn-success" data-action="signature-pad-change-width">Change width</a>
                                <a  href='javascript:;' class="btn btn-success" data-action="signature-pad-undo">Undo</a>
                            </div>
                            <div>
                                <a  href='javascript:;'  class="btn btn-success save" data-action="signature-pad-save-jpg">Upload</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
