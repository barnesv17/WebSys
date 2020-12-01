<?php
  echo "<div class='tab-pane fade' id='settings' role='tabpanel' aria-labelledby='settings-tab'>";
    echo "<div id='studioSettings' class='container'>";
      echo "<form action='studio.php' method='POST'>";

        // Studio Name
        echo "<div class='form-group'>";
          echo "<label for='studio-name-input'>Studio Name</label>";
          echo "<input type='text' name='studio-name' value='" . $settings["Studio Name"] . "'class='form-control' id='studio-name-input'>";
        echo "</div>";

        // Studio Visibility
        echo "<div class='form-group'>";
          echo "<label for='studio-visibilty'>Studio Visibility</label>";
          echo "<select name='studio-visibility' class='form-control' id='studio-visibilty'>";
          if( $settings["Studio Visibility"] == "Public" ) {
            echo "<option>Public</option>";
            echo "<option>Private</option>";
          }
          else {
            echo "<option>Private</option>";
            echo "<option>Public</option>";
          }
          echo "</select>";
        echo "</div>";

        // Allow Fork
        echo "<div class='form-group'>";
          echo "<label for='studio-permissions-fork'>Allow Users to Fork Studio</label>";
          echo "<select name='allow-fork' class='form-control' id='studio-permissions-fork'>";
          if( $settings["Allow Fork"] == "Yes" ) {
            echo "<option>Yes</option>";
            echo "<option>No</option>";
          }
          else {
            echo "<option>No</option>";
            echo "<option>Yes</option>";
          }
          echo "</select>";
        echo "</div>";

        // Studio Description
        echo "<div class='form-group'>";
          echo "<label for='studio-description-input'>Edit Studio Description</label>";
          echo "<textarea name='studio-description' class='form-control' id='studio-description-input' rows='3'maxlength='255'>";
            echo $settings["Studio Description"];
          echo "</textarea>";
        echo "</div>";

        // Add Genres
        echo "<div class='form-group'>";
          echo "<label for='studio-genres-input'>Add Genre to the Studio</label>";
          echo "<input name='add-genre' type='text' class='form-control' id='studio-genres-input'>";
        echo "</div>";

        // Submit Button
        echo "<button name='update-settings' type='submit' class='btn btn-info'>Save Changes</button>";
      echo "</form>";
    echo "</div>";
  echo "</div>";
 ?>
