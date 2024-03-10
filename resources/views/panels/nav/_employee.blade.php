<li class="navigation-header">
    <a class="navigation-header-text">Employee Dashboard ({{$user['id']}})</a>
    <i class="navigation-header-icon material-icons"></i>
</li> 

<!--<li>
    <a href="{{route('training.employee_courses',['id'=>$user['id'] ])}}">
        <i class="material-icons">radio_button_unchecked</i>
        <span>All Course</span>
    </a>
</li>
<li>
    <a href="{{route('training.employee_resume_courses',['id'=>$user['id'] ])}}">
        <i class="material-icons">radio_button_unchecked</i>
        <span>Course In-Progress</span>
    </a>
</li>  -->
<li>
    <a href="{{route('training.employee_courses_audios',['id'=>$user['id'] ])}}">
        <i class="material-icons">radio_button_unchecked</i>
        <span class="menu-title">Course's Audio</span>
    </a>
</li>
<li>
    <a href="{{route('training.employee_audios',['id'=>$user['id'] ])}}">
        <i class="material-icons">radio_button_unchecked</i>
        <span class="menu-title">Audios</span>
    </a>
</li>
<hr>