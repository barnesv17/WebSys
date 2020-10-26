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
routput.innerHTML = "0x" + Number(rslider.value).toString(16).toUpperCase(); // Display the default slider value

var gslider = document.getElementById("Grange");
var goutput = document.getElementById("Gdemo");
var ginput = document.getElementById("Gtext");
goutput.innerHTML = "0x" + Number(gslider.value).toString(16).toUpperCase(); // Display the default slider value


var bslider = document.getElementById("Brange");
var boutput = document.getElementById("Bdemo");
var binput = document.getElementById("Btext");
boutput.innerHTML = "0x" + Number(bslider.value).toString(16).toUpperCase(); // Display the default slider value


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
//---- GREEN ---------------------------------------------------------------------
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
//---- BLUE ---------------------------------------------------------------------
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
