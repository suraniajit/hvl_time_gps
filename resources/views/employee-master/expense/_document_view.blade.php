<?php if (count($account_detaile_file) > 0) { ?>
<h6>Upload Bills / Documents##</h6>
<br>
<div class="row">
    <?php
    foreach ($account_detaile_file as $key => $files) {
        ?>
        <div class="" style="margin-right: 16px; text-align: center;">
            @include('employee-master.expense.__file_extension')
        </div>
    <?php } ?>
</div>
<?php } else { ?>
    Document Not Uploaded
<?php } ?>