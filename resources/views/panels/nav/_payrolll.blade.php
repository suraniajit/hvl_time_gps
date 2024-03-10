@include('panels.nav._header')
<!--{{ (request()->segment(1) == 'payroll') ? 'active open' : 'active'}}-->
<li class=" {{(request()->is('payroll/manage-salary/4')) ? 'active open 123' : '' }}" text='payroll'>

    <a class="collapsible-header" href="javascript:void(0);" >
        <i class="material-icons">dashboard</i>
        <span class="menu-title" data-i18n="Dashboard">Payroll</span>
        <span class=""></span>
    </a> 


    <div class="collapsible-body" style="">
        <ul class="collapsible collapsible-sub" data-collapsible="accordion">


            <li>
                <a href="/payroll/salary-list" class="{{$custom_classes}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">Manage Salary</span>
                </a>
            <li>
            <li>
                <a href="/payroll/salary_type" class="{{$custom_classes}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">Manage Salary Type</span>
                </a>
            <li>
            <li>
                <a href="/payroll/programs" class="{{$custom_classes}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">Manage Programs</span>
                </a>
            <li>
            <li>
                <a href="/payroll/allowance" class="{{$custom_classes}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">Manage Allowance</span>
                </a>
            <li>
            <li>
                <a href="/payroll/deduction" class="{{$custom_classes}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">Manage Deduction</span>
                </a>
            <li>
            <li>
                <a href="/attendance" class="{{$custom_classes}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">Attendance</span>
                </a>
            <li>
            <li>
                <a href="/attendance/master" class="{{$custom_classes}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">Get All A.Master</span>
                </a>
            <li>
            <li>
                <a href="/attendance/viewall" class="{{$custom_classes}}">
                    <i class="material-icons">radio_button_unchecked</i>
                    <span data-i18n="Analytics">/attendance/viewall</span>
                </a>
            <li>



        </ul>
    </div>                    
</li>

