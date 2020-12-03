<?php
  $instruments = json_decode( $instruments );
  $in_names = $instruments->{'names'};
  $in_files = $instruments->{'files'};

  for( $i=0; $i < count($in_names); $i++ ) {
    echo "<tr>";
      echo "<th scope='row'>";
      echo $in_names[$i];
      echo "<form action='studio.php' method='POST' enctype='multipart/form-data'>";
        echo "<button type='submit' name='trashcan' value='" . $in_names[$i] . "'>";
          echo "<img class='trashcan' src='assets/img/trashcan.png'/>";
        echo "</button>";
      echo "</form>";
      echo "</th>";
      echo "<td><audio class='mp3' controls>";
        echo "<source src='". $in_files[$i] ."'>";
      echo "</audio></td>";
      echo "</tr>";
  }
 ?>
