<!--Mileage  (
Type of Vehicle (ok)
Distance (ok)
Amount = Rate per km * Distance, 
Currency,  (ok)
Spent at, (ok)
Description,  (ok)
City Name, (ok)
Category,  (ok)
Date of Expense, Time of Expense)-->

<div class="card-content mailage_flow">
    <h4 class="card-title">Mileage Expense</h4>
    <div class="row">
        <div class="col s2">
            <label>Currency</label>
            <input type="text" value="INR" disabled="">
            <!--<div class="errorTxt3"></div>-->
        </div>
        <div class="input-field  col s4">
            <select name="vehicle_type_mile" id="vehicle_type_mile" class="txtCal vehicle_type_mile" onchange="calculation();">
                <option disabled="" selected="">Type of Vehicle*</option>
                @foreach($vehicles_master as $vehicles)
                <option value="{{$vehicles->id}}" {{$vehicles->id == $edit_details->vehicle_type_mile ? 'selected' : ''}}>{{$vehicles->name}}</option>
                @endforeach
            </select>
            <label>Type of Vehicle* </label>
            <div class="vehicle_type_mile_error"></div>
        </div>
        <div class="input-field col s3">
            <label for="">Rate Per Km</label> 
            <input type="number" readonly="" name="vehicle_rate_mile" id="vehicle_rate_per_km" class="vehicle_rate_per_km txtCal" placeholder="Enter Rat Per km." value="{{$edit_details->vehicle_rate_mile}}" onchange="calculation();">
         </div>
        <div class="input-field col s3">
            <label>Distance* </label>
            <input type="number" name="distance_mile" class="distance_mile txtCal" placeholder="Enter Distance" value="{{$edit_details->distance_mile}}" onchange="calculation();">
            <div class="distance_mile_error"></div>
        </div>

        <div class="col s3">
            <label>Spent at * </label>
            <input type="text" name="spent_at_mile" placeholder="ie:Mettro" class="spent_at_mile" value="{{$edit_details->spent_at_mile}}">
            <div class="spent_at_mile_error"></div>
        </div>
        <div class="col s2">
            <label>Date of Expense* </label>
            <input type="text" name="date_of_expense_mile" class="date_of_expense date_of_expense_mile" placeholder="Select Date of Expense" value="{{$edit_details->date_of_expense_mile}}"  >
            <div class="date_of_expense_error"></div>
        </div>
        <div class="col s3">
            <label>City Name* </label>
            <input type="text" name="city_name_mile" placeholder="City Name" class="city_name_mile" value="{{$edit_details->city_name_mile}}" >
            <div class="city_name_mile_error"></div>
        </div>
        <div class="col s4">
            <label>Total Amount*(<i>Amount = Rate per Km * Distance</i>) </label>
            <input type="text" readonly="" name="total_amount_mile" placeholder="Total Amount" value="{{$edit_details->total_amount_mile}}" class="total_amount_mile">
         </div>
        <div class="input-field  col s3">
            <select name="category_id_mile" id="category_id_mile" class="category_id_mile">
                <option value="" selected disabled="">Categorys</option>
                @foreach($category_master as $category)
                <option value="{{$category->id}}" {{$category->id == $edit_details->category_id_mile ? 'selected' : ''}}>{{$category->name}}</option>
                @endforeach
            </select>
            <label>Categorys* </label>
            <div class="category_id_mile_error"></div>
        </div>
        <div class="input-field col s3">
            <select name="subcategory_id_mile" id="subcategory_id_mile" class="subcategory_id_mile">
                <option value="0" disabled=""> Sub Category</option>
                @foreach($subcategory_master as $subcategory)
                <option value="{{$subcategory->id}}" {{$subcategory->id == $edit_details->subcategory_id_mile ? 'selected' : ''}}>{{$subcategory->name}}</option>
                @endforeach
            </select>
            <label for="">Sub Category </label>
            <div class="subcategory_id_mile_error"></div>
        </div>

        <div class="col s4">
            <label>Description </label>
            <textarea id="description_mile" name="description_mile" rows="3" cols="5">{{$edit_details->description_mile}}</textarea>
            <!--<div class="errorTxt3"></div>-->
        </div>
    </div>
</div>
<script>

    $(document).ready(function () {
//        $('.distance_mile').val(0);
//        $('.vehicle_rate_per_km').val(0);
//        $('.total_amount_mile').val(0);
        calculation();
    });
    function calculation() {
        $('.total_amount_mile').val('');
        var sum = vehicle_rate_per_km = 0;
        var distance = $('.distance_mile').val();
        var vehicle_rate_per_km = $(".vehicle_rate_per_km").val();

        var sum = (distance * vehicle_rate_per_km);
        $(".total_amount_mile").val(sum);
    }

    $('#vehicle_type_mile').change(function () {
        calculation();
        var cid = $(this).val();
        if (cid) {
            $.ajax({
                type: "get",
                url: "/expense/getvehicalRat",
                data: {
                    id: cid
                },
                success: function (res)
                {
                    if (res)
                    {
                        calculation();
                        $(".vehicle_rate_per_km").empty();
                        $.each(res, function (key, value) {
                            $(".vehicle_rate_per_km").val(value.rate_per_km);
                            $("#vehicle_rate_per_km").val(value.rate_per_km);
                        });
                    }
                }
            });
        }
    });
</script>

<script>

    $('#category_id_mile').change(function () {
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
                        $("#subcategory_id_mile").empty();
                        $("#subcategory_id_mile").append('<option value="0">Sub Category</option>');
                        $.each(res, function (key, value) {
                            $("#subcategory_id_mile").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        $('select').formSelect();
                    }
                }
            });
        }
    });
</script>