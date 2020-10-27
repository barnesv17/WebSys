(function($) {
  // Plugin function
  $.fn.hexed = function({ username, turns }) {

    //----Setup Global Variables----------------------------------------------
    let re = new RegExp( '^0x[0-9A-Fa-f]{2}$' );
    let numTurns = 0;
    let score = null;
    let topscore = 0;
    let goal = {
      r: null,
      g: null,
      b: null
    };

    //----Setup Gameplay HTML---------------------------------------------------
    let startButton = $( '<button id="startButton"/>' ).text( 'Start Game' );
    let settingsButton = $( '<button id="settingsButton"/>' ).text( 'Settings' );
    let settingsDialog = $( '<div id="settingsDialog"/>');
    let usernameSettings = $('<p id="usernameSettings"/>').text("User name");
    let usernameTextArea = $('<input type="text" placeholder="User Name" id="usernameText"/>');
    let numTurnsSlider = $('<div id="turnsSlider"/>')
    let guesscounter = $( '<p id="numguesses"/>').text( 'Turns Remaining: ' + Number(turns).toString() );
    let timer = $( '<p id="timer"/>' );
    let bestscorep = $( '<p id="bestscore"/>' ).text( 'Top Score: 0' );
    let currentscorep = $( '<p id="score"/>' ).text( 'Current Score: 0' );
    let box = $( '<div id="box"/>' );

    let slidersdiv = $( '<div class="sliders"/>' );
    let slidecontainers = {
      r : $( '<div class="slidecontainer"/>' ),
      g : $( '<div class="slidecontainer"/>' ),
      b : $( '<div class="slidecontainer"/>' )
    };
    let sliders = {
      r: $( '<input type="range" min="0" max="255" value="0" class="slider" id="Rrange"/>' ),
      g: $( '<input type="range" min="0" max="255" value="0" class="slider" id="Grange"/>' ),
      b: $( '<input type="range" min="0" max="255" value="0" class="slider" id="Brange"/>' )
    };
    let labels = {
      r : $( '<p/>' ).text( 'R' ),
      g : $( '<p/>' ).text( 'G' ),
      b : $( '<p/>' ).text( 'B' )
    };
    let displayValues = {
      r : $( '<p/>' ).text( '0x' + Number( sliders.r.val() ).toString(16).toUpperCase() ),
      g : $( '<p/>' ).text( '0x' + Number( sliders.g.val() ).toString(16).toUpperCase() ),
      b : $( '<p/>' ).text( '0x' + Number( sliders.b.val() ).toString(16).toUpperCase() )
    };

    let textboxesdiv = $( '<div class="textboxes"/>' );
    let textboxcontainers = {
      r : $( '<div class="textbox"/>' ),
      g : $( '<div class="textbox"/>' ),
      b : $( '<div class="textbox"/>' )
    };
    let textboxes = {
      r: $( '<input type="text" placeholder="Input R Value" id="Rtext"/>' ),
      g: $( '<input type="text" placeholder="Input G Value" id="Gtext"/>' ),
      b: $( '<input type="text" placeholder="Input B Value" id="Btext"/>' )
    };

    let guesser = $( '<div id="guesser"/>' );
    slidecontainers.r.append( labels.r ).append( sliders.r ).append( displayValues.r );
    slidecontainers.g.append( labels.g ).append( sliders.g ).append( displayValues.g );
    slidecontainers.b.append( labels.b ).append( sliders.b ).append( displayValues.b );
    slidersdiv.append( slidecontainers.r ).append( slidecontainers.g ).append( slidecontainers.b );
    guesser.append( slidersdiv );
    textboxcontainers.r.append( textboxes.r );
    textboxcontainers.g.append( textboxes.g );
    textboxcontainers.b.append( textboxes.b );
    textboxesdiv.append( textboxcontainers.r ).append( textboxcontainers.g ).append( textboxcontainers.b )
    guesser.append( textboxesdiv );

    //-----Add to dialog---------------------------------------------------------
    guesser.append( settingsDialog );


    let guessButton = $( '<button id="guessButton"/>' ).text( 'Guess!' );
    let nextGameButton = $( '<button id="nextButton"/>' ).text( 'New Game' );
    let percents = $( '<div id="percents"/>' );

    $( '#game' ).append( startButton );
    $( '#game' ).append( timer ).append( bestscorep ).append( currentscorep );
    $( '#game' ).append( box ).append( guesscounter );
    $( '#game' ).append( box ).append( guesser );
    $( '#game' ).append( guessButton ).append( percents ).append( nextGameButton );
    $( '#game' ).append(settingsButton);
    timer.hide();
    bestscorep.hide();
    currentscorep.hide();
    box.hide();
    guesser.hide();
    guessButton.hide();
    percents.hide();
    nextGameButton.hide();
    settingsButton.hide();

    //----Start handler---------------------------------------------------------
    function getRandom() {
      return Math.floor( Math.random() * 256 );
    };
    function start() {
      $( '#startButton' ).remove();
      timer.show();
      bestscorep.show();
      currentscorep.css( 'color', 'red' );
      currentscorep.text( 'Current Score: 0' );
      currentscorep.show();
      box.show();
      guesser.show();
      guessButton.show();
      nextGameButton.hide();
      $( '#nextButton' ).hide();
      $('#settingsButton').show();
      timer.text( '0.00' );
      numTurns = 0;
      score = 0;
      sliders.r.val( 0 );
      sliders.g.val( 0 );
      sliders.b.val( 0 );
      displayValues.r.html( "0x00" );
      displayValues.g.html( "0x00" );
      displayValues.b.html( "0x00" );
      textboxes.r.val( "0x00" );
      textboxes.g.val( "0x00" );
      textboxes.b.val( "0x00" );

      goal.r = getRandom();
      goal.g = getRandom();
      goal.b = getRandom();
      goalrgb = 'rgb(' + goal.r + ',' + goal.g + ',' + goal.b + ')';
      box.css( 'background-color', goalrgb );

      // Timer Implementation
      startTime = Date.now();
      setInterval( function() {
        currentSecs = Math.floor( ( Date.now() - startTime ) / 1000 );
        currentMil = ( Date.now() - startTime ) - ( currentSecs * 1000 );
        output = '<p id="timer>' + currentSecs + '.' + currentMil + '</p>';
        timer.text( currentSecs + '.' + currentMil );
      }, 1);
    };
    startButton.on( 'click', start );

    //----Settings Dialog-------------------------------------------------------
    $( "#settingsDialog" ).dialog({
      autoOpen: false,
      buttons: {
        Continue: function() {$(this).dialog("close");}
      },
      title: "Settings"
    });
    settingsButton.on('click', function() {
      $( "#settingsDialog" ).dialog( "open" );
    });

    //----Slider handlers-------------------------------------------------------
    function sliderChange( color, dec ) {
      hexString = "0x" + Number( dec ).toString(16).toUpperCase();
      if( color == 'r' ) {
        displayValues.r.html( hexString );
        textboxes.r.val( hexString );
      }
      if( color == 'g' ) {
        displayValues.g.html( hexString );
        textboxes.g.val( hexString );
      }
      if( color == 'b' ) {
        displayValues.b.html( hexString );
        textboxes.b.val( hexString );
      }
    };
    sliders.r.on( 'input', function () {
      sliderChange( 'r', sliders.r.val() );
    });
    sliders.g.on( 'input', function () {
      sliderChange( 'g', sliders.g.val() );
    });
    sliders.b.on( 'input', function () {
      sliderChange( 'b', sliders.b.val() );
    });

    //----Textbox handlers------------------------------------------------------
    function textboxChange( e, color, hex ) {
      if( e.which == 13 ) {
        if( !re.test( hex ) ) {
          alert( "Please enter a valid hex value in the format '0x__'" );
        }
        else {
          dec = parseInt( hex, 16 );
          if( color == 'r' ) {
            sliders.r.val( dec );
            displayValues.r.html( hex.toUpperCase() );
          }
          if( color == 'g' ) {
            sliders.g.val( dec );
            displayValues.g.html( hex.toUpperCase() );
          }
          if( color == 'b' ) {
            sliders.b.val( dec );
            displayValues.b.html( hex.toUpperCase() );
          }
        }
      }
    };
    textboxes.r.on( 'keypress', function( e ) {
      textboxChange( e, 'r', textboxes.r.val() );
    });
    textboxes.g.on( 'keypress', function( e ) {
      textboxChange( e, 'g', textboxes.g.val() );
    });
    textboxes.b.on( 'keypress', function( e ) {
      textboxChange( e, 'b', textboxes.b.val() );
    });

    //----Guess handler---------------------------------------------------------
    function percentOff( correct, guess ) {
      return Math.round( Math.abs(( correct - guess )/255 ) * 100 );
    };
    function calcScore( roff, goff, boff ) {
      milTaken = Date.now() - startTime;
      return (300 - (roff + goff + boff)) * (( 20000 - milTaken) < 0 ? 0 : (20000 - milTaken));
    };
    guessButton.on( 'click', function() {
      numTurns += 1;

      guesscounter
      guesscounter.text( 'Turns Remaining: ' + Number(turns - numTurns).toString() );

      roff = percentOff( goal.r, sliders.r.val() );
      goff = percentOff( goal.g, sliders.g.val() );
      boff = percentOff( goal.b, sliders.b.val() );
      var rstring = "<p>Red: ";
      var gstring = "<p>Green: ";
      var bstring = "<p>Blue: ";
      var correctstring = "You got it! (0&#37; off)</p>";
      var incorrectstring = "&#37; off</p>"

      if ( roff == 0 ) { rstring += correctstring; }
      else { rstring += roff + incorrectstring; }

      if ( goff == 0 ) { gstring += correctstring; }
      else { gstring += goff + incorrectstring; }

      if ( boff == 0 ) { bstring += correctstring; }
      else { bstring += boff + incorrectstring; }

      var output = rstring + gstring + bstring;
      percents.html( output );
      percents.show();

      // if this is a new top score, then replace the old one
      score = calcScore( roff, goff, boff );
      if( score > topscore ) {
        topscore = score;
        bestscorep.text( "Top Score: " + topscore );
        currentscorep.css( 'color', 'black' );
        currentscorep.text( "Current Score: " + topscore );
      }
      // if the score is equal to or worse than the best, display in diff color
      else {
        currentscorep.css( 'color', 'red' );
        currentscorep.text( "Current Score: " + score );
      }

      // If the guess is correct or there are no more turns, end game
      if( (roff == 0 && goff == 0 && boff == 0) || numTurns == turns ) {
        
        // $( '#percents' ).hide("slow");
        setTimeout(function() {
          $('#percents').fadeOut();
          $( '#guessButton' ).fadeOut();
          $( '#settingsButton' ).fadeOut();
          $( '#nextButton' ).show();
        }, 1200);
      }
    });
    nextGameButton.on( 'click', start );
  };
})( jQuery );
