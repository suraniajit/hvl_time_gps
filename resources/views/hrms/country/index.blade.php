{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Country Managment')

{{-- vendor styles --}}
@section('vendor-style')
<!-- BEGIN: VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/select.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/datatable/colReorder.dataTables.min.css') }} ">
<link rel="stylesheet" type="text/css" href="{{ asset('css/datatable/buttons.dataTables.min.css') }} ">

<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-tables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/form-select2.css') }}">
@endsection



@section('content')
<div class="row">
    <!--success message start-->
    @if ($message = Session::get('success'))
    <div class="card-alert card green lighten-5" id="message">
        <div class="card-content green-text">
            <p>{{ $message }}</p>
        </div>
        <button type="button" class="close green-text close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @endif
    <!--success message end-->
</div>
<div class="card">

    <div class="card-content">
        <div class="row">
            <div class="col s12 m6 l6">
                <h5 class="title-color"><span>Country</span></h5>
            </div>
        </div>
        <!-- Page Length Options -->
        <div class="section section-data-tables">
            <div class="row">
                <div class="col s12">
                    <div class="  ">
                        <div class="row">
                            <div class="col s12">
                                <table id="page-length-option" class="display multiselect">
                                    <thead>
                                        <tr>
{{--                                            <th class="sorting_disabled" width="4%">--}}
{{--                                                <label>--}}
{{--                                                    <input type="checkbox" class="select-all"/>--}}
{{--                                                    <span></span>--}}
{{--                                                </label>--}}
{{--                                            </th>--}}

                                            <th>Country Name</th>
                                            <!--<th>code</th>-->
                                            <!--<th>Symbol</th>-->
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($CountryDetails as $key => $Detailes)
                                        <tr>
{{--                                            <td width="4%">--}}
{{--                                                <label>--}}
{{--                                                    <input type="checkbox" data-id="{{ $Detailes->id }}"--}}
{{--                                                           name="selected_row"/>--}}
{{--                                                    <span></span>--}}
{{--                                                </label>--}}
{{--                                            </td>--}}
                                            <td>{{$Detailes->country_name}}</td>
                                           <!--<td>{{$Detailes->code}}</td>-->
                                           <!--<td>{{$Detailes->symbol}}</td>-->
                                            <td>
                                                <?php if ($Detailes->is_active == '0') { ?>
                                                    <span class="badge green lighten-5 green-text text-accent-4">active</span>
                                                <?php } else { ?>
                                                    <span class="badge pink lighten-5 pink-text text-accent-2">Inactive</span>
                                                <?php } ?>
                                            </td>
                                            <td width="8%">
                                                @if($Detailes->id !== 1)
                                                    @can('Edit Country')
                                                    <a href="{{ route('hrms.country.edit', $Detailes->id) }}"
                                                       class="tooltipped mr-10"
                                                       data-position="top"
                                                       data-tooltip="Edit">
                                                        <span class="material-icons">edit</span>
                                                    </a>
                                                    @endcan
                                                    @can('Delete Country')
                                                    <a href="#"
                                                       class="tooltipped delete-record-click"
                                                       data-position="top"
                                                       data-tooltip="Delete" data-id="{{ $Detailes->id }}">
                                                        <span class="material-icons">delete</span>
                                                    </a>
                                                    @endcan
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- vendor script --}}
@section('vendor-script')

<script src="{{ asset('js/ajax/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/ajax/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('vendors/select2/select2.full.min.js') }}"></script>
<script src="{{asset('js/ajax/sweetalert.min.js')}}"></script>
<!-- END THEME  JS-->
<script src="{{ asset('js/scripts/data-tables.js') }}"></script>
<script src="https://cdn.datatables.net/colreorder/1.5.2/js/dataTables.colReorder.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>
<script src="{{ asset('js/scripts/page-users.js') }}"></script>
<script src="{{ asset('js/download-table.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script>
$(document).ready(function () {
    $('#mass_delete_id').click(function () {
        var checkbox_array = [];
        var token = $("meta[name='csrf-token']").attr("content");
        $.each($("input[name='selected_row']:checked"), function () {
            checkbox_array.push($(this).data("id"));
        });
// console.log(checkbox_array);
        if (typeof checkbox_array !== 'undefined' && checkbox_array.length > 0) {

            swal({
                title: "Are you sure, You will not be able to recover these record!",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                    cancel: 'No, Please!',
                    delete: 'Yes, Delete It'
                }
            }).then(function (willDelete) {
                if (willDelete) {
                    $.ajax({
                        url: '/hrms/country/multidelete',
                        mehtod: "get",
                        data: {
                            "_token": token,
                            id: checkbox_array
                        },
                        success: function (result) {
                            swal("Record has been deleted!", {
                                icon: "success",
                            }).then(function () {
                                location.reload();
                            });
                        }
                    });
                } else {
//                    swal(name + " Record is safe", {
//                        title: 'Cancelled',
//                        icon: "error",
//                    });
                }
            });
        } else {
//            swal({
//                title: "0 Row selected!",
//                text: "Select any record from the list",
//                icon: 'warning',
//            });
        }
    });

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


    $('.delete-record-click').click(function () {
        var id = $(this).data("id");
        var name = 'Countrys';
        var token = $("meta[name='csrf-token']").attr("content");

        swal({
            title: "Are you sure, you want to delete " + name.substring(0, name.length - 1) + "/s ?",
            icon: 'warning',
            dangerMode: true,
            buttons: {
                cancel: 'No, Please!',
                delete: 'Yes, Delete It'
            }
        }).then(function (willDelete) {
            if (willDelete) {
                $.ajax({
                    url: '/hrms/country/delete',
                    mehtod: "get",
                    data: {
                        "_token": token,
                        'id': id
                    },
                    success: function (result) {
                        swal("Record has been deleted!", {
                            icon: "success",
                        }).then(function () {
                            location.reload();
                        });
                    }
                });
            } else {
//                swal(name + " Record is safe", {
//                    title: 'Cancelled',
//                    icon: "error",
//                });
            }
        });
    });

});
</script>
@endsection

