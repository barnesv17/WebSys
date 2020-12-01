<?php
  $studioID = 1; //TO DO: find the proper ID for the studio
  $studioPath = "studios/".$studioID;
  $mp3s = scandir( $studioPath );
  // Remove the . and ..
  array_shift( $mp3s );
  array_shift( $mp3s );
  // Display each Instrument
  foreach( $mp3s as $mp3 ) {
    $name = substr( $mp3, 0, -4 );
    // echo "<tr data-toggle='modal' data-target='#uploadFile'>";
    echo "<tr>";
      echo "<th scope='row'>";
      echo $name;
      echo "<form action='studio.php' method='POST' enctype='multipart/form-data'>";
        echo "<button type='submit' name='trashcan' value='" . $name . "'>";
          echo "<img class='trashcan' src='assets/img/trashcan.png'/>";
        echo "</button>";
      echo "</form>";
      echo "</th>";
      echo "<td><audio class='mp3' controls>";
        echo "<source src='".$studioPath."/".$mp3."'>";
      echo "</audio></td>";
      echo "</tr>";
  }
 ?>
