<li class=" {{(request()->is('/hrms/'.'*')) ? 'active' : '' }}" text='HRSM'>
    
    @include('panels.nav._header')
    
    
    <?php
    $path = 'HRMS';
    $hrms_roles_ids = array();
    foreach ($user_role_name as $roles) {
        $hrms_roles_ids[] = $roles->roles_id;
    }

    $getCountRolesByRoleid = app('App\Http\Controllers\UserProfileController')->getCountDetailsRoleID($hrms_roles_ids, $path);
    if (count($getCountRolesByRoleid) >= 0) {
        if (count($getCountRolesByRoleid) != 0) {
            ?>
            <a class="collapsible-header" href="javascript:void(0);">
                <i class="material-icons">dvr</i>
                <span class="menu-title">HRMS</span>
            </a>
            <?php
        }
    } else {
//        echo 'not found in HRMS';
    }
    ?>


    <div class="collapsible-body" style="">
        <ul class="collapsible collapsible-sub" data-collapsible="accordion">

            @can('Access User')
            <li>
                <a href="/users" class="{{$custom_classes}} {{ (request()->segment(1) == 'users') ? 'active '.$configData['activeMenuColor'] : ''}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">Users Managment</span>
                </a>
            </li>
            @endcan



            @foreach($modules as $module)
            @can('Access '.$module->name)
            @if($module->path === 'HRMS')
            <li>
                <a href="/modules/module/{{ $module->name }}" class="{{$custom_classes}} {{ (request()->segment(2) == 'shift') ? 'active '.$configData['activeMenuColor'] : ''}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">{{ucfirst($module->name)}}
                    </span>
                </a>

            <li>
                @endif
                @endcan
                @endforeach





                @can('Access Employee type')
            <li>
                <a href="/hrms/employee_type/" class="{{$custom_classes}} {{ (request()->segment(2) == 'employee_type') ? 'active '.$configData['activeMenuColor'] : ''}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">Employee Type</span>
                </a>
            </li>
            @endcan
            @can('Access Leave type')
            <li>
                <a href="/hrms/leavetype/" class="{{$custom_classes}} {{ (request()->segment(2) == 'leavetype') ? 'active '.$configData['activeMenuColor'] : ''}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">Leave Type Managment</span>
                </a>
            </li>
            @endcan
            @can('Access Shift')
            <li>
                <a href="/hrms/shift/" class="{{$custom_classes}} {{ (request()->segment(2) == 'shift') ? 'active '.$configData['activeMenuColor'] : ''}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">Shift Managment</span>
                </a>
            </li>
            @endcan
            @can('Access Penalty')
            <li>
                <a href="/penalty" class="{{$custom_classes}} {{ (request()->segment(2) == 'penalty') ? 'active '.$configData['activeMenuColor'] : ''}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">Penalty Managment</span>
                </a>
            </li>
            @endcan

        </ul>
    </div>                    
</li>

