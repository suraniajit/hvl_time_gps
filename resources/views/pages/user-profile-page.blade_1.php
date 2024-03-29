{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','User Profile Page')

{{-- page style --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/user-profile-page.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div class="section">
<!--    <div class="row user-profile mt-1 ml-0 mr-0">
        <img class="responsive-img" alt="" src="{{asset('images/gallery/profile-bg')}}.png">
    </div>-->




    <div class="section" id="user-profile">
        <div class="row">
            <!-- User Profile Feed -->
<!--            <div class="col s12 m4 l3 user-section-negative-margin">
                <div class="row">
                    <div class="col s12 center-align">
                        <img class="responsive-img circle z-depth-5" width="120" src="{{asset('images/user/12.jpg')}}" alt="">
                        <br>
                        <a class="waves-effect waves-light btn mt-5 border-radius-4"> Follow</a>
                    </div>
                </div>


                <div class="row mt-5 hide">
                    <div class="col s6">
                        <h6>Follower</h6>
                        <h5 class="m-0"><a href="#">540</a></h5>
                    </div>
                    <div class="col s6">
                        <h6>Following</h6>
                        <h5 class="m-0"><a href="#">128</a></h5>
                    </div>
                </div>
              
                <div class="row hide">
                    <div class="col s12">
                        <p class="m-0">Performance</p>
                        <p class="m-0"><a href="#">56</a> and <a href="#">42</a> reviews</p>
                    </div>
                </div>
            
                <div class="row hide">
                    <div class="col s12">
                        <p class="m-0">Email id{{$user}}</p>
                        <p class="m-0"><a href="#">{{$user['email']}}</a></p>
                    </div>
                </div>
             

                <div class="row user-projects hide">
                    <h6 class="col s12">Projects</h6>
                    <div class="col s4">
                        <img class="responsive-img photo-border mt-10" alt="" src="{{asset('images/gallery/35.png')}}">
                    </div>
                    <div class="col s4">
                        <img class="responsive-img photo-border mt-10" alt="" src="{{asset('images/gallery/36.png')}}">
                    </div>
                    <div class="col s4">
                        <img class="responsive-img photo-border mt-10" alt="" src="{{asset('images/gallery/37.png')}}">
                    </div>
                    <div class="col s4">
                        <img class="responsive-img photo-border mt-10" alt="" src="{{asset('images/gallery/38.png')}}">
                    </div>
                    <div class="col s4">
                        <img class="responsive-img photo-border mt-10" alt="" src="{{asset('images/gallery/39.png')}}">
                    </div>
                    <div class="col s4">
                        <img class="responsive-img photo-border mt-10" alt="" src="{{asset('images/gallery/40.png')}}">
                    </div>
                    <div class="col s4">
                        <img class="responsive-img photo-border mt-10" alt="" src="{{asset('images/gallery/41.png')}}">
                    </div>
                    <div class="col s4">
                        <img class="responsive-img photo-border mt-10" alt="" src="{{asset('images/gallery/42.png')}}">
                    </div>
                    <div class="col s4">
                        <img class="responsive-img photo-border mt-10" alt="" src="{{asset('images/gallery/43.png')}}">
                    </div>
                </div>
                <hr class="mt-5 hide">
                <div class="row hide">
                    <div class="col s12">
                        <h6>Boosts</h6>
                    </div>
                </div>
                <div class="row mt-2 hide">
                    <div class="col s2 mt-2 pr-0 circle">
                        <a href="#"><img class="responsive-img circle" src="{{asset('images/user/1.jpg')}}" alt=""></a>
                    </div>
                    <div class="col s9">
                        <a href="#">
                            <p class="m-0">Micheal S. Castilleja</p>
                        </a>
                        <p class="m-0 amber-text"><span class="material-icons star-width">star_rate</span> <span
                                class="material-icons star-width">star_rate</span>
                            <span class="material-icons star-width">star_rate</span> <span
                                class="material-icons star-width">star_rate</span>
                            <span class="material-icons star-width">star_rate</span></p>
                    </div>
                </div>
                <div class="row mt-2 hide">
                    <div class="col s2 mt-2 pr-0 circle">
                        <a href="#"><img class="responsive-img circle" src="{{asset('images/user/11.jpg')}}" alt=""></a>
                    </div>
                    <div class="col s9">
                        <a href="#">
                            <p class="m-0">Thomas A. Carranza</p>
                        </a>
                        <p class="m-0 amber-text"><span class="material-icons star-width">star_rate</span> <span
                                class="material-icons star-width">star_rate</span>
                            <span class="material-icons star-width">star_rate</span> <span
                                class="material-icons star-width">star_rate</span>
                            <span class="material-icons star-width">star_rate</span></p>
                    </div>
                </div>
                <div class="row mt-2 hide">
                    <div class="col s2 mt-2 pr-0 circle">
                        <a href="#"><img class="responsive-img circle" src="{{asset('images/user/5.jpg')}}" alt=""></a>
                    </div>
                    <div class="col s9">
                        <a href="#">
                            <p class="m-0">Micheal Bryant</p>
                        </a>
                        <p class="m-0 amber-text"><span class="material-icons star-width">star_rate</span> <span
                                class="material-icons star-width">star_rate</span>
                            <span class="material-icons star-width">star_rate</span> <span
                                class="material-icons star-width">star_rate</span>
                            <span class="material-icons star-width">star_rate</span></p>
                    </div>
                </div>
                <div class="row mt-2 hide">
                    <div class="col s2 mt-2 pr-0 circle pb-2">
                        <a href="#"><img class="responsive-img circle" src="{{asset('images/user/8.jpg')}}" alt=""></a>
                    </div>
                    <div class="col s9">
                        <a href="#">
                            <p class="m-0">Wiley J. Bryant</p>
                        </a>
                        <p class="m-0 amber-text"><span class="material-icons star-width">star_rate</span> <span
                                class="material-icons star-width">star_rate</span>
                            <span class="material-icons star-width">star_rate</span> <span
                                class="material-icons star-width">star_rate</span>
                            <span class="material-icons star-width">star_rate</span></p>
                    </div>
                </div>
            </div>-->


            <!-- User Post Feed -->
            <div class="col s12">
                <div class="row">
                    <div class="card user-card-negative-margin z-depth-0" id="feed">
                        <div class="card-content card-border-gray">
                            <div class="row">
                                <div class="col s12">

                                    <h5>Name : {{$user['name']}}</h5>
                                    <h6>Role : <?php echo $users_roles_name[0]->user_role ?></h6>
                                    <p>
<!--                                        <span class="amber-text">
                                            <span class="material-icons star-width vertical-align-middle">star_rate</span>
                                            <span class="material-icons star-width vertical-align-middle">star_rate</span> 
                                            <span class="material-icons star-width vertical-align-middle">star_rate</span>
                                            <span class="material-icons star-width vertical-align-middle">star_rate</span> 
                                            <span class="material-icons star-width vertical-align-middle">star_rate</span>
                                        </span>-->
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <ul class="tabs card-border-gray mt-4">
                                        <li class="tab col m3 s6 p-0"><a href="#test1">
                                                <i class="material-icons vertical-align-middle">crop_portrait</i> Info
                                            </a></li>
                                        <li class="tab col m3 s6 p-0"><a class="active" href="#test2">
                                                <i class="material-icons vertical-align-middle">bookmark_border</i> Feed
                                            </a></li>
                                        <li class="tab col m3 s6 p-0"><a href="#test3">
                                                <i class="material-icons vertical-align-middle">date_range</i> Agenda
                                            </a></li>
                                        <li class="tab col m3 s6 p-0"><a href="#test4">
                                                <i class="material-icons vertical-align-middle">attach_file</i> Resume
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row mt-5 hide">
                                <div class="col s1 pr-0 circle">
                                    <a href="#"><img class="responsive-img circle" src="{{asset('images/user/12.jpg')}}" alt=""></a>
                                </div>
                                <div class="col s11">
                                    <a href="#">
                                        <p class="m-0">Suzanne Martin <span><i class="material-icons vertical-align-bottom">access_time</i>
                                                1
                                                days</span></p>
                                    </a>
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="card card-border z-depth-2">
                                                <div class="card-image">
                                                    <img src="{{asset('images/gallery/post-1')}}.png" alt="">
                                                </div>
                                                <div class="card-content">
                                                    <h6 class="font-weight-900 text-uppercase"><a href="#">Designing Services</a></h6>
                                                    <p>UI/UX & Graphics Design</p>
                                                </div>
                                            </div>
                                            <div class="social-icon">
                                                <span><i class="material-icons vertical-align-bottom mr-1">favorite_border</i>90</span> <i
                                                    class="material-icons vertical-align-bottom ml-3 mr-1">chat_bubble_outline</i>
                                                15 <span><i class="material-icons vertical-align-bottom ml-3 mr-1">redo</i> 6</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="mt-5 hide" >
                            <div class="row mt-5 hide">
                                <div class="col s1 pr-0 circle">
                                    <a href="#"><img class="responsive-img circle" src="{{asset('images/user/12.jpg')}}" alt=""></a>
                                </div>
                                <div class="col s11">
                                    <a href="#">
                                        <p class="m-0">Suzanne Martin <span><i class="material-icons vertical-align-bottom">access_time</i>
                                                5
                                                days</span></p>
                                    </a>
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="card card-border z-depth-2">
                                                <div class="card-image">
                                                    <img src="{{asset('images/gallery/post-2')}}.png" alt="">
                                                </div>
                                                <div class="card-content">
                                                    <h6 class="font-weight-900 text-uppercase"><a href="#">Australia office hours</a></h6>
                                                    <p>Working so hard</p>
                                                </div>
                                            </div>
                                            <div class="social-icon">
                                                <span><i class="material-icons vertical-align-bottom mr-1">favorite_border</i>90</span> <i
                                                    class="material-icons vertical-align-bottom ml-3 mr-1">chat_bubble_outline</i>
                                                15 <span><i class="material-icons vertical-align-bottom ml-3 mr-1">redo</i> 6</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="mt-5 hide">
                            <div class="row mt-5 hide">
                                <div class="col s1 pr-0 circle">
                                    <a href="#"><img class="responsive-img circle" src="{{asset('images/user/7.jpg')}}" alt=""></a>
                                </div>
                                <div class="col s11">
                                    <a href="#">
                                        <p class="m-0">Luiza Ales <span><i class="material-icons vertical-align-bottom">access_time</i> 10
                                                days</span></p>
                                    </a>
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="card card-border z-depth-2">
                                                <div class="card-content">
                                                    <div class="row">
                                                        <div class="col s2 pr-0 circle">
                                                            <a href="#"><img class="responsive-img circle" src="{{asset('images/user/1.jpg')}}"
                                                                             alt=""></a>
                                                        </div>
                                                        <div class="col s10">
                                                            <a href="#">
                                                                <h6>Mario Mendez</h6>
                                                            </a>
                                                            <p class="m-0 amber-text"><span class="material-icons star-width">star_rate</span> <span
                                                                    class="material-icons star-width">star_rate</span> <span
                                                                    class="material-icons star-width">star_rate</span>
                                                                <span class="material-icons star-width">star_rate</span> <span
                                                                    class="material-icons star-width">star_rate</span></p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h6 class="font-weight-900 text-uppercase"><a href="#">Senior Developer</a></h6>
                                                    <p>When I hear “Senior Developer” I think of someone who has mastered ... When looking at
                                                        software engineers I see 4 tiers of skills: Luminary, Senior.</p>
                                                </div>
                                            </div>
                                            <div class="social-icon">
                                                <span><i class="material-icons vertical-align-bottom mr-1">favorite_border</i>90</span> <i
                                                    class="material-icons vertical-align-bottom ml-3 mr-1">chat_bubble_outline</i>
                                                15 <span><i class="material-icons vertical-align-bottom ml-3 mr-1">redo</i> 6</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Today Highlight -->
            <div class="col s12 m12 l3 hide-on-med-and-down hide">
                <div class="row mt-5">
                    <div class="col s12">
                        <h6>Today Highlight</h6>
                        <img class="responsive-img card-border z-depth-2 mt-2" src="{{asset('images/gallery/post-3')}}.png" alt="">
                        <p><a href="#">Meeting with clients</a></p>
                        <p>Crediting isn’t required, but is appreciated and allows photographers to gain exposure. Copy the text
                            below or embed a credit badge</p>
                    </div>
                </div>
                <hr class="mt-5">
                <div class="row">
                    <div class="col s12">
                        <h6>Who to follow</h6>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col s2 mt-2 pr-0 circle">
                        <a href="#"><img class="responsive-img circle" src="{{asset('images/user/2.jpg')}}" alt=""></a>
                    </div>
                    <div class="col s9">
                        <a href="#">
                            <p class="m-0">Frank Goodman</p>
                        </a>
                        <p class="m-0 grey-text lighten-3">Senior architect</p>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col s2 mt-2 pr-0 circle">
                        <a href="#"><img class="responsive-img circle" src="{{asset('images/user/7.jpg')}}" alt=""></a>
                    </div>
                    <div class="col s9">
                        <a href="#">
                            <p class="m-0">Luiza Ales</p>
                        </a>
                        <p class="m-0 grey-text lighten-3">Senior Developer</p>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col s2 mt-2 pr-0 circle">
                        <a href="#"><img class="responsive-img circle" src="{{asset('images/user/4.jpg')}}" alt=""></a>
                    </div>
                    <div class="col s9">
                        <a href="#">
                            <p class="m-0">Robbin Drummo</p>
                        </a>
                        <p class="m-0 grey-text lighten-3">Graphic Designer</p>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col s2 mt-2 pr-0 circle">
                        <a href="#"><img class="responsive-img circle" src="{{asset('images/user/8.jpg')}}" alt=""></a>
                    </div>
                    <div class="col s9">
                        <a href="#">
                            <p class="m-0">Myles Steven</p>
                        </a>
                        <p class="m-0 grey-text lighten-3">Senior Developer</p>
                    </div>
                </div>
                <hr class="mt-5">
                <div class="row">
                    <div class="col s12">
                        <h6>Latest Updates</h6>
                        <p class="latest-update">Make Metronic<span class="right"> <a href="#">+480</a> </span></p>
                        <p class="latest-update">Programming Language <span class="right"> <a href="#">+12</a> </span></p>
                        <p class="latest-update">Project completed <span class="right"> <a href="#">+570</a> </span></p>
                        <p class="latest-update">New Customer <span class="right"><a href="#">+120</a> </span></p>
                        <p class="latest-update">Annual Companies<span class="right"> <a href="#">+890</a> </span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection