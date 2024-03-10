{{-- layout --}}
@extends('app.layout')

{{-- page title --}}
@section('title','Expense Management')
@section('vendor-style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<style>
    /* Tabs */
    .tabs {

        background-color: #09F;
        border-radius: 5px 5px 5px 5px;
    }
    ul#tabs-nav {
        list-style: none;
        margin: 0;
        padding: 5px;
        overflow: auto;
    }
    ul#tabs-nav li {
        float: left;
        font-weight: bold;
        margin-right: 2px;
        padding: 8px 10px;
        border-radius: 5px 5px 5px 5px;
        /*border: 1px solid #d5d5de;
        border-bottom: none;*/
        cursor: pointer;
    }
    ul#tabs-nav li:hover,
    ul#tabs-nav li.active {
        background-color: #08E;
    }
    #tabs-nav li a {
        text-decoration: none;
        color: #FFF;
    }
    .tab-content {
        padding: 10px;
        border: 5px solid #09F;
        background-color: #FFF;
    }
    section header {
        padding-top: 0rem;
        padding-bottom: 0rem;
    }
</style>
@endsection
@section('content') 
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{route('expense_report')}}">Expense Report </a></li>
        </ul>
    </div>
</div>
<section>
    <div class="card">
        <div class="card-body p-4">
            <header>
                <div class="row">
                    <div class="col-md-4">
                        <h2 class="h3 display"> Expense History </h2>
                    </div>
                    <div class="col-md-8" style="display: none;">
                        <a style="float: inline-end;" class="btn btn-primary mr-1" data-toggle="modal" data-target="#modal_download"> <span class="fa fa-download fa-lg"></span> Download </a>

                    </div>
                </div>
            </header>
            <br>
            <!--===============================================-->
            @include('employee-master.expense.report.index_filter')
            @include('employee-master.expense.report.index_admin_details')
        </div>
    </div>
</section>



<div id="modal_download" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Download Report</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body p-4 row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body text-center ">
                            <button class="btn btn-success " onclick="exportTableToCSV('Report.csv')">
                                <span class="fa fa-file-excel-o fa-3x text-green"></span>
                                CSV
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6" style="display:none;">
                    <div class="card">
                        <div class="card-body text-center">
                            <button class="btn btn-primary center" data-toggle="modal" data-target="#email_div">
                                <span class="fa fa-envelope fa-3x text-danger"></span>
                                Email
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection


{{-- page script --}}
@section('page-script')
<script>
    $(document).ready(function () {

        $('#payment_status_id_search').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            nonSelectedText: 'Select Status',
            maxHeight: 450
        });
        $('#employee_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            nonSelectedText: 'Select Employee',
            maxHeight: 450
        });

// Show the first tab and hide the rest
        $('#tabs-nav li:first-child').addClass('active');
        $('.tab-content').hide();
        $('.tab-content:first').show();

// Click function
        $('#tabs-nav li').click(function () {
            $('#tabs-nav li').removeClass('active');
            $(this).addClass('active');
            $('.tab-content').hide();

            var activeTab = $(this).find('a').attr('href');
            $(activeTab).fadeIn();
            return false;
        });
        $('#page-length-option_combination').DataTable({
            "scrollX": true
        });


        $('.delete-record-click').click(function () {
            var id = $(this).data("id");
            var name = 'Expense';
            var token = $("meta[name='csrf-token']").attr("content");
            swal({
                title: "Are you sure? ",
                text: "You will not be able to recover this record!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '/expense/removedata/',
                        type: 'get',
                        data: {
                            "_token": token,
                            'id': id,
                            'delete': 'expance_details',
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script>
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
    };

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

        for (var i = 1; i < rows.length; i++) {
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

