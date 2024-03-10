<!--Amount, ok
Currency, ok
Spent at, ok
Description, ok
City Name, ok
Category,  ok
Date of Expense, ok
TIme of Expense, ok
(checkbox)Is Multi Day Expense - From to To Date),

Particulars, ok
Department(ddl-dep), ok
Property address(txt), 
Account / Premises No.,  ok
Payment Method(ddl-pstat),   ok
Card used(txt), ok
Account Name,   ok
Status(ddl-payment) ok-->


<div class="card-content cash_flow">
    <h4 class="card-title">Cash Expense</h4>
    <div class="row">
        <div class="col s2">
            <label>Currency </label>
            <input type="text" value="INR" disabled="">
            <!--<div class="errorTxt3"></div>-->
        </div>
        <div class="col s3">
            <label>Amount* </label>
            <input type="number" name="total_amount_cash" class="total_amount_cash" data-error=".errorTxt5" placeholder="Enter Amount" value="{{$edit_details->total_amount_cash}}">
            <div class="errorTxt5"></div>
        </div>
        <div class="col s4">
            <label>Spent At * </label>
            <input type="text" name="spent_at_cash" class="spent_at_cash" data-error=".errorTxt6" placeholder="ie:Mettro" value="{{$edit_details->spent_at}}">
            <!--<div class="errorTxt6"></div>-->
        </div>
        <div class="col s3">
            <label>Date of Expense* </label>
            <input type="text" name="date_of_expense_cash" class="date_of_expense" data-error=".errorTxt7" placeholder="Select Date of Expense" value="{{$edit_details->date_of_expense_cash}}">
            <div class="errorTxt7"></div>
        </div>
        <div class="col s4">
            <label>City Name* </label>
            <input type="text" name="city_id_cash" class="city_id_cash" placeholder="City Name" data-error=".errorTxt8" value="{{$edit_details->city_id_cash}}">
            <div class="errorTxt8"></div>
        </div>

        <div class="col s4">
            <label>Account / Premises No*</label>
            <input type="text" name="account_premises_no_cash" class="account_premises_no_cash" data-error=".errorTxt9" placeholder="Enter Account / Premises No" value="{{$edit_details->account_premises_no_cash}}">
            <div class="errorTxt9"></div>
        </div>
        <div class="col s4">
            <label>Card Used* </label>
            <input type="text" name="card_used_cash" data-error=".errorTxt10" class="card_used_cash" placeholder="Enter Card Used" value="{{$edit_details->card_used_cash}}">
            <div class="errorTxt10"></div>
        </div>
        <div class="input-field col s3">
            <label>Account Name </label>
            <input type="text" name="account_name_cash" data-error=".errorTxt11" class="account_name_cash" placeholder="Enter Amount Name" value="{{$edit_details->account_name_cash}}">
            <div class="errorTxt11"></div>
        </div>
        <div class="input-field  col s3">
            <select name="ddl_department_cash" id="ddl_department" class="ddl_department_cash" data-error=".errorTxt12">
                <option selected="">Departments</option>
                @foreach($departments_master as $department)
                <option value="{{$department->id}}" {{$department->id == $edit_details->department_id ? 'selected' : ''}}>{{$department->name}}</option>
                @endforeach
            </select>
            <label>Department * </label>
            <div class="errorTxt12"></div>
        </div>
        <div class="input-field col s3">
            <select name="category_id_cash" id="category_id_cash" class="category_id_cash" data-error=".errorTxt13">
                <option selected="">Categorys</option>
                @foreach($category_master as $category)
                <option value="{{$category->id}}" {{$category->id == $edit_details->category_id_cash ? 'selected' : ''}}>{{$category->name}}</option>
                @endforeach
            </select>
            <label>Categorys* </label>
            <div class="errorTxt13"></div>
        </div>

        <div class="input-field col s3">
            <select name="sub_category_id_cash" id="sub_category_id_cash" class="sub_category_id_cash" data-error=".errorTxt14">
                <option value="" selected="">Sub Category*</option>
                @foreach($subcategory_master as $subcategory)
                <option value="{{$subcategory->id}}" {{$subcategory->id == $edit_details->sub_category_id_cash ? 'selected' : ''}}>{{$subcategory->name}}</option>
                @endforeach
            </select>
            <label for="">Sub Category* </label>
            <div class="errorTxt14"></div>
        </div>

        
        <div class="col s6">
            <label>Description </label>
            <textarea name="description_cash" class="description_cash" rows="3" cols="5">{{$edit_details->description_cash}}</textarea>
            <!--<div class="errorTxt3"></div>-->
        </div>
        <div class="col s6">
            <label>Property Address </label>
            <textarea name="property_address_cash" class="property_address_cash" rows="3" cols="5">{{$edit_details->property_address_cash}}</textarea>
            <!--<div class="errorTxt3"></div>-->
        </div>

    </div>
    <div class="row">
        <div class="col s4">
            <p style="margin-top: 25px;">
                <label>
                    <input type="checkbox" name="expance_multi_day" class="expance_multi_day" onclick="expance_multi_day();"/>
                    <span>Is Multi Day Expense</span>
                </label>
            </p>
        </div>
        <div class="multi_day_div">
            <div class="col s4">
                <label>From Date</label>
                <input type="text" name="multi_day_from_date_cash" data-error=".errorTxt17" class="multi_day_from_date" placeholder="YYYY-MM-DD" value="{{$edit_details->multi_day_from_date}}">
                <div class="errorTxt17"></div>
            </div>
            <div class="col s4">
                <label>To Date </label>
                <input type="text" name="multi_day_to_date_cash" data-error=".errorTxt18"  class="multi_day_to_date" placeholder="YYYY-MM-DD"  value="{{$edit_details->multi_day_to_date}}">
                <div class="errorTxt18"></div>
            </div>
        </div>
    </div>
</div>

<script>



    $('#ddl_category').change(function () {
        var cid = $(this).val();
        if (cid) {
            $.ajax({
                type: "get",
                url: "/expense/getsubcategory",
                data: {
                    id: cid
                },
                success: function (res)
                {
                    if (res)
                    {
                        $("#subcategory_id").empty();
                        $("#subcategory_id").append('<option value="">Sub Category</option>');
                        $.each(res, function (key, value) {
                            $("#subcategory_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        $('select').formSelect();
                    }
                }
            });
        }
    });
</script>