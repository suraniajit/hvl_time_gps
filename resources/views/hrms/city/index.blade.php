
@extends('app.layout')

{{-- page title --}}
@section('title','City Management | HVL')

@section('content')

    <section>
        <div class="container-fluid">
            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display">City</h2>
                    </div>
                    <div class="col-md-5">
                        @can('Create City')
                            <a href="{{route('city.create')}}" class="btn btn-primary pull-right rounded-pill">Add City</a>
                        @endcan
                        @can('Delete City' )
                            <a id="mass_delete_id" class="btn btn-primary pull-right rounded-pill mr-2">
                                <i class="fa fa-trash"></i> Mass Delete
                            </a>
                        @endcan
                    </div>
                </div>

            </header>

            <!-- Page Length Options -->
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show center-block" role="alert">
                        <strong>{!! \Session::get('success') !!} </strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                @endif
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="page-length-option" class="table table-striped table-hover multiselect">
                                    <thead>
                                        <tr>
                                            <th class="sorting_disabled" width="4%">
                                                <label>
                                                    <input type="checkbox" class="select-all"/>
                                                    <span></span>
                                                </label>
                                            </th>
                                            <th>Action</th>
                                            <th>#ID</th>
{{--                                            <th>Country Name</th>--}}
                                            <th>State Name</th>
                                            <th>City Name</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($CityDetails as $key => $Detailes)
                                        <tr>
                                    <td width="8%">
                                        @can('Edit City')
                                        <a href="{{ route('city.edit', $Detailes->id) }}"
                                           class="tooltipped mr-10"
                                           data-position="top"
                                           data-tooltip="Edit">
                                            <span class="fa fa-edit"></span>
                                        </a>

                                        @endcan
                                        @can('Delete City')
                                        <a href="#"
                                           class="tooltipped delete-record-click"
                                           data-position="top"
                                           data-tooltip="Delete" data-id="{{ $Detailes->id }}">
                                            <span class="fa fa-trash"></span>
                                        </a>
                                        @endcan
                                    </td>
                                            <td width="4%">
                                                <label>
                                                    <input type="checkbox" data-id="{{ $Detailes->id }}"
                                                           name="selected_row"/>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td width="2%"> <center>{{$key+1}}</center> </td>
{{--                                    <td>{{$Detailes->country_name}}</td>--}}
                                    <td>{{$Detailes->state_name}}</td>
                                    <td>{{$Detailes->city_name}}</td>
                                    <td>
                                        <?php if ($Detailes->is_active == '0') { ?>
                                            <span class="badge badge-success">active</span>
                                        <?php } else { ?>
                                            <span class="badge badge-danger">Inactive</span>
                                        <?php } ?>
                                    </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
@endsection
@section('page-script')
    <script>
        $(document).ready(function () {
            $('#page-length-option').DataTable({
                "scrollX": true
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script>
        $(document).ready(function () {
            var checkbox = $('.multiselect tbody tr td input');
            var selectAll = $('.multiselect .select-all');

            checkbox.on('click', function () {
                // console.log($(this).attr("checked"));
                $(this).parent().parent().parent().toggleClass('selected');
            });

            checkbox.on('click', function () {
                // console.log($(this).attr("checked"));
                if ($(this).attr("checked")) {
                    $(this).attr('checked', false);
                } else {
                    $(this).attr('checked', true);
                }
            });


            // Select Every Row

            selectAll.on('click', function () {
                $(this).toggleClass('clicked');
                if (selectAll.hasClass('clicked')) {
                    $('.multiselect tbody tr').addClass('selected');
                } else {
                    $('.multiselect tbody tr').removeClass('selected');
                }

                if ($('.multiselect tbody tr').hasClass('selected')) {
                    checkbox.prop('checked', true);
                } else {
                    checkbox.prop('checked', false);
                }
            });
            // mass delete
            $('#mass_delete_id').click(function () {
                var checkbox_array = [];
                var token = $("meta[name='csrf-token']").attr("content");
                $.each($("input[name='selected_row']:checked"), function () {
                    checkbox_array.push($(this).data("id"));
                });
                // console.log(checkbox_array);
                if (typeof checkbox_array !== 'undefined' && checkbox_array.length > 0) {

                    swal({
                            title: "Are you sure, you want to delete? ",
                            text: "You will not be able to recover this record!",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Yes, delete it!",
                            closeOnConfirm: false
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    url: '{{route('city.multidelete')}}',
                                    type: 'get',
                                    data: {
                                        "_token": token,
                                        ids: checkbox_array,
                                    },
                                    success: function (result) {
                                        swal({
                                            title: "Record has been deleted!",
                                            type: "success",
                                        }, function () {
                                            location.reload();
                                        });
                                    }
                                });
                            }
                        });
                } else {
                    swal({
                        title: "Please Select Atleast One Record",
                        type: 'warning',

                    });
                }

            });

            $('.delete-record-click').click(function () {
                var id = $(this).data("id");

                swal({
                        title: "Are you sure you want to delete? ",
                        text: "You will not be able to recover this record!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: "{{route('city.delete')}}",
                                type: "get",
                                data: {
                                    "id": id
                                },
                                success: function (result) {
                                    if(result === 'error')
                                    {
                                        swal({
                                            title: "City can't be delete as employee is assigned!",
                                            type: "warning",
                                        })

                                    }
                                    else{
                                        swal({
                                            title: "Record has been deleted!",
                                            type: "success",
                                        }, function () {
                                            location.reload();
                                        });
                                    }
                                }
                            });
                        }
                    });
            });
        });

    </script>
@endsection

