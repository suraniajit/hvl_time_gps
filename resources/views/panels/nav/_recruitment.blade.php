@include('panels.nav._header')
<li class=" {{(request()->is('/recruitment/'.'*')) ? 'active' : '' }}" text='Recruitment'>


    <?php
    $req_roles_ids = array();
    foreach ($user_role_name as $roles) {
        $req_roles_ids[] = $roles->roles_id;
    }
    $path = 'RECRUITMENT';
    $getCountRolesByRoleid = app('App\Http\Controllers\UserProfileController')->getCountDetailsRoleID($req_roles_ids, $path);
//    echo count($getCountRolesByRoleid);
//    if ((count($getCountRolesByRoleid) > 0) && (count($getCountRolesByRoleid) != 1)) {
    if (count($getCountRolesByRoleid) > 0) {
        ?>
        <a class="collapsible-header" href="javascript:void(0);">
            <i class="material-icons">dvr</i>
            <span class="menu-title">Recruitment</span>
        </a>
        <?php
    } else {
//        echo 'not found in RECRUITMENT';
    }
    ?>

    <div class="collapsible-body" style="">
        <ul class="collapsible collapsible-sub" data-collapsible="accordion">

            @foreach($modules as $module)
            <?php // print_r($module); ?>
            @can('Access '.$module->name)
            @if($module->path === 'RECRUITMENT')
            <li>
                <a href="/modules/module/{{ $module->name }}" class="{{$custom_classes}} {{ (request()->segment(2) == 'shift') ? 'active '.$configData['activeMenuColor'] : ''}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">{{ucfirst($module->name)}}</span>
                </a>

            <li>
                @endif
                @endcan
                @endforeach

                @include('panels.nav._recruitment-static')

        </ul>
    </div>                    
</li>