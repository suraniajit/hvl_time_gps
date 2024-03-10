{{-- layout --}}
@extends('app.layout')

{{-- page title --}}
@section('title','Expense Management')
@section('vendor-style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


<style>
    /* Tabs */
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
                        <h2 class="h3 display"> Expense Management
                            <?php
                            if ($emp_id) {
                                echo ': <span style="color: #0091ea"> ' . app('App\Http\Controllers\Controller')->getConditionDynamicNameTable('employees', 'user_id', $emp_id, 'name');
                            }
                            ?>
                        </h2>
                    </div>
                    <div class="col-md-5">
                         @can('Create expense')
                        <a href="{{route('expense.create')}}" class="btn btn-primary pull-right rounded-pill">Add Expense</a>
                        @endcan
                    </div>
                </div>
            </header>


            <!--===============================================-->
            <?php
            if (Auth::id() == '122') {
                if ($emp_id) {
                    ?>
                    @include('employee-master.expense.index_filter')
                    @include('employee-master.expense.index_admin_details')
<!--                    1-->
                <?php } else { ?>
                    <!--2-->
                    @include('employee-master.expense.index_admin')
                    <?php
                }
            } else {
                ?>
                <!--3-->
                @include('employee-master.expense.index_employee')
            <?php } ?>



            <!--        <div class="tabs">
                        <ul id="tabs-nav">
                            <li><a href="#tab1">Bob</a></li>
                            <li><a href="#tab2">Dante</a></li>
                            <li><a href="#tab3">Randall</a></li>
                            <li><a href="#tab4">Jay</a></li>
                        </ul>  END tabs-nav 
                        <div id="tabs-content">
                            <div id="tab1" class="tab-content">
                                <h2>Silent Bob</h2>
                                <p>"You know, there's a million fine looking women in the world, dude. But they don't all bring you lasagna at work. Most of 'em just cheat on you."</p>
                            </div>
                            <div id="tab2" class="tab-content">
                                <h2>Dante Hicks</h2>
                                <p>"My friend here's trying to convince me that any independent contractors who were working on the uncompleted Death Star were innocent victims when it was destroyed by the Rebels."</p>
                            </div>
                            <div id="tab3" class="tab-content">
                                <h2>Randall Graves</h2>
                                <p>"In light of this lurid tale, I don't even see how you can romanticize your relationship with Caitlin. She broke your heart and inadvertently drove men to deviant lifestyles."</p>
                            </div>
                            <div id="tab4" class="tab-content">
                                <h2>Jay</h2>
                                <p>"I don't care if she's my cousin or not, I'm gonna knock those boots again tonight."</p>
                            </div>
                        </div>  END tabs-content 
                    </div>  END tabs -->

            <!--===============================================-->
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
}
$(document).ready(function () {

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
    $('#page-length-option_combination').DataTable({
        "scrollX": true
    });


    $('.delete-record-click').click(function () {
        var id = $(this).data("id");
        var name = 'Expense';
        var token = $("meta[name='csrf-token']").attr("content");
        swal({
            title: "Are you sure? ",
            text: "You will not be able to recover this record!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: '/expense/removedata/',
                    type: 'get',
                    data: {
                        "_token": token,
                        'id': id,
                        'delete': 'expance_details',
                    },
                    success: function (result) {
                        swal({
                            title: "Record has been deleted!",
                            type: "success",
                        }, function () {
                            location.reload();
                        });
                    }
                });
            } else {
                //                swal(name + " Record is safe", {
                //                    title: 'Cancelled',
                //                    icon: "error",
                //                });
            }
        });
    });
});


</script>
@endsection

