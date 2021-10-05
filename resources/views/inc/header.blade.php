<header id="header">
<!-- Top Nav bar with ksm logo and user icon -->
    <div id="top-nav" class="d-flex">
      <div class="mr-auto align-self-center pl-5">
        <a href="/"><img src="{{$logo}}" style="width:18em;"></a>
      </div>

      <ul class="nav ml-auto align-self-center pr-5">
        <li class="nav-item">
          <a class="nav-link" href=""><i class="fa fa-bell" id="notifications"></i></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown"><i class="fa fa-user" id="user-icon"></i></a>
          <div class="dropdown-menu" id="profile-dropdown">
            <a class="dropdown-item" href=""><i class="fa fa-bell mr-2"></i>ACTION HERE</a>
            <a class="dropdown-item" href="/settings"><i class="fa fa-cog mr-2"></i>Settings</a>
            <a class="dropdown-item" href="/signout"><i class="fa fa-sign-out mr-2"></i>Sign Out</a>
          </div>
        </li>
      </ul>
    </div>

    @include('inc.sidenav')
</header>
