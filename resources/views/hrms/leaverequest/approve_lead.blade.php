{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Approve Leave Request')

{{-- vendor styles --}}
@section('vendor-style')
<!-- BEGIN: VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/select.dataTables.min.css') }}">
<!--<link rel="stylesheet" type="text/css" href="{{ asset('css/datatable/responsive.dataTables.min.css') }}">-->

<link rel="stylesheet" type="text/css" href="{{ asset('css/datatable/colReorder.dataTables.min.css') }} ">
<link rel="stylesheet" type="text/css" href="{{ asset('css/datatable/buttons.dataTables.min.css') }} ">
<link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('vendors/select2/select2-materialize.css') }}" type="text/css">
<!-- END: VENDOR CSS-->

<!-- BEGIN: Page Level CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/form-select2.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-tables.css') }}">

@endsection


@section('content')
<div class="section section-data-tables">
    <!--success message start-->
    <div class="row">
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
    </div>
    <!--success message end-->
    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="col s12 m6 l6">
                    <h5 class="title-color"><span>Approve Leave Request</span></h5>
                </div>
            </div>
            <div class="section section-data-tables">
                <div class="row">
                    <div class="col s12">
                        <div class="  ">
                            <div class="row">
                                <div class="col s12">
                                    <table id="page-length-option" class="display multiselect">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">ID</th>
                                                <th>Employee Name</th>
                                                <th>Leave Type</th>
                                                <th>From Date</th>
                                                <th>End Date</th>
                                                <th>No. of Leaves</th>
                                                <th>Remark</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1 ?>
                                            @foreach($leaverequest as $leave)
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>{{$leave->emp_name}}</td>
                                                <td>{{$leave->leavetype_name}}</td>
                                                <td>{{$leave->from_date}}</td>
                                                <td>{{$leave->end_date}}</td>
                                                <td>{{$leave->total_days}}</td>
                                                <td>{{$leave->remark}}</td>
                                                <td>
                                                    @if($leave->status==1)
                                                    <span class="badge green" style="width:79px;height: 24px;">Approved</span>
                                                    @elseif($leave->status==3)
                                                    <span class="badge green" style="width:79px;height: 24px;">Approved</span>
                                                    @elseif($leave->status==2)
                                                    <span class="badge brown darken-1" style="width:79px;height: 24px;">Pending</span>
                                                    @elseif($leave->status==0)
                                                    <span class="badge red" style="width:79px;height: 24px;">Rejected</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($leave->status!=3 && $leave->status!=0)
                                                    <a href="{{route('hrms.leaverequest.lead.approve.edit', ['id' => $leave->id]) }}" 
                                                       class="invoice-action-edit edit"
                                                       data-position="top"
                                                       data-tooltip="Action"
                                                       id="{{$leave->id}}"><i class="material-icons">edit</i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <?php $i++ ?>
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
</div>



@endsection
{{-- vendor script --}}
@section('vendor-script')

<script src="{{ asset('js/ajax/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/ajax/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('vendors/select2/select2.full.min.js') }}"></script>


<!-- END THEME  JS-->
<script src="{{ asset('js/scripts/data-tables.js') }}"></script>
<script src="https://cdn.datatables.net/colreorder/1.5.2/js/dataTables.colReorder.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>

<!-- BEGIN PAGE LEVEL JS-->
<script src="{{ asset('js/scripts/extra-components-sweetalert.js') }}"></script>
<!-- END PAGE LEVEL JS--><!-- BEGIN: Custom Page JS-->
<script src="{{ asset('js/scripts/form-select2.js') }}"></script>
<script src="{{ asset('js/scripts/ui-alerts.js') }}"></script>

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
                        url: '/recruitment/jobs/massremove',
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
        var name = 'Jobs';
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
                    url: '/recruitment/jobs/removedata',
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



