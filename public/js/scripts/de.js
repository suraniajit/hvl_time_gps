$(document).ready(function () {

    $('.delete-record-click').click(function () {
        var id = $(this).data("id");
        var name = 'customer Services';
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

