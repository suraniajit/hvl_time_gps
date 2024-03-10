<div class="card">
    <div class="card-content">
        <div class="row">
            <div class="col s12 m6 l6">
                <h5 class="title-color"><span>Activity List</span></h5>
            </div>
            <?php $customer_id = \Request::segment(4); ?>
            <div class="col s12 m6 l6 right-align-md">
                <ul class="breadcrumbs mb-0">
                    <li class="breadcrumb-item">
                        <a class="btn mb-1 mr-1 waves-light cyan modal-trigger" href="#download_modal">
                            <i class="material-icons left">get_app</i>
                            Download
                        </a>
                        <a href="{{ route('recruitment.candidate.create_activity')}}?id={{$customer_id}}" class="btn mb-1 mr-1 waves-light cyan modal-trigger">
                            Add Activity  
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="section section-data-tables">
            <?php
           echo $to = '2021-03-01';
           echo $from = '2021-05-01';
            $results = App\Http\Controllers\recruitment\CandidateController::getCustomerDetails($table_data->id, $to, $from);
             ?>
            <table id="page-length-option" class="display multiselect">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Activity</th>
                        <th>Employee</th>
                        <th>Frequency</th>
                        <th>flag</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $key => $data) { ?>
                        <tr>
                            <th>{{$key+=1}}</th>
                            <th> {{$data->start_date}} </th>
                            <th> {{$data->end_date}} </th>
                            <th> {{$data->type}}
                                <?php
                                if ($data->type == '') {
                                    echo 'Not Selected';
                                }
                                ?>
                            </th>
                            <th> {{ucfirst($data->status)}} </th>
                            <th> {{$data->comment}} </th>
                            <th> 
                                <?php
                                $getEmpDetailsbyUser_id = DB::table('employees')->select('Name')->where('user_id', $data->user_id)->get();
                                if (count($getEmpDetailsbyUser_id) > 0) {
                                    echo ucfirst($getEmpDetailsbyUser_id[0]->Name);
                                } else {
                                    echo 'Emp deleted';
                                }
                                ?>
                            </th>
                            <th> {{ucfirst($data->frequency)}} </th>
                            <th> {{ucfirst($data->flag)}} </th>
                            <th>
                                <a href="#" class="tooltipped delete-record-click" data-position="top" data-tooltip="Delete" data-id="{{ $data->id }}">
                                    <span class="material-icons">delete</span>
                                </a>
                                <a href="{{ route('recruitment.candidate.edit_activity', $data->id) }}"
                                   class="tooltipped mr-10"
                                   data-position="top"
                                   data-tooltip="View">
                                    <span class="material-icons">edit</span>
                                </a>
                            </th>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="download_modal" class="modal" style="width: 25%">
    <div class="modal-content">
        <h5>Download</h5>
        <p>Choose report download format</p>
        <div class="row center">
            <div class="col s6">
                <button class="white" onclick="exportTableToCSV('members.csv')">
                    <div class="card box-shadow-none">
                        <div class="card-content">
                            <div class="center">
                                <span class="material-icons cyan-text" style="font-size: 50px">description</span>
                            </div>
                        </div>
                        <div class="center">
                            <div class="black-text">
                                CSV
                            </div>
                        </div>
                    </div>
                </button>
            </div>
            <div class="col s6">
                <button class="white" onclick="exportTableToPDF()">
                    <div class="card box-shadow-none">
                        <div class="card-content">
                            <div class="center">
                                <span class="material-icons  cyan-text"
                                      style="font-size: 50px">picture_as_pdf</span>
                            </div>
                        </div>
                        <div class="center">
                            <div class="black-text">
                                PDF
                            </div>
                        </div>
                    </div>
                </button>
            </div>
        </div>
        <div class="row" id="email_div" hidden>
            <div class="col s12">
                <div class="mt-10">
                    <h5>Send Mail</h5>
                    <form action="{{ route('mail.sendcsv') }}" method="post" id="mail_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="input-field col s12 mt-2 mb-2">
                                <label for="">To</label>
                                <input type="email" name="to" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 mt-2 mb-2">
                                <label for="">CC</label>
                                <input type="email" name="cc">
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 mt-2 mb-2">
                                <label for="">BCC</label>
                                <input type="email" name="bcc">
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 mt-2 mb-2">
                                <label for="">Subject</label>
                                <input type="text" name="subject" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 mt-2 mb-2">
                                <label for="">Body</label>
                                <textarea class="materialize-textarea" name="body"></textarea>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 mt-0 mb-0">
                                    <button class="btn cyan  waves-light right" type="submit">
                                        Send
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
