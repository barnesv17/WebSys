(function($) {
  // Plugin function
  $.fn.hexed = function({ username, turns }) {

    //----Setup Gameplay HTML---------------------------------------------------
    let startButton = $( '<button id="startButton"/>' ).text( 'Start Game' );

    let timer = $( '<div id="timer"/>' );
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
      g: $( '<input type="text" placeholder="Input R Value" id="Gtext"/>' ),
      b: $( '<input type="text" placeholder="Input R Value" id="Btext"/>' )
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

    let guessButton = $( '<button/>' ).text( 'Guess!' );
    let percents = $( '<div id="percents"/>' );

    //----Setup Gameplay Variables----------------------------------------------
    let re = new RegExp( '^0x[0-9A-Fa-f]{2}$' );
    let numGuesses = 0;
    let score = null;
    let time = null;
    let goal = {
      r: null,
      g: null,
      b: null
    };
    let goalrgb = "";

    //----getRandom()-----------------------------------------------------------
    function getRandom() {
      return Math.floor( Math.random() * 256 );
    };

    //----start()---------------------------------------------------------------
    function start() {
      $( '#startButton' ).remove();
      $( '#game' ).append( box ).append( guesser );
      $( '#game' ).append( guessButton ).append( percents );

      numGuesses = 0;
      score = 0;

      goal.r = getRandom();
      goal.g = getRandom();
      goal.b = getRandom();

      goalrgb = 'rgb(' + goal.r + ',' + goal.g + ',' + goal.b + ')';

      box.css( 'background-color', goalrgb );
    };

    //----Start handler---------------------------------------------------------
    $( '#game' ).append( startButton );
    startButton.on( 'click', start );

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

  };
})( jQuery );
