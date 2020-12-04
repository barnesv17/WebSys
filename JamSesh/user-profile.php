<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to homepage
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: homepage.php");
  exit;
}

// Include config file
include 'assets/php/db_conn.php';
?>

<!-- Check for edit profile updates ------------------------------------------>
<?php
if (isset($_POST['save-changes'])) {

  // Profile Picture
  if (isset($_FILES['profile-pic'])) {
    if (
      @mime_content_type($_FILES["profile-pic"]["tmp_name"]) == "image/png" ||
      @mime_content_type($_FILES["profile-pic"]["tmp_name"]) == "image/jpeg"
    ) { // check that it is an image
      $file_name = $_FILES['profile-pic']['name'];
      move_uploaded_file($_FILES["profile-pic"]["tmp_name"], "assets/img/profile-pictures/" . $file_name);
      $sql = "UPDATE users SET profilePic = ? WHERE id = ?";
      if ($stmt = mysqli_prepare($link, $sql)) {
        $param_profilePic = "assets/img/profile-pictures/" . $file_name;
        $param_id = $_SESSION["id"];
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "si", $param_profilePic, $param_id);
        // Attempt to execute the prepared statement
        if (!mysqli_stmt_execute($stmt)) {
          echo "Oops! Something went wrong. Please try again later.";
        }
      }
    }
  }

  //Bio
  if ($_POST['bio'] != "") {
    $sql = "UPDATE users SET bio = ? WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
      $param_bio = $_POST['bio'];
      $param_id = $_SESSION["id"];
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "si", $param_bio, $param_id);
      // Attempt to execute the prepared statement
      if (!mysqli_stmt_execute($stmt)) {
        echo "Oops! Something went wrong. Please try again later.";
      }
    }
  }

  // Display Name
  if ($_POST['display-name'] != "") {
    $sql = "UPDATE users SET displayName = ? WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
      $param_displayName = $_POST['display-name'];
      $param_id = $_SESSION["id"];
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "si", $param_displayName, $param_id);
      // Attempt to execute the prepared statement
      if (!mysqli_stmt_execute($stmt)) {
        echo "Oops! Something went wrong. Please try again later.";
      }
    }
  }

  // Username
  if ($_POST['username'] != "") {
    $sql = "UPDATE users SET username = ? WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
      $param_username = $_POST['username'];
      $param_id = $_SESSION["id"];
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "si", $param_username, $param_id);
      // Attempt to execute the prepared statement
      if (!mysqli_stmt_execute($stmt)) {
        echo "Oops! Something went wrong. Please try again later.";
      }
    }
  }

  $sql = "SELECT id, email, password, username, displayName, bio, profilePic FROM users WHERE email = ?";
  if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_email);
    // Set parameters
    $param_email = $_SESSION["email"];
    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
      // Store result
      mysqli_stmt_store_result($stmt);
      // Bind result variables
      mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password, $username, $displayName, $bio, $profilePic);
      if (mysqli_stmt_fetch($stmt)) {
        // Store data in session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $id;
        $_SESSION["email"] = $email;
        $_SESSION["username"] = $username;
        $_SESSION["displayName"] = $displayName;
        $_SESSION["bio"] = $bio;
        $_SESSION["profilePic"] = $profilePic;
      }
    }
  }
}

// Check if new studio was added-----------------------------------------
if (isset($_POST['create-new-studio'])) {
  if (empty($_POST["new-title"])) {
    echo "<script>alert( 'Empty Title' );</script>";
  } else { // Add studio directory and to the database
    $new_settings = '{ "title" : "' . $_POST["new-title"] . '",
                              "visibility" : "' . $_POST["new-visibility"] . '",
                              "allowFork" : "' . $_POST["new-allowFork"] . '",
                              "description" : "' . $_POST["new-description"] . '",
                              "genres" : [] }';

    $new_instruments = '{ "names" : [], "files" : [] }';

    $sql = "INSERT INTO studios (owner, instruments, settings) VALUES (?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_instruments, $param_settings);

      // Set parameters
      $param_email = $_SESSION["email"];
      $param_instruments = $new_instruments;
      $param_settings = $new_settings;

      // Attempt to execute the prepared statement
      if (!mysqli_stmt_execute($stmt)) {
        echo "Something went wrong. Please try again later.";
      } else {
        $last_id = $link->insert_id;
        echo "HERE";
        echo "<script>console.log(HERE);</script>";
        mkdir("studios/" . $last_id);
      }
    }
  }
}

// Check if a specific studio was cliked----------------------------------
if (isset($_POST["studio-clicked"])) {
  $_SESSION["studioID"] = $_POST["studio-clicked"];
  header("Location: studio.php");
}

// Fetch all of the users studios-----------------------------------------
$studios = array();
$collab_studios = array();

// Prepare a select statement for studios where this user is the owner
$sql = "SELECT id, settings FROM studios WHERE owner = '" . $_SESSION["email"] . "'";
$result = $link->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $settings = json_decode($row["settings"]);
    $title = $settings->{'title'};
    $visibility = $settings->{'visibility'};
    $allowFork = $settings->{'allowFork'};
    $description = $settings->{'description'};
    $genres = $settings->{'genres'};

    array_push($studios, [
      "id" => $row["id"],
      "title" => $title,
      "visibility" => $visibility,
      "allowFork" => $allowFork,
      "description" => $description,
      "genres" => $genres
    ]);
  }
}

// Prepare a select statement for studios where this user is a collaborator
$sql2 = "SELECT * FROM collaborators WHERE email = '" . $_SESSION["email"] . "'";
if ($result2 = $link->query($sql2)) {
  if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
      $sql3 = "SELECT id, settings, owner FROM studios WHERE id = " . $row2["studioID"] . "";
      $result3 = $link->query($sql3);
      if ($result3->num_rows > 0) {
        while ($row3 = $result3->fetch_assoc()) {
          $settings = json_decode($row3["settings"]);
          $title = $settings->{'title'};
          $visibility = $settings->{'visibility'};
          $allowFork = $settings->{'allowFork'};
          $description = $settings->{'description'};
          $genres = $settings->{'genres'};
          $owner_email = $row3["owner"];
          // Find the owner's username
          $sql4 = "SELECT username FROM users WHERE email = '" . $row3["owner"] . "'";
          $result4 = $link->query($sql4);
          if ($result4->num_rows == 1) {
            while ($row4 = $result4->fetch_assoc()) {
              $owner_username = $row4["username"];
            }
          }
          array_push($collab_studios, [
            "id" => intval($row3["id"]),
            "title" => $title,
            "visibility" => $visibility,
            "allowFork" => $allowFork,
            "description" => $description,
            "genres" => $genres,
            "owner" => $owner_username
          ]);
        }
      }
    }
  }
}
$_SESSION["users_studios"] = $studios;
$_SESSION["users_collab_studios"] = $collab_studios;
?>

<!DOCTYPE html>
<html lang="en-us">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>User Profile Page</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/Homepage-Nav.css">
  <link rel="stylesheet" href="assets/css/User-Profile.css">
</head>

<body>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
    <div class="container"><a class="navbar-brand" href="#">JamSesh</a>
      <div class="collapse navbar-collapse" id="navcol-1">
        <ul class="nav navbar-nav mr-auto">
        </ul>
        <span class="navbar-text actions">
          <a class="btn btn-link" role="button" href="search.php">Search</a>
          <a class="btn btn-light action-button" role="button" href="logout.php">Log Out</a>
        </span>
      </div>
    </div>
  </nav>

  <!-- Edit Profile Modal -->
  <div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="editProfileLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editProfileLabel">Edit Profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form id="editProfileForm" method='POST' action='user-profile.php' enctype='multipart/form-data'>
          <div class="modal-body">
            <div class="form-group">

              <?php
              // Profile Picture
              echo "<label id='firstLabel' for='profilePicInput'>Upload Profile Picture</label>";
              echo "<input type='file' name='profile-pic' class='form-control' id='profilePicInput'>";

              // Bio
              echo "<label for='userBioInput'>Edit Bio</label>";
              echo "<textarea name='bio' class='form-control' id='userBioInput' rows='3' maxlength='255'>";
              echo $_SESSION["bio"];
              echo "</textarea>";

              // Display Name
              echo "<label for='profileNameInput'>Change Profile Name</label>";
              echo "<input type='text' name='display-name' class='form-control' id='profileNameInput' placeholder='" . $_SESSION["displayName"] . "'>";

              // Username
              echo "<label for='usernameInput'>Change Username</label>";
              echo "<div class='input-group'>";
              echo "<div class='input-group-prepend'>";
              echo "<div class='input-group-text'>@</div>";
              echo "</div>";
              echo "<input type='text' name='username' class='form-control' id='usernameInput' placeholder='" . $_SESSION["username"] . "'>";
              echo "</div>";
              ?>

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" name='save-changes' value="Submit" class="btn btn-info">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- New Studio Modal -->
  <div class="modal fade" id="newStudio" tabindex="-1" role="dialog" aria-labelledby="editProfileLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newStudioLabel">New Studio</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form id="newStudioForm" method='POST' action='user-profile.php' enctype='multipart/form-data'>
          <div class="modal-body">
            <div class="form-group">
              <label for='titleInput'>Sudio Name</label>
              <input type='text' name='new-title' class='form-control' placeholder='Title'><br>

              <label for='visibilityInput'>Studio Visibility</label>
              <select name='new-visibility' class='form-control' id='new-visibilty'>
                <option>Public</option>
                <option>Private</option>
              </select><br>

              <label for='allowForkInput'>Allow Others to Fork</label>
              <select name='new-allowFork' class='form-control' id='new-allowFork'>
                <option>Yes</option>
                <option>No</option>
              </select><br>

              <label for='descriptionInput'>Studio Description</label>
              <textarea name='new-description' class='form-control' id='new-input' rows='3' maxlength='255'>Description</textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" name='create-new-studio' value="Submit" class="btn btn-info">Create Studio</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <section class="d-xl-flex flex-row pad">
    <div class="d-flex flex-column text-center bio">

      <?php
      echo "<img src='" . $_SESSION["profilePic"] . "' alt='profile picture' class='pic'>";
      echo "<p class='subName'>@" . $_SESSION["username"] . "</p>";
      echo "<p class='name'>" . $_SESSION["displayName"] . "</p>";
      echo "<p class='subName'>" . $_SESSION["bio"] . "</p>";
      ?>

      <a data-toggle="modal" data-target="#editProfile" class="btn btn-light action-button changePic" role="button">
        Edit Profile
      </a>
      <hr />
      <div class="genreContainer d-flex flex-row">
        <?php
        $all_genres = array();
        if (@$_SESSION["users_studios"]) {
          foreach ($_SESSION["users_studios"] as $s) {
            foreach ($s["genres"] as $g) {
              array_push($all_genres, $g);
            }
          }
          $all_genres = array_unique($all_genres);
          foreach ($all_genres as $g) {
            echo "<p class='btn btn-light action-button genres'>" . $g . "</p>";
          }
        }
        ?>
      </div>
    </div>
    <div class="d-flex flex-column text-center studioSection">

      <!-- Display the studios the user owns -->
      <div class="studioHeader d-flex flex-row">
        <h2>Your Studios</h2>
        <a data-toggle="modal" data-target="#newStudio" class="btn btn-light action-button addStudio" role="button">New Studio</a>
      </div>
      <?php
      if (@$_SESSION["users_studios"]) {
        foreach ($_SESSION["users_studios"] as $s) {
          echo "<form method='POST' action='user-profile.php'>";
          echo "<button type='submit' name='studio-clicked' value=" . $s["id"] . " class='studio'>";
          echo "<div class='studioTitle text-left'>" . $s["title"] . "</div>";
          echo "<p class='studioDescription text-left'>" . $s["description"] . "</p>";
          echo "<div class='studioGenres d-flex flex-row'>";
          foreach ($s["genres"] as $g) {
            echo "<p class='btn btn-light action-button genres'>" . $g . "</p>";
          }
          echo "</div>";
          echo "</button>";
          echo "</form>";
        }
      } else {
        echo "<p>No Studios Yet</p>";
      }

      // Display the studios the user is a collaborator on
      echo "<div class='studioHeader d-flex flex-row'>";
      echo "<h2>Collaborator Studios</h2>";
      echo "</div>";
      if (@$_SESSION["users_collab_studios"]) {
        foreach ($_SESSION["users_collab_studios"] as $s) {
          echo "<form method='POST' action='user-profile.php'>";
          echo "<button type='submit' name='studio-clicked' value=" . $s["id"] . " class='studio'>";
          echo "<div class='studioTitle text-left'>@" . $s["owner"] . "/" . $s["title"] . "</div>";
          echo "<p class='studioDescription text-left'>" . $s["description"] . "</p>";
          echo "<div class='studioGenres d-flex flex-row'>";
          foreach ($s["genres"] as $g) {
            echo "<p class='btn btn-light action-button genres'>" . $g . "</p>";
          }
          echo "</div>";
          echo "</button>";
          echo "</form>";
        }
      } else {
        echo "<p>You are not a collaborator on any studios</p>";
      }

      // Display the studios the user has favorited
      echo "<div class='studioHeader d-flex flex-row'>";
      echo "<h2>Favorited Studios</h2>";
      echo "</div>";
      if (@$_SESSION["favorited-studios"]) {
        foreach ($_SESSION["users_collab_studios"] as $s) {
          echo "<form method='POST' action='user-profile.php'>";
          echo "<button type='submit' name='studio-clicked' value=" . $s["id"] . " class='studio'>";
          echo "<div class='studioTitle text-left'>@" . $s["owner"] . "/" . $s["title"] . "</div>";
          echo "<p class='studioDescription text-left'>" . $s["description"] . "</p>";
          echo "<div class='studioGenres d-flex flex-row'>";
          foreach ($s["genres"] as $g) {
            echo "<p class='btn btn-light action-button genres'>" . $g . "</p>";
          }
          echo "</div>";
          echo "</button>";
          echo "</form>";
        }
      } else {
        echo "<p>You have not favorited any studios</p>";
      }
      ?>
    </div>
  </section>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>