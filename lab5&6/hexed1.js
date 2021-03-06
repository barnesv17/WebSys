(function ($) {
  // Plugin function
  $.fn.hexed = function ({ username, turns }) {

    //----Setup Global Variables----------------------------------------------
    let re = new RegExp('^0x[0-9A-Fa-f]{2}$');
    let timerInterval = null;
    let numTurns = 0;
    let score = null;
    let topscore = 0;
    let goal = {
      r: null,
      g: null,
      b: null
    };

    //----Setup Gameplay HTML---------------------------------------------------
    let startButton = $('<button id="startButton"/>').text('Start Game');
    let settingsButton = $('<button id="settingsButton"/>').text('Settings');
    let settingsDialog = $('<div id="settingsDialog"/>');
    let highscoresDialog = $('<div id="highscoresDialog"/>');
    let usernameSettings = $('<p id="usernameSettings"/>').text("Username");
    let usernameTextArea = $('<input type="text" id="usernameText"/>');
    usernameTextArea.attr("placeholder", username);
    let numTurnsSlider = $('<div id="turnsSlider"/>');
    let numTurnsSliderTitle = $('<p id="turnsTitle"><label for="amount">Number of Guesses</label><input type="text" id="amount"></p>');
    
    let gameinfoContainer = $('<div id="gameinfoContainer" />')
    let gameContentContainer = $('<div id="gameContentContainer" />')

    let guesscounter = $('<p id="numguesses"/>').text('Guesses Remaining: ' + Number(turns).toString());
    let timer = $('<p id="timer"/>');
    let bestscorep = $('<p id="bestscore"/>').text('Top Score: 0');
    let currentscorep = $('<p id="score"/>').text('Current Score: 0');
    let box = $('<div id="box"/>');
    let highscoresTable = $('<table id="highscoresTable"/>');

    let slidersdiv = $('<div class="sliders"/>');
    let slidecontainers = {
      r: $('<div class="slidecontainer"/>'),
      g: $('<div class="slidecontainer"/>'),
      b: $('<div class="slidecontainer"/>')
    };
    let sliders = {
      r: $('<div id="red"/>'),
      g: $('<div id="green"/>'),
      b: $('<div id="blue"/>')
    };
    let labels = {
      r: $('<p id="rlabel"/>').text('R'),
      g: $('<p id="glabel"/>').text('G'),
      b: $('<p id="blabel"/>').text('B')
    };
    let displayValues = {
      r: $('<p id="rdisplay"/>').text('0x' + Number(sliders.r.val()).toString(16).toUpperCase()),
      g: $('<p id="gdisplay"/>').text('0x' + Number(sliders.g.val()).toString(16).toUpperCase()),
      b: $('<p id="bdisplay"/>').text('0x' + Number(sliders.b.val()).toString(16).toUpperCase())
    };

    let textboxesdiv = $('<div class="textboxes"/>');
    let textboxcontainers = {
      r: $('<div class="textbox" id="rtext"/>'),
      g: $('<div class="textbox" id="gtext"/>'),
      b: $('<div class="textbox" id="btext"/>')
    };
    let textboxes = {
      r: $('<input type="text" placeholder="Input R Value" id="Rtext"/>'),
      g: $('<input type="text" placeholder="Input G Value" id="Gtext"/>'),
      b: $('<input type="text" placeholder="Input B Value" id="Btext"/>')
    };

    let guesser = $('<div id="guesser"/>');
    slidecontainers.r.append(labels.r).append(sliders.r).append(displayValues.r);
    slidecontainers.g.append(labels.g).append(sliders.g).append(displayValues.g);
    slidecontainers.b.append(labels.b).append(sliders.b).append(displayValues.b);
    slidersdiv.append(slidecontainers.r).append(slidecontainers.g).append(slidecontainers.b);
    guesser.append(slidersdiv);
    textboxcontainers.r.append(textboxes.r);
    textboxcontainers.g.append(textboxes.g);
    textboxcontainers.b.append(textboxes.b);
    textboxesdiv.append(textboxcontainers.r).append(textboxcontainers.g).append(textboxcontainers.b)
    guesser.append(textboxesdiv);

    $(function () {
      $("#red").slider({
        orientation: "horizontal",
        max: 255,
        value: 0,
      });

      $("#green").slider({
        orientation: "horizontal",
        max: 255,
        value: 0,
      });

      $("#blue").slider({
        orientation: "horizontal",
        max: 255,
        value: 0,
      });
    });



    //-----Add to dialog---------------------------------------------------------
    settingsDialog.append(usernameSettings).append(usernameTextArea);
    settingsDialog.append(numTurnsSliderTitle).append(numTurnsSlider);
    guesser.append(settingsDialog).append(highscoresDialog);
    highscoresDialog.append(highscoresTable);

    let guessButton = $('<button id="guessButton"/>').text('Guess!');
    let nextGameButton = $('<button id="nextButton"/>').text('New Game');
    let highscoresButton = $('<button id="highscoresButton"/>').text('High Scores');
    let playpauseMusicButton = $('<button id="playpauseMusicButton"/>').text('Pause Music');
    let percents = $('<div id="percents"/>');
    let scores = $('<div id="scoresDiv"/>');
    scores.append(bestscorep).append(currentscorep);
    $('#game').append(startButton);
    $('#game').append(scores);
    $('#game').append(gameinfoContainer);
    $('#game').append(gameContentContainer)
    $('#game').append(guessButton).append(nextGameButton).append(settingsButton);
    $('#game').append(percents).append(highscoresButton);
    $('#game').append(playpauseMusicButton);
    $('#gameinfoContainer').append(timer).append(guesscounter);
    $('#gameContentContainer').append(box).append(guesser);

    timer.hide();
    guesscounter.hide();
    gameinfoContainer.hide();
    bestscorep.hide();
    currentscorep.hide();
    box.hide();
    guesser.hide();
    guessButton.hide();
    percents.hide();
    nextGameButton.hide();
    highscoresButton.hide();

    //----Start handler---------------------------------------------------------
    function getRandom() {
      return Math.floor(Math.random() * 256);
    };
    function start() {
      $('#header').text("Let's play Hexed, " + username + "!");
      $('#startButton').remove();
      timer.show();
      bestscorep.show();
      currentscorep.css('color', 'red');
      currentscorep.text('Current Score: 0');
      currentscorep.show();
      box.show();
      gameinfoContainer.show();
      guesser.show();
      guesscounter.show();
      guessButton.show();
      percents.hide();
      nextGameButton.hide();
      highscoresButton.hide();
      settingsButton.hide();
      timer.text('0.00secs');
      numTurns = 0;
      guesscounter.text("Turns Remaining: " + turns);
      score = 0;
      $("#red").slider("value", 0);
      $("#green").slider("value", 0);
      $("#blue").slider("value", 0);
      displayValues.r.html("0x00");
      displayValues.g.html("0x00");
      displayValues.b.html("0x00");
      textboxes.r.val("0x00");
      textboxes.g.val("0x00");
      textboxes.b.val("0x00");

      goal.r = getRandom();
      goal.g = getRandom();
      goal.b = getRandom();
      goalrgb = 'rgb(' + goal.r + ',' + goal.g + ',' + goal.b + ')';
      box.css('background-color', goalrgb);
      createScores();
      loadHighScores();

      //----Timer Implementation--------------------------------------------------
      startTime = Date.now();
      timerInterval = setInterval(function () {
        currentSecs = Math.floor((Date.now() - startTime) / 1000);
        currentMil = (Date.now() - startTime) - (currentSecs * 1000);
        output = '<p id="timer>' + currentSecs + '.' + currentMil + 'secs</p>';
        timer.text(currentSecs + '.' + currentMil + ' seconds');
      }, 1);
    };
    startButton.on('click', start);

    //----Settings Dialog-------------------------------------------------------
    function settingsApply() {
      username = usernameTextArea.val();
      turns = $("#turnsSlider").slider("value");
      $('#header').text("Let's play Hexed, " + username + "!");
    };

    $("#turnsSlider").slider({
      range: "min",
      min: 1,
      max: 5,
      value: turns,
      slide: function (event, ui) {
        $("#amount").val(ui.value);
      }
    });
    $("#amount").val($("#turnsSlider").slider("value"));
    $("#settingsDialog").dialog({
      autoOpen: false,
      buttons: {
        Apply: function () {
          settingsApply();
          $(this).dialog("close");
        }
      },
      title: "Settings",
      modal: true
    });
    settingsButton.on('click', function () {
      $("#settingsDialog").dialog("open");
    });

    //----Slider handlers-------------------------------------------------------
    function sliderChange(color, dec) {
      hexString = "0x" + Number(dec).toString(16).toUpperCase();
      if (color == 'r') {
        displayValues.r.html(hexString);
        textboxes.r.val(hexString);
      }
      if (color == 'g') {
        displayValues.g.html(hexString);
        textboxes.g.val(hexString);
      }
      if (color == 'b') {
        displayValues.b.html(hexString);
        textboxes.b.val(hexString);
      }
    };
    $("#red").on("slidechange", function (event, ui) {
      rval = $("#red").slider("value");
      sliderChange('r', rval);
    });
    $("#red").on("slide", function (event, ui) {
      rval = $("#red").slider("value");
      sliderChange('r', rval);
    });
    $("#green").on("slidechange", function (event, ui) {
      gval = $("#green").slider("value");
      sliderChange('g', gval);
    });
    $("#green").on("slide", function (event, ui) {
      gval = $("#green").slider("value");
      sliderChange('g', gval);
    });
    $("#blue").on("slidechange", function (event, ui) {
      bval = $("#blue").slider("value");
      sliderChange('b', bval);
    });
    $("#blue").on("slide", function (event, ui) {
      bval = $("#blue").slider("value");
      sliderChange('b', bval);
    });

    //----Textbox handlers------------------------------------------------------
    function textboxChange(e, color, hex) {
      if (e.which == 13) {
        if (!re.test(hex)) {
          alert("Please enter a valid hex value in the format '0x__'");
        }
        else {
          dec = parseInt(hex, 16);
          if (color == 'r') {
            $("#red").slider("value", dec);
            displayValues.r.html(hex.toUpperCase());
          }
          if (color == 'g') {
            $("#green").slider("value", dec);
            displayValues.g.html(hex.toUpperCase());
          }
          if (color == 'b') {
            $("#blue").slider("value", dec);
            displayValues.b.html(hex.toUpperCase());
          }
        }
      }
    };
    textboxes.r.on('keypress', function (e) {
      textboxChange(e, 'r', textboxes.r.val());
    });
    textboxes.g.on('keypress', function (e) {
      textboxChange(e, 'g', textboxes.g.val());
    });
    textboxes.b.on('keypress', function (e) {
      textboxChange(e, 'b', textboxes.b.val());
    });

    //----Guess handler---------------------------------------------------------
    function percentOff(correct, guess) {
      return Math.round(Math.abs((correct - guess) / 255) * 100);
    };
    function calcScore(roff, goff, boff) {
      milTaken = Date.now() - startTime;
      score = (300 - (roff + goff + boff)) * ((20000 - milTaken) < 0 ? 0 : (20000 - milTaken));
      addNewScore(score, milTaken / 1000);
      return score;
    };
    guessButton.on('click', function () {
      numTurns += 1;

      guesscounter
      guesscounter.text('Turns Remaining: ' + Number(turns - numTurns).toString());

      roff = percentOff(goal.r, $("#red").slider("value"));
      goff = percentOff(goal.g, $("#green").slider("value"));
      boff = percentOff(goal.b, $("#blue").slider("value"));
      var rstring = "<p>Red: ";
      var gstring = "<p>Green: ";
      var bstring = "<p>Blue: ";
      var correctstring = "You got it! (0&#37; off)</p>";
      var incorrectstring = "&#37; off</p>"

      if (roff == 0) { rstring += correctstring; }
      else { rstring += roff + incorrectstring; }

      if (goff == 0) { gstring += correctstring; }
      else { gstring += goff + incorrectstring; }

      if (boff == 0) { bstring += correctstring; }
      else { bstring += boff + incorrectstring; }

      var output = rstring + gstring + bstring;
      percents.html(output);
      percents.show();

      // if this is a new top score, then replace the old one
      score = calcScore(roff, goff, boff);
      if (score > topscore) {
        topscore = score;
        bestscorep.text("Top Score: " + topscore);
        currentscorep.css('color', 'black');
        currentscorep.text("Current Score: " + topscore);
      }
      // if the score is equal to or worse than the best, display in diff color
      else {
        currentscorep.css('color', 'red');
        currentscorep.text("Current Score: " + score);
      }

      // If the guess is correct or there are no more turns, end game
      if ((roff == 0 && goff == 0 && boff == 0) || numTurns == turns) {
        clearInterval(timerInterval);
        $('#guessButton').hide();
        $('#settingsButton').show();
        $('#nextButton').show();
        $('#highscoresButton').show();
      }
    });
    nextGameButton.on('click', start);

    //---- Extra Credit-----------------------------------------------------------
    function loadHighScores() {
      var highScores = (window.localStorage.getItem("highScores"));
      highScores = JSON.parse(highScores);
      highscoresTable.html('<table id="highscoresTable"/>');
      for (let i = 1; i < 11; i++) {
        let highscorerow = $('<tr></tr>');
        let highscoreuser = $('<td></td>');
        let highscore = $('<td></td>');
        let highscoretime = $('<td></td>');
        if (i != 10) {
          highscoreuser.append('0' + String(i) + '. ' + highScores[i].user + ': ');
        }
        else {
          highscoreuser.append(String(i) + '. ' + highScores[i].user + ': ');
        }
        highscore.append(highScores[i].score);
        highscoretime.append(highScores[i].time + 's');
        highscorerow.append(highscoreuser).append(highscore).append(highscoretime);
        highscoresTable.append(highscorerow);
      }
    }

    function addNewScore(score, guesstime) {
      var highScores = (window.localStorage.getItem("highScores"));
      highScores = JSON.parse(highScores);
      for (let i = 1; i < 11; i++) {
        if (highScores[i].score < score || (highScores[i].score == score && highScores[i].time < guesstime)) {
          for (let j = 10; j > i; j--) {
            highScores[j] = highScores[j - 1];
          }
          console.log(username, score, guesstime);
          highScores[i] = { "user": username, "score": score, "time": guesstime }
          break;
        }
      }
      window.localStorage.setItem("highScores", JSON.stringify(highScores));
    }

    function createScores() {
      if (!window.localStorage.highScores) {
        var emptyHighScores = {
          1: { user: "Player Name", score: 0, time: 0.000 }, 2: { user: "Player Name", score: 0, time: 0.000 },
          3: { user: "Player Name", score: 0, time: 0.000 }, 4: { user: "Player Name", score: 0, time: 0.000 }, 5: { user: "Player Name", score: 0, time: 0.000 },
          6: { user: "Player Name", score: 0, time: 0.000 }, 7: { user: "Player Name", score: 0, time: 0.000 }, 8: { user: "Player Name", score: 0, time: 0.000 },
          9: { user: "Player Name", score: 0, time: 0.000 }, 10: { user: "Player Name", score: 0, time: 0.000 }
        }
        window.localStorage.setItem("highScores", JSON.stringify(emptyHighScores))
        console.log("Created New Empty High Scores Table in Local Storage")
      }
    }

    $("#highscoresDialog").dialog({
      autoOpen: false,
      title: "High Scores",
      width: 'auto',
      modal: true
    });
    highscoresButton.on('click', function () {
      loadHighScores();
      $("#highscoresDialog").dialog("open");
    });

    //-----Play/Pause music------------------------------------------------------------
    var bgm = document.getElementById("backgroundmusic");
    var musicPlaying = true;
    function playMusic() {
      bgm.play();
    }

    function pauseMusic() {
      bgm.pause();
    }

    playpauseMusicButton.on('click', function() {
      if (musicPlaying) {
        pauseMusic();
        playpauseMusicButton.text('Play Music')
      } else {
        playMusic();
        playpauseMusicButton.text('Pause Music')
      }
      musicPlaying = !musicPlaying;
    });
  };

  

})(jQuery);
