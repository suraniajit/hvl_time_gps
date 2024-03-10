<form id="formValidateEmployee" action="{{ route('expense_history.report_history_search_step_3') }}" method="get" enctype="multipart/form-data">
    <input type="hidden" id="emp_id" value="{{$emp_id}}" name="emp_id">
    <input type="hidden" id="report_name" value="{{$report_name}}" name="report_name">