<?php

  // Initialize the session
  session_start();

  // Check if the user is logged in, if not then redirect him to homepage
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: hompage.php");
    exit;
  }

  include 'assets/php/db_conn.php';

  // Collect information on the studio from the DB------------------------------
  $sql = "SELECT instruments, settings FROM studios WHERE id = ?";
  if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_id);
    // Set parameters
    $param_id = $_SESSION["studioID"];
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
      // Store result
      mysqli_stmt_store_result($stmt);
      // Check if email exists, if yes then verify password
      if(mysqli_stmt_num_rows($stmt) == 1){
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $instruments, $s);
        if(mysqli_stmt_fetch($stmt)){
          $s = json_decode( $s );
          $title = $s->{'title'};
          $visibility = $s->{'visibility'};
          $allowFork = $s->{'allowFork'};
          $description = $s->{'description'};
          $genres = $s->{'genres'};
        }
      }
    }
  }

  // Add instrument-------------------------------------------------------------
  if( isset($_POST['submit']) ) {
    //-Form Validation---------------------------------------------------------
    if( isset($_POST['newFileName']) == false || $_POST['newFileName'] == "" ) { // If no name was given for the file
      echo "<script>alert( 'Please name the file' );</script>";
    }
    else if( isset($_FILES['fileToUpload']) == false ||
     @mime_content_type($_FILES["fileToUpload"]["tmp_name"]) != "audio/x-m4a" ) { // If no file was uplaoded or a file of the wrong type
      echo "<script>alert( 'Please upload a file of type: mp3' );</script>";
    }
    else {
      //-Check that the filename is not already in use-------------------------
      $json_instruments = json_decode( $instruments );
      $in_names = $json_instruments->{'names'};
      $in_files = $json_instruments->{'files'};
      $match = false;
      for( $i=0; $i < count($in_names); $i++ ) {
       if( $_POST['newFileName'] == $in_names[$i] ) {
         $match = true;
       }
      }
      if( $match == false ) {
        // If everything was inputted correctly, upload the file
        $file_name = $_FILES['fileToUpload']['name'];
        $target_file = "studios/" . $_SESSION["studioID"] . "/" . $_POST['newFileName'] . ".mp3";
        move_uploaded_file( $_FILES["fileToUpload"]["tmp_name"], $target_file );
        // update the db
        array_push($json_instruments->{'names'}, $_POST['newFileName']);
        array_push($json_instruments->{'files'}, $target_file);
        $updated_instruments = json_encode($json_instruments);
        $sql = "UPDATE studios SET instruments='" . $updated_instruments . "' WHERE id=" . $_SESSION["studioID"];
        if ($link->query($sql) === TRUE) {
          // echo "Record updated successfully";
        } else {
          // echo "Error updating record: " . $link->error;
        }
      }
      else { // If the filename is not unique
        echo "<script>alert( 'Please choose a unique file name' );</script>";
      }
    }
  }

  // Delete Instrument----------------------------------------------------------
  if( isset($_POST['trashcan']) ) {
    $json_instruments = json_decode( $instruments );
    $in_names = $json_instruments->{'names'};
    $in_files = $json_instruments->{'files'};
    $json_instruments->{'names'} = array();
    $json_instruments->{'files'} = array();
    for( $i=0; $i < count($in_names); $i++ ) {
     if( $_POST['trashcan'] != $in_names[$i] ) {
       array_push( $json_instruments->{'names'}, $in_names[$i] );
       array_push( $json_instruments->{'files'}, $in_files[$i] );
     }
     else {
       unlink( "studios/" . $_SESSION["studioID"] . "/" . $_POST['trashcan'] . ".mp3" );
     }
    }
    // Remove from DB
    $updated_instruments = json_encode($json_instruments);
    $sql = "UPDATE studios SET instruments='" . $updated_instruments . "' WHERE id=" . $_SESSION["studioID"];
    if ($link->query($sql) === TRUE) {
      // echo "Record updated successfully";
    } else {
      // echo "Error updating record: " . $link->error;
    }
  }

  // Collect information on the studio from the DB------------------------------
  $sql = "SELECT instruments, settings FROM studios WHERE id = ?";
  if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_id);
    // Set parameters
    $param_id = $_SESSION["studioID"];
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
      // Store result
      mysqli_stmt_store_result($stmt);
      // Check if email exists, if yes then verify password
      if(mysqli_stmt_num_rows($stmt) == 1){
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $instruments, $s);
        if(mysqli_stmt_fetch($stmt)){
          $s = json_decode( $s );
          $title = $s->{'title'};
          $visibility = $s->{'visibility'};
          $allowFork = $s->{'allowFork'};
          $description = $s->{'description'};
          $genres = $s->{'genres'};
        }
      }
    }
  }

  include 'assets/php/studio/update_settings.php';
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
  <!-- Navigation Bar -->
  <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
    <div class="container"><a class="navbar-brand" href="user-profile.php">JamSesh</a>
      <div class="collapse navbar-collapse" id="navcol-1">
        <ul class="nav navbar-nav mr-auto">
        </ul>
        <span class="navbar-text actions">
          <a class="btn btn-light action-button" role="button" href="logout.php">Log Out</a>
        </span>
      </div>
    </div>
  </nav>

  <!-- Display Studio Name and Description -->
  <?php
    echo "<div id='studio-title-card' class='container-fluid'>";
      echo "<div class='row align-items-center justify-content-between'>";
        echo "<h1 id='studio-title'>@" . $_SESSION["username"] . ": " . $title . "</h1>";
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
      foreach( $genres as $g ) {
        echo "<p class='btn btn-light action-button genres'>" . $g . "</p>";
      }
      echo "</div>";

      // Studio Description
      echo "<div class='row'>";
        echo "<div class='col-7'>";
          echo "<p>" . $description . "</p>";
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
              <input type="text" class="form-control" id="instrumentInput1" name="newFileName">
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
    <!-- Composition -->
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
              $json_instruments = json_decode( $instruments );
              $in_names = $json_instruments->{'names'};
              $in_files = $json_instruments->{'files'};

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
          </tbody>
        </table>
      </div>
      <button id="add-instrument-btn" type="button" class="btn btn-info" data-toggle="modal"
        data-target="#add-instrument">Add Instrument</button>
      <button id="play-all-btn" type="button" class="btn btn-info">Play All</button>
      <button id="pause-all-btn" type="button" class="btn btn-info">Pause All</button>
      <button id="restart-all-btn" type="button" class="btn btn-info">Restart All</button>
    </div>

    <!-- Settings -->
    <?php include 'assets/php/studio/display_settings_tab.php'; ?>
  </div>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/studio.js"></script>

</body>
</html>
