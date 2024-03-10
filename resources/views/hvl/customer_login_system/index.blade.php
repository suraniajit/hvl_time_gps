
@extends('app.layout')

{{-- page title --}}
@section('title','Customer Admin Login System | HVL')

@section('vendor-style')
<style>
    /*.swal-small{*/
    /*    width: 450px !important;*/
    /*}*/
</style>
@endsection
@section('content')

<section>
    <div class="container-fluid">
        <header>
            <div class="row">
                <div class="col-md-7">
                    <h2 class="h3 display">Customer Login System</h2>
                </div>
                <div class="col-md-5">
                    @can('Create CustomerAdmin')
                        <a href="{{route('customer.login_system.create')}}" class="btn btn-primary pull-right rounded-pill">Add Customer</a>
                    @endcan
                    @can('Delete CustomerAdmin')
                        <a id="mass_delete_id" class="btn btn-primary pull-right rounded-pill mr-2">
                            <i class="fa fa-trash"></i> Mass Delete
                        </a>
                    @endcan    
                </div>
            </div>
        </header>
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
            <br>
                <div class="table-responsive">
                    <table id="page-length-option" class="table table-striped table-hover multiselect">
                        <thead>
                            <tr>
                                <th class="sorting_disabled" width="5%">
                                    <label>
                                        <input type="checkbox" class="select-all m-1"/>
                                        <span></span>
                                    </label>
                                </th>
                                <th>ID</th>
                                <th>Action</th>
                                <th>Customer Name</th>
                                <th>Email_id</th>
                                <th>Customer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index=1; @endphp
                            @foreach($users as $user)
                            <tr>
                                
                                <td>
                                    <label>
                                        <input type="checkbox" data-id="{{ $user->id }}"
                                               name="selected_row"/>
                                        <span></span>
                                    </label>
                                </td>
                                <td>{{$index++}}</td>
                                <td>
                                    @can('Read CustomerAdmin')
                                    <a href="{{ route('customer.login_system.show',$user->id) }}" class="tooltipped mr-10" data-position="top" data-tooltip="View">
                                        <span class="fa fa-eye"></span>
                                    </a>
                                    @endcan
                                    
                                    @can('Edit CustomerAdmin')
                                    <a href="{{ route('customer.login_system.edit',$user->id) }}" class="tooltipped mr-10"  data-position="top" data-tooltip="Edit" target="_blank">
                                        <span class="fa fa-edit"></span>
                                    </a>
                                    @endcan
                                    @can('Delete CustomerAdmin')
                                        <a class="button single_delete " data-id="{{$user->id}}"><span class="fa fa-trash"></span></a>
                                    @endcan
                                </td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @php $customer_array = []; @endphp
                                        @if(isset($customers_admins[$user->id])&& (!(empty(json_decode($customers_admins[$user->id]) )) ) )
                                            @foreach(json_decode($customers_admins[$user->id]) as $customer_id)
                                                
                                                @if(isset($customers[$customer_id]))
                                                    @php $customer_array[] = $customers[$customer_id]; @endphp
                                                @endif
                                               
                                            @endforeach
                                            {{ implode(" , ",$customer_array) }}
                                        @else
                                         &nbsp;
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
 </section>

@endsection
@section('page-script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

<script>
 $(document).ready(function () {
      // mass delete
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
                // $('.select-all').prop('checked', false);
                // $('.select-all').attr('checked', true);
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
                title: "Are you sure, you want to delete? ",
                text: "You will not be able to recover this record!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "{{route('customer.login_system.massdelete')}}",
                        type: 'POST',
                        data: {
                            "_token": token,
                            ids: checkbox_array,
                        },
                        success: function (result) {
                            if (result === 'error') {
                                swal({
                                    title: "Customer cannot be deleted !",
                                    type: "warning",
                                })
                            } else {
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
        } else {
            swal({
                title: "Please Select Atleast One Record",
                type: 'warning',
            });
        }
    });
    
 $('.single_delete').click(function (e) {
        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        swal({
            title: "Are you sure you want to delete? ",
            text: "You will not be able to recover this record!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "{{route('customer.login_system.delete')}}",
                    type: "post",
                    data: {
                        "_token": token,
                        "id": id,
                    },
                    success: function (result) {
                        if (result === 'error') {
                            swal({
                                title: "customer not able to delete !",
                                type: "warning",
                            })
                        } else {
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
        }
        );
    });
</script>

@endsection


