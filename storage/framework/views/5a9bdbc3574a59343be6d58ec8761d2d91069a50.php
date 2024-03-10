<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Read expense')): ?>
<li class=" " text='Employee Management'>
    <a href="#expance_dropdown" aria-expanded="false" data-toggle="collapse">Expense Management</a>



    <ul id="expance_dropdown" class="collapse list-unstyled     <?php echo e(Request::routeIs('report_history_index') ? 'show' : ''); ?> <?php echo e(Request::routeIs('expense_report') ? 'show' : ''); ?> <?php echo e(Request::routeIs('subcategory') ? 'show' : ''); ?>   <?php echo e(Request::routeIs('category') ? 'show' : ''); ?> <?php echo e(Request::routeIs('expense') ? 'show' : ''); ?> <?php echo e(Request::routeIs('expance_action') ? 'show' : ''); ?>  <?php echo e(Request::routeIs('account') ? 'show' : ''); ?> ">


        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access expense')): ?>
        <li class="<?php echo e(Request::routeIs('expense') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('expense')); ?>" class=" ">
                <span>Expense Management</span>
            </a>
        </li>
        <li class="<?php echo e((request()->is('expance_action')) ? 'active' : ''); ?>">
            <a href="/expance_action" class=" ">
                <span>My Approvals</span>
            </a>
        </li>

        <?php endif; ?>
        <?php if($user->email == $super_admin || $user->email == 'probsoltechnology@gmail.com'): ?>
        <li class="<?php echo e((request()->is('account')) ? 'active' : ''); ?>">
            <a href="/account" class=" ">
                <span>Account Management</span>
            </a>
        </li>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Access Expense Report')): ?>
        <?php if (auth()->User()->id == '916') { ?>
            <li class="<?php echo e((request()->is('report_history_index')) ? 'active' : ''); ?>">
                <a href="/report_history_index" class=" ">
                    <span>Expense History</span>
                </a>
            </li> 
        <?php } else { ?>
            <li class="<?php echo e((request()->is('expense_report')) ? 'active' : ''); ?>">
                <a href="/expense_report" class=" ">
                    <span>Expense Report</span>
                </a>
            </li> 
        <?php } ?>
        <?php endif; ?>

        <li style="display: none;" class="<?php echo e((request()->is('category')) ? 'active' : ''); ?>">
            <a href="/category" class=" ">
                <span>Category</span>
            </a>
        </li>
        <li style="display: none;" class="<?php echo e((request()->is('subcategory')) ? 'active' : ''); ?>">
            <a href="/subcategory" class=" ">
                <span>Sub Category</span>
            </a>
        </li>
    </ul>
</li>
<?php endif; ?>
<?php /**PATH C:\xampp_7.4.19\htdocs\web_project\HVL_Mar2024\resources\views/panels/_expances_nav.blade.php ENDPATH**/ ?>