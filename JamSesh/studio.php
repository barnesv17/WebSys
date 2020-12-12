<?php
// Initialize the session-------------------------------------------------------
session_start();
// Check if the user is logged in, if not then redirect him to homepage---------
// include 'assets/php/login_check.php';
// Include db config file-------------------------------------------------------
include 'assets/php/db_conn.php';

// Updates all properties of the studio from the database-----------------------
function getStudio($link)
{
  $sql = "SELECT * FROM studios WHERE id = " . $_SESSION["studioID"] . "";
  $result = $link->query($sql);
  if ($result->num_rows == 1) {
    while ($row = $result->fetch_assoc()) {
      $_SESSION["ownerEmail"] = $row["owner"];
      $_SESSION["instruments"] = $row["instruments"];
      $_SESSION["title"] = $row["title"];
      $_SESSION["visibility"] = $row["visibility"];
      $_SESSION["allowFork"] = $row["allowFork"];
      $_SESSION["description"] = $row["description"];
      $_SESSION["forks"] = $row["forks"];
      $_SESSION["favorites"] = $row["favorites"];
    }
    $sql2 = "SELECT genre FROM genres WHERE studioID = " . $_SESSION["studioID"] . ";";
    $result2 = $link->query($sql2);
    $_SESSION["genres"] = array();
    mysqli_fetch_all($result2, MYSQLI_NUM);
    foreach ($result2 as $res) {
      foreach ($res as $r) {
        array_push($_SESSION["genres"], $r);
      }
    }
    // Find the owner's username
    $sql3 = "SELECT username FROM users WHERE email = '" . $_SESSION["ownerEmail"] . "'";
    $result3 = $link->query($sql3);
    if ($result3->num_rows == 1) {
      while ($row3 = $result3->fetch_assoc()) {
        $_SESSION["ownerUsername"] = $row3["username"];
      }
    }
  }
  // Collect collaborators
  $_SESSION["collaborators_emails"] = array();
  $_SESSION["collaborators"] = array();
  $sql = "SELECT email FROM collaborators WHERE studioID = " . $_SESSION["studioID"] . "";
  $result = $link->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      array_push($_SESSION["collaborators_emails"], $row["email"]);
      $sql2 = "SELECT username FROM users WHERE email = '" . $row["email"] . "'";
      $result2 = $link->query($sql2);
      if ($result2->num_rows > 0) {
        while ($row2 = $result2->fetch_assoc()) {
          array_push($_SESSION["collaborators"], $row2["username"]);
        }
      }
    }
  }
}

// Checks if the fork button was clicked----------------------------------------
function checkFork($link)
{
  if (isset($_POST['fork'])) {
    // Update all of the attributes for the current studio
    getStudio($link);
    // Insert a copy of this studio with the current session's email as the owner
    $sql = "INSERT INTO studios (owner, instruments, title, visibility, allowFork, description) VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
      mysqli_stmt_bind_param($stmt, "ssssss", $email, $instruments, $title, $visibility, $allowFork, $description);
      $email = $_SESSION["email"];
      $instruments = $_SESSION["instruments"];
      $title = $_SESSION["title"];
      $visibility = $_SESSION["visibility"];
      $allowFork = $_SESSION["allowFork"];
      $description = $_SESSION["description"];
      if (mysqli_stmt_execute($stmt)) {
        $last_id = $link->insert_id;
        // Add one to the number of forks of the current studio
        $sql = "UPDATE studios SET forks = " . ($_SESSION["forks"] + 1) . " WHERE id = " . $_SESSION["studioID"] . "";
        if ($stmt = mysqli_prepare($link, $sql)) {
          if (!mysqli_stmt_execute($stmt)) {
            echo "Oops! Something went wrong. Please try again later.";
            exit();
          }
        }
        // Direct the user to the new forked studio page
        $_SESSION["studioID"] = $last_id;
        getStudio($link);
        header("Location: studio.php");
      } else {
        echo "Something went wrong. Please try again later.";
      }
    } else {
      echo "Something went wrong. Please try again later.";
    }
  }
}

// Checks if the studio is favorited i.e. "favorite" button is clicked

function checkFav($link) {
  if (isset($_POST['favorite'])) {
    // Same as checkFork, update the studio
    getStudio($link);
    $sql = "INSERT INTO favorites (email, studioID) VALUES (?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
      mysqli_stmt_bind_param($stmt, "ss", $email, $studioID);
      $email = $_SESSION["email"];
      $studioID = $_SESSION["studioID"];
      if (mysqli_stmt_execute($stmt)) {
        $last_id = $link->insert_id;
        // Add one to the number of favorites of the current studio
        $sql = "UPDATE studios SET favorites = " . ($_SESSION["favorites"] + 1) . " WHERE id = " . $_SESSION["studioID"] . "";
        if ($stmt = mysqli_prepare($link, $sql)) {
          if (!mysqli_stmt_execute($stmt)) {
            echo "Oops! Something went wrong. Please try again later.";
            exit();
          }
        }
        // Direct the user to the new forked studio page
        $_SESSION["studioID"] = $last_id;
        getStudio($link);
        header("Location: studio.php");
      } else {
        echo "Something went wrong. Please try again later1.";
      }
    } else {
      echo "Something went wrong. Please try again later2.";
    }
  }
}
   
// Checks if an instrument was added--------------------------------------------
function addInstrument($link)
{
  if (isset($_POST['submit'])) {
    // Update all of the attributes for the current studio
    getStudio($link);
    // If no name was given for the file, alert the user
    if (isset($_POST['newFileName']) == false || $_POST['newFileName'] == "") {
      echo "<script>alert( 'Please name the file' );</script>";
      // If no file was uplaoded or a file of the wrong type, alert the user
    } else if (
      isset($_FILES['fileToUpload']) == false ||
      @mime_content_type($_FILES["fileToUpload"]["tmp_name"]) != "audio/x-m4a"
    ) {
      echo "<script>alert( 'Please upload a file of type: mp3' );</script>";
    } else {
      // Check that the filename is not already in use
      $json_instruments = json_decode($_SESSION["instruments"]);
      $in_names = $json_instruments->{'names'};
      $in_files = $json_instruments->{'files'};
      $match = false;
      for ($i = 0; $i < count($in_names); $i++) {
        if ($_POST['newFileName'] == $in_names[$i]) {
          $match = true;
        }
      }
      // If the filename is not already in use, add the instrument
      if ($match == false) {
        $file_name = $_FILES['fileToUpload']['name'];
        $target_file = "studios/" . $_SESSION["studioID"] . "/" . $_POST['newFileName'] . ".mp3";
        // Upload the file to a local directory for the studio
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        // Update the database with the instrument
        array_push($json_instruments->{'names'}, $_POST['newFileName']);
        array_push($json_instruments->{'files'}, $target_file);
        $updated_instruments = json_encode($json_instruments);
        $sql = "UPDATE studios SET instruments='" . $updated_instruments . "' WHERE id=" . $_SESSION["studioID"];
        if (!$link->query($sql)) {
          echo "Error updating record: " . $link->error;
        }
        // If the filename is not unique, alert the user
      } else {
        echo "<script>alert( 'Please choose a unique file name' );</script>";
      }
    }
  }
}

// Checks if an instrument was deleted------------------------------------------
function deleteInstrument($link)
{
  if (isset($_POST['trashcan'])) {
    // Update all of the attributes for the current studio
    getStudio($link);
    // Deconstruct the current instrument array
    $json_instruments = json_decode($_SESSION["instruments"]);
    $in_names = $json_instruments->{'names'};
    $in_files = $json_instruments->{'files'};
    $json_instruments->{'names'} = array();
    $json_instruments->{'files'} = array();
    for ($i = 0; $i < count($in_names); $i++) {
      // Keep the files that are not deleted
      if ($_POST['trashcan'] != $in_names[$i]) {
        array_push($json_instruments->{'names'}, $in_names[$i]);
        array_push($json_instruments->{'files'}, $in_files[$i]);
      } else {
        // Remove the file to be deleted from the local directory
        unlink("studios/" . $_SESSION["studioID"] . "/" . $_POST['trashcan'] . ".mp3");
      }
    }
    // Update the new array of instruments in the database
    $updated_instruments = json_encode($json_instruments);
    $sql = "UPDATE studios SET instruments='" . $updated_instruments . "' WHERE id=" . $_SESSION["studioID"];
    if (!$link->query($sql)) {
      echo "Error updating record: " . $link->error;
    }
  }
}

// Checks if Studio Name was updated--------------------------------------------
function updateStudioName($link)
{
  // Validate that the studio name is not an empty string
  if (trim($_POST['studio-name']) == "") {
    echo "<script>alert( 'Please enter a Studio Name' );</script>";
  } else {
    $sql = "UPDATE studios SET title='" . $_POST['studio-name'] . "' WHERE id=" . $_SESSION["studioID"];
    if (!$link->query($sql)) {
      echo "Error updating record: " . $link->error;
    }
  }
}

// Checks if Visibility was updated---------------------------------------------
function updateVisibility($link)
{
  $sql = "UPDATE studios SET visibility='" . $_POST['studio-visibility'] . "' WHERE id=" . $_SESSION["studioID"];
  if (!$link->query($sql)) {
    echo "Error updating record: " . $link->error;
  }
}

// Checks if AllowFork was updated----------------------------------------------
function updateAllowFork($link)
{
  $sql = "UPDATE studios SET allowFork='" . $_POST['allow-fork'] . "' WHERE id=" . $_SESSION["studioID"];
  if (!$link->query($sql)) {
    echo "Error updating record: " . $link->error;
  }
}

// Checks if Description was updated--------------------------------------------
function updateDescription($link)
{
  $sql = "UPDATE studios SET description='" . $_POST['studio-description'] . "' WHERE id=" . $_SESSION["studioID"];
  if (!$link->query($sql)) {
    echo "Error updating record: " . $link->error;
  }
}

// Updates Genres of studio-----------------------------------------------------
function updateGenres($link)
{
  if (@$_POST['add-genre'] != "") {
    $sql = "DELETE FROM genres WHERE " . $_SESSION["studioID"] . " = studioID";
    if (!$link->query($sql)) {
      echo "Error updating record: " . $link->error;
    }
    foreach ($_POST['add-genre'] as $genre) {
      $sql = "INSERT IGNORE INTO genres VALUES (" . $_SESSION["studioID"] . ", '" . mysqli_real_escape_string($link, $genre) . "')";
      if (!$link->query($sql)) {
        echo "Error updating record: " . $link->error;
      }
    }
  }
}

// Adds collaborator to studio--------------------------------------------------
function addCollaborator($link)
{
  if ($_POST['add-collab'] != "") {
    // Check that the email is in the users DB
    $sql = "SELECT * FROM users WHERE email = '" . $_POST['add-collab'] . "'";
    if ($result = $link->query($sql)) {
      // If it is a registered user, add them to the database
      if ($result->num_rows == 1) {
        $sql = "INSERT INTO collaborators VALUES (?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
          mysqli_stmt_bind_param($stmt, "is", $param_studioID, $param_collab_email);
          $param_studioID = $_SESSION["studioID"];
          $param_collab_email = $_POST['add-collab'];
          if (!mysqli_stmt_execute($stmt)) {
            echo "Something went wrong. Please try again later.";
          }
        }
      } else {
        echo "<script>alert( 'Collaborator does not exist' );</script>";
      }
    }
  }
}

// Adds collaborator to studio--------------------------------------------------
function removeCollaborator($link)
{
  if ($_POST["remove-collab"] != "n/a") {
    // Find and remove the studio and email in the collaborators table
    $sql = "DELETE FROM collaborators WHERE studioID = " . $_SESSION["studioID"] . " AND email = '" . $_POST["remove-collab"] . "'";
    if ($stmt = mysqli_prepare($link, $sql)) {
      if (!mysqli_stmt_execute($stmt)) {
        echo "Something went wrong. Please try again later.";
      }
    }
  }
}

// Checks if settings were updated----------------------------------------------
function updateSettings($link)
{
  if (isset($_POST['update-settings'])) {
    updateStudioName($link);
    updateVisibility($link);
    updateAllowFork($link);
    updateDescription($link);
    updateGenres($link);
    addCollaborator($link);
    removeCollaborator($link);
  }
}

getStudio($link);
checkFork($link);
checkFav($link);
addInstrument($link);
deleteInstrument($link);
updateSettings($link);
getStudio($link);
?>

<!DOCTYPE html>
<html lang="en-us">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>JamSesh - Studio</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
  <link rel="stylesheet" href="assets/chosen/chosen.min.css">
  <link rel="stylesheet" href="assets/css/Homepage-Nav.css">
  <link rel="stylesheet" href="assets/css/Studio.css">
  <script src="assets/js/jquery.min.js" defer></script>
  <script src="assets/bootstrap/js/bootstrap.min.js" defer></script>
  <script src="assets/js/studio.js" defer></script>
  <script src="assets/chosen/chosen.jquery.min.js" defer></script>
</head>

<body>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
    <div class="container"><a class="navbar-brand" href="user-profile.php">JamSesh</a>
      <div class="collapse navbar-collapse" id="navcol-1">
        <ul class="nav navbar-nav mr-auto">
        </ul>
        <span class="navbar-text actions">
          <a class="btn btn-link" role="button" href="search_button.php">Search</a>
          <?php
          if (isset($_SESSION["email"])) {
            echo '<a class="btn btn-light action-button" role="button" href="logout.php">Log Out</a>';
          } else {
            echo '<a class="btn btn-light action-button" href="login.php">Log In</a>';
          }
          ?>
        </span>
      </div>
    </div>
  </nav>

  <!-- Display Studio Name and Description -->
  <?php
  echo "<div id='studio-title-card' class='container-fluid'>";
  echo "<div class='row align-items-center justify-content-between'>";
  echo "<h1 id='studio-title'>" . $_SESSION["title"] . "</h1>";

  echo "<div class='row justify-content-between'>";
  // Only display favorite and fork if you are not an owner and only if logged in
  if (isset($_SESSION["email"])) {
    echo "<form action='studio.php' method='POST' id='favorite-form'>";
    if ($_SESSION["email"] != $_SESSION["ownerEmail"]) /*{
      echo "<button class='btn btn-secondary invisible fork-button' name='favorite' type='submit'>Favorite&nbsp;";
      echo "<span class='badge badge-light'>". $_SESSION["favorites"] . "</span>";
      echo "</button>";
    } else*/ {
      echo "<button class='btn btn-secondary fork-button' name='favorite' type='submit'>Favorite&nbsp;";
      echo "<span class='badge badge-light'>". $_SESSION["favorites"] . "</span>";
      echo "</button>";
    }


    echo "</form>";

    echo "<form action='studio.php' method='POST' id='fork-form'>";
    if ($_SESSION["allowFork"] == "No") {
      echo "<button class='btn btn-secondary invisible fork-button' name='fork' type='submit'>Fork&nbsp;";
      echo "<span class='badge badge-light'>" . $_SESSION["forks"] . "</span>";
      echo "</button>";
    } else {
      echo "<button class='btn btn-secondary fork-button' name='fork' type='submit'>Fork&nbsp;";
      echo "<span class='badge badge-light'>" . $_SESSION["forks"] . "</span>";
      echo "</button>";
    }
    echo "</form>";
  }
  echo "</div>";
  echo "</div>";

  // Studio Description
  echo "<div class='row'>";
  echo "<div class='col-7'>";
  echo "<p>" . $_SESSION["description"] . "</p>";
  echo "</div>";
  echo "</div>";

  // Owner
  echo "<br>";
  echo "<div class='row'>";
  echo "<p class='font-weight-bold'>Owner:&nbsp;</p><p>@" . $_SESSION["ownerUsername"] . "</p>";
  echo "</div>";

  if (@$_SESSION["collaborators"]) {
    echo "<div class='row'>";
    echo "<p class='font-weight-bold'>Collaborators:&nbsp;</p><p> |&nbsp;";
    foreach ($_SESSION["collaborators"] as $c) {
      echo "@" . $c . " | ";
    }
    echo "</p>";
    echo "</div>";
  }
  // Genres
  echo "<div class='row'>";
  foreach ($_SESSION["genres"] as $g) {
    echo "<p class='genres'>" . $g . "</p>";
  }
  echo "</div>";
  echo "</div>";


  ?>
  <!-- Navbar Tabs -->
  <ul id="studio-navtabs" class="nav nav-tabs mb-3s" role="tablist">
    <li id="first-tab" class="nav-item">
      <a class="nav-link active tabs" id="composition-tab" data-toggle="tab" href="#composition" role="tab" aria-controls="composition" aria-selected="true">Composition</a>
    </li>
    <?php
    if (isset($_SESSION["email"]) && $_SESSION["email"] == $_SESSION["ownerEmail"]) {
      echo "<li class='nav-item'>";
      echo "<a class='nav-link tabs' id='settings-tab' data-toggle='tab' href='#settings' role='tab' aria-controls='settings' aria-selected='false'>";
      echo "Settings";
      echo "</a>";
      echo "</li>";
    }
    ?>
  </ul>

  <!-- Modal for Uploading new file -->
  <div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-labelledby="uploadFileLabel" aria-hidden="true">
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
  <div class="modal fade" id="add-instrument" tabindex="-1" role="dialog" aria-labelledby="add-instrumentLabel" aria-hidden="true">
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
          <thead>
            <tr>
              <th class="table-headers" scope="col">Instrument</th>
              <th class="table-headers" scope="col">Composition</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $json_instruments = json_decode($_SESSION["instruments"]);
            $in_names = $json_instruments->{'names'};
            $in_files = $json_instruments->{'files'};

            $is_collaborator = false;
            if (@$_SESSION["collaborators_emails"]) {
              foreach ($_SESSION["collaborators_emails"] as $ce) {
                if (isset($_SESSION["email"]) && $ce == $_SESSION["email"]) {
                  $is_collaborator = true;
                }
              }
            }

            for ($i = 0; $i < count($in_names); $i++) {
              echo "<tr>";
              echo "<th scope='row'>";
              echo $in_names[$i];
              if (isset($_SESSION["email"]) && $is_collaborator) {
                echo "<form action='studio.php' method='POST' enctype='multipart/form-data'>";
                echo "<button type='submit' name='trashcan' value='" . $in_names[$i] . "'>";
                echo "<img class='trashcan' src='assets/img/trashcan.png'/>";
                echo "</button>";
                echo "</form>";
              }
              echo "</th>";
              echo "<td><audio class='mp3' controls>";
              echo "<source src='" . $in_files[$i] . "'>";
              echo "</audio></td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>

      <?php
      $is_collaborator = false;
      if (@$_SESSION["collaborators_emails"]) {
        foreach ($_SESSION["collaborators_emails"] as $ce) {
          if (isset($_SESSION["email"]) && $ce == $_SESSION["email"]) {
            $is_collaborator = true;
          }
        }
      }
      if (isset($_SESSION["email"]) && ($_SESSION["email"] == $_SESSION["ownerEmail"] || $is_collaborator == true)) {
        echo "<button id='add-instrument-btn' type='button' class='btn btn-info' data-toggle='modal' data-target='#add-instrument'>Add Instrument</button>";
      }
      ?>
      <button id="play-all-btn" type="button" class="btn btn-info">Play All</button>
      <button id="pause-all-btn" type="button" class="btn btn-info">Pause All</button>
      <button id="restart-all-btn" type="button" class="btn btn-info">Restart All</button>
    </div>

    <!-- Settings -->
    <?php
    if (isset($_SESSION["email"]) && $_SESSION["email"] == $_SESSION["ownerEmail"]) {
      echo "<div class='tab-pane fade' id='settings' role='tabpanel' aria-labelledby='settings-tab'>";
      echo "<div id='studioSettings' class='container'>";
      echo "<form action='studio.php' method='POST'>";

      // Studio Name
      echo "<div class='form-group'>";
      echo "<label for='studio-name-input'>Studio Name</label>";
      echo "<input type='text' name='studio-name' value='" . $_SESSION["title"] . "'class='form-control' id='studio-name-input'>";
      echo "</div>";

      // Studio Visibility
      echo "<div class='form-group'>";
      echo "<label for='studio-visibilty'>Studio Visibility</label>";
      echo "<select name='studio-visibility' class='form-control' id='studio-visibilty'>";
      if ($_SESSION["visibility"] == "Public") {
        echo "<option>Public</option>";
        echo "<option>Private</option>";
      } else {
        echo "<option>Private</option>";
        echo "<option>Public</option>";
      }
      echo "</select>";
      echo "</div>";

      // Allow Fork
      echo "<div class='form-group'>";
      echo "<label for='studio-permissions-fork'>Allow Users to Fork Studio</label>";
      echo "<select name='allow-fork' class='form-control' id='studio-permissions-fork'>";
      if ($_SESSION["allowFork"] == "Yes") {
        echo "<option>Yes</option>";
        echo "<option>No</option>";
      } else {
        echo "<option>No</option>";
        echo "<option>Yes</option>";
      }
      echo "</select>";
      echo "</div>";

      // Studio Description
      echo "<div class='form-group'>";
      echo "<label for='studio-description-input'>Edit Studio Description</label>";
      echo "<textarea name='studio-description' class='form-control' id='studio-description-input' rows='3'maxlength='255'>";
      echo $_SESSION["description"];
      echo "</textarea>";
      echo "</div>";

      // Add Genres
      echo "<div class='form-group'>";
      echo "<label for='studio-genres-input'>Pick Genres for the Studio</label>";
      echo "<select name='add-genre[]' class='form-control' id='studio-genres-input' multiple>";
      echo "<option id='Avant-Garde'>Avant-Garde</option>";
      echo "<option id='Blues'>Blues</option>";
      echo "<option id='Children'>Children's</option>";
      echo "<option id='Classical'>Classical</option>";
      echo "<option id='Comedy'>Comedy</option>";
      echo "<option id='Country'>Country</option>";
      echo "<option id='Easy-Listening'>Easy Listening</option>";
      echo "<option id='Electronic'>Electronic</option>";
      echo "<option id='Folk'>Folk</option>";
      echo "<option id='Holiday'>Holiday</option>";
      echo "<option id='International'>International</option>";
      echo "<option id='Jazz'>Jazz</option>";
      echo "<option id='R&B'>R&B</option>";
      echo "<option id='Rap'>Rap</option>";
      echo "<option id='Reggae'>Reggae</option>";
      echo "<option id='Religious'>Religious</option>";
      echo "<option id='Score'>Score</option>";
      echo "<option id='Vocal'>Vocal</option>";
      echo "</select>";
      echo "</div>";

      // Add Collaborator
      echo "<div class='form-group'>";
      echo "<label for='studio-collabs-input'>Add Collaborator to the Studio by Email</label>";
      echo "<input name='add-collab' type='text' class='form-control' id='studio-collab-input'>";
      echo "</div>";

      // Remove Collaborator
      echo "<div class='form-group'>";
      echo "<label for='remove-collab'>Remove Collaborator</label>";
      echo "<select name='remove-collab' class='form-control' id='remove-collab'>";
      echo "<option>n/a</option>";
      // Display all emails of collaborators
      foreach ($_SESSION["collaborators_emails"] as $e) {
        echo "<option>" . $e . "</option>";
      }
      echo "</select>";
      echo "</div>";

      // Submit Button
      echo "<button name='update-settings' type='submit' class='btn btn-info'>Save Changes</button>";
      echo "</form>";
      echo "</div>";
      echo "</div>";
    }
    ?>
  </div>

</body>

</html>