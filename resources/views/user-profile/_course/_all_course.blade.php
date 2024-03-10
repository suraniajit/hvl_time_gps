<style>
    table, th, td {
        border: 1px solid black;
    }
    .btn-flat {
         color: #fff !important; 
    }
</style>

<table class="display striped">
    <thead>
        <tr>

            <th>All Course Name</th>
            <!--<th>Category</th>-->
            <th>End Date</th>
            <th>Passing Criteria(%)</th>
            <th>Increase Passing Criteria by (%)</th>
            <th>Result</th>
            <th>%</th>
            <th>Attempts</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @include('user-profile._course._loop_course')
        @include('user-profile._course._loop_simulation')
    </tbody>
</table>
