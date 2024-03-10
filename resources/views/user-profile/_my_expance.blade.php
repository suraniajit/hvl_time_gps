<script src="https://hherp.probsoltech.com/js/ajax/jquery.min.js"></script>

<style>


    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    /* Style the buttons inside the tab */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }
</style> 

<h5 class="title-color"><span>My Expense</span></h5>
<div class="tab">
    <button class="tablinks" onclick="myepanceTab(event, 'account_tab')">Account Action</button>
    <button class="tablinks" onclick="myepanceTab(event, 'expance_tab')">Manager Action</button>
<!--    <button class="tablinks" onclick="myepanceTab(event, 'my_expance')">My Expance Report</button>-->
</div>
<div id="account_tab" class="tabcontent">
    @include('user-profile._account_action_combination')
</div>
<div id="expance_tab" class="tabcontent">
    @include('user-profile._expance_action_combination')
    <!--include('user-profile._expance_action')-->
</div>
<!--<div id="expance_tab" class="tabcontent">
     my expancee
    include('user-profile.expance.my_expance.index')
</div>-->
<!--<div id="my_expance" class="tabcontent">
</div>-->


