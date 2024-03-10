<div class="table-responsive">
    <table id="page-length-option_submited" class="table table-striped table-hover multiselect">
        <thead>
            @include('employee-master.expense.admin_filter._comm_head')
        </thead>
        <tbody>
            @foreach($expenses_details_normal as $key => $detaile)
            @include('employee-master.expense.admin_filter._comm_data')
            @endforeach
        </tbody>
    </table>
</div>



<script>
    $(document).ready(function () {
        $('#page-length-option_submited').DataTable({
            "scrollX": true
        });
    });
</script>