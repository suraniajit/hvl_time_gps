
{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
 
{{-- page title --}}
@section('title','Candidate Management')

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
@endsection


{{-- page content --}}
@section('content')


<?php
use App\Employee;
use App\Module;
use App\User;
?>
<div class="card">
    <div class="card-content">
        <div class="row">
            <div class="col s8">
                <h5>
                    {{ucfirst($table_name) }} Information
                </h5>
            </div>
            <div class="col s4">
                @can('Edit '.str_replace('_', ' ', $table_name))
                <a class="btn-floating activator waves-light green accent-0 z-depth-0 right"
                   data-tooltip="edit"
                   href="{{ route('modules.module.edit', [str_replace(' ', '_', $table_name), $table_data->id]) }}">
                    <i class="material-icons">edit</i>
                </a>
                @endcan
            </div>
        </div>


        <div class="card-content">
            <div class="row">


                <div class="row">

                    @if($table_name === 'employees')
                    @php $employees = \App\Employee::find($table_data->id) @endphp
                    <!--                    <div class="input-field col s4"> 
                    
                                            <strong> Email </strong>: {{ $table_data->email }}
                    
                                        </div>-->
                    <!--                    <div class="input-field col s4"> 
                                            <strong> Departments : </strong>
                                            @if(isset($employees->departments))
                                            @foreach($employees->departments as $dep)
                                            <a href="{{ route('modules.module.show', ['departments', $dep->id]) }}"
                                               class="collection-item">
                                                <span class="new badge gradient-45deg-light-blue-cyan"
                                                      data-badge-caption="{{ $dep->Name }}"></span>
                                            </a>
                                            @endforeach
                                            @endif
                                        </div>-->


                    <!--                    <div class="input-field col s4"> 
                                            <strong> Teams: </strong>
                                            @if(isset($employees->teams))
                                            @foreach($employees->teams as $team)
                                            <a href="{{ route('modules.module.show', ['teams', $team->id]) }}"
                                               class="collection-item">
                                                <span class="new badge gradient-45deg-light-blue-cyan"
                                                      data-badge-caption="{{ $team->Name }}"></span>
                                            </a>
                                            @endforeach
                                            @endif
                                        </div>-->

                    <!--                    <div class="input-field col s4"> 
                                            <strong>  Designations: </strong> 
                                            @if(isset($employees->designations))
                                            @foreach($employees->designations as $des)
                                            <a href="{{ route('modules.module.show', ['designations', $des->id]) }}"
                                               class="collection-item">
                                                <span class="new badge gradient-45deg-light-blue-cyan"
                                                      data-badge-caption="{{ $des->Name }}"></span>
                                            </a>
                                            @endforeach
                                            @endif
                                        </div>-->


                    @endif


                    @if($table_name === 'departments')
                    @php $department = \App\Department::find($table_data->id) @endphp

                    <div class="input-field col s4">
                        <strong>  Employees:</strong> 
                        @foreach($department->employees as $emp)
                        <a href="{{ route('modules.module.show', ['employees', $emp->id]) }}"
                           class="collection-item">
                            <span class="new badge gradient-45deg-light-blue-cyan"
                                  data-badge-caption="{{ $emp->Name }}"></span>
                        </a>
                        @endforeach
                    </div> 

                    @endif

                    @if($table_name === 'teams')
                    @php $team = \App\Team::find($table_data->id) @endphp

                    <div class="input-field col s4">
                        <strong>   Employees: </strong> 
                        @foreach($team->employees as $emp)
                        <a href="{{ route('modules.module.show', ['employees', $emp->id]) }}"
                           class="collection-item">
                            <span class="new badge gradient-45deg-light-blue-cyan"
                                  data-badge-caption="{{ $emp->Name }}"></span>
                        </a>
                        @endforeach
                    </div>

                    @endif

                    @if($table_name === 'designations')
                    @php $designation = \App\Designation::find($table_data->id) @endphp

                    <div class="input-field col s4">
                        <strong>    Employees: </strong> 
                        @foreach($designation->employees as $emp)
                        <a href="{{ route('modules.module.show', ['employees', $emp->id]) }}"
                           class="collection-item">
                            <span class="new badge gradient-45deg-light-blue-cyan"
                                  data-badge-caption="{{ $emp->Name }}"></span>
                        </a>
                        @endforeach
                    </div>


                    @endif

                    <?php $i = 0; ?>
                    @foreach ($fields as $field)
                    @include('module._emp-detail')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($table_name === 'Customers') { ?>
    <div class="card">
        <div class="card-content">


            <div class="row">
                <div class="col s12 m6 l6">
                    <h5 class="title-color"><span>Service List</span></h5>
                </div>


                <div class="col s12 m6 l6 right-align-md">
                    <ul class="breadcrumbs mb-0">
                        <li class="breadcrumb-item">
                            <a class="btn mb-1 mr-1 waves-light cyan modal-trigger" href="#download_modal">
                                <i class="material-icons left">get_app</i>
                                Download
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="section section-data-tables">


                <?php $results = App\Http\Controllers\recruitment\CandidateController::getCustomerDetails($table_data->id); ?>
                <table id="page-length-option" class="display multiselect">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Comment</th>
                            <th>Employee</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($results as $key => $data) { ?>
                            <tr>
                                <th>{{$key+=1}}</th>
                                <th> {{$data->start_date}} </th>
                                <th> {{$data->end_date}} </th>
                                <th> {{$data->type}} </th>
                                <th> {{$data->status}} </th>
                                <th> {{$data->comment}} </th>
                                <th> {{$data->emp_name}} </th>
                                <th>
                                    <a href="#" class="tooltipped delete-record-click" data-position="top" data-tooltip="Delete" data-id="{{ $data->id }}">
                                        <span class="material-icons">delete</span>
                                    </a>
                                    <a href="{{ route('recruitment.candidate.edit_activity', $data->id) }}"
                                       class="tooltipped mr-10"
                                       data-position="top"
                                       data-tooltip="View">
                                        <span class="material-icons">edit</span>
                                    </a>
                                     
                                </th>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>



    <div id="download_modal" class="modal" style="width: 25%">
        <div class="modal-content">
            <h5>Download</h5>
            <p>Choose report download format</p>
            <div class="row center">
                <div class="col s6">
                    <button class="white" onclick="exportTableToCSV('members.csv')">
                        <div class="card box-shadow-none">
                            <div class="card-content">
                                <div class="center">
                                    <span class="material-icons cyan-text" style="font-size: 50px">description</span>
                                </div>
                            </div>
                            <div class="center">
                                <div class="black-text">
                                    CSV
                                </div>
                            </div>
                        </div>

                    </button>
                </div>
                <div class="col s6">
                    <button class="white" onclick="exportTableToPDF()">
                        <div class="card box-shadow-none">
                            <div class="card-content">
                                <div class="center">
                                    <span class="material-icons  cyan-text"
                                          style="font-size: 50px">picture_as_pdf</span>
                                </div>
                            </div>
                            <div class="center">
                                <div class="black-text">
                                    PDF
                                </div>
                            </div>
                        </div>

                    </button>
                </div>

            </div>

            <div class="row" id="email_div" hidden>
                <div class="col s12">
                    <div class="mt-10">
                        <h5>Send Mail</h5>
                        <form action="{{ route('mail.sendcsv') }}" method="post" id="mail_form" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="input-field col s12 mt-2 mb-2">
                                    <label for="">To</label>
                                    <input type="email" name="to" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 mt-2 mb-2">
                                    <label for="">CC</label>
                                    <input type="email" name="cc">
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 mt-2 mb-2">
                                    <label for="">BCC</label>
                                    <input type="email" name="bcc">
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 mt-2 mb-2">
                                    <label for="">Subject</label>
                                    <input type="text" name="subject" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 mt-2 mb-2">
                                    <label for="">Body</label>
                                    <textarea class="materialize-textarea" name="body"></textarea>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 mt-0 mb-0">
                                        <button class="btn cyan  waves-light right" type="submit">
                                            Send
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php } ?>  

 @endsection

{{-- vendor script --}}
@section('vendor-script')

 <script src="{{asset('js/materialize.js')}}"></script>
<script src="{{asset('js/ajax/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/scripts/form-select2.js')}}"></script>
<script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/dropify/js/dropify.min.js')}}"></script>

<script src="{{ asset('vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}"></script>


<!-- END THEME  JS-->
<script src="{{ asset('js/scripts/data-tables.js') }}"></script>
<script src="https://cdn.datatables.net/colreorder/1.5.2/js/dataTables.colReorder.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>


<style>

    .dataTables_wrapper .dataTables_info{
        text-align: center !important;
    }
</style>

 
<script>
                    $(document).ready(function () {

                        $('.delete-record-click').click(function () {
                            var id = $(this).data("id");
                            var name = 'Candidates';
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
                                        url: '/recruitment/candidate/hvi_hisrty_delete',
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




                        $('.modal').modal();



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


                        $("#reset").click(function () {
                            window.location.href = window.location.href.split('?')[0];
                        });
                        $('#filter_form_id').submit(function () {
                            $(this)
                                    .find('input[name]')
                                    .filter(function () {
                                        return !this.value;
                                    })
                                    .prop('name', '');
                        });

                        $('#savefilter-cancel').on('click', function () {
                            $('#save-filter').hide();
                            $('#filter').show();
                        });

                        $('.rename_savefilter').on('click', function () {
                            var filter_name = $(this).data('filtername');
                            var filter_id = $(this).data('filterid');
                            $("#update_filter_name").val(filter_name);
                            $("#update_filter_id").val(filter_id);
                        });

                        $('#email_toggle_btn').click(function () {
                            $('#email_div').toggle();
                        });


// attach file to mail
// var pdf = new jsPDF('p', 'pt', 'letter');
//
// pdf.cellInitialize();
// pdf.setFontSize(10);
// $.each($('table tr'), function (i, row) {
//     var total = $(row).find("td, th").length;
//     $.each($(row).find("td, th"), function (j, cell) {
//         if (j !== 0) {
//             if (j !== total - 1) {
//                 var txt = $(cell).text().trim() || " ";
//                 var txtWidth = pdf.splitTextToSize(txt, 100);
//                 var width = 100;
//                 pdf.cell(30, 30, width, 30, txtWidth, i);
//             }
//         }
//     });
// });
//
// var pdfBase64 = pdf.output('datauristring');
// var data = pdfBase64.match(/base64,(.+)$/);
// var base64String = data[1];
//
// var input = $("<input>")
//     .attr("type", "hidden")
//     .attr("name", "pdffile").val(base64String);
// $('#mail_form').append(input);

                        var csv = [];
                        var rows = document.querySelectorAll("table tr");

                        for (var i = 0; i < rows.length; i++) {
                            var row = [],
                                    cols = rows[i].querySelectorAll("td, th");

                            for (var j = 0; j < cols.length; j++)
                                if (j !== 0) {
                                    if (j !== cols.length - 1) {
                                        row.push(cols[j].innerText);
                                    }
                                }

                            csv.push(row.join(","));
                        }
                        var csvFile;

                        csvFile = new Blob([csv.join("\n")], {
                            type: "text/csv"
                        });
                        var reader = new FileReader();
                        reader.readAsDataURL(csvFile);
                        reader.onloadend = function () {

                            var base64data = reader.result;
                            var data = base64data.match(/base64,(.+)$/);
                            var base64String = data[1];

                            var input = $("<input>")
                                    .attr("type", "hidden")
                                    .attr("name", "csvfile").val(base64String);
                            $('#mail_form').append(input);
                        }


                    });




                    function downloadCSV(csv, filename) {
                        var csvFile;
                        var downloadLink;

// CSV file
                        csvFile = new Blob([csv], {
                            type: "text/csv"
                        });

// Download link
                        downloadLink = document.createElement("a");

// File name
                        downloadLink.download = filename;

// Create a link to the file
                        downloadLink.href = window.URL.createObjectURL(csvFile);

// Hide download link
                        downloadLink.style.display = "none";

// Add the link to DOM
                        document.body.appendChild(downloadLink);

// Click download link
                        downloadLink.click();
                    }

                    function exportTableToCSV(filename) {
                        var csv = [];
                        var rows = document.querySelectorAll("table tr");

                        for (var i = 0; i < rows.length; i++) {
                            var row = [],
                                    cols = rows[i].querySelectorAll("td, th");

                            for (var j = 0; j < cols.length; j++)
                                if (j !== 0) {
                                    if (j !== cols.length - 1) {
                                        row.push(cols[j].innerText);
                                    }
                                }

                            csv.push(row.join(","));
                        }

// Download CSV file
                        downloadCSV(csv.join("\n"), filename);
                    }

                    function exportTableToPDF() {
                        var pdf = new jsPDF('p', 'pt', 'letter');

                        pdf.cellInitialize();
                        pdf.setFontSize(10);
                        $.each($('table tr'), function (i, row) {
                            var total = $(row).find("td, th").length;
                            $.each($(row).find("td, th"), function (j, cell) {
                                if (j !== 0) {
                                    if (j !== total - 1) {
                                        var txt = $(cell).text().trim() || " ";
                                        var txtWidth = pdf.splitTextToSize(txt, 100);
                                        var width = 100;
                                        pdf.cell(30, 30, width, 30, txtWidth, i);
                                    }
                                }
                            });
                        });

                        pdf.save('sample-file.pdf');
                    }



</script>