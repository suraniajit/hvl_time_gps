 
<?php
if (count($CourseDetails) > 0) {
    ?>
    <table class="display striped">
        <thead>
            <tr>
                <th>Course Name</th>
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
        </tbody>
    </table>
<?php } else { ?>
    <div class="center">
        <h6>Assign Courses Record not found</h6>
    </div>
<?php } ?>