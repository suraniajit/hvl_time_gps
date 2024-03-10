<div class="table-responsive">
    <table id="page-length-option_normal" class="table table-striped table-hover multiselect">
        <thead>
            @include('employee-master.expense.employee_filter._comm_head')
        </thead>
        <tbody>
            @foreach($expenses_details as $key => $details_normal)
            @include('employee-master.expense.employee_filter._comm_data')
            @endforeach
        </tbody>
    </table>
</div>


<script>
    $(document).ready(function () {
        $('#page-length-option_normal').DataTable({
            "scrollX": true
        });
    });
</script>