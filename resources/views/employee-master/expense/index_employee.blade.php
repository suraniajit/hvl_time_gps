
@include('employee-master.expense.employee_filter.dashboard.report_dashboard')
 
 
<div class="tabs">
    <ul id="tabs-nav">
        <li><a href="#tab1">All Expenses</a></li>
        <li><a href="#tab2">Submitted Expenses</a></li>
        <?php if ($combined_submission == '2') { ?>
            <li><a href="#tab3">Drafted Expenses</a> </li>
        <?php } ?>
        <li><a href="#tab4">Approved Expenses</a></li>
        <li><a href="#tab5">Resubmit Expenses</a></li>
    </ul> <!-- END tabs-nav -->
    <div id="tabs-content">
        <div id="tab1" class="tab-content">
            <h2>All Expenses</h2>
            @include('employee-master.expense.employee_filter.all_emp')
        </div>
        <div id="tab2" class="tab-content">
            <h2>Submitted Expenses</h2>
            @include('employee-master.expense.employee_filter.submit_emp')
        </div>
        <?php if ($combined_submission == '2') { ?>
            <div id="tab3" class="tab-content">
              
                <header>
                    
                        <div class="row">
                        <div class="col-md-7">
                            <h2 class="h3 display">Drafted Expenses </h2>
                            
                        </div>
                        <div class="col-md-5">
                   
                        <a onclick="combinationAction();" class="btn btn-primary pull-right rounded-pill" style="display: {{($combined_submission=='2')? "" : "none"}}">
                                Submit for Approval
                            </a>
                        </div>
                    </div>
                </header>
                <div class=" ">
                        <span>
                            <input type='checkbox' class="btn btn-primary rounded-pill" id='CheckAll'> Select All
                            </span>
                </div>
                         
                        <br>
                @include('employee-master.expense.employee_filter.draft_emp')
            </div>
        <?php } ?>
        <div id="tab4" class="tab-content">
            <h2>Approved Expenses</h2>
            @include('employee-master.expense.employee_filter.complited_emp')
        </div>
        <div id="tab5" class="tab-content">
            <h2>Resubmit Expenses</h2>
            @include('employee-master.expense.employee_filter.resubmit_exp')
        </div>
    </div>
</div>
