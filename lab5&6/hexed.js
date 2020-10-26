var box = document.getElementById("box");
var red = Math.floor( Math.random() * 256 );
var green = Math.floor( Math.random() * 256 );
var blue = Math.floor( Math.random() * 256 );
var rgb = "rgb(" + red + "," + green + "," + blue + ")";
box.style.backgroundColor = rgb;

var re = new RegExp( /^0x[0-9A-F]{2}$/ );

var rslider = document.getElementById("Rrange");
var routput = document.getElementById("Rdemo");
var rinput = document.getElementById("Rtext");
routput.innerHTML = "0x" + Number(rslider.value).toString(16).toUpperCase();

var gslider = document.getElementById("Grange");
var goutput = document.getElementById("Gdemo");
var ginput = document.getElementById("Gtext");
goutput.innerHTML = "0x" + Number(gslider.value).toString(16).toUpperCase();


var bslider = document.getElementById("Brange");
var boutput = document.getElementById("Bdemo");
var binput = document.getElementById("Btext");
boutput.innerHTML = "0x" + Number(bslider.value).toString(16).toUpperCase();

var guess = document.getElementById("guessButton");
var percents = document.getElementById( "percents" );


//---- RED ---------------------------------------------------------------------
// TO DO: HANDLE INVALID BOX INPUT
rslider.oninput = function() { // If slider is changed...
  var hexString = "0x" + Number(this.value).toString(16).toUpperCase()
  routput.innerHTML = hexString;
  rinput.value = hexString;
}
rinput.onkeypress = function( e ) { // If textbox is changed...
  if (e.keyCode == '13' ) {
    // Check for valid box input
    if ( !this.value.match(re) ) {
      alert( "Please enter a valid hex value in the format '0x__'" );
    }
    else {
      var dec = parseInt( this.value, 16 );
      rslider.value = dec;
      routput.innerHTML = this.value;
    }
  }
}
//---- GREEN -------------------------------------------------------------------
gslider.oninput = function() { // If slider is changed...
  var hexString = "0x" + Number(this.value).toString(16).toUpperCase()
  goutput.innerHTML = hexString;
  ginput.value = hexString;
}
ginput.onkeypress = function( e ) { // If textbox is changed...
  if (e.keyCode == '13' ) {
    // Check for valid box input
    if ( !this.value.match(re) ) {
      alert( "Please enter a valid hex value in the format '0x__'" );
    }
    else {
      var dec = parseInt( this.value, 16 );
      gslider.value = dec;
      goutput.innerHTML = this.value;
    }
  }
}
//---- BLUE --------------------------------------------------------------------
bslider.oninput = function() { // If slider is changed...
  var hexString = "0x" + Number(this.value).toString(16).toUpperCase()
  boutput.innerHTML = hexString;
  binput.value = hexString;
}
binput.onkeypress = function( e ) { // If textbox is changed...
  if (e.keyCode == '13' ) {
    // Check for valid box input
    if ( !this.value.match(re) ) {
      alert( "Please enter a valid hex value in the format '0x__'" );
    }
    else {
      var dec = parseInt( this.value, 16 );
      bslider.value = dec;
      boutput.innerHTML = this.value;
    }
  }
}
//---- GUESS BUTTON ------------------------------------------------------------
function percentOff( correct, guess ) {
  return Math.round( Math.abs(( correct - guess )/255 ) * 100 );
}
guess.onclick = function() {
  var roff = percentOff( red, rslider.value );
  var goff = percentOff( green, gslider.value );
  var boff = percentOff( blue, bslider.value );
  var rstring = "<p>Red: ";
  var gstring = "<p>Green: ";
  var bstring = "<p>Blue: ";
  var correctstring = "You got it! (0&#37; off)</p>";
  var incorrectstring = "&#37; off</p>"

  if ( roff == 0 ) {
    rstring += correctstring;
  }
  else {
    rstring += roff + incorrectstring;
  }

  if ( goff == 0 ) {
    gstring += correctstring;
  }
  else {
    gstring += goff + incorrectstring;
  }

  if ( boff == 0 ) {
    bstring += correctstring;
  }
  else {
    bstring += boff + incorrectstring;
  }

  var output = rstring + gstring + bstring;
  percents.innerHTML = output;
}
