<br>
<h6 class="card-title">
    Account Details 
    <!--    <a class="bank_type_add_btn">
            <i class="material-icons">add_circle_outline</i>
        </a>-->
</h6>
<div class="row">
    <div class="input-field  col s4">
        <select disabled=" class="select manager_id" name="manager_id" id="manager_id">
            <option  disabled="">Manager Name</option>
            @foreach($employee_master as $employee)
            <option value="{{$employee->user_id}}" @if(!empty($edit_details->manager_id)) {{$employee->id == $edit_details->manager_id ? 'selected' : ''}} @endif >{{$employee->name}}</option>
            @endforeach
        </select>
        <label>Manager Name* </label>
    </div>
    <div class="input-field  col s4">
        <select disabled=" class="select account_id" name="account_id" id="account_id" >
            <option  disabled="">Accouting list</option>
            @foreach($employee_master as $employee)
            <option value="{{$employee->user_id}}" @if(!empty($edit_details->account_id)) {{$employee->id == $edit_details->account_id ? 'selected' : ''}} @endif >{{$employee->name}}</option>
            @endforeach
        </select>
        <label>Accouting list* </label>

    </div>
    <div class="input-field  col s4">
        <select disabled=" class="select payment_status_id" name="payment_status_id" id="payment_status_id" >
            <option disabled="">Payment Status</option>
            @foreach($payment_status_master as $payment_status)
            <option value="{{$payment_status->id}}" @if(!empty($edit_details->payment_status_id)) {{$payment_status->id == $edit_details->payment_status_id ? 'selected' : ''}} @endif>{{$payment_status->name}}</option>
            @endforeach
        </select>
        <label>Payment Status* </label>
    </div>
</div>