@extends('app.layout')

{{-- page title --}}
@section('title','Zone wise Customer Management | HVL')

@section('vendor-style')

@endsection
@section('content')

    <section>
        <div class="container-fluid">
            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display">Zone wise Customers Management</h2>
                    </div>
                    <div class="col-md-5">
{{--                        @can('Create Activity')--}}
                            <a href="{{route('branch-customer.create')}}" class="btn btn-primary pull-right rounded-pill">Add Zone wise Customer</a>
{{--                        @endcan--}}
                        {{--                        <a class="btn btn-primary rounded-pill pull-right mr-2 " data-toggle="modal" data-target="#modal_download">--}}
                        {{--                            <span class="fa fa-download fa-lg"></span> Download--}}
                        {{--                        </a>--}}

                    </div>


                </div>

            </header>

            <!-- Page Length Options -->
            <div class="card p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show center-block" role="alert">
                        <strong>{!! Session::get('success') !!} </strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif


                <div class="table-responsive mt-4">
                    <table id="page-length-option" class="table table-striped table-hover multiselect">
                        <thead>
                        <tr>
                            <th width="2%">ID</th>
                             <th width="5%">Action</th>
                            <th width="5%">Zone</th>
                            <th width="8%">Branch</th>
                            <th width="12%">Customer Name</th>
                            <th width="8%">Employee</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($details as $zone => $data)

                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    @foreach($data->groupby('zone_id') as $key => $value)
                                    <a href="{{ route('branch-customer.edit', $key) }}"
                                       class="tooltipped mr-10"
                                       data-position="top"
                                       data-tooltip="Edit">
                                        <span class="fa fa-edit"></span>
                                    </a>

{{--                                        @can('Delete Customer')--}}
                                            <a href="" class="button" data-id="{{$key}}"><span class="fa fa-trash"></span></a>
{{--                                        @endcan--}}
                                    @endforeach
                                </td>
                                
                                <td>
                                    <span class="badge badge-primary p-2 m-1">{{$zone}}</span>
                                </td>

                                <td>
                                    @foreach($data->groupby('branch_name') as $key => $value)

                                        <span class="badge badge-success p-2 m-1">{{$key}}</span>
                                    @endforeach

                                </td>
                                <td>
                                    @foreach($data->groupby('customer_name') as $key => $value)
                                        <span class="badge badge-info p-2 m-1">{{$key}}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($data->groupby('emp_name') as $key => $value)
                                        <span class="badge badge-warning p-2 m-1">{{$key}}</span>
                                    @endforeach
                                </td>
                                {{--                                    <td> {{$data->branch_name}} </td>--}}
                                {{--                                    <td> {{$data->customer_name}} </td>--}}
                                {{--                                    <td> {{$data->emp_name}} </td>--}}




                                {{--                                            <a href="{{ route('activity.show_activity', $data->id) }}"--}}
                                {{--                                               class="tooltipped mr-10"--}}
                                {{--                                               data-position="top"--}}
                                {{--                                               data-tooltip="View">--}}
                                {{--                                                <span class="fa fa-eye"></span>--}}
                                {{--                                            </a>--}}
                                {{--                                  --}}
                                {{--                                    --}}


                                {{--                                                --}}
                                {{--                                            @if($data->activity_status != 'Completed')--}}
                                {{--                                                <a href="" class="button" data-id="{{$data->id}}"><span class="fa fa-trash"></span></a>--}}
                                {{--                                            @endif--}}

                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </section>


@endsection


{{-- page script --}}
@section('page-script')
    <script>
        $(document).ready(function () {
            $('#page-length-option').DataTable({
                "scrollX": true,
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
            });
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
                            url: "{{route('branch-customer.delete')}}",
                            type: "get",
                            data: {
                                "id": id
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
        });
    </script>

@endsection
