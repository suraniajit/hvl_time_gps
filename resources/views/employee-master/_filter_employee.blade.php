<div class="card">
    <div class="card-content">

        <!--<ul class="collapsible">
            <li>
                <div class="collapsible-header"><i class="material-icons">filter_drama</i>Filters</div>
                <div class="collapsible-body">-->

        <form id="formValidateEmployee" action="{{route('emp.index')}}" method="get" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row">
                <div class="input-field col s6 m3 l3">
                    <select name="ddl_account" id="ddl_account">
                        <option value="0">Acounts </option>
                        @foreach($employeesDetails as $employees_acounts)
                        <option value="{{$employees_acounts->user_id}}" <?php echo (!empty($_GET['ddl_account'])) ? $_GET['ddl_account'] == $employees_acounts->user_id ? 'selected' : '' : "" ?> > {{$employees_acounts->name}}</option>
                        @endforeach
                    </select>
                    <label>Accounts </label>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select name="ddl_manager" id="ddl_manager">
                        <option value="0">Managers</option>
                        @foreach($employeesDetails as $employees_managers)
                        <option value="{{$employees_managers->user_id}}" <?php echo (!empty($_GET['ddl_manager'])) ? $_GET['ddl_manager'] == $employees_managers->user_id ? 'selected' : '' : "" ?> > {{$employees_managers->name}}</option>
                        @endforeach
                    </select>
                    <label>Managers</label>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select name="ddl_emp" id="ddl_emp">
                        <option value="0">Employees </option>
                        @foreach($employeesDetails as $employees)
                        <option value="{{$employees->user_id}}" <?php echo (!empty($_GET['ddl_emp'])) ? $_GET['ddl_emp'] == $employees->user_id ? 'selected' : '' : "" ?> > {{$employees->name}}</option>
                        @endforeach
                    </select>
                    <label>Employees </label>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select name="ddl_team" id="ddl_team">
                        <option value="0">Teams</option>
                        @foreach($teams_master as $team)
                        <option value="{{$team->id}}" <?php echo (!empty($_GET['ddl_team'])) ? $_GET['ddl_team'] == $team->id ? 'selected' : '' : "" ?> >{{$team->name}}</option>
                        @endforeach
                    </select>
                    <label>Team </label>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select name="ddl_department" id="ddl_department">
                        <option value="0">Departments</option>
                        @foreach($departments_master as $department)
                        <option value="{{$department->id}}" <?php echo (!empty($_GET['ddl_department'])) ? $_GET['ddl_department'] == $department->id ? 'selected' : '' : "" ?>>{{$department->name}}</option>
                        @endforeach
                    </select>
                    <label>Department </label>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select name="ddl_designation" id="ddl_designation">
                        <option value="0" >Designation</option>
                        @foreach($designations_master as $designation)
                        <option value="{{$designation->id}}"  <?php echo (!empty($_GET['ddl_designation'])) ? $_GET['ddl_designation'] == $designation->id ? 'selected' : '' : "" ?>>{{$designation->name}}</option>
                        @endforeach
                    </select>
                    <label>Designation </label>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select name="ddl_shift" id="ddl_shift">
                        <option value="0" >Shift</option>
                        @foreach($shifts_master as $shift)
                        <option value="{{$shift->id}}" <?php echo (!empty($_GET['ddl_shift'])) ? $_GET['ddl_shift'] == $shift->id ? 'selected' : '' : "" ?>>{{$shift->id}}- {{$shift->name}}</option>
                        @endforeach
                    </select>
                    <label>Shift</label>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select name="ddl_recruiter" id="ddl_recruiter">
                        <option value="0" >Recruiters</option>
                        @foreach($recruiters_master as $recruiter)
                        <option value="{{$recruiter->id}}" <?php echo (!empty($_GET['ddl_recruiter'])) ? $_GET['ddl_recruiter'] == $recruiter->id ? 'selected' : '' : "" ?> >{{$recruiter->name}}</option>
                        @endforeach
                    </select>
                    <label>Recruiters </label>
                </div>
                <div class="input-field col s6 m3 l3">
                    <select class="select" name="ddl_salary_type" id="ddl_salary_type">
                        <option value="0" >Salary Type</option>
                        @foreach($salaryTypeDetails as $salaryType)
                        <option value="{{$salaryType->id}}" <?php echo (!empty($_GET['ddl_salary_type'])) ? $_GET['ddl_salary_type'] == $salaryType->id ? 'selected' : '' : "" ?>>{{$salaryType->name}}</option>
                        @endforeach
                    </select>
                    <label>Salary Type</label>
                </div>

                <div class="input-field col s6 m3 l3"> 
                    <select name="ddl_employee_status" id="ddl_employee_status">
                        <option value="0">Employee Status</option>
                        <option value="0" <?php echo (!empty($_GET['ddl_employee_status'])) ? $_GET['ddl_employee_status'] == 0 ? 'selected' : '' : "" ?> >Active</option>
                        <option value="1" <?php echo (!empty($_GET['ddl_employee_status'])) ? $_GET['ddl_employee_status'] == 1 ? 'selected' : '' : "" ?> >Inactive</option>
                    </select>
                    <label>Employee Status </label>
                </div>
                <div class="input-field col s6 m3 l3"> 
                    <select name="ddl_date_filter" id="ddl_date_filter" class="ddl_filter" onchange="ddl_filter();">
                        <option value="0" selected="">Select of</option>
                        <option value="dob" <?php echo (!empty($_GET['ddl_date_filter'])) ? $_GET['ddl_date_filter'] == 'dob' ? 'selected' : '' : "" ?> >Date of birth</option>
                        <option value="date_of_appointment" <?php echo (!empty($_GET['ddl_date_filter'])) ? $_GET['ddl_date_filter'] == 'date_of_appointment' ? 'selected' : '' : "" ?> >Date of Appointment</option>
                        <option value="date_of_increment" <?php echo (!empty($_GET['ddl_date_filter'])) ? $_GET['ddl_date_filter'] == 'date_of_increment' ? 'selected' : '' : "" ?> >Date of Increment</option>
                    </select>
                    <label>Select of</label>
                </div>
                <div class="filter" style="display: none;">
                    <div class="input-field col s6 m3 l3"> 
                        <label>To Date</label>
                        <input type="text" class="date" name="to_date" placeholder="To Date" value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : '' ?>">
                    </div>
                    <div class="input-field col s6 m3 l3"> 
                        <label>From Date</label>
                        <input type="text" class="date" name="from_date" placeholder="From Date" value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : '' ?>">
                    </div> 
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <div class="display-flex justify-content-end form-action">
                        <button type="submit" class="btn btn-small waves-light mr-1">
                            Search
                        </button>
                        <a href="/emp/"class="btn btn-small waves-light mr-1" >
                            Reset
                        </a>
                    </div> 
                </div>
            </div>
        </form>
        <!--        </div>
            </li>
        </ul>-->
    </div>
</div> 