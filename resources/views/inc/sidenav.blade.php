<!-- Side Nav bar -->
    <nav class="nav flex-column side-nav-expanded" id="side-nav">

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

      <a class="nav-link sidenav-items pl-4" href="/user">
        <i class="fa fa-users"></i>
        <span class="ml-2 sidenav-text-visible sidenav-text" id="management">User Management</span>
      </a>

      <a class="nav-link sidenav-items pl-4" href="/system-settings">
        <i class="fa fa-cogs"></i>
        <span class="ml-2 sidenav-text-visible sidenav-text" id="settings">Settings</span>
      </a>

      <a class="nav-link sidenav-items pl-4" id="toggle">
        <i class="fa fa-chevron-left" id="toggle-icon"></i>
      </a>

    </nav>
    <!--/js/nav.js include-->
    <script src="{{asset('js/nav.js')}}" type="text/javascript"></script>