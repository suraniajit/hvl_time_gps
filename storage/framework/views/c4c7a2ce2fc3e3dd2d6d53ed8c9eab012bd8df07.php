



<?php $table_name = str_replace('_', ' ', $table); ?>

<?php $pagetitle = ($table_name == 'Rating')?'Geographical Segment':ucfirst($table_name); ?>
<?php $__env->startSection('title', $pagetitle.' | HVL'); ?>


<?php $__env->startSection('vendor-style'); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
$user = auth()->user();
?>
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?php echo e(url('/')); ?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <?php if($table_name == 'LeadSource'): ?>
                        Lead Source
                    <?php elseif($table_name == 'LeadStatus'): ?>
                        Lead Status
                    <?php elseif($table_name == 'activitystatus'): ?>
                        Activity Status
                    <?php elseif($table_name == 'activitytype'): ?>
                        Activity Type
                    <?php elseif($table_name == 'Rating'): ?>
                        Geographical Segment
                    <?php else: ?>
                    <?php echo e(ucfirst($table_name)); ?>

                        <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <header>
                <div class="row">
                    <div class="col-md-4">
                        <h2 class="h3 display">
                            <?php if($table_name == 'LeadSource'): ?>
                                Lead Source
                            <?php elseif($table_name == 'LeadStatus'): ?>
                                Lead Status
                            <?php elseif($table_name == 'activitystatus'): ?>
                                Activity Status
                            <?php elseif($table_name == 'activitytype'): ?>
                                Activity Type
                            <?php elseif($table_name == 'Rating'): ?>
                                Geographical Segment
                            <?php else: ?>
                            <?php echo e(ucfirst($table_name)); ?></h2>
                            <?php endif; ?>

                    </div>
                    <div class="col-md-8">
                        <a href="<?php echo e(url('/modules/module/' . $table . '/create')); ?>" class="btn btn-primary pull-right rounded-pill ">Add New</a>
                        
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete '.$table_name )): ?>
                        <a id="mass_delete_id" class="btn btn-primary pull-right rounded-pill mr-2">
                            <i class="fa fa-trash"></i> Mass Delete
                        </a>
                        <?php endif; ?>
                        <a class="btn btn-primary rounded-pill pull-right mr-2 " data-toggle="modal" data-target="#modal_download">
                            <span class="fa fa-download fa-lg"></span> Download
                        </a>
                            <?php if($table_name == 'employees'): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access Employee Bulkupload')): ?>
                                <a href="<?php echo e(route('admin.employeemaster_bulkupload.index')); ?>" class="btn btn-primary pull-right rounded-pill mr-2">
                                <span class="fa fa-upload fa-lg"></span> Bulk Upload
                                </a>
                                <?php endif; ?>
                            <?php endif; ?>
                    </div>
                </div>
            </header>

            <div class="card">
                <div class="card-body p-4">
                   
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="page-length-option" class="table table-striped table-hover multiselect nowrap">
                <thead>
                <tr>
                    <th width="2%">
                        <label>
                            <input type="checkbox" class="select-all"/>
                            <span></span>
                        </label>
                    </th>
                    <th class="sorting_disabled" width="5%">Action</th>
                    <?php $__currentLoopData = $filter_columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = json_decode($forms->form); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($column->type !== 'file'): ?>
                                <?php if($column->type !== 'section'): ?>
                                    <?php if($column->label == 'Select Department'): ?>
                                        <th width="10%">Departments</th>
                                    <?php elseif($column->label == 'Select Designation'): ?>
                                        <th width="10%">Designation</th>
                                    <?php elseif($column->label == 'Select Team'): ?>
                                        <th width="10%">Team</th>
                                    <?php elseif($column->label == 'select city'): ?>
                                        <th width="10%">City</th>
                                    <?php elseif($column->label == 'zone'): ?>
                                       <th width="10%">Zone</th>
                                    <?php else: ?>
                                    <th width="10%"><?php echo e(str_replace('_', ' ', $column->label)); ?></th>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($module_name == 'employees'): ?>
                        <th width="10%">Created Date</td>
                        <th width="10%">Updated Date</td>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td width="2%">
                            <label>
                                <input type="checkbox" data-id="<?php echo e($row->id); ?>"
                                       name="selected_row"/>
                                <span></span>
                            </label>
                        </td>
                        <td width="10%" >
                        <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($column === 'id'): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit '.$table_name)): ?>
                                    <a href="<?php echo e(route('modules.module.edit', [$table, $row->$column])); ?>"
                                        class="p-2">
                                        <span class="fa fa-edit"></span>
                                    </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete '.$table_name)): ?>
                                    <?php if($table_name == 'employees'): ?>
                                        <?php if($row->$column != 121): ?>
                                            <a href="" class="button" data-id="<?php echo e($row->$column); ?>"  data-name="<?php echo e($table); ?>">
                                                <span class="fa fa-trash"></span>
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a href="" class="button" data-id="<?php echo e($row->$column); ?>"  data-name="<?php echo e($table); ?>">
                                            <span class="fa fa-trash"></span>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <?php $__currentLoopData = $filter_columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = json_decode($forms->form); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($column->type !== 'file'): ?>
                                    <?php if($column->type !== 'section'): ?>
                                        <?php $label = str_replace(' ', '_', $column->label) ?>
                                        <?php if($column->type === 'lookup'): ?>
                                            <?php $tableDatas = DB::table($column->module)->where('id', $row->$label)->first(); ?>
                                            <td width="10%">
                                                <?php if(!empty($tableDatas)): ?>
                                                    <?php echo e($tableDatas->Name); ?>

                                                <?php endif; ?>
                                            </td>
                                        <?php else: ?>
                                            <td width="10%">
                                                <?php if( $row->$label == 'email'): ?>
                                                    Email ID
                                                <?php else: ?>
                                                <?php echo e($row->$label); ?>

                                                    <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($module_name == 'employees'): ?>
                        <td width="10%"><?php echo e($row->created_at); ?></td>
                        <td width="10%"><?php echo e($row->updated_at); ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
</div>


                </div>
            </div>



        <div id="modal_download" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Download Report</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body p-4 row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body text-center ">
                                    <button class="btn btn-success " onclick="exportTableToCSV('Report.csv')">
                                        <span class="fa fa-file-excel-o fa-3x text-green"></span>
                                        CSV
                                    </button>
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-6">
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
        <div id="email_div" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Send Mail</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body p-4 row">
                        <div class="col-sm-12">
                            <form action="<?php echo e(route('mail.sendcsv')); ?>" method="post" id="mail_form" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="">To</label>
                                        <input type="email" class="form-control"  name="to" required>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="">CC</label>
                                        <input type="email" class="form-control"  name="cc">
                                    </div>

                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="">BCC</label>
                                        <input type="email" class="form-control"  name="bcc">
                                    </div>

                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="">Subject</label>
                                        <input type="text"  class="form-control"  name="subject" required>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="">Body</label>
                                        <textarea class="form-control" name="body"></textarea>
                                    </div>

                                    <div class="col-sm-12">

                                        <input type="submit" class="btn btn-success rounded" value="Send">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('vendor-script'); ?>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('page-script'); ?>

<script>
    $(document).ready(function() {

        $('#page-length-option').DataTable({
            "scrollX": true,
        });
    });
                    $(document).ready(function () {
//                       $('#theme-cutomizer-out').hide();
//                         $('.modal').modal();

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
                                        title: "Are you sure, you want to delete " + name + "? ",
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
                                            url: 'massdestroy',
                                            type: 'POST',
                                            data: {
                                                "_token": token,
                                                ids: checkbox_array,
                                                table: '<?php echo e($table); ?>'
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
                            var name = $(this).data("name");
                       
                            var token = $("meta[name='csrf-token']").attr("content");

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
                                        url: name + "/" + id,
                                        type: 'DELETE',
                                        data: {
                                            "_token": token,
                                            "name":name,
                                            "id":id
                                        },
                                        success: function (result) {
                                            if(result === 'error')
                                            {
                                                swal({
                                                    title: "Employee cannot be deleted as customer is assigned to this employee",
                                                    type: "warning",
                                                })
                                            }
                                            else if(result === 'zone_error')
                                            {
                                                swal({
                                                    title: "Zone cannot be deleted as branch is assigned to this zone",
                                                    type: "warning",
                                                })
                                            }
                                            else{
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


                        var checkbox = $('.multiselect tbody tr td input');
                        var selectAll = $('.multiselect .select-all');

                        checkbox.on('click', function () {
                            $(this).parent().parent().parent().toggleClass('selected');
                        });

                        checkbox.on('click', function () {
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
                                    }).prop('name', '');
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp_7.4.19\htdocs\web_project\HVL_Mar2024\resources\views/module/index.blade.php ENDPATH**/ ?>