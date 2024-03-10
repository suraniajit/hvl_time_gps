@include('panels.nav._header')

<li class="A{{(request()->segment(1) == 'workflow') ? 'active open ' : '' }} " text='training'>
    <a class="collapsible-header" href="javascript:void(0);">
        <i class="material-icons">dvr</i>
        <span class="menu-title">Rules</span>
    </a>
    <div class="collapsible-body" style="">
        <ul class="collapsible collapsible-sub" data-collapsible="accordion">
            <li>
                <a href="/workflow/" class="{{$custom_classes}} {{ (request()->segment(2) == 'workflow') ? 'active '.$configData['activeMenuColor'] : ''}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">Add Rules </span>
                </a>
            <li>
            <li>
                <a href="/workflow/index_submit" class="{{$custom_classes}} {{ (request()->segment(2) == 'workflow') ? 'active '.$configData['activeMenuColor'] : ''}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">Submit Rules</span>
                </a>
            <li>
        </ul>
    </div>                    
</li>