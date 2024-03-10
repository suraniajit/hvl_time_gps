<div class="table-responsive mt-4">
    <table id="page-length-option" class="table table-striped table-hover multiselect">
        <thead>
            <tr>
                <th class="sorting_disabled" width="5%">
                    <label>
                        <input type="checkbox" class="select-all m-1"/>
                        <span></span>
                    </label>
                </th>
                <th>ID</th>
                <th width="5%">Action</th>
                <th width="10%">Customer Name</th>
                <th width="10%">Subject</th>
                <th width="10%">Branch</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Frequency</th>
                <th>Remark</th>
                @can('Access Job Cards')
                <th>Job Update</th>
                @can('Create Job Cards')
                <th>Job Cards</th>
                @endcan
                @endcan
                @can('Access Audit Report')
                <th>Audit Update</th>
                <th>Send Audit</th>
                @can('Create Audit Report')
                <th>Audit Report</th>
                @endcan
                @endcan

            </tr>
        </thead>
        <tbody>
            @foreach($details as $key => $data)
            <tr>
                <td >
                    <label>
                        <input type="checkbox" data-id="{{ $data->id }}"
                               name="selected_row"/>
                        <span></span>
                    </label>
                </td>
                <td>{{$key+=1}}</td>
                <td>
                    @can('Read Activity')
                    <a href="{{ route('activity.show_activity', $data->id) }}"
                       class="tooltipped mr-10"
                       data-position="top"
                       data-tooltip="View">
                        <span class="fa fa-eye"></span>
                    </a>
                    @endcan
                    @can('Edit Activity')
                    <?php
                    $em_id = \Illuminate\Support\Facades\Auth::User()->id;
                    $emp = DB::table('employees')->where('user_id', '=', $em_id)->first();
                    ?>
                    @if($em_id == 1 or $em_id == 122)
                    <a href="{{ route('activity.edit_activity', $data->id) }}"
                       class="tooltipped mr-10"
                       data-position="top"
                       data-tooltip="Edit">
                        <span class="fa fa-edit"></span>
                    </a>
                    @elseif($data->activity_status != 'Completed')
                    <a href="{{ route('activity.edit_activity', $data->id) }}"
                       class="tooltipped mr-10"
                       data-position="top"
                       data-tooltip="Edit">
                        <span class="fa fa-edit"></span>
                    </a>
                    @endif
                    @endcan
                    @can('Delete Activity')
                    @if($data->activity_status != 'Completed')
                    <a href="" class="button" data-id="{{$data->id}}"><span class="fa fa-trash"></span></a>
                    @endif
                    @endcan
                </td>

                <td> {{$data->customer_id}} </td>
                <td> {{$data->subject}} </td>
                <td> {{$data->name}} </td>
                <td> {{$data->start_date}} </td>
                <td> {{$data->end_date}} </td>

                <td> {{ucfirst($data->activity_status)}} </td>
                <td>
                    {{$data->frequency == "daily" ? 'Daily' : ''}}
                    {{$data->frequency == "weekly" ? 'Weekly' : ''}}
                    {{$data->frequency == "weekly_twice" ? 'Weekly Twice' : ''}}
                    {{$data->frequency == "weekly_thrice" ? 'Weekly Thrice' : ''}}
                    {{$data->frequency == "monthly" ? 'Monthly' : ''}}
                    {{$data->frequency == "monthly_thrice" ? 'Monthly Thrice' : ''}}
                    {{$data->frequency == "fortnightly" ? 'Fortnightly' : ''}}
                    {{$data->frequency == "bimonthly" ? 'Bimonthly' : ''}}
                    {{$data->frequency == "quarterly" ? 'Quarterly' : ''}}
                    {{$data->frequency == "quarterly_twice" ? 'Quarterly twice' : ''}}
                    {{$data->frequency == "thrice_year" ? 'Thrice in a Year' : ''}}
                    {{$data->frequency == "onetime" ? 'One Time' : ''}}
                </td>
                <td>{{$data->remark}}</td>

                @can('Access Job Cards')
                <td>
                    @php
                    $date = \Illuminate\Support\Facades\DB::table('hvl_job_cards')
                    ->where('activity_id',$data->id)
                    ->orderBy('id','DESC')
                    ->paginate(1);
                    foreach ($date as $update)
                    {
                    echo $update->added;
                    }
                    @endphp
                </td>

                <td>
                    @can('Create Job Cards')
                    <button type="button" class="btn btn-primary rounded p-1" data-toggle="modal" data-target="#modal{{$data->id}}">
                        <span class="fa fa-upload"></span>Add Images
                    </button>
                    @endcan
                </td>
                @endcan
                @can('Access Audit Report')
                <td>
                    @php
                    $date = \Illuminate\Support\Facades\DB::table('hvl_audit_reports')
                    ->where('activity_id',$data->id)
                    ->orderBy('id','DESC')
                    ->paginate(1);
                    foreach ($date as $update)
                    {
                    echo $update->added;
                    }
                    @endphp
                </td>
                <td>
                    <a class="center" data-toggle="modal" data-target="#email_div{{$data->id}}">
                        <span class="fa fa-envelope fa-lg "></span>
                    </a>
                </td>
                <td>
                    <button type="button" class="btn btn-primary rounded p-1" data-toggle="modal" data-target="#modal_report{{$data->id}}">
                        <span class="fa fa-upload"></span>Audit Report
                    </button>
                </td>
                @endcan
            </tr>
            @endforeach
        </tbody>

    </table>
</div>

<!--/*models*/-->
<div class="modal fade" id="modal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
<!--/*models*/-->
<div class="modal fade" id="modal_report{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
<!--/*models*/-->
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