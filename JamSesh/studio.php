<!-- Connect to database -->
<?php
  include 'assets/php/db_conn.php';
  // TO DO: Get settings from the database
  $settings = [
    "Username" => "username",
    "Studio Name" => "Bad Guy",
    "Studio Visibility" => "Public",
    "Allow Users to Fork Studio" => "Yes",
    "Studio Description" => "This is an example studio description",
    "Genres" => [ "Alternative", "Indie" ],
  ];
?>

<!DOCTYPE html>
<html lang="en-us">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>JamSesh - Studio</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/Homepage-Nav.css">
  <link rel="stylesheet" href="assets/css/Studio.css">
</head>

<body>
  <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
    <div class="container"><a class="navbar-brand" href="user-profile.html">JamSesh</a>
      <div class="collapse navbar-collapse" id="navcol-1">
        <ul class="nav navbar-nav mr-auto">
          <!-- <li class="nav-item"><a class="nav-link active" href="user-profile.html">Home</a></li> -->
        </ul>
        <span class="navbar-text actions">
          <a class="btn btn-light action-button" role="button" href="homepage.html">Log Out</a>
        </span>
      </div>
    </div>
  </nav>

  <!-- Display studio info from settings -->
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

  <!-- Navbar Tabs -->
  <ul id="studio-navtabs" class="nav nav-tabs mb-3s" role="tablist">
    <li id="first-tab" class="nav-item">
      <a class="nav-link active" id="composition-tab" data-toggle="tab" href="#composition" role="tab"
        aria-controls="composition" aria-selected="true">Composition</a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" id="mixes-tab" data-toggle="tab" href="#mixes" role="tab" aria-controls="mixes"
        aria-selected="false">Mixes</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="contributions-tab" data-toggle="tab" href="#contributions" role="tab"
        aria-controls="contributions" aria-selected="false">Contributions</a>
    </li> -->
    <li class="nav-item">
      <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings"
        aria-selected="false">Settings</a>
    </li>
  </ul>

  <!-- Modal for Uploading new file -->
  <div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-labelledby="uploadFileLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadFileLabel">Upload New File</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="update-instrument-form">
          <div class="modal-body">
            <div class="form-group">
              <label for="choosefile1">Choose File</label>
              <input type="file" class="form-control-file" id="choosefile1">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-info" data-dismiss="modal">Submit Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- php for adding instrument -->
  <?php
   if( isset($_POST['submit']) ) {
     //-Form Validation---------------------------------------------------------
     if( isset($_POST['name']) == false || $_POST['name'] == "" ) { // If no name was given for the file
       echo "<script>alert( 'Please name the file' );</script>";
     }
     else if( isset($_FILES['fileToUpload']) == false ||
      @mime_content_type($_FILES["fileToUpload"]["tmp_name"]) != "audio/x-m4a" ) { // If no file was uplaoded or a file of the wrong type
       echo "<script>alert( 'Please upload a file of type: mp3' );</script>";
     }
     else {
       //-Check that the filename is not already in use-------------------------
       $studioID = 1; //TO DO: find the proper ID for the studio
       $studioPath = "studios/".$studioID;
       $mp3s = scandir( $studioPath );
       array_shift( $mp3s ); array_shift( $mp3s ); // Remove the . and ..
       $match = false;
       foreach( $mp3s as $mp3 ) {
         $name = substr( $mp3, 0, -4 );
         if( $name == $_POST['name'] ) {
           $match = true;
         }
       }
       if( $match == false ) {
         // If everything was inputted correctly, upload the file
         $file_name = $_FILES['fileToUpload']['name'];
         $target_file = $studioPath . "/" . $_POST['name'] . ".mp3";
         move_uploaded_file( $_FILES["fileToUpload"]["tmp_name"], $target_file );
       }
       else { // If the filename is not unique
         echo "<script>alert( 'Please choose a unique file name' );</script>";
       }
     }
     $_POST = array(); // Reset inputs to be blank
   }
  ?>
  <!-- php for deleting an instrument -->
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

  <!-- Modal for adding instrument -->
  <div class="modal fade" id="add-instrument" tabindex="-1" role="dialog" aria-labelledby="add-instrumentLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="add-instrumentLabel">Add New Instrument</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="add-instrument-form" method="POST" action="studio.php" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label for="instrumentInput1">Instrument Name</label>
              <input type="text" class="form-control" id="instrumentInput1" name="name">
              <label for="choosefile2">Choose File</label>
              <input type="file" class="form-control-file" id="choosefile2" name="fileToUpload">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" name="submit" value="Submit" class="btn btn-info">Submit Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Navbar Tab Content -->
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="composition" role="tabpanel" aria-labelledby="composition-tab">
      <div id="studio-composition" class="table-responsive">
        <table class="table table-hover">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Instrument</th>
              <th scope="col">Composition</th>
            </tr>
          </thead>
          <tbody>
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
          </tbody>
        </table>
      </div>
      <button id="add-instrument-btn" type="button" class="btn btn-info" data-toggle="modal"
        data-target="#add-instrument">Add Instrument</button>
      <button id="play-all-btn" type="button" class="btn btn-info">Play All</button>
      <button id="pause-all-btn" type="button" class="btn btn-info">Pause All</button>
      <button id="restart-all-btn" type="button" class="btn btn-info">Restart All</button>
    </div>
    <!-- <div class="tab-pane fade" id="mixes" role="tabpanel" aria-labelledby="mixes-tab">
      <div id="studio-mixes">
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">User</th>
              <th scope="col">Mix</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Gabe Wild</td>
              <td><audio controls>
                  <source src="assets/audio/slurp.mp3">
                </audio></td>
            </tr>
            <tr>
              <td>Virginia Barnes</td>
              <td><audio controls>
                  <source src="assets/audio/slurp.mp3">
                </audio></td>
            </tr>
            <tr>
              <td>Tyler Samuels</td>
              <td><audio controls>
                  <source src="assets/audio/slurp.mp3">
                </audio></td>
            </tr>
            <tr>
              <td>Kyle Qin</td>
              <td><audio controls>
                  <source src="assets/audio/slurp.mp3">
                </audio></td>
            </tr>
            <tr>
              <td>Derek Li</td>
              <td><audio controls>
                  <source src="assets/audio/slurp.mp3">
                </audio></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div> -->
    <!-- <div class="tab-pane fade" id="contributions" role="tabpanel" aria-labelledby="contributions-tab">
      <form id="approve-contributions-form">
        <div id="studio-contributions" class="table-reponsive">
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Instrument</th>
                <th scope="col">Approve Contribution</th>
                <th scope="col">Composition</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">Lead Guitar</th>
                <td>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="check-yes1">
                    <label class="form-check-label" for="check-yes1">Yes</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="check-no1">
                    <label class="form-check-label" for="check-no1">No</label>
                  </div>
                </td>
                <td><audio controls>
                    <source src="assets/audio/slurp.mp3">
                  </audio></td>
              </tr>
              <tr>
                <th scope="row">(NEW) Vocals</th>
                <td>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="check-yes2">
                    <label class="form-check-label" for="check-yes2">Yes</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="check-no2">
                    <label class="form-check-label" for="check-no2">No</label>
                  </div>
                </td>
                <td><audio controls>
                    <source src="assets/audio/slurp.mp3">
                  </audio></td>
              </tr>
            </tbody>
          </table>
        </div>
        <button id="approve-contributions-btn" type="submit" class="btn btn-info">Save Changes</button>
      </form>
    </div> -->


    <?php
      echo "<div class='tab-pane fade' id='settings' role='tabpanel' aria-labelledby='settings-tab'>";
        echo "<div id='studioSettings' class='container'>";
          echo "<form>";

            // Studio Name
            echo "<div class='form-group'>";
              echo "<label for='studio-name-input'>Studio Name</label>";
              echo "<input type='text' class='form-control' id='studio-name-input' placeholder='" . $settings["Studio Name"] . "'>";
            echo "</div>";

            // Studio Visibility
            echo "<div class='form-group'>";
              echo "<label for='studio-visibilty'>Studio Visibility</label>";
              echo "<select class='form-control' id='studio-visibilty'>";
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
              echo "<select class='form-control' id='studio-permissions-fork'>";
              if( $settings["Allow Users to Fork Studio"] == "Yes" ) {
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
              echo "<textarea class='form-control' id='studio-description-input' rows='3'maxlength='255'>";
                echo $settings["Studio Description"];
              echo "</textarea>";
            echo "</div>";

            // Add Genres
            echo "<div class='form-group'>";
              echo "<label for='studio-genres-input'>Add Genres to the Studio</label>";
              echo "<input type='text' class='form-control' id='studio-genres-input'>";
            echo "</div>";

            // Submit Button
            echo "<button type='submit' class='btn btn-info'>Save Changes</button>";
          echo "</form>";
        echo "</div>";
      echo "</div>";
     ?>
  </div>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/studio.js"></script>

</body>

</html>
