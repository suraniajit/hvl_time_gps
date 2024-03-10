<?php

use Carbon\Carbon; ?>

<div class="card-panel">

    <h4 class="title-color"><span>Calendar View</span></h4>

    <div class="card">
        <div class="card-content">
            <div id="calendar">
                <!-- Modal Structure START for Leave Request-->
                <div id="leaverequest_modal" class="modal">
                    <div class="modal-content">
                        <div class="container">

                            <h4 class="title-color">Create Leave Request</h4>
                            <form action="{{route('hrms.leaverequest.store')}}" method="post">
                                @csrf
                                <input type="hidden" id="employee_id" name="employee_id">
                                <input type="hidden" id="department_lead_id" name="department_lead_id">
                                <input type="hidden" id="is_confirm" name="is_confirm">
                                <input type="hidden" id="emp_date" name="emp_date">
                                <input type="hidden" id="team_lead" name="team_lead">
                                <input type="hidden" id="request_create_date" name="request_create_date" value="<?php echo Carbon::today()->format('Y-m-d'); ?>">
                                <input type="hidden" id="hr" name="hr">
                                <div class="row">
                                    <div class="col s6">
                                        <label for="">Employee Name</label>
                                        <input type="text" placeholder="Enter Name" id="emp_name" class="input-field"
                                               name="emp_name" disabled>

                                    </div>

                                    <div class="input-field col s6">
                                        <select id="leave_type" name="leave_type">
                                            <option value="">Select Leave Type</option>

                                        </select>
                                        <label for="leave_type">Select Leave Type</label>
                                        @error('leave_type')
                                        <div class="alert alert-danger red-text">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col s4">
                                        <label for="">From Date</label>
                                        <input type="text" placeholder="From Date" class="input-field"
                                               id="from_date" name="from_date">
                                        @error('from_date')
                                        <div class="alert alert-danger red-text">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col s4">
                                        <label for="">End Date</label>
                                        <input type="text" placeholder="End Date" class=" input-field"
                                               id="end_date" name="end_date">
                                        @error('end_date')
                                        <div class="alert alert-danger red-text">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="input-field col s4">
                                        <input type="hidden" id="total_days" name="total_days">
                                        <label style="margin-top: -23px;">Total Days</label><br>
                                        <span id="result" class="green-text result"></span>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col s12">
                                        <label for="remark">Remark</label>
                                        <input type="text" placeholder="Enter Remark" class="input-field" name="remark">
                                        @error('remark')
                                        <div class="alert alert-danger red-text">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col s12 display-flex justify-content-end form-action">
                                        <button type="submit" class="btn btn-color mr-2">
                                            Create
                                        </button>
                                        <button type="reset"
                                                class="btn modal-close btn-color mb-1">Cancel
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal Structure END for Leave Request-->

                <!-- Modal Structure START-->
                <div id="modal1" class="modal">
                    <div class="modal-content">
                        <h4 id="modal_date"></h4>
                        <table>
                            <tbody>
                                <tr>
                                    <td>Check In Time</td>
                                    <td id="modal_checkin"></td>
                                    <td>Total Hours</td>
                                    <td id="modal_total_hours"></td>

                                </tr>
                                <tr>
                                    <td>Check Out Time</td>
                                    <td id="modal_checkout"></td>
                                    <td style="display: none" id="penalty_title">Penalty</td>
                                    <td id="penalty_amount"></td>
                                </tr>
                                <tr>


                                </tr>


                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button href="#!" class="modal-close white-text red btn-flat">Close</button>
                    </div>
                </div>
                <!-- Modal Structure END-->

                <div class="row">

                    <label style="margin: 13px;">
                        <input type="checkbox" id="sel"/>
                        <span>Select to add Leave Request</span>
                    </label>

                    <div class="col s12" style="margin-top: 13px;">
                        <div id="basic-calendar"></div>
                    </div>

                    <input type="hidden" value="{{$id}}" id="id">

                </div>
            </div>
        </div>
    </div>
</div>

