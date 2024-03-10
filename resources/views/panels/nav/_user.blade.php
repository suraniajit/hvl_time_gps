

<!--<li>
    <a href="{{route('attendance.index')}}" class="{{$custom_classes}} {{ (request()->segment(2) == 'index') ? 'active '.$configData['activeMenuColor'] : ''}}">
        <i class="material-icons">radio_button_unchecked</i>
        <span class="menu-title">Attendance</span>
    </a>
</li>-->
<!--<li>
    <a href="{{route('hrms.leaverequest')}}" class="{{$custom_classes}} {{ (request()->segment(2) == 'leaverequest') ? 'active '.$configData['activeMenuColor'] : ''}}">
        <i class="material-icons">radio_button_unchecked</i>
        <span class="menu-title">Leave Request</span>
    </a>
</li> -->

<!--<li class="bold">
    <a class="waves-effect waves-cyan" href="{{route('hrms.leaverequest.lead.approve')}}" >
        <i class="material-icons">color_lens</i>
        <span class="menu-title" data-i18n="Chat">Leave Request(Lead)</span>
    </a>
</li>-->
<!--<li class="bold">
    <a class="waves-cyan" href="{{route('hrms.leaverequest.hr.approve')}}" >
        <i class="material-icons">color_lens</i>
        <span class="menu-title" data-i18n="Chat">Leave Request(HR)</span>
    </a>
</li>-->
@include('panels.nav._employee')
@include('panels.nav._training-static')
@include('panels.nav._recruitment-static')
@include('panels.nav._hrms-static')
<!--
Access User for roles and permission start
@can('Access User')
<li class="">
    <a href="javascript:void(0) " class="collapsible-header" >
        <i class="material-icons">person</i>
        <span>Users</span>
    </a>
    <div class="collapsible-body" style="">
        <ul class="collapsible collapsible-sub" data-collapsible="accordion" id="Users">
            <li class="">
                <a href="{{ route('users.index') }}" class=" ">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span>Manage</span>
                </a>
            </li>
            @can('Access Role')
            <li class="">
                <a href="{{ route('roles.index') }}" class=" ">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span>Roles</span>
                </a>
            </li>
            @endcan
        </ul>
    </div>             
</li>
@endcan-->
<!--Access User for roles and permission end-->



<!--

@foreach($modules as $module)
@can('Access '.$module->name)
<li>
    <a href="/modules/module/{{ $module->name }}">
        <i class="material-icons">radio_button_unchecked</i>
        <span data-i18n="Analytics">{{ ucfirst($module->name) }}</span>
    </a>
</li>
@endcan
@endforeach-->

<li>
    <a class="waves-cyan sidenav-trigger" href="#" data-target="theme-cutomizer-out" >
        <i class="material-icons">color_lens</i>
        <span class="menu-title" data-i18n="Chat">Theme Customization</span>
    </a>
</li>