  
  // Navbar globals
  // NOTE: added state management so that the navbar toggle state is kept across page reloads
  var shouldToggle = function(state){ //only set state param if you need to change the state of should_nav_toggle, if left blank then it will simply return the value of should_nav_toggle
    if(typeof state == "undefined"){
      try{
        return appDB.get('should_nav_toggle')
      }
      catch(e){
        appDB.set('should_nav_toggle', false)
        return false
      }
    }
    //NOTE TO SELF: add check that checks that state is boolean
    else appDB.set('should_nav_toggle', state) // if state param is not undefined then update the state of should_nav_toggle
  };

  var $sidenav = $("#side-nav")
  var $toggleBtn = $("#toggle")
  
  //navbar functions
  function toggleNav() {
    var toggle = shouldToggle()
    $("#toggle-icon").css('transform', toggle ? 'rotate(0deg)' : 'rotate(180deg)')
    shouldToggle(!toggle) //update should_nav_toggle state
  }
  function openNav() {
    if (shouldToggle()) {
      $sidenav.addClass("side-nav-expanded").removeClass("side-nav-collapsed");
      // using custom functions view util.js
      $('.sidenav-text-hidden').addClass("sidenav-text-visible").removeClass("sidenav-text-hidden")
    }
  }
  function closeNav() {
    if (shouldToggle()) {
      $sidenav.addClass("side-nav-collapsed").removeClass("side-nav-expanded")
      $(".sidenav-text-visible").addClass("sidenav-text-hidden").removeClass("sidenav-text-visible")
    }
  }
  
  // Use the state of the should_nav_toggle to show or hide the nav on page reload
  if(shouldToggle()){
    $("#toggle-icon").css('transform', 'rotate(180deg)')
    closeNav()
  }
  else{
    $(".toggle-icon").css("transform", 'rotate(0deg)')
    openNav()
  }
  // Event handler definitions
  $toggleBtn.click(toggleNav)
  $sidenav.hover(openNav, closeNav)