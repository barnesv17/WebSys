<?php
  if( isset($_POST['trashcan']) ) {
    $studioID = 1; //TO DO: find the proper ID for the studio
    $studioPath = "studios/".$studioID;
    $mp3s = scandir( $studioPath );
    array_shift( $mp3s ); array_shift( $mp3s ); // Remove the . and ..
    foreach( $mp3s as $mp3 ) {
      $name = substr( $mp3, 0, -4 );
      if( $name == $_POST['trashcan'] ) {
        unlink( $studioPath . "/" . $mp3 );
      }
    }
  }
?>
