@extends('app.layout')

@section('title','Customer Management | HVL')

@section('vendor-style')
@endsection
@php 
$isOperators =false;
$isCustomerAdmin = false;
@endphp
@role('Operators')
    @php
        $isOperators = true;
    @endphp
@endrole

@role('customers_admin')
    @php
        $isCustomerAdmin = true;
    @endphp
@endrole

@section('content')

<section>
    <div class="container-fluid">
        <header>
            <div class="row">
                <div class="col-md-4">
                    <h2 class="h3 display">Customer Management</h2>
                </div>
                <div class="col-md-8">
                    @can('Create Customer' )
                    <a href="{{route('customer.create')}}" class="btn btn-primary pull-right rounded-pill">Add Customer</a>
                    @endcan
                    <a class="btn btn-primary rounded-pill pull-right mr-2 " data-toggle="modal" data-target="#modal_download">
                        <span class="fa fa-download fa-lg"></span> Download
                    </a>
                    @can('Delete Customer' )
                    <a id="mass_delete_id" class="btn btn-primary pull-right rounded-pill mr-2">
                        <i class="fa fa-trash"></i> Mass Delete
                    </a>
                    @endcan
                    @can('Access Customer Bulkupload')
                   
                     <a class="btn btn-primary rounded-pill pull-right mr-2"  href="{{ route('admin.customermaster_bulkupload.index') }}">
                            <i class="fa fa-upload fa-lg"></i>Upload Customer
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
                <div class="">
                    <form action="{{route('customer.index')}}" method="post">
                        <div class="row">
                           <div class="col-sm-6 col-md-3">
                                <select id="branch" name="branch_id" class="form-control" required="">
                                    <option value="" >Select Branch</option>
                                    @foreach($branchs as $key=>$branch)
                                    @if($key ==0)
                                        @php continue; @endphp
                                    @endif
                                        <option value="{{$key}}"  {{( isset($search_branch) && ($key == $search_branch) )?'selected':''}}  >{{$branch}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <select id="customer_id" multiple    name="customer_id[]" class="form-control" required>
                                    @foreach($search_branchs_customers as $key=>$customer)
                                        <option value="{{$key}}"  {{( in_array($key,$search_customer) )?'selected':''}}  >{{$customer}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <input type="text" name="contract_start" value="{{$search__sdate}}"  id="search_start_date" class="form-control datepicker" placeholder="Enter Start Date" autocomplete="off" autofocus="off">
                            </div>

                            <div class="col-sm-6 col-md-3">
                                <input type="text" name="contract_end" value="{{$search__edate}}" id="search_end_date" class="form-control datepicker" placeholder="Enter End Date" autocomplete="off" autofocus="off">
                            </div>
                            <div class="col-sm-6 col-md-1">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                            <div class="col-sm-6 col-md-1">
                                <a class="btn btn-primary" href="{{route('customer.index')}}">Reset</a>
                            </div>

                        </div>
                    </form>

                </div>

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
                                <th width="2%">ID</th>
                                @if(!$isCustomerAdmin)
                                    <th width="10%">Action</th>
                                @endif
                                <th width="5%">Activity</th>
                                <th >Audit</th>
                                @if(!$isCustomerAdmin)
                                    <th width="2%">Customer Code</th>
                                @endif
                                <th width="10%">Customer Name</th>
                                <th width="5%">Customer Alias</th>
                                <th width="2%">Billing Address</th>
                                <th width="2%">Billing State</th>
                                <th width="2%">Contact Person</th>
                                <th width="2%">Contact Phone</th>
                                <th width="5%">Billing Mail</th>
                                <th width="5%">Billing Phone</th>
                                @if(!$isCustomerAdmin)
                                    <th width="2%">Sales Person</th>
                                @endif
                                <th width="2%">Creation Date</th>
                                <th width="2%">Shipping Address</th>
                                <th width="2%">Shipping State</th>
                                <th width="2%">Credit Limit</th>
                                <th width="2%">GSTIN</th>
                                <th width="2%">Payment Mode</th>
                                <th width="2%">Branch</th>
                                <th width="2%">Contract Start Date</th>
                                <th width="2%">Contract End Date</th>
                                @if(!$isOperators)
                                    @if(!$isCustomerAdmin)
                                        <th width="2%">Value</th>
                                    @endif
                                @endif
                                @if(!$isCustomerAdmin)
                                    <th width="2%">Reference</th>
                                @endif
                                <th >Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customerDetails as $key => $Detailes)

                            <tr>
                                <td>
                                    <label>
                                        <input type="checkbox" data-id="{{ $Detailes->id }}" name="selected_row"/>
                                        <span></span>
                                    </label>
                                </td>
                                <td>
                                <center>{{$loop->iteration}}</center>
                                </td>
                                @if(!$isCustomerAdmin)
                                    <td width="10%">
                                        @can('Edit Customer')
                                        <a href="{{ route('customer.edit', $Detailes->id) }}"
                                        class="p-2">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                        @endcan
                                        <a href="{{ route('customer.services.history', $Detailes->id) }}"
                                        class="p-2"> 
                                            <span class="fa fa-history"></span>
                                        </a>

                                        @can('Delete Customer')
                                        <a href="" class="button" data-id="{{$Detailes->id}}"><span class="fa fa-trash"></span></a>
                                        @endcan
                                        @if($Detailes->contract == 0)
                                        @can('Access Customer Contract')
                                        <a class="p-2" data-toggle="modal" data-id="{{$Detailes->id}}" data-target="#modal{{$Detailes->id}}">
                                            <span class="fa fa-paperclip fa-lg"></span>
                                        </a>
                                        <div id="modal{{$Detailes->id}}" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
                                            <div role="document" class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4>Upload Contract</h4>
                                                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <form method="post" action="{{route('customer.contract')}}" enctype="multipart/form-data">
                                                            {{--                                                                    <div class="row">--}}
                                                                <input type="hidden" name="customer_id" value="{{$Detailes->id}}">
                                                            <div class="form-group">
                                                                <label>Contract File</label>
                                                                <input type="file" name="contract[]" id="audit_file" required multiple class="form-control-file" accept=".jpg, .jpeg, .png,.doc,.docx,application/pdf">
                                                                <p class="text-danger">Max File Size:<strong> 3MB</strong><br>Supported Format: <strong>.jpg, .jpeg, .png, .pdf, .doc, .docx</strong></p>
                                                            </div>
                                                    {{--                                                                    </div>--}}
                                                    <input type="submit" class="btn btn-success rounded" value="Upload">
                                                </form>
                                            </div>
                                        </div>
                                        </div>
                                        </div>
                                        @endcan

                                        @endif
                                        @can('Read Customer')
                                        <a href="{{ route('customer.view', $Detailes->id) }}"
                                        class="p-2"
                                        data-position="top"
                                        data-tooltip="Edit">
                                            <span class="fa fa-eye"></span>
                                        </a>
                                        @endcan

                                    </td>
                                @endif                    
                                <td>
                                    <a href="{{ route('customer.view-activity', $Detailes->id) }}"
                                    class="p-1 btn btn-primary">
                                        View
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.customer.audit_list', $Detailes->id) }}"
                                    class="p-1 btn btn-primary">
                                        Audit
                                    </a>
                                </td>
                                @if(!$isCustomerAdmin)
                                    <td>{{$Detailes->customer_code}}</td>
                                @endif
                                <td>{{$Detailes->customer_name}}</td>
                                <td>{{$Detailes->customer_alias}}</td>
                                <td>{{$Detailes->billing_address}}</td>
                                <td>{{$Detailes->billing_state_name}}</td>
                                <td>{{$Detailes->contact_person}}</td>
                                <td>{{$Detailes->contact_person_phone}}</td>
                                <td>{{$Detailes->billing_email}}</td>
                                <td>{{$Detailes->billing_mobile}}</td>
                                @if(!$isCustomerAdmin)
                                    <td>{{$Detailes->sales_person}}</td>
                                @endif
                                <td>{{$Detailes->create_date}}</td>
                                <td>{{$Detailes->shipping_address}}</td>
                                <td>{{$Detailes->shipping_state_name}}</td>
                                <td>{{$Detailes->credit_limit}}</td>
                                <td>{{$Detailes->gstin}}</td>
                                <td>{{$Detailes->payment_mode}}</td>
                                <td>{{$Detailes->customer_branch_name}}</td>
                                <td>{{$Detailes->con_start_date}}</td>
                                <td>{{$Detailes->con_end_date}}</td>
                                    @if(!$isOperators)
                                        @if(!$isCustomerAdmin)
                                            <td>{{$Detailes->cust_value}}</td>
                                        @endif
                                    @endif
                                @if(!$isCustomerAdmin)
                                    <td>{{$Detailes->reference}}</td>
                                @endif
                                <td>
                                @if($Detailes->is_active==0)
                                <span class="badge green">Active</span>
                                @elseif($Detailes->is_active==1)
                                <span class="badge red">Inactive</span>
                                @else
                                {{$Detailes->status}}
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
    @include('hvl.customermaster._popup')
</section>
@endsection
@section('page-script')
<script>
    $("#download_customer_button").click( function() {
        DownloadExcelFile();
    });
    $("#mail_form").submit( function(e) {
        $(this).append('<input type="hidden" name="branch" value="'+$('#branch').val()+'">');
        $(this).append('<input type="hidden" name="customers_id" value="'+$('#customer_id').val()+'">');
      
        $(this).append('<input type="hidden" name="search_start_date" value="'+$('#search_start_date').val()+'">');
        $(this).append('<input type="hidden" name="search_end_date" value="'+$('#search_end_date').val()+'">');
        var limit = ($('#data_limit').prop('checked')==true)?1:0;
        $(this).append('<input type="hidden" name="data_limit" value="'+ limit +'">');
        return true;
    });
    

    function DownloadExcelFile() {
        var form = document.createElement("form");
        var branch = document.createElement("input"); 
        var customers_id = document.createElement("input"); 
        var search_start_date = document.createElement("input"); 
        var search_end_date = document.createElement("input"); 
        var data_limit = document.createElement("input"); 
        
        document.body.appendChild(form);
        form.method = "POST";
        form.action = "{{route('customer.download_customer')}}";
            branch.name="branch";
            customers_id.name = "customers_id";
            search_start_date.name="search_start_date";
            search_end_date.name="search_end_date";
            data_limit.name="data_limit";

            branch.value=$('#branch').val();
            customers_id.value = $('#customer_id').val();
            search_start_date.value=$('#search_start_date').val();
            search_end_date.value= $('#search_end_date').val();
            data_limit.value = ($('#data_limit').prop('checked')==true)?1:0;
            
            form.appendChild(branch); 
            form.appendChild(customers_id); 
            form.appendChild(search_start_date); 
            form.appendChild(search_end_date);
            form.appendChild(data_limit); 
            form.submit();
    }
</script>
</script>
<script>
    $(document).ready(function () {
        $('#page-length-option').DataTable({
            "scrollX": true,
            "fixedHeader": true,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            dom: 'Blfrtip',
            buttons: [
                'colvis'
            ]
        });
    });
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script>
    $(document).ready(function () {
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
                                    url: '{{route('customer.massdelete')}}',
                                    type: 'POST',
                                    data: {
                                        "_token": token,
                                        ids: checkbox_array,
                                    },
                                    success: function (result) {
                                        if (result === 'error') {
                                            swal({
                                                title: "Customer cannot be deleted as activity is assigned to this customer!",
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

        $(document).on('click', '.button', function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            swal({
                title: "Are you sure you want to delete? ",
                text: "You will not be able to recover this record!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: "{{route('customer.delete')}}",
                                type: "get",
                                data: {
                                    "id": id
                                },
                                success: function (result) {
                                    if (result === 'error') {
                                        swal({
                                            title: "Customer cannot be deleted as activity is assigned to this customer!",
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
        });

    });
    $(document).ready(function () {
        var categCheck = $('#customer_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            nonSelectedText: 'Select Customer',
            maxHeight: 450
        });
        $('#branch').change(function () {
            var eids = $(this).val();
            if (eids) {
                $.ajax({
                    type: "get",
                    url: "/activity-master/get-branch-customer",
                    data: {
                        eids: eids
                    },
                    success: function (res) {
                            $("#customer_id").empty();
                            $.each(res, function (key, value) {
                                var opt = $('<option />', {
                                    value: key,
                                    text: value,
                                });
                                opt.appendTo(categCheck);
                            });
                            categCheck.multiselect('rebuild');
                    }
                });
            }
        });
    });
</script>
@endsection


