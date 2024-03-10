<li class=" {{ (request()->segment(1) == 'dashboard') ? 'active bold open '.$configData['activeMenuColor'] : ' '}}" text='dashboard'>
    <?php
    $path = '';
    $dashboard_ids = array();
    foreach ($user_role_name as $roles) {
        $dashboard_ids[] = $roles->roles_id;
    }
//    $getCountDashboardRolesByRoleid = app('App\Http\Controllers\UserProfileController')->getCountDetailsRoleID($dashboard_ids, $path);
    $getCountDashboardRolesByRoleid = app('App\Http\Controllers\UserProfileController')->getCount_dashboard_details_role_id($dashboard_ids);
//        echo count($getCountDashboardRolesByRoleid);

    if (count($getCountDashboardRolesByRoleid) != 0) {
        ?>
        <a class="collapsible-header" href="javascript:void(0);" >
            <i class="material-icons">dashboard</i>
            <span class="menu-title" data-i18n="Dashboard">Dashboard</span>
            <span class=""></span>
        </a> 
        <?php
    }
    ?>


    <div class="collapsible-body" style="">
        <ul class="collapsible collapsible-sub" data-collapsible="accordion">

            @can('Access HRMS Dashboard')
            <li class="{{ (request()->segment(2) == 'hrms-dashboard') ? 'active '.$configData['activeMenuColor'] : ''}}">
                <a href="{{route('hrms')}}" class="{{$custom_classes}} {{ (request()->segment(2) == 'hrms-dashboard') ? 'active '.$configData['activeMenuColor'] : ''}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">HRMS</span>
                </a>
            </li>
            @endcan
            @can('Access CRM Dashboard')
            <li class="{{ (request()->segment(2) == 'crm-dashboard') ? 'active '.$configData['activeMenuColor'] : ''}}">
                <a href="{{route('crm')}}" class="{{$custom_classes}} {{ (request()->segment(2) == 'crm-dashboard') ? 'active '.$configData['activeMenuColor'] : ''}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">CRM</span>
                </a>
            </li>
            @endcan
            @can('Access Training Dashboard')
            <li class="{{ (request()->segment(2) == 'training-dashboard') ? 'active '.$configData['activeMenuColor'] : ''}}">

                <a href="{{route('training')}}" class="{{$custom_classes}} {{ (request()->segment(2) == 'training-dashboard') ? 'active '.$configData['activeMenuColor'] : ''}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">Training</span>
                </a>
            </li>
            @endcan
            @can('Access Recruitment Dashboard')
            <li class="{{ (request()->segment(2) == 'recruitment-dashboard') ? 'active '.$configData['activeMenuColor'] : ''}}">
                <a href="{{route('recruitment')}}" class="{{$custom_classes}} {{ (request()->segment(2) == 'recruitment-dashboard') ? 'active '.$configData['activeMenuColor'] : ''}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="eCommerce">Recruitment</span>
                </a>
            </li>
            @endcan
            <li>
                <a href="/lead">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="eCommerce">Lead</span>
                </a>
            </li>
            <li>
                <a href="/customerActivity">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="eCommerce">Customer/Activity</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="eCommerce">Report</span>
                </a>
            </li>
            <li>
                <a href="/Activity">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="eCommerce">Activity</span>
                </a>
            </li>
            
        </ul>
    </div>
</li>
@include('panels.nav._hrms')
@include('panels.nav._recruitment')
@include('panels.nav._training')
@include('panels.nav._crm')
 
