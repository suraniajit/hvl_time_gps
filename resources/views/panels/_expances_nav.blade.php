@can('Read expense')
<li class=" " text='Employee Management'>
    <a href="#expance_dropdown" aria-expanded="false" data-toggle="collapse">Expense Management</a>



    <ul id="expance_dropdown" class="collapse list-unstyled     {{ Request::routeIs('report_history_index') ? 'show' : '' }} {{ Request::routeIs('expense_report') ? 'show' : '' }} {{ Request::routeIs('subcategory') ? 'show' : '' }}   {{ Request::routeIs('category') ? 'show' : '' }} {{ Request::routeIs('expense') ? 'show' : '' }} {{ Request::routeIs('expance_action') ? 'show' : '' }}  {{ Request::routeIs('account') ? 'show' : '' }} ">


        @can('Access expense')
        <li class="{{ Request::routeIs('expense') ? 'active' : '' }}">
            <a href="{{ route('expense') }}" class=" ">
                <span>Expense Management</span>
            </a>
        </li>
        <li class="{{ (request()->is('expance_action')) ? 'active' : '' }}">
            <a href="/expance_action" class=" ">
                <span>My Approvals</span>
            </a>
        </li>

        @endcan
        @if($user->email == $super_admin || $user->email == 'probsoltechnology@gmail.com')
        <li class="{{ (request()->is('account')) ? 'active' : '' }}">
            <a href="/account" class=" ">
                <span>Account Management</span>
            </a>
        </li>
        @endif

        @can('Access Expense Report')
        <?php if (auth()->User()->id == '916') { ?>
            <li class="{{ (request()->is('report_history_index')) ? 'active' : '' }}">
                <a href="/report_history_index" class=" ">
                    <span>Expense History</span>
                </a>
            </li> 
        <?php } else { ?>
            <li class="{{ (request()->is('expense_report')) ? 'active' : '' }}">
                <a href="/expense_report" class=" ">
                    <span>Expense Report</span>
                </a>
            </li> 
        <?php } ?>
        @endcan

        <li style="display: none;" class="{{ (request()->is('category')) ? 'active' : '' }}">
            <a href="/category" class=" ">
                <span>Category</span>
            </a>
        </li>
        <li style="display: none;" class="{{ (request()->is('subcategory')) ? 'active' : '' }}">
            <a href="/subcategory" class=" ">
                <span>Sub Category</span>
            </a>
        </li>
    </ul>
</li>
@endcan
