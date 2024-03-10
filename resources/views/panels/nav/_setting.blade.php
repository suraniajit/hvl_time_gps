<!--setting start-->
<li class=" {{(request()->segment(1) == 'training') ? ' active' : '' }}" text='setting'>
    <a class="collapsible-header" href="javascript:void(0);">
        <i class="material-icons">dvr</i>
        <span class="menu-title">Settings </span>
    </a>
    <div class="collapsible-body" style="">
        <ul class="collapsible collapsible-sub" data-collapsible="accordion">
            <li>
                <a class="waves-cyan sidenav-trigger" href="#" data-target="theme-cutomizer-out" >
                    <i class="material-icons">color_lens</i>
                    <span class="menu-title" data-i18n="Chat">Theme Customization</span>
                </a>
            </li>
            @can('Access Country')
            <li>
                <a href="/hrms/country">
                    <i class="material-icons">color_lens</i>
                    <span class="menu-title" data-i18n="Chat">Country</span>
                </a>
            </li>
            @endcan
            @can('Access State')
            <li>
                <a href="/hrms/state">
                    <i class="material-icons">color_lens</i>
                    <span class="menu-title" data-i18n="Chat">State</span>
                </a>
            </li>
            @endcan
            @can('Access City')
            <li>
                <a href="/hrms/city">
                    <i class="material-icons">color_lens</i>
                    <span class="menu-title" data-i18n="Chat">City</span>
                </a>
            </li>
            @endcan



            <!--            <li>
                            <a href="/training/employee_courses/{{$user['id']}}">
                                <i class="material-icons">color_lens</i>
                                <span class="menu-title" data-i18n="Chat">My Assign Course</span>
                            </a>
                        </li>
                        <li>
                            <a href="/training/employee_courses/{{$user['id']}}">
                                <i class="material-icons">color_lens</i>
                                <span class="menu-title" data-i18n="Chat">My Assign Simulate Course</span>
                            </a>
                        </li>-->

<!--            <li>
                <a href="{{route('training.employee_courses_audios',['id'=>$user['id']])}}">
                    <i class="material-icons">color_lens</i>
                    <span class="menu-title" data-i18n="Chat">Course's Audio</span>
                </a>
            </li>-->
<!--            <li>
                <a href="{{route('training.employee_audios',['id'=>$user['id']])}}">
                    <i class="material-icons">color_lens</i>
                    <span class="menu-title" data-i18n="Chat">Audios</span>
                </a>
            </li>-->
<!--            <li>
                <a href="{{route('training.teams',['id'=>$user['id']])}}">
                    <i class="material-icons">color_lens</i>
                    <span class="menu-title" data-i18n="Chat">Teams</span>
                </a>
            </li>-->
        </ul>
    </div>                    
</li>
<!--setting end-->



<!--<li class="bold ">-->
    <!--    <a href="{{route('training.employee_courses',['id'=>$user['id']])}}">All Course</a>
        <a href="{{route('training.employee_resume_courses',['id'=>$user['id']])}}">Course In-Progress</a>-->
    <!--<a href=""> </a>-->
    <!--<a href=""> </a>-->
    <!--<a href="{{route('training.teams',['id'=>$user['id']])}}"> Teams</a>-->
<!--</li>-->