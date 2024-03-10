{{-- layout --}}
@extends('app.layout')

{{-- page title --}}
@section('title','Account Management')
@section('vendor-style')
@endsection


@section('content')
<section>
    <div class="container-fluid">

        <header>
            <div class="row">
                <div class="col-md-7">
                    <h2 class="h3 display">Account Master</h2>
                </div>
            </div>
        </header>
        <div class="table-responsive">
            <table id="page-length-option" class="table table-striped table-hover multiselect">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Manager</th>
                        <th>Account</th>
                        <th>Action By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($account_detais as $key => $detaile)
                    <tr>
                        <td>
                            <a href="{{ route('account.edit', $detaile->id) }}"
                               class="tooltipped mr-10"
                               data-position="top"
                               data-tooltip="Edit">
                                <span class="fa fa-edit	"></span>
                            </a>

                            <a href="#"
                               class="tooltipped delete-record-click"
                               data-position="top"
                               data-tooltip="Delete" data-id="{{ $detaile->id }}">
                                <span class="fa fa-trash"></span>
                            </a>
                        </td>
                        <td width="2%"> <center>{{$key+1}}</center> </td>
                <td> 
                    <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $detaile->user_id, 'Name'); ?>
                </td>
                <td> 
                    <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $detaile->manager_id, 'Name'); ?>
                </td>
                <td> 
                    <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $detaile->account_id, 'Name'); ?>
                </td>
                <td> 
                    <?php
                    if ($detaile->user_id == '122') {
                        echo 'admin';
                    } else {
                        app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $detaile->user_id, 'Name');
                    }
                    ?>
                </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection 


{{-- page script --}}
@section('page-script')
<script>
    $(document).ready(function () {
        $(document).ready(function () {
            $('#page-length-option').DataTable({
                "scrollX": true
            });
        });
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
                            url: '/emp/massremove/',
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
            var name = 'Account';
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
                        url: '/account/delete',
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

