 
<div class="table-responsive">
    <table id="page-length-option_complited" class="table table-striped table-hover multiselect">
        <thead>
            @include('employee-master.expense.admin_filter._comm_head')
        </thead>
        <tbody>
            @foreach($expenses_details_complited as $key => $detaile)
            @include('employee-master.expense.admin_filter._comm_data')
            @endforeach
        </tbody>
    </table>
</div>





<script>
    $(document).ready(function () {
        $('#page-length-option_complited').DataTable({
            "scrollX": true
        });
    });
</script>