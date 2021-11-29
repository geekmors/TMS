<header id="header">
    <!-- Top Nav bar with ksm logo and user icon -->
    <div id="top-nav" class="d-flex">
        <div class="align-self-center logo-div">
            <a href="/"><img id="logo" src="/sysimages/ksm-logo.png" ></a>
        </div>

        <ul class="nav ml-auto align-self-center">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown">
                    @if(!empty($userSetting))
                    @if($userSetting['avatar'])
                    <img id="userAvatar" src="{{$userSetting['avatar']}}" alt="User Avatar">
                    @elseif($userSetting['avatar_original'])
                    <img id="userAvatar" src="{{$userSetting['avatar_original']}}" alt="User Avatar">
                    @else
                    <i class="fa fa-user" id="user-icon"></i>
                    @endif
                    @else
                    <i class="fa fa-user" id="user-icon"></i>
                    @endif
                </a>
                <div class="dropdown-menu" id="profile-dropdown">
                    <a class="dropdown-item" href="/preferences"><i class="fa fa-user mr-2"></i>{{auth()->user()->first_name.' '.auth()->user()->last_name}}</a>
                    <a class="dropdown-item" href="/signout"><i class="fa fa-sign-out mr-2"></i>Sign Out</a>
                </div>
            </li>
        </ul>
    </div>
    <div id="mobile-menu-li" onclick="toggleMobileMenu()">
        <i class="fa fa-bars" id="mobile-menu-icon"></i>
    </div>
    @include('inc.sidenav')
</header>
