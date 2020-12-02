<?php
  echo "<div id='studio-title-card' class='container-fluid'>";
    echo "<div class='row align-items-center justify-content-between'>";
      echo "<h1 id='studio-title'>@" . $settings["Username"] . ": " . $settings["Studio Name"] . "</h1>";
      echo "<div class='row justify-content-between'>";
        echo "<form id='favorite-form'>";
          echo "<button class='btn btn-secondary' type='submit'>Favorite <span class='badge badge-light'>4</span>";
          echo "</button>";
        echo "</form>";
        echo "<form id='fork-form'>";
          echo "<button class='btn btn-secondary' type='submit'>Fork <span class='badge badge-light'>0</span>";
          echo "</button>";
        echo "</form>";
      echo "</div>";
    echo "</div>";

    // Genres
    echo "<div class='row'>";
    foreach( $settings["Genres"] as $genre ) {
      echo "<p class='btn btn-light action-button genres'>" . $genre . "</p>";
    }
    echo "</div>";

    // Studio Description
    echo "<div class='row'>";
      echo "<div class='col-7'>";
        echo "<p>" . $settings["Studio Description"] . "</p>";
      echo "</div>";
    echo "</div>";
  echo "</div>";
?>