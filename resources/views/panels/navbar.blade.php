<?php

use App\User;
use App\Module;
use App\Permission;
use App\Role;

$user = auth()->user();
$user_role_name = App\Http\Controllers\UserProfileController::find_user_role($user['id']);

$modules = Module::all();
?>

<div class="navbar @if(($configData['isNavbarFixed'])=== true){{'navbar-fixed'}} @endif">
    <nav
        class="{{$configData['navbarMainClass']}} @if($configData['isNavbarDark']=== true) {{'navbar-dark'}} @elseif($configData['isNavbarDark']=== false) {{'navbar-light'}} @elseif(!empty($configData['navbarBgColor'])) {{$configData['navbarBgColor']}} @else {{$configData['navbarMainColor']}} @endif">
        <div class="nav-wrapper">
            <!--            <div class="header-search-wrapper hide-on-med-and-down">
                          <i class="material-icons">search</i>
                          <input class="header-search-input z-depth-2" type="text" name="Search" placeholder="Explore Materialize"
                            data-search="template-list">
                          
                            <ul class="navbar-list">
                                
                                
                            </ul>
                        </div>-->
            <ul class="navbar-list right">
                <!--        <li class="dropdown-language">
                          <a class=" waves-block waves-light translation-button" href="#"
                            data-target="translation-dropdown">
                            <span class="flag-icon flag-icon-gb"></span>
                          </a>
                        </li>-->




                <?php if (($user_role_name[0]->user_role == 'Employee')) { ?>
                    <li class="waves-block waves-light">
                        <span style="font-size:27px" id="navbar_time">
                        </span>
                    </li>
                <?php } else { ?>
                    <li class="waves-block waves-light">
                    </li>
                <?php } ?>

                <li>
                    <a class="waves-block waves-light" href="#">
                        @if (!Request::is('attendance'))

                        <!----Hidden Values START---->
                        <input type="hidden" value="{{\Carbon\Carbon::now()->format('H:i')}}" id="hidden_time">
                        <input type="hidden" id="hidden_shift">
                        <input type="hidden" id="hidden_date">
                        <!----Hidden Values START---->

                        <!----Check In Button START---->
                        <button class="btn green time" id="navbar_checkin" style="display: none">
                            <span class="btn-text" id="navbar_in" data-id="1" style="padding: 17px;">
                                Check In
                            </span>
                        </button>
                        <!----Check In Button END---->

                        <!----Check Out Button START---->
                        <button class="btn red time" style="display: none" id="navbar_checkout_btn">
                            <span class="btn-text" id="navbar_out" data-id="0">Check Out</span>
                        </button>

                        <button class="btn grey darken" style="display: none" id="checkout_disabled">
                            <span class="btn-text" style="padding: 17px;">Check Out</span>
                        </button>
                        <!----Check Out Button END--->


                        <?php if (($user_role_name[0]->user_role == 'Employee')) { ?>
                            <button class="btn grey darken" style="display: none" id="shift_not_assign_disabled_btn">
                                <span class="btn-text" style="padding: 17px;">unassign</span>
                            </button>
                        <?php } ?>



                        @endif
                    </a>
                </li>
                <li class=" waves-block waves-light">

                    <span>
                        Welcome {{Session::get('someKey')}}
                    </span>

                </li>
                <li class="hide-on-med-and-down">
                    <a class=" waves-block waves-light toggle-fullscreen" href="javascript:void(0);">
                        <i class="material-icons">settings_overscan</i>
                    </a>
                </li>
                <li class="hide-on-large-only search-input-wrapper">
                    <a class=" waves-block waves-light search-button" href="javascript:void(0);">
                        <i class="material-icons">search</i>
                    </a>
                </li>
<!--                <li>
                    <a class=" waves-block waves-light notification-button" href="javascript:void(0);"
                       data-target="notifications-dropdown">
                        <i class="material-icons">notifications_none<small class="notification-badge">5</small></i>
                    </a>
                </li>-->
                <li>

                    <a class=" waves-block waves-light" href="{{ asset('user-profile-page')}} ">
                        <span class="avatar-status avatar-online">

                            <img src="{{asset('public/profile/'.Session::get('profile_image'))}}" alt="avatar"><i></i>
                        </span>
                    </a>
                </li>
                <!--        <li>
                          <a class=" waves-block waves-light sidenav-trigger" href="#" data-target="slide-out-right">
                            <i class="material-icons">format_indent_increase</i>
                          </a>
                        </li>-->
                <li class="logout">
                    <a class=" waves-block waves-light" href="javascript:void(0)">
                        <i class="material-icons">keyboard_tab</i> 
                    </a>
                </li>
            </ul>
            <!-- translation-button-->
            <!--      <ul class="dropdown-content" id="translation-dropdown">
                    <li class="dropdown-item">
                      <a class="grey-text text-darken-1" href="{{url('lang/en')}}" data-language="en">
                        <i class="flag-icon flag-icon-gb"></i>
                        English
                      </a>
                    </li>
                    <li class="dropdown-item">
                      <a class="grey-text text-darken-1" href="{{url('lang/fr')}}" data-language="fr">
                        <i class="flag-icon flag-icon-fr"></i>
                        French
                      </a>
                    </li>
                    <li class="dropdown-item">
                      <a class="grey-text text-darken-1" href="{{url('lang/pt')}}" data-language="pt">
                        <i class="flag-icon flag-icon-pt"></i>
                        Portuguese
                      </a>
                    </li>
                    <li class="dropdown-item">
                      <a class="grey-text text-darken-1" href="{{url('lang/de')}}" data-language="de">
                        <i class="flag-icon flag-icon-de"></i>
                        German
                      </a>
                    </li>
                  </ul>-->
            <!-- notifications-dropdown-->
            <ul class="dropdown-content" id="notifications-dropdown">
                <li>
                    <h6>NOTIFICATIONS<span class="new badge">5</span></h6>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="black-text" href="javascript:void(0)">
                        <span class="material-icons icon-bg-circle cyan small">add_shopping_cart</span>
                        A new order has been placed!
                    </a>
                    <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">2 hours ago</time>
                </li>
                <li>
                    <a class="black-text" href="javascript:void(0)">
                        <span class="material-icons icon-bg-circle red small">stars</span>
                        Completed the task
                    </a>
                    <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">3 days ago</time>
                </li>
                <li>
                    <a class="black-text" href="javascript:void(0)">
                        <span class="material-icons icon-bg-circle teal small">settings</span>
                        Settings updated
                    </a>
                    <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">4 days ago</time>
                </li>
                <li>
                    <a class="black-text" href="javascript:void(0)">
                        <span class="material-icons icon-bg-circle deep-orange small">today</span>
                        Director meeting started
                    </a>
                    <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">6 days ago</time>
                </li>
                <li>
                    <a class="black-text" href="javascript:void(0)">
                        <span class="material-icons icon-bg-circle amber small">trending_up</span>
                        Generate monthly report
                    </a>
                    <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">1 week ago</time>
                </li>
            </ul>
            <!-- profile-dropdown-->
            <ul class="dropdown-content" id="profile-dropdown">
                <li>
                    <a class="grey-text text-darken-1" href="{{asset('user-profile-page')}}">
                        <i class="material-icons">person_outline</i>
                        Profile
                    </a>
                </li>
                <li>
                    <a class="grey-text text-darken-1" href="{{asset('app-chat')}}">
                        <i class="material-icons">chat_bubble_outline</i>
                        Chat
                    </a>
                </li>
                <li>
                    <a class="grey-text text-darken-1" href="{{asset('page-faq')}}">
                        <i class="material-icons">help_outline</i>
                        Help
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="grey-text text-darken-1" href="{{asset('user-lock-screen')}}">
                        <i class="material-icons">lock_outline</i>
                        Lock
                    </a>
                </li>
                <li>
                    <a class="grey-text text-darken-1" href="{{asset('user-login')}}">
                        <i class="material-icons">keyboard_tab</i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
        <nav class="display-none search-sm">
            <div class="nav-wrapper">
                <form id="navbarForm">
                    <div class="input-field search-input-sm">
                        <input class="search-box-sm mb-0" type="search" required="" placeholder='Explore Materialize' id="search"
                               data-search="template-list">
                        <label class="label-icon" for="search">
                            <i class="material-icons search-sm-icon">search</i>
                        </label>
                        <i class="material-icons search-sm-close">close</i>
                        <ul class="search-list collection search-list-sm display-none"></ul>
                    </div>
                </form>
            </div>
        </nav>
    </nav>
    <!--     Modal Structure START
        <div id="navbar_check_out_modal" class="modal">
            <div class="modal-content">
                <h6>Are you sure you want to checkout?</h6>
            </div>
            <div class="modal-footer">
                <button id="checkout" class="modal-close btn green">Yes</button>
                <button class="modal-close btn red">No</button>
            </div>
        </div>
         Modal Structure END -->


    <script src="{{asset('js/ajax/jquery.min.js')}}"></script>
    <script src="{{asset('js/navbar/navbar.js')}}"></script>



