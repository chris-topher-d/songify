$(document).ready(function() {
  $(".newUser").hide();
  $(".returningUser").show();

  $("#hideLogin").click(function() {
    $(".returningUser").hide();
    $(".newUser").show();
  });

  $("#hideRegister").click(function() {
    $(".newUser").hide();
    $(".returningUser").show();
  });
});
