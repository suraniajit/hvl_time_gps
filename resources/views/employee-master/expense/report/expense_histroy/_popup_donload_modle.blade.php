<div id="modal_download" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Download Report</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body p-4 row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body text-center ">
                            <!--                            <button class="btn btn-success " id="download_lead_button">
                                                            <span class="fa fa-file-excel-o fa-3x text-green"></span>
                                                            CSV
                                                        </button>-->
                            <button class="btn btn-success " onclick="exportTableToCSV('Report.csv')">
                                <span class="fa fa-file-excel-o fa-3x text-green"></span>
                                CSV
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body text-center ">
                            <button class="btn btn-success " onclick="exportTableToPDF()">
                                <span class="fa fa-file-pdf-o fa-3x text-green"></span>
                                PDF
                            </button>
                        </div>
                    </div>
                </div>

                <!--/**/-->
                <div class="col-sm-6" style="display: none;">
                    <div class="card">
                        <div class="card-body text-center">
                            <button class="btn btn-primary center" data-toggle="modal" data-target="#email_div">
                                <span class="fa fa-envelope fa-3x text-danger"></span>
                                Email
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="email_div" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Send Mail</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body p-4 row">
                <div class="col-sm-12">
                    <form action="{{ route('mail.sendcsv') }}" method="post" id="mail_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="">To</label>
                                <input type="email" class="form-control"  name="to" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="">CC</label>
                                <input type="email" class="form-control"  name="cc">
                            </div>

                            <div class="form-group col-sm-12 col-md-6">
                                <label for="">BCC</label>
                                <input type="email" class="form-control"  name="bcc">
                            </div>

                            <div class="form-group col-sm-12 col-md-6">
                                <label for="">Subject</label>
                                <input type="text"  class="form-control"  name="subject" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="">Body</label>
                                <textarea class="form-control" name="body"></textarea>
                            </div>

                            <div class="col-sm-12">

                                <input type="submit" class="btn btn-success rounded" value="Send">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>