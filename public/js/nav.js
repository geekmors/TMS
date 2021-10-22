//navbar functions
var toggle = false;

function toggleNav() {
  if( toggle )
    document.getElementById("toggle-icon").style.color = '#025426';
  else
    document.getElementById("toggle-icon").style.color = '#3b3b3b';

  toggle = !toggle;
}

var mobiletoggle = false;

function toggleMobileMenu() {
  if( mobiletoggle )
    document.getElementById("mobile-menu").style.height = "100%";
  else
    document.getElementById("mobile-menu").style.height = "0%";

  mobiletoggle = !mobiletoggle;
};


/* This is a terrible way of doing it, but getelementsbyclass wasn't working for me for some reason */
function openNav() {
   if( toggle ) {

    var sidenav = document.getElementById("side-nav");

    sidenav.classList.add("side-nav-expanded");
    sidenav.classList.remove("side-nav-collapsed");

    document.getElementById("dashboard").classList.remove("sidenav-text-hidden");
    document.getElementById("dashboard").classList.add("sidenav-text-visible");

    document.getElementById("timesheet").classList.remove("sidenav-text-hidden");
    document.getElementById("timesheet").classList.add("sidenav-text-visible");

    document.getElementById("reports").classList.remove("sidenav-text-hidden");
    document.getElementById("reports").classList.add("sidenav-text-visible");

    document.getElementById("management").classList.remove("sidenav-text-hidden");
    document.getElementById("management").classList.add("sidenav-text-visible");

    document.getElementById("settings").classList.remove("sidenav-text-hidden");
    document.getElementById("settings").classList.add("sidenav-text-visible");
  }
}

function closeNav() {
  if( toggle ){
    var sidenav = document.getElementById("side-nav");

    sidenav.classList.add("side-nav-collapsed");
    sidenav.classList.remove("side-nav-expanded");

    document.getElementById("dashboard").classList.remove("sidenav-text-visible");
    document.getElementById("dashboard").classList.add("sidenav-text-hidden");

    document.getElementById("timesheet").classList.remove("sidenav-text-visible");
    document.getElementById("timesheet").classList.add("sidenav-text-hidden");

    document.getElementById("reports").classList.remove("sidenav-text-visible");
    document.getElementById("reports").classList.add("sidenav-text-hidden");

    document.getElementById("management").classList.remove("sidenav-text-visible");
    document.getElementById("management").classList.add("sidenav-text-hidden");

    document.getElementById("settings").classList.remove("sidenav-text-visible");
    document.getElementById("settings").classList.add("sidenav-text-hidden");
  }
}
