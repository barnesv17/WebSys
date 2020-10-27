// Create closure.
(function( $ ) {
  
  var default_settings = {
    userName : "User#",
    guessNum : 3
  }


  // Loads game (add box, sliders, text areas, guess buttons, score display area)
  function loadGame() {
    var settingButton = "<button id='settingsButton'>Settings</button>";
    var colorSwatch = '<div id="box"></div>';
    var sliders = '<div class="sliders"><div class="slidecontainer"><p>R</p><input type="range" min="0" max="255" value="0" class="slider" id="Rrange"><p id="Rdemo"></p></div><div class="slidecontainer"></div><div class="slidecontainer"><p>G</p><input type="range" min="0" max="255" value="0" class="slider" id="Grange"><p id="Gdemo"></p></div><div class="slidecontainer"><div class="slidecontainer"><p>B</p><input type="range" min="0" max="255" value="0" class="slider" id="Brange"><p id="Bdemo"></p></div></div>';
    var textAreas = '<div class="textboxes"><div class="textbox"><input type="text" placeholder="Input R Value" id="Rtext"></div><div class="textbox"><input type="text" placeholder="Input G Value" id="Gtext"></div><div class="textbox"><input type="text" placeholder="Input B Value" id="Btext"></div></div>';
    var guessButton = '<button type="button" id="guessButton">Guess!</button>';
    var percentage = '<div id="percents"></div>';
    $("#guesser").append(sliders, textAreas);
    $("#colorSwatch").append(settingButton);
    $("#colorSwatch").append(colorSwatch);
    $("#gamePlay").append(guessButton, percentage);
  }

  function addGameComponents() {
    var red = Math.floor( Math.random() * 256 );
    var green = Math.floor( Math.random() * 256 );
    var blue = Math.floor( Math.random() * 256 );
    var rgb = "rgb(" + red + "," + green + "," + blue + ")";
    $("#box").css("background-color", rgb);

  }

  // takes a json query "usr_settings", validate, and extend to default settings
  function loadUserSettings(usr_settings) {
    if (usr_settings.guessNum > 5 || usr_settings.guessNum < 1) {
      var settings = $.extend({}, default_settings, usr_settings)
      alert("Settings change successful!" + JSON.stringify(settings));
    }
  } 

  // Plugin definition.
  // Create onclick event in hexed.js, when start button is clicked, load game & other functionalities
  // Call multiple subfunctions to complete game plays
  $.fn.hexed = function() {
    $("#startGame").remove();
    loadGame();
    loadUserSettings(default_settings);
    addGameComponents();
    return this;
  };



})( jQuery );

$(document).ready(function() {
  $("#startGame").click(function() { 
    $("body").hexed();
  });
});