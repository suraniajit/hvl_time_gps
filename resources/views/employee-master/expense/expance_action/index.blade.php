{{-- layout --}}
@extends('app.layout')

{{-- page title --}}
@section('title','My Approval')
@section('vendor-style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


<style>
    /* Tabs */
    .dataTables_info, .dataTables_length{
        float: inline-start !important
    }
    .tabs {

        background-color: #09F;
        border-radius: 5px 5px 5px 5px;
    }
    ul#tabs-nav {
        list-style: none;
        margin: 0;
        padding: 5px;
        overflow: auto;
    }
    ul#tabs-nav li {
        float: left;
        font-weight: bold;
        margin-right: 2px;
        padding: 8px 10px;
        border-radius: 5px 5px 5px 5px;
        /*border: 1px solid #d5d5de;
        border-bottom: none;*/
        cursor: pointer;
    }
    ul#tabs-nav li:hover,
    ul#tabs-nav li.active {
        background-color: #08E;
    }
    #tabs-nav li a {
        text-decoration: none;
        color: #FFF;
    }
    .tab-content {
        padding: 10px;
        border: 5px solid #09F;
        background-color: #FFF;
    }
    section header {
        padding-top: 0rem;
        padding-bottom: 0rem;
    }
    @media (min-width: 992px){
        .modal-lg, .modal-xl {
            max-width: 1421px;
        }
    }
</style>
@endsection
@section('content') 
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{route('expense')}}">Expense </a></li>
        </ul>
    </div>
</div>
<section>

    <div class="card">
        <div class="card-body p-4">
            <header>
                <div class="row">
                    <div class="col-md-7">
                        <h2 class="h3 display"> My Approval
                            <?php // echo  $uid = auth()->User()->id;?></h2>
                    </div>
                    <div class="col-md-5">


                        <?php
                        if (auth()->User()->id == 1395) {
                         ?>
                        @include('employee-master.expense.expance_action._zoom')
                             <?php   
                        }
                        ?>
                    </div>
                </div>
            </header>

            <div class="tabs">
                <ul id="tabs-nav">
                    <li><a href="#account_action">Account Approve Action</a></li>
                    <li><a href="#manager_action">Manager Expense Action</a></li>
                </ul>  
                <div id="tabs-content">
                    <div id="account_action" class="tab-content">
                        <h2>Account Action</h2>



                        @include('employee-master.expense.expance_action.filter')
                        @include('employee-master.expense.expance_action._account_action_combination')
                    </div>
                    <div id="manager_action" class="tab-content">
                        <h2>Manager Action</h2>
                        @include('employee-master.expense.expance_action.filter')
                        @include('employee-master.expense.expance_action._expance_action_combination')
                    </div>
                </div>   
            </div>
        </div>
    </div>
</section>
@endsection


{{-- page script --}}
@section('page-script')
<script>
function closer(popid) {
//    alert(popid);

    $(popid).modal('hide');
    $(".modal").css({"overflow-y": "scroll"});
}
$(document).ready(function () {

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });


// Show the first tab and hide the rest
    $('#tabs-nav li:first-child').addClass('active');
    $('.tab-content').hide();
    $('.tab-content:first').show();

// Click function
    $('#tabs-nav li').click(function () {
        $('#tabs-nav li').removeClass('active');
        $(this).addClass('active');
        $('.tab-content').hide();

        var activeTab = $(this).find('a').attr('href');
        $(activeTab).fadeIn();
        return false;
    });
});


</script>
@endsection

