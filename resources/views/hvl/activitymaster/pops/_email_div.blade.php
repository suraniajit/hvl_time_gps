<div id="email_div{{$data->id}}" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Send Mail</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body p-4 row">
                <div class="col-sm-12">
                    <form action="{{ route('mail.sendaudit') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="customer" value="{{$data->customer_id}}">
                        <input type="hidden" name="act_id" value="{{$data->id}}">
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="">To</label>
                                <input type="email" class="form-control" name="to" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="">Subject</label>
                                <input type="text" class="form-control" name="subject" value="" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-12">
                                <label for="">Body</label>
                                <textarea class="form-control" name="body">Start Date : {{$data->start_date}} End Date : {{$data->end_date}}     Customer : {{$data->customer_id}}
                                </textarea>
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
