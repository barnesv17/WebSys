$(document).ready(function () {
  // $("#userinfo").hide();
  // $("#studioinfo").hide();
  // $("#genreinfo").hide();
  // $("#sysinfo").hide();

  $('.ins').on('click', function() {
    $('#instructions').show();
    $('.tb').hide();
  });

  if ($('.tb').is(":visible")) {
    $('#instructions').hide();
  }

  // if ($("#userinfo").is(":visible") || $("#studioinfo").is(":visible")) {
  //   $('#instructions').hide();
  // }



});