document.getElementById("play-all-btn").addEventListener( 'click', function() {
  var mp3s = document.getElementsByClassName( "mp3" );
  var mp3Length = mp3s.length;
  for( var i=0; i < mp3Length; i++ ) {
    (mp3s[i]).play();
  }
  document.getElementById("play-all-btn").style.display = "none";
  document.getElementById("pause-all-btn").style.display = "inline-block";
});

document.getElementById("pause-all-btn").addEventListener( 'click', function() {
  var mp3s = document.getElementsByClassName( "mp3" );
  var mp3Length = mp3s.length;
  for( var i=0; i < mp3Length; i++ ) {
    (mp3s[i]).pause();
  }
  document.getElementById("pause-all-btn").style.display = "none";
  document.getElementById("play-all-btn").style.display = "inline-block";
});
