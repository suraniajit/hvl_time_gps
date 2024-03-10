{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Report Management')

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


@section('content')
<div class="section section-data-tables">
    <div class=" ">
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
                    <h5 class="title-color"><span>Report Management</span></h5>
                </div>
            </div>
            <div class="row">

                <div class="col s12 m6 l6 right-align-md hide">
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

            <!-- Page Length Options -->


            <div class="section section-data-tables">


                <table id="page-length-option" class="display multiselect">
                    <thead>
                        <tr>

                            <th>
                                <label>
                                    <input type="checkbox" class="select-all"/>
                                    <span></span>
                                </label>
                            </th>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Employee Name</th>
                            <th>Email</th>
                            
                            <th>Location</th>
                             <th class="sorting_disabled" width="8%">Action</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach($customer_report as $key => $row)
                        <?php
                        $results = App\Http\Controllers\recruitment\CandidateController::getcityNameByCityId($row->Select_City);
                        ?>
                        <tr>
                            <td>
                                <label>
                                    <input type="checkbox" data-id="{{ $row->id }}" name="selected_row"/> <span></span>
                                </label>
                            </td>

                            <td>{{$key+=1}}</td>
                            <td>{{$row->Name}}</td>
                            <td> 

                                <?php
                                $getEmpDetailsbyUser_id = DB::table('employees')->select('Name')->where('user_id', $row->user_id)->get();
                                if (count($getEmpDetailsbyUser_id) > 0) {
                                    echo $getEmpDetailsbyUser_id[0]->Name;
                                } else {
                                    echo 'Emp deleted';
                                }
                                ?>
                            </td>
                            <td>{{$row->Email_ID}}</td>
                            
                            <td>{{$results[0]->city_name}}</td>
                             <td>
                                <a href="/modules/module/Customers/{{$row->id}}" class="tooltipped mr-10" data-position="top" data-tooltip="View">
                                    <span class="material-icons">visibility</span>
                                </a>

                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
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
@endsection

{{-- vendor script --}}
@section('vendor-script')

<script src="{{asset('js/ajax/jquery.min.js')}}"></script>
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

@endsection

{{-- page script --}}
@section('page-script')
<script>
                    $(document).ready(function () {
//                       $('#theme-cutomizer-out').hide();
                        $('.modal').modal();




                        $('.delete-record-click').click(function () {
                            var id = $(this).data("id");
                            var name = $(this).data("name");
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
                                        url: name + "/" + id,
                                        type: 'DELETE',
                                        data: {
                                            "_token": token,
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
//					swal(name + " Record is safe", {
//						title: 'Cancelled',
//						icon: "error",
//					});
                                }
                            });
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
@endsection
