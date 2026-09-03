$("#menu-toggle").click(function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
  if ($("#wrapper").hasClass("toggled")) {
    localStorage.chk_menu = 1;
  }else{
    localStorage.chk_menu = 0;
  }
});
$(function(){
  if (localStorage.chk_menu == 1 ) {
    $("#wrapper").addClass("toggled");
  }else{
    $("#wrapper").removeClass("toggled");
  }
})