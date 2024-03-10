{{-- layout --}}
@extends('app.layout')

{{-- page title --}}
@section('title','Sub Category Management')
@section('vendor-style')
@endsection


@section('content')
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{route('expense')}}">Sub Category Master</a></li>
            <li class="breadcrumb-item"><a href="{{route('subcategory.create')}}">Create </a></li>
        </ul>
    </div>
</div>
<section>
    <div class="container-fluid">

        <header>
            <div class="row">
                <div class="col-md-7">
                    <h2 class="h3 display">Sub Category Master</h2>
                </div>
                <div class="col-md-5">
                    <a href="{{route('subcategory.create')}}" class="btn btn-primary pull-right rounded-pill">Sub Category</a>
                </div>
            </div>
        </header>
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
                        <th>Sub Category Name</th>
                        <th>Category Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subcategoryDetails as $key => $Detailes)
                    <tr>
                        <td width="4%">
                            <label>
                                <input type="checkbox" data-id="{{ $Detailes->id }}" name="selected_row"/>
                                <span></span>
                            </label>
                        </td>
                        <td width="8%">
                            <!--can('Edit category')-->
                            <a href="{{ route('subcategory.edit', $Detailes->id) }}"
                               class="tooltipped mr-10"
                               data-position="top"
                               data-tooltip="Edit">
                                <span class="fa fa-edit	"></span>
                            </a>
                            <!--endcan-->
                            <!--can('Delete category')-->
                            <a href="#"
                               class="tooltipped delete-record-click"
                               data-position="top"
                               data-tooltip="Delete" data-id="{{ $Detailes->id }}">
                                <span class="fa fa-trash"></span>
                            </a>
                            <!--endcan-->
                        </td>
                        <td>{{$Detailes->name}}</td>
                        <td> 
                            <?php echo app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('category', 'id', $Detailes->category_id, 'name'); ?>
                        </td>
                        <td> 
                            <?php if ($Detailes->is_active == '0') { ?>
                                <span class="badge green lighten-5 green-text text-accent-4">active</span>   
                            <?php } else { ?>
                                <span class="badge pink lighten-5 pink-text text-accent-2">Inactive</span>
                            <?php } ?>
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
        $('#page-length-option').DataTable({
            "scrollX": true
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
                            url: '/subcategory/multidelete',
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
            var name = 'Sub Categorys';
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
                        url: '/subcategory/delete',
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

