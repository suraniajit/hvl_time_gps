@include('panels.nav._header')

<li class="A{{(request()->segment(1) == 'training') ? 'active open ' : '' }} " text='training'>

    <?php
    $path = 'TRAINING';
    $trining_roles_ids = array();
    foreach ($user_role_name as $roles) {
        $trining_roles_ids[] = $roles->roles_id;
    }
    $getCountRolesByRoleid = app('App\Http\Controllers\UserProfileController')->getCountDetailsRoleID($trining_roles_ids, $path);
    if (count($getCountRolesByRoleid) > 0) {
        ?>
        <a class="collapsible-header" href="javascript:void(0);">
            <i class="material-icons">dvr</i>
            <span class="menu-title">Training</span>
        </a>
        <?php
    } else {
//        echo 'not found in Tranig';
    }
    ?>

    <div class="collapsible-body" style="">
        <ul class="collapsible collapsible-sub" data-collapsible="accordion">


            @foreach($modules as $module)
            @can('Access '.$module->name)
            @if($module->path === 'TRAINING')
            <li>
                <a href="/modules/module/{{ $module->name }}" class="{{$custom_classes}} {{ (request()->segment(2) == 'shift') ? 'active '.$configData['activeMenuColor'] : ''}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">{{ucfirst($module->name)}}</span>
                </a>
            <li>
                @endif
                @endcan
                @endforeach

                @include('panels.nav._training-static')


        </ul>
    </div>                    
</li>