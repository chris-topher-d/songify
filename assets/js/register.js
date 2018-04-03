$(document).ready(function() {
  $(".new-user").hide();
  $(".returning-user").show();

  $("#hide-login").click(function() {
    $(".returning-user").hide();
    $(".new-user").show();
  });

  $("#hide-register").click(function() {
    $(".new-user").hide();
    $(".returning-user").show();
  });
});
