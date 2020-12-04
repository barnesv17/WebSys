$(document).ready(function () {

  $('.nav-item').on('click', function() {
    $('#instructions').hide();
  });

  $('.ins').on('click', function() {
    $('#instructions').show();
  });

});