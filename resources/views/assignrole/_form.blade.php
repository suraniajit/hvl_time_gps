<div class="col s12">
    <div class="row">
        <p>Select Roles</p>
        <div class="input-field col s12">
            <select class="select2 browser-default" multiple="multiple" name="roles[]">
                <optgroup label="Roles">
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
        <p>Assign roles to</p>
        <div class="input-field col s12">
            <select class="select2 browser-default" name="assign_to" id="assign_to">
                <option disabled selected>Select</option>
                <option value="employees">Employees</option>
                <option value="department">Department</option>
                <option value="team">Team</option>
                <option value="designation">Designation</option>
            </select>
        </div>
        <div class="input-field col s12" id="employees" style="display: none">
            <select class="select2 browser-default" multiple="multiple" name="employees[]" id="employees_select">
                <optgroup label="Employees">
                    @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->Name }}</option>
                    @endforeach
                </optgroup>
            </select>
            <span>Select Employees</span>
        </div>
        <div class="input-field col s12" id="department" style="display: none">
            <select class="select2 browser-default" name="department" id="department_select" tabindex="-1">
                <optgroup label="Department">
                    <option disabled selected>Select</option>
                    @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->Name }}</option>
                    @endforeach
                </optgroup>
            </select>
            <span>Select Department</span>
        </div>
        <div class="input-field col s12" id="team" style="display: none">
            <select class="select2 browser-default" name="team" id="team_select"  tabindex="-1">
                <optgroup label="Team">
                    <option disabled selected>Select</option>
                    @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->Name }}</option>
                    @endforeach
                </optgroup>
            </select>
            <span>Select Team</span>
        </div>
        <div class="input-field col s12" id="designation" style="display: none">
            <select class="select2 browser-default" name="designation" id="designation_select">
                <optgroup label="Designation">
                    <option disabled selected>Select</option>
                    @foreach($designations as $designation)
                    <option value="{{ $designation->id }}">{{ $designation->Name }}</option>
                    @endforeach
                </optgroup>
            </select>
            <span>Select Team</span>
        </div>
    </div>
</div>
