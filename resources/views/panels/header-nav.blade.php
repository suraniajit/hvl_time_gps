
<header class="header">
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
                <div class="navbar-header">
                    <a id="toggle-btn" href="#" class="menu-btn center p-2"><i class="icon-bars"> </i></a>
                    <a href="<?php echo $business_logo; ?>" class="navbar-brand center">
                        <img src="<?php echo $business_logo; ?>" class="img-responsive" height="75" alt="">
                        <div class="brand-text d-none d-md-inline-block mt-2">
                            <strong class="text-primary">HVl Pest Control</strong>
                        </div>
                    </a>
                </div>

                <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                   
                    <li >
                            <span class="row" stype="margin: 10px ">
                                <div class="brand-text d-none d-md-inline-block mt-2">
                                    <strong class="_clock_watch mr-2" style="color: yellow">00:00:00</strong>
                                </div>
                                <div class="brand-text d-none d-md-inline-block mt-2">
                                    <a href="{{route('start_stop_watch')}}"  class="btn btn-primary rounded-pill pull-right mr-2" id="__start_clock"><i class="fa fa-sharp fa-play"></i></a>
                                </div>
                                <div class="brand-text d-none d-md-inline-block mt-2">
                                    <a href="{{route('start_stop_watch')}}"  class="btn btn-secondary rounded-pill pull-right mr-2" id="__pause_clock"><i class="fa fa-pause" aria-hidden="true"></i></a>
                                </div>
                                <div class="brand-text d-none d-md-inline-block mt-2">
                                    <a href="{{route('stop_stop_watch')}}"  class="btn btn-primary rounded-pill pull-right mr-2" id="__stop_clock"><i class="fa fa-stop-circle-o" aria-hidden="true"></i></a>
                                </div>
                            </span>
                    </li>

                    <li class="logout">
                        <a class=" waves-block waves-light" href="javascript:void(0)">
                           Logout <i class="fa fa-sign-out fa-lg"></i>
                        </a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a class="dropdown-item" href="{{ route('logout') }}"--}}
{{--                           onclick="event.preventDefault();--}}
{{--                                                     document.getElementById('logout-form').submit();">--}}
{{--                            <span class="d-none d-sm-inline-block">Logout</span>--}}
{{--                                                        <i class="fa fa-sign-out"></i>--}}
{{--                        </a>--}}

{{--                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">--}}
{{--                            @csrf--}}
{{--                        </form>--}}
{{--                    </li>--}}
                </ul>
            </div>
        </div>
    </nav>

</header>
