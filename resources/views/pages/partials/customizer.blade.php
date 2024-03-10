<?php

use App\Models\UserColors;
use Illuminate\Support\Facades\Auth;

$id = Auth::id();
$colors = UserColors::where('user_id', $id)->get();
?>


<style>
    html {
        color: black;
    } 
    .color {
        float: right;
        margin-top: -30px;
        width: 30%;
        height: 31px;
    }

    #default {
        float: left;
        margin-left: 10px;
    }

    #submit {
        padding-left: 25px;
        padding-right: 25px;
        float: right;
        margin-right: 10px;
    }
    /*    .theme-cutomizer .customize-devider {
            border: 1px solid #000;
        }*/
</style>

<div id="theme-cutomizer-out" class="theme-cutomizer sidenav row theme-bg-color">
    <form method="post" action="javascript:void(0);">
        <div class="col s12">
            <a class="sidenav-close" href="#!"><i class="material-icons">close</i></a>
            <h5 class="theme-cutomizer-title">Theme Customizer</h5>
            <br>
            <hr class="customize-devider"/>
            <div class="menu-options">
                <h6 class="mt-3">Menu Color</h6>
                <input type="color" class="color" id="menu_color">
                <div class="menu-options-form row">
                    <div class="col s12 menu-color mb-0">
                        <div class="gradient-color center-align">
                            <span class="menu-color-option gradient-45deg-indigo-blue "
                                  data-color="gradient-45deg-indigo-blue"></span>
                            <span class="menu-color-option gradient-45deg-purple-deep-orange"
                                  data-color="gradient-45deg-purple-deep-orange"></span>
                            <span class="menu-color-option gradient-45deg-light-blue-cyan"
                                  data-color="gradient-45deg-light-blue-cyan"></span>
                            <span class="menu-color-option gradient-45deg-purple-amber"
                                  data-color="gradient-45deg-purple-amber"></span>
                            <span class="menu-color-option gradient-45deg-purple-deep-purple"
                                  data-color="gradient-45deg-purple-deep-purple"></span>
                            <span class="menu-color-option gradient-45deg-deep-orange-orange"
                                  data-color="gradient-45deg-deep-orange-orange"></span>
                            <span class="menu-color-option gradient-45deg-green-teal"
                                  data-color="gradient-45deg-green-teal"></span>
                            <span class="menu-color-option gradient-45deg-indigo-light-blue"
                                  data-color="gradient-45deg-indigo-light-blue"></span>
                            <span class="menu-color-option gradient-45deg-red-pink"
                                  data-color="gradient-45deg-red-pink"></span>
                        </div>
                        <div class="solid-color center-align">
                            <span class="menu-color-option red" data-color="red"></span>
                            <span class="menu-color-option purple" data-color="purple"></span>
                            <span class="menu-color-option pink" data-color="pink"></span>
                            <span class="menu-color-option deep-purple" data-color="deep-purple"></span>
                            <span class="menu-color-option cyan" data-color="cyan"></span>
                            <span class="menu-color-option teal" data-color="teal"></span>
                            <span class="menu-color-option light-blue" data-color="light-blue"></span>
                            <span class="menu-color-option amber" data-color="amber"></span>
                            <span class="menu-color-option brown" data-color="brown"></span>
                        </div>
                    </div>

                    <div class="col s12">
                        <div class="switch">
                            Menu Dark
                            <label class="float-right"><input class="menu-dark-checkbox" type="checkbox"/> <span
                                    class="lever ml-0"></span></label>
                        </div>
                    </div>

                    <div class="col s12">
                        <div class="switch">
                            <p class="mt-0">Menu Selection</p>
                            <label>
                                <input class="menu-selection-radio with-gap sidenav-active-square"
                                       value="sidenav-active-square" name="menu-selection"
                                       type="radio"/>
                                <span class="black-text">Square</span>
                            </label>
                            <label>
                                <input class="menu-selection-radio with-gap sidenav-active-rounded"
                                       value="sidenav-active-rounded" name="menu-selection"
                                       type="radio"/>
                                <span class="black-text">Rounded</span>
                            </label>
                            <label>
                                <input class="menu-selection-radio with-gap menu-selection" value="menu-selection"
                                       name="menu-selection" type="radio"/>
                                <span class="black-text">Normal</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <hr class="customize-devider"/>
            <h6 class="mt-3">Navbar Color  </h6>
            <input type="color" class="color" id="navbar_color">
            <div class="navbar-options row">
                <div class="col s12 navbar-color mb-0">
                    <div class="gradient-color center-align">
                        <span class="navbar-color-option gradient-45deg-indigo-blue"
                              data-color="gradient-45deg-indigo-blue"></span>
                        <span class="navbar-color-option gradient-45deg-purple-deep-orange"
                              data-color="gradient-45deg-purple-deep-orange"></span>
                        <span class="navbar-color-option gradient-45deg-light-blue-cyan"
                              data-color="gradient-45deg-light-blue-cyan"></span>
                        <span class="navbar-color-option gradient-45deg-purple-amber"
                              data-color="gradient-45deg-purple-amber"></span>
                        <span class="navbar-color-option gradient-45deg-purple-deep-purple"
                              data-color="gradient-45deg-purple-deep-purple"></span>
                        <span class="navbar-color-option gradient-45deg-deep-orange-orange"
                              data-color="gradient-45deg-deep-orange-orange"></span>
                        <span class="navbar-color-option gradient-45deg-green-teal"
                              data-color="gradient-45deg-green-teal"></span>
                        <span class="navbar-color-option gradient-45deg-indigo-light-blue"
                              data-color="gradient-45deg-indigo-light-blue"></span>
                        <span class="navbar-color-option gradient-45deg-red-pink"
                              data-color="gradient-45deg-red-pink"></span>
                    </div>
                    <div class="solid-color center-align">
                        <span class="navbar-color-option red" data-color="red"></span>
                        <span class="navbar-color-option purple" data-color="purple"></span>
                        <span class="navbar-color-option pink" data-color="pink"></span>
                        <span class="navbar-color-option deep-purple" data-color="deep-purple"></span>
                        <span class="navbar-color-option cyan" data-color="cyan"></span>
                        <span class="navbar-color-option teal" data-color="teal"></span>
                        <span class="navbar-color-option light-blue" data-color="light-blue"></span>
                        <span class="navbar-color-option amber" data-color="amber"></span>
                        <span class="navbar-color-option brown" data-color="brown"></span>
                    </div>
                </div>
            </div>

            <h6 class="mt-3">BreadCrumbs Color  </h6>
            <input type="color" class="color" id="breadcrumb_color">
            <hr class="customize-devider"/>
            <div class="breadcrumb-options row">
                <div class="col s12">
                    <div class="solid-color center-align">
                        <span class="breadcrumb-color-option red red-text" data-color="red-text"></span>
                        <span class="breadcrumb-color-option white white-text" data-color="white-text"></span>
                        <span class="breadcrumb-color-option pink pink-text" data-color="pink-text"></span>
                        <span class="breadcrumb-color-option deep-purple deep-purple-text" data-color="deep-purple-text"></span>
                        <span class="breadcrumb-color-option cyan cyan-text" data-color="cyan-text"></span>
                        <span class="breadcrumb-color-option teal teal-text" data-color="teal-text"></span>
                        <span class="breadcrumb-color-option light-blue light-blue-text" data-color="light-blue-text"></span>
                        <span class="breadcrumb-color-option amber amber-text" data-color="amber-text"></span>
                        <span class="breadcrumb-color-option black black-text" data-color="black-text"></span>
                    </div>
                </div>
            </div>


            <!--/*/*-->
            <h6 class="mt-6">Icon Color</h6>

            <input type="color" class="color" id="icon_color">

            <hr class="customize-devider"/>
            <div class="icon-options row">
                <div class="input-field col s12">
                    <div class="solid-color center-align">
                        <span class="icon-color-option red red-text" data-color="red-text"></span>
                        <span class="icon-color-option white white-text" data-color="white-text"></span>
                        <span class="icon-color-option pink pink-text" data-color="pink-text"></span>
                        <span class="icon-color-option deep-purple deep-purple-text"
                              data-color="deep-purple-text"></span>
                        <span class="icon-color-option cyan cyan-text" data-color="cyan-text"></span>
                        <span class="icon-color-option teal teal-text" data-color="teal-text"></span>
                        <span class="icon-color-option light-blue light-blue-text"
                              data-color="light-blue-text"></span>
                        <span class="icon-color-option amber amber-text" data-color="amber-text"></span>
                        <span class="icon-color-option black black-text" data-color="black-text"></span>
                    </div>
                </div>
            </div>
            <!--/*/*-->

            <h6 class="mt-3">Card Title Color</h6>
            <input type="color" class="color" id="title_color">
            <hr class="customize-devider"/>
            <div class="title-options row">
                <div class="col s12">
                    <div class="solid-color center-align">
                        <span class="title-color-option red red-text" data-color="red-text"></span>
                        <span class="title-color-option purple purple-text" data-color="purple-text"></span>
                        <span class="title-color-option pink pink-text" data-color="pink-text"></span>
                        <span class="title-color-option deep-purple deep-purple-text" data-color="deep-purple-text"></span>
                        <span class="title-color-option black black-text" data-color="black-text"></span>
                        <span class="title-color-option teal teal-text" data-color="teal-text"></span>
                        <span class="title-color-option light-blue light-blue-text" data-color="light-blue-text"></span>
                        <span class="title-color-option amber amber-text" data-color="amber-text"></span>
                        <span class="title-color-option brown brown-text" data-color="brown-text"></span>
                    </div>
                </div>
            </div>

            <h6 class="mt-3">Button Color</h6>
            <input type="color" class="color" id="button_color">
            <hr class="customize-devider"/>
            <div class="btn-options row">
                <div class="col s12">
                    <div class="gradient-color center-align">
                        <span class="btn-color-option gradient-45deg-indigo-blue"
                              data-color="gradient-45deg-indigo-blue"></span>
                        <span class="btn-color-option gradient-45deg-purple-deep-orange"
                              data-color="gradient-45deg-purple-deep-orange"></span>
                        <span class="btn-color-option gradient-45deg-light-blue-cyan"
                              data-color="gradient-45deg-light-blue-cyan"></span>
                        <span class="btn-color-option gradient-45deg-purple-amber"
                              data-color="gradient-45deg-purple-amber"></span>
                        <span class="btn-color-option gradient-45deg-purple-deep-purple"
                              data-color="gradient-45deg-purple-deep-purple"></span>
                        <span class="btn-color-option gradient-45deg-deep-orange-orange"
                              data-color="gradient-45deg-deep-orange-orange"></span>
                        <span class="btn-color-option gradient-45deg-green-teal"
                              data-color="gradient-45deg-green-teal"></span>
                        <span class="btn-color-option gradient-45deg-indigo-light-blue"
                              data-color="gradient-45deg-indigo-light-blue"></span>
                        <span class="btn-color-option gradient-45deg-red-pink"
                              data-color="gradient-45deg-red-pink"></span>
                    </div>
                    <div class="solid-color center-align">
                        <span class="btn-color-option red" data-color="red"></span>
                        <span class="btn-color-option purple" data-color="purple"></span>
                        <span class="btn-color-option pink" data-color="pink"></span>
                        <span class="btn-color-option deep-purple" data-color="deep-purple"></span>
                        <span class="btn-color-option cyan" data-color="cyan"></span>
                        <span class="btn-color-option teal" data-color="teal"></span>
                        <span class="btn-color-option light-blue" data-color="light-blue"></span>
                        <span class="btn-color-option amber" data-color="amber"></span>
                        <span class="btn-color-option brown" data-color="brown"></span>
                    </div>
                </div>
            </div>



            <!--Select Menu Size start-->
            <hr class="customize-devider"/>
            <h6 class="mt-3">Select Menu Size</h6>
            <div class="btn-options row">
                <div class="col s12">
                    <select id="menusize">
                        @foreach($colors as $color)
                        <option value="8px" {{ $color->menu_size == "8px" ? ' selected="" ' : '' }}>8px</option>
                        <option value="10px" {{ $color->menu_size == "10px" ? ' selected="" ' : '' }}>10px</option>
                        <option value="12px" {{ $color->menu_size == "12px" ? ' selected="" ' : '' }}>12px</option>
                        <option value="14px" {{ $color->menu_size == "14px" ? ' selected="" ' : '' }}>14px</option>
                        <option value="16px" {{ $color->menu_size == "16px" ? ' selected="" ' : '' }}>16px</option>
                        <option value="18px" {{ $color->menu_size == "18px" ? ' selected="" ' : '' }}>18px</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!--Select Menu Size end-->


            <!--Select BreadCrumb Size start-->
            <hr class="customize-devider"/>
            <h6 class="mt-3">Select BreadCrumb Size</h6>
            <div class="btn-options row">
                <div class="col s12">
                    <select id="breadcrumbsize">
                        @foreach($colors as $color)
                        <option value="8px" {{ $color->breadcrumb_size == "8px" ? ' selected="" ' : '' }}>8px</option>
                        <option value="10px" {{ $color->breadcrumb_size == "10px" ? ' selected="" ' : '' }}>10px</option>
                        <option value="12px" {{ $color->breadcrumb_size == "12px" ? ' selected="" ' : '' }}>12px</option>
                        <option value="14px" {{ $color->breadcrumb_size == "14px" ? ' selected="" ' : '' }}>14px</option>
                        <option value="16px" {{ $color->breadcrumb_size == "16px" ? ' selected="" ' : '' }}>16px</option>
                        <option value="18px" {{ $color->breadcrumb_size == "18px" ? ' selected="" ' : '' }}>18px</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!--Select BreadCrumb Size end-->



            <!--Select Title Size start-->
            <hr class="customize-devider"/>
            <h6 class="mt-3">Select Title Size</h6>
            <div class="btn-options row">
                <div class="col s12">
                    <select id="titlesize">
                        @foreach($colors as $color)

                        <option value="18px" {{ $color->title_size == "18px" ? ' selected="" ' : '' }}>18px</option>
                        <option value="20px" {{ $color->title_size == "20px" ? ' selected="" ' : '' }}>20px</option>
                        <option value="22px" {{ $color->title_size == "22px" ? ' selected="" ' : '' }}>22px</option>
                        <option value="24px" {{ $color->title_size == "24px" ? ' selected="" ' : '' }}>24px</option>
                        <option value="26px" {{ $color->title_size == "26px" ? ' selected="" ' : '' }}>26px</option>
                        <option value="30px" {{ $color->title_size == "30px" ? ' selected="" ' : '' }}>30px</option>
                        <option value="32px" {{ $color->title_size == "32px" ? ' selected="" ' : '' }}>32px</option>
                        <option value="34px" {{ $color->title_size == "34px" ? ' selected="" ' : '' }}>34px</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!--Select Title Size end-->


            <!--Select Table Size start-->
            <hr class="customize-devider"/>
            <h6 class="mt-3">Select Table Size</h6>
            <div class="btn-options row">
                <div class="col s12">
                    <select id="tablesize">
                        @foreach($colors as $color)
                        <option value="13px" {{ $color->table_size == "13px" ? ' selected="" ' : '' }}>13px</option>
                        <option value="15px" {{ $color->table_size == "15px" ? ' selected="" ' : '' }}>15px</option>
                        <option value="18px" {{ $color->table_size == "18px" ? ' selected="" ' : '' }}>18px</option>
                        <option value="22px" {{ $color->table_size == "22px" ? ' selected="" ' : '' }}>22px</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!--Select Table Size end-->


            <!--Select Label Size start-->
            <hr class="customize-devider"/>
            <h6 class="mt-3">Select Label Size</h6>
            <div class="btn-options row">
                <div class="col s12">
                    <select id="labelsize">
                        @foreach($colors as $color)
                        <option value="8px" {{ $color->label_size == "8px" ? ' selected="" ' : '' }}>8px</option>
                        <option value="10px" {{ $color->label_size == "10px" ? ' selected="" ' : '' }}>10px</option>
                        <option value="12px" {{ $color->label_size == "12px" ? ' selected="" ' : '' }}>12px</option>
                        <option value="14px" {{ $color->label_size == "14px" ? ' selected="" ' : '' }}>14px</option>
                        <option value="16px" {{ $color->label_size == "16px" ? ' selected="" ' : '' }}>16px</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!--Select Label Size end-->



            <!--Select Font start-->
            <hr class="customize-devider"/>
            <h6 class="mt-3">Select Font</h6>
            <div class="row">
                <div class="col s12">
                    <select id="fontfamily">

                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <button type="submit" class="btn btn-color" id="submit">Apply
                        <i class="material-icons right">save</i>
                    </button>
                    <button class="btn btn-color defaultTheme">Default
                        <i class="material-icons right">rotate_left</i>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div> 


<script src="{{asset('js/ajax/jquery.min.js')}}"></script>
<script src="{{asset('js/scripts/advance-ui-modals.js')}}"></script>
