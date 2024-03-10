
<script>
    $(document).ready(function () {
        
        
        
        $('#page-length-option').DataTable({
            "scrollX": true,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            dom: 'Blfrtip',
            buttons: [
                'colvis'
            ]
        });
        
        var statusCheck = $('#status_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            nonSelectedText: 'Select status',
            maxHeight: 450
        });
        
        
        var categCheck = $('#customer_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            nonSelectedText: 'Select Customer',
            maxHeight: 450
        });
        
        $('.addJob_button').click(function () {
            var activity_id= $(this).attr('data-id');
            $('#addJobId').val(activity_id);
        });
        
        $('.create_audit_report').click(function () {
            var activity_id= $(this).attr('data-id');
            $('#auditreport_id').val(activity_id);
        });
        

        $('.send_audit_email').click(function () {
            var mail_customer = $(this).attr('data-customer_id');    
            var mail_act_id = $(this).attr('data-id');
            var mail_start_date = $(this).attr('data-start_date');
            var mail_end_date = $(this).attr('data-end_date');
          
            $('#mail_body').html("Start Date : "+ mail_start_date + " End Date : "+ mail_end_date + "     Customer : "+ mail_customer);
            $('#mail_act_id').val(mail_act_id);
            $('#mail_customer').val(mail_customer);

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
<script>
    $(document).ready(function () {
        $('.select').multiselect({
            // includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for Customer...',
            nonSelectedText: 'Select Customer',
            maxHeight: 450
        });
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
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
                        url: "{{route('activity.massdelete')}}",
                        type: 'POST',
                        data: {
                            "_token": token,
                            ids: checkbox_array,
                        },
                        success: function (result) {
                            if (result === 'error') {
                                swal({
                                    title: "Activity cannot be deleted as Job card or Audit report is assigned to this activity!",
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
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "{{route('activity.hvi_hisrty_delete')}}",
                    type: "get",
                    data: {
                        "id": id
                    },
                    success: function (result) {
                        if (result === 'error') {
                            swal({
                                title: "Activity cannot be deleted as Job card or Audit report is assigned to this activity!",
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
                if (j !== 0  && j !== 2   && j!==17 && j!==19 && j!==20) {
                    if (j !== cols.length - 0) {
                        row.push(cols[j].innerText);
                    }
                }
            csv.push(row.join(","));
        }
        // Download CSV file
        downloadCSV(csv.join("\n"), filename);
    }
</script>