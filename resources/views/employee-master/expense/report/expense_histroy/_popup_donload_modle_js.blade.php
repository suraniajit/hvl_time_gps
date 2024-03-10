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
        //location.reload();
    };

    function downloadCSV(csv, filename) {
        $('.resubmited_popu').remove();
        $('.resubmit_span').remove();
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
        location.reload();
    }

    function exportTableToCSV(filename) {
        $('.resubmited_popu').remove();
        $('.resubmit_span').remove();
        var csv = [];
        var rows = document.querySelectorAll("table tr");


        for (var i = 1; i < rows.length; i++) {
            var row = [],
                    cols = rows[i].querySelectorAll("td, th");

            for (var j = 0; j < cols.length; j++)
                if (j !== 0) {
                    if (j !== cols.length - 0) {
                        row.push(cols[j].innerText);
                    }
                }

            csv.push(row.join(","));
        }
        // alert(csv.join("\n"));
        // Download CSV file
        downloadCSV(csv.join("\n"), filename);
        location.reload();
    }

    function exportTableToPDF() {
        $('.resubmited_popu').remove();
        $('.resubmit_span').remove();

        var pdf = new jsPDF('p', 'pt', 'letter');
        pdf.cellInitialize();
        pdf.setFontSize(10);

        $.each($('table tr'), function (i, row) {
            var total = $(row).find("td, th").length;

            $.each($(row).find("td, th"), function (j, cell) {
                if (j !== 2) {
                    if (j !== (total - 1)) {
                        var txt = $(cell).text().trim() || " ";
                        var txtWidth = pdf.splitTextToSize(txt, 100);
                        var width = 100;
                        pdf.cell(10, 20, width, 30, txtWidth, i);
                    }
                }
            });
        });

        pdf.save('sample-file.pdf');
        location.reload();
    }

</script>