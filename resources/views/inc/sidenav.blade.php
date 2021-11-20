<!-- Side Nav bar -->
   <nav class="nav flex-column side-nav-expanded" id="side-nav" onmouseover="openNav()" onmouseout="closeNav()">

      <a class="nav-link sidenav-items pl-4" href="/">
        <i class="fa fa-tachometer"></i>
        <span class="ml-2 sidenav-text-visible sidenav-text" id="dashboard">Dashboard</span>
      </a>

      <a class="nav-link sidenav-items pl-4" href="/timesheet">
        <i class="fa fa-clock-o"></i>
        <span class="ml-2 sidenav-text-visible sidenav-text" id="timesheet">Timesheet</span>
      </a>

      <a class="nav-link sidenav-items pl-4" href="/reports">
        <i class="fa fa-file"></i>
        <span class="ml-2 sidenav-text-visible sidenav-text" id="reports">Reports</span>
      </a>

      @if($isAdmin)
      <a class="nav-link sidenav-items pl-4" href="/user">
        <i class="fa fa-users"></i>
        <span class="ml-2 sidenav-text-visible sidenav-text" id="management">User Management</span>
      </a>

      <a class="nav-link sidenav-items pl-4" href="/system-settings">
        <i class="fa fa-cogs"></i>
        <span class="ml-2 sidenav-text-visible sidenav-text" id="settings">System Settings</span>
      </a>
      @endif
      <a class="nav-link sidenav-items pl-4" id="toggle" onclick="toggleNav()">
        <i class="fa fa-thumb-tack" id="toggle-icon"></i>
      </a>

    </nav>
    <!-- Mobile menu -->
    <div id="mobile-menu">
      <nav class="nav flex-column mobile-nav">

        <a class="nav-link sidenav-items" href="/">
          <i class="fa fa-tachometer"></i>
          <span class="ml-2 sidenav-text-visible sidenav-text" id="dashboard">Dashboard</span>
        </a>

        <a class="nav-link sidenav-items" href="/timesheet">
          <i class="fa fa-clock-o"></i>
          <span class="ml-2 sidenav-text-visible sidenav-text" id="timesheet">Timesheet</span>
        </a>

        <a class="nav-link sidenav-items" href="/reports">
          <i class="fa fa-file"></i>
          <span class="ml-2 sidenav-text-visible sidenav-text" id="reports">Reports</span>
        </a>
        @if($isAdmin)
        <a class="nav-link sidenav-items" href="/user">
          <i class="fa fa-users"></i>
          <span class="ml-2 sidenav-text-visible sidenav-text" id="management">User Management</span>
        </a>

        <a class="nav-link sidenav-items" href="/system-settings">
          <i class="fa fa-cogs"></i>
          <span class="ml-2 sidenav-text-visible sidenav-text" id="settings">System Settings</span>
        </a>
        @endif
        <a class="nav-link sidenav-items" href="/settings">
          <i class="fa fa-cog mr-2"></i>
            <span class="ml-2 sidenav-text-visible sidenav-text" id="preferences">Preferences</span>
          </a>

        <a class="nav-link sidenav-items" href="/signout">
          <i class="fa fa-sign-out"></i>
          <span class="ml-2 sidenav-text-visible sidenav-text" id="signout">Sign Out</span>
        </a>

      </nav>
    </div>

    <!--/js/nav.js include-->
    <script src="{{asset('js/nav.js')}}" type="text/javascript"></script>