var box = document.getElementById("box");
var red = Math.floor( Math.random() * 256 );
var green = Math.floor( Math.random() * 256 );
var blue = Math.floor( Math.random() * 256 );
var rgb = "rgb(" + red + "," + green + "," + blue + ")";
box.style.backgroundColor = rgb;

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


// Update the current slider value (each time you drag the slider handle)
rslider.oninput = function() {
  var hexString = "0x" + Number(this.value).toString(16).toUpperCase()
  routput.innerHTML = hexString;
  rinput.value = hexString;
}
rinput.onkeypress = function( e ) {
  if (e.keyCode == '13' ) {
    var dec = parseInt( this.value, 16 );
    rslider.value = dec;
    routput.innerHTML = this.value;
  }
}
// Update the current slider value (each time you drag the slider handle)
gslider.oninput = function() {
  var hexString = "0x" + Number(this.value).toString(16).toUpperCase()
  goutput.innerHTML = hexString;
  ginput.value = hexString;
}
ginput.onkeypress = function( e ) {
  if (e.keyCode == '13' ) {
    var dec = parseInt( this.value, 16 );
    gslider.value = dec;
    goutput.innerHTML = this.value;
  }
}
// Update the current slider value (each time you drag the slider handle)
bslider.oninput = function() {
  var hexString = "0x" + Number(this.value).toString(16).toUpperCase()
  boutput.innerHTML = hexString;
  binput.value = hexString;
}
binput.onkeypress = function( e ) {
  if (e.keyCode == '13' ) {
    var dec = parseInt( this.value, 16 );
    bslider.value = dec;
    boutput.innerHTML = this.value;
  }
}
