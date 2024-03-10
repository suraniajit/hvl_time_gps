@extends('app.layout')
@section('title','Google Drives')
@section('vendor-style')
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css">
@endsection

@php
    $AccessGoogleUser = false;
    $ReadGoogleUser   = false;
    $EditGoogleUser   = false;
    $CreateGoogleUser = false;
    $DeleteGoogleUser = false;

@endphp

@can('Access google_drive')
    @php
        $AccessGoogleUser = true;
    @endphp
@endcan
@can('Read google_drive')
    @php
        $ReadGoogleUser = true;
    @endphp
@endcan

@can('Create google_drive')
    @php
        $CreateGoogleUser = true;
    @endphp
@endcan

@can('Edit google_drive')
    @php
        $EditGoogleUser = true;
    @endphp
@endcan
@can('Delete google_drive')
    @php
        $DeleteGoogleUser = true;
    @endphp
@endcan
@section('content')
<section>
    <div class="container-fluid">
        <header>
            <div class="row">
                <div class="col-md-8">
                    <h2 class="h3 display">Google Drives</h2>
                      <h4 class="h3 display">Active Drive :- {{$active_google_users->mail_id}}</h4>
                </div>
                <div class="col-md-4">
                    <a href="{{route('google_drive.create')}}" class="btn btn-primary pull-right rounded-pill">Add Drive</a>
                    <a id="mass_delete_id" class="btn btn-primary pull-right rounded-pill mr-2">
                        <i class="fa fa-trash"></i> Mass Delete
                    </a>
                </div>
            </div>
        </header>
        <div class="card">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">
                                <label>
                                        <input type="checkbox" class="select-all m-1"/>
                                        <span></span>
                                </label>
                            </th>
                            <th scope="col">Action</th>
                            <th scope="col">ID</th>
                            <th scope="col">Mail</th>
                            <th scope="col">Client Id</th>
                            <th scope="col">Client Secret</th>
                        </tr>
                    </thead>
                    <tbody class="grid-data">
                        @if($google_users)
                                @foreach($google_users as $key=>$google_user)
                                <tr>
                                    <td>
                                        <label>
                                            <input type="checkbox" data-id="{{ $google_user->id }}"
                                                name="selected_row"/>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td>
                                        @if($EditGoogleUser)
                                            <a href="{{ route('google_drive.edit', $google_user->id) }}"
                                                class="tooltipped mr-10"
                                                data-position="top"
                                                data-tooltip="Edit"
                                                target="_blank">
                                                    <span class="fa fa-edit"></span>
                                            </a>
                                        @endif
                                        <?php /*
                                        @if($DeleteGoogleUser)
                                            <a href="" class="button" data-id="{{$google_user->id}}">
                                                <span class="fa fa-trash"></span>
                                            </a>
                                        @endif
                                        */
                                        ?>
                                    </td>
                                    <td>{{$key+=1}}</td>
                                    <td align="center">{{$google_user->mail_id}}</td>
                                    <td align="center">{{substr($google_user->client_id,0,40)}}</td>
                                    <td align="center">{{substr($google_user->client_secret,0,40)}}</td>
                                    
                                </tr>
                                @endforeach
                        @else
                        <tr>
                            <td align="center" colspan="4">No Data Found</th>
                        </tr>
                        @endif                        
                    </tbody>
                </table>

                <div class="card">
                    <div class="card-body">
                        {{ $google_users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-script')

<script>
    $(document).ready(function () {
        var checkbox = $('.multiselect tbody tr td input');
        var selectAll = $('.multiselect .select-all');
        checkbox.on('click', function () {
            $(this).parent().parent().parent().toggleClass('selected');
        });
        $('.select').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for Customer...',
            nonSelectedText: 'Select Customer',
            maxHeight: 450
        });
        checkbox.on('click', function () {
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
        // mass delete
       <?php
       /*
        $('#mass_delete_id').click(function () {
            var checkbox_array = [];
            var token = $("meta[name='csrf-token']").attr("content");
            $.each($("input[name='selected_row']:checked"), function () {
                checkbox_array.push($(this).data("id"));
            });
            if (typeof checkbox_array !== 'undefined' && checkbox_array.length > 0) {
                swal({
                    title: "Are you sure, you want to delete? ",
                    text: "You will not be able to recover this record!",
                    type: 'warning',
                    showCancelButton: true,
                    customClass: 'swal-small',
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    url: '{{route("emailtemplate.massdelete")}}',
                                    type: 'POST',
                                    data: {
                                        "_token": token,
                                        ids: checkbox_array,
                                    },
                                    success: function (result) {
                                        swal({
                                            title: "Record has been deleted!",
                                            type: "success",
                                        }, function () {
                                            loadPageGrid();
                                        });
                                    }
                                });
                            }
                        });
            } else {
                swal({
                    title: "Please Select Atleast One Record",
                    type: 'warning',
                    customClass: 'swal-small',
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
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "{{route('emailtemplate.delete')}}",
                        type: "get",
                        data: {
                            "id": id
                        },
                        success: function (result) {
                            swal({
                                title: "Record has been deleted!",
                                type: "success",
                            }, function () {
                                loadPageGrid();
                            });
                        }
                    });
                }
            });
        });
        */
        ?>
    });
</script>
@endsection

