// Create closure.
(function( $ ) {
  
  var default_settings = {
    userName = "User#",
    guessNum = 3
  }
  // Plugin definition.
  // Create onclick event in hexed.js, when start button is clicked, load game & other functionalities
  // Call multiple subfunctions to complete game plays
  $.fn.hexed = function(usr_settings) {
    $("#startButton").remove();
    loadGame();
  };

  // Loads game (add box, sliders, text areas, guess buttons, score display area)
  function loadGame() {
    var settingButton = "<button id='settingsButton'>Settins</button>";
    var colorSwatch = "";
    var sliders = "";
    // Add 3 JQ UI sliders under
  }
  // takes a json query "usr_settings", validate, and extend to default settings
  function loadUserSettings(usr_settings) {
    if (usr_settings.guessNum > 5 || usr_settings.guessNum < 1) {
      var settings = $.extend({}, default_settings, usr_settings)
      alert("Settings change successful!" + JSON.stringify(settings));
    }
  } 

})( jQuery );