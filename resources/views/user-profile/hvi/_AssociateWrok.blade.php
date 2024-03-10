
<div class="card-panel">

    <div>
        <h4 class="title-color">Our Customers</span></h4>

        <table class="display striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email id</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hvi_customer_details as  $key=>$Details)
                <tr>
                    <td>{{$key+=1}}</td>
                    <td>{{$Details->customer_name}}</td>
                    <td>{{$Details->billing_email}}</td>
                    <td>{{$Details->billing_mobile}}</td>
                    <td>{{$Details->city_name}}</td>
                    <td>

{{--                        <a class="modal-trigger" href="#moda{{$Details->id}}_{{$key}}">--}}
{{--                            <span class="material-icons">add_circle_outline</span>--}}
{{--                        </a>--}}

                        <a href="/modules/module/Customers/{{$Details->id}}" class="tooltipped mr-10" data-position="top" data-tooltip="View">
                            <span class="material-icons">visibility</span>
                        </a>
                        <!-- Modal Structure -->
                            <div id="moda{{$Details->id}}_{{$key}}" class="modal" >
                        <form action="{{route('activity.activity_store')}}" method="post" id="" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <h4 class="title-color">Add Activity</h4>
                                    <hr>



                                    {{csrf_field()}}
                                        <input type="hidden" value="{{$Details->id}}" id="customer_id" name="customer_id">

{{--                                      @include('hvl.activitymaster.create_activity')--}}

                                </div>


                                <div class="modal-footer">
                                    <button type="submit" name="action" id="butsave" class="modal-action btn-color btn-flat btn-color">Save<i class="material-icons right">send</i>
                                    </button>
                                    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat btn-color">Close</a>
                                </div>
                        </form>
                            </div>
                    </td>

                </tr>

                @endforeach


            </tbody>
        </table>
        <div id="current_sa"></div>
    </div>

</div>

<script>
    $(document).ready(function () {


        jQuery.datetimepicker.setLocale('en');
        jQuery('.txt_start_date').datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
//            minDate: 0,
            defaultDate: new Date(),
            formatDate: 'Y-m-d',
            scrollInput: false

        });
        jQuery('.txt_end_date').datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            defaultDate: new Date(),
//            minDate: 0,
            formatDate: 'Y-m-d',
            scrollInput: false,

        });

        $('#butsave').on('click', function () {


            var customer_id = $('#customer_id').val();
            var txt_start_date = $('#txt_start_date').val();
            var txt_end_date = $('#txt_end_date').val();
            var ddl_type = $('#ddl_type').val();
            var ddl_status = $('#ddl_status').val();
            var comment = $('#comment').val();



            $.ajax({
                url: "/recruitment/candidate/HVI_ajax_store",
                type: "post",
                data: {
                    customer_id: customer_id,
                    txt_start_date: txt_start_date,
                    txt_end_date: txt_end_date,
                    ddl_type: ddl_type,
                    ddl_status: ddl_status,
                    comment: comment
                },
                cache: false,
                success: function (message) {
                    console.log(message);
                    location.reload();

                    $('#current_sa').html(message);
                    $("#current_sa").val(message);

                }
            });


        });
    });
</script>
