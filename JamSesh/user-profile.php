<?php
// Initialize the session-------------------------------------------------------
session_start();
// Check if the user is logged in, if not then redirect him to homepage---------
// include 'assets/php/login_check.php';
// Include db config file-------------------------------------------------------
include 'assets/php/db_conn.php';

// Updates the user's Profile Picture-------------------------------------------
function checkProfilePic( $link ) {
  if (isset($_FILES['profile-pic'])) {
    // Validate the file is an image
    if (
      @mime_content_type($_FILES["profile-pic"]["tmp_name"]) == "image/png" ||
      @mime_content_type($_FILES["profile-pic"]["tmp_name"]) == "image/jpeg"
    ) {
      $file_name = $_FILES['profile-pic']['name'];
      // Upload the file to local directory
      move_uploaded_file($_FILES["profile-pic"]["tmp_name"], "assets/img/profile-pictures/" . $file_name);
      $param_profilePic = "assets/img/profile-pictures/" . $file_name;
      $param_id = $_SESSION["email"];
      // Update the profile picture file in the database
      $sql = "UPDATE users SET profilePic = '" . $param_profilePic . "' WHERE email = '" . $param_id . "'";
      if ($stmt = mysqli_prepare($link, $sql)) {
        if (!mysqli_stmt_execute($stmt)) {
          echo "Oops! Something went wrong. Please try again later.";
        }
      }
    }
  }
}

// Updates the user's bio-------------------------------------------------------
function checkBio( $link ) {
  $param_bio = $_POST['bio'];
  $param_id = $_SESSION["email"];
  // Update bio in the database
  $sql = "UPDATE users SET bio = '" . $param_bio . "' WHERE email = '" . $param_id . "'";
  if ($stmt = mysqli_prepare($link, $sql)) {
    if (!mysqli_stmt_execute($stmt)) {
      echo "Oops! Something went wrong. Please try again later.";
    }
  }
}

// Updates the user's display name----------------------------------------------
function checkDisplayName( $link ) {
  // Validate that the user's name is not an empty string
  if( trim($_POST['display-name']) != "" ) {
    $param_displayName = $_POST['display-name'];
    $param_id = $_SESSION["email"];
    // Update displayName in the database
    $sql = "UPDATE users SET displayName = '" . $param_displayName . "' WHERE email = '" . $param_id . "'";
    if ($stmt = mysqli_prepare($link, $sql)) {
      if (!mysqli_stmt_execute($stmt)) {
        echo "Oops! Something went wrong. Please try again later.";
      }
    }
  } /*else { // If the user's name is an empty string, alert the user
    echo "<script>alert( 'Profile Name was not changed, but other settings have been applied!' );</script>";
  }*/
}

// Updates the user's username--------------------------------------------------
function checkUsername( $link ) {
  // Validate that the user's username is not an empty string
  if ( trim($_POST['username']) != "") {
    $param_username = $_POST['username'];
    $param_id = $_SESSION["email"];
    // Update the username in the database
    $sql = "UPDATE users SET username = '" . $param_username . "'WHERE email = '" . $param_id . "'";
    if ($stmt = mysqli_prepare($link, $sql)) {
      if (!mysqli_stmt_execute($stmt)) {
        echo "Oops! Something went wrong. Please try again later.";
      }
    }
  } /*else { // If the username is an empty string, alert the user
    echo "<script>alert( 'Username was not changed, but other settings have been applied!' );</script>";
  }*/
}

// Checks if changes have been made in the "Edit Profile" block
function checkEditProfile( $link ) {
  // If the save-changes button was clicked
  if (isset($_POST['save-changes'])) {
    // Update all properties in the database
    checkProfilePic( $link );
    checkBio( $link );
    checkDisplayName( $link );
    checkUsername( $link );
    echo "<script>alert('Changes applied!');</script>";
    // Fetch the updated properties from the database
    $param_id = $_SESSION["email"];
    $sql = "SELECT email, password, username, displayName, bio, profilePic FROM users WHERE email = '" . $param_id . "'";
    if ($stmt = mysqli_prepare($link, $sql)) {
      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $email, $hashed_password, $username, $displayName, $bio, $profilePic);
        if (mysqli_stmt_fetch($stmt)) {
          $_SESSION["loggedin"] = true;
          $_SESSION["email"] = $email;
          $_SESSION["username"] = $username;
          $_SESSION["displayName"] = $displayName;
          $_SESSION["bio"] = $bio;
          $_SESSION["profilePic"] = $profilePic;
        }
      }
    }
  }
}

// Checks if a new studio was created-------------------------------------------
function checkNewStudio( $link ) {
  if (isset($_POST['create-new-studio'])) {
    // Validate that a title was entered for the Studio
    if (!empty($_POST["new-title"])) {
      // Insert the new studio into the database
      $sql = "INSERT INTO studios (owner, instruments, title, visibility, allowFork, description) VALUES (?, ?, ?, ?, ?, ?)";
      if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssss", $email, $instruments, $title, $visibility, $allowFork, $description);
        $email = $_SESSION["email"];
        $instruments = '{ "names" : [], "files" : [] }';
        $title = $_POST["new-title"];
        $visibility = $_POST["new-visibility"];
        $allowFork = $_POST["new-allowFork"];
        $description = $_POST["new-description"];
        if (mysqli_stmt_execute($stmt)) {
          // Make a local directory for the new studio
          $last_id = $link->insert_id;
          mkdir("studios/" . $last_id);
        } else {
          echo "Something went wrong. Please try again later.";
        }
      }
    } /*else { // If the title of the studio is empty
      echo "<script>alert( 'Empty Title' );</script>";
    }*/
  }
}

// Checks if a studio was clicked on--------------------------------------------
function checkStudioClicked() {
  if (isset($_POST["studio-clicked"])) {
    $_SESSION["studioID"] = $_POST["studio-clicked"];
    header("Location: studio.php");
  }
}

// Fetches all of the users owned studios---------------------------------------
function fetchOwnedStudios( $link ) {
  $owned_studios = array();
  // Prepare a select statement for studios where this user is the owner
  $sql = "SELECT id, title, visibility, allowFork, description FROM studios WHERE owner = '" . $_SESSION["email"] . "'";
  $result = $link->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      array_push( $owned_studios, [ 'id' => $row['id'],
                                    'title' => $row['title'],
                                    'visibility' => $row['visibility'],
                                    'allowFork' => $row['allowFork'],
                                    'description' => $row['description'] ] );
    }
  }
  return $owned_studios;
}

// Fetches all of the studios the user is a collaborator on---------------------
function fetchCollabStudios( $link ) {
  $collab_studios = array();
  // Prepare a select statement for studios where this user is a collaborator
  $sql = "SELECT * FROM collaborators WHERE email = '" . $_SESSION["email"] . "'";
  if ($result = $link->query($sql)) {
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $sql2 = "SELECT * FROM studios WHERE id = " . $row["studioID"] . "";
        $result2 = $link->query($sql2);
        if ($result2->num_rows > 0) {
          while ($row2 = $result2->fetch_assoc()) {
            $title = $row2['title'];
            $visibility = $row2['visibility'];
            $allowFork = $row2['allowFork'];
            $description = $row2['description'];
            // Find the owner of the studio's username
            $sql3 = "SELECT username FROM users WHERE email = '" . $row2["owner"] . "'";
            $result3 = $link->query($sql3);
            if ($result3->num_rows == 1) {
              while ($row3 = $result3->fetch_assoc()) {
                $owner_username = $row3["username"];
              }
            }
            array_push( $collab_studios, [ 'id' => $row2['id'],
                                          'title' => $row2['title'],
                                          'visibility' => $row2['visibility'],
                                          'allowFork' => $row2['allowFork'],
                                          'description' => $row2['description'],
                                          'owner' => $owner_username ] );
          }
        }
      }
    }
  }
  return $collab_studios;
}

function fetchFavoritedStudios( $link ) {
  $fav_studios = array();
  // Prepare a select statement for studios where this user has favorited
  $sql = "SELECT * FROM favorites WHERE email = '" . $_SESSION["email"] . "'";
  if ($result = $link->query($sql)) {
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc() ) {
        $sql2 = "SELECT * FROM studios WHERE id = " . $row["studioID"] . "";
        $result2 = $link->query($sql2);
        if ($result2->num_rows > 0) {
          while ($row2 = $result2->fetch_assoc()) {
            $title = $row2['title'];
            $visibility = $row2['visibility'];
            $allowFork = $row2['allowFork'];
            $description = $row2['description'];
            // Find the owner of the studio's username
            $sql3 = "SELECT username FROM users WHERE email = '" . $row2["owner"] . "'";
            $result3 = $link->query($sql3);
            if ($result3->num_rows == 1) {
              while ($row3 = $result3->fetch_assoc()) {
                $owner_username = $row3["username"];
              }
            }
            array_push( $fav_studios, [ 'id' => $row2['id'],
                                          'title' => $row2['title'],
                                          'visibility' => $row2['visibility'],
                                          'allowFork' => $row2['allowFork'],
                                          'description' => $row2['description'],
                                          'owner' => $owner_username ] );
          }
        }
      }
    }
  }
  return $fav_studios;
}

checkEditProfile( $link );
checkNewStudio( $link );
checkStudioClicked();
$_SESSION["users_studios"] = fetchOwnedStudios( $link );
$_SESSION["users_collab_studios"] = fetchCollabStudios( $link );
$_SESSION["favorited-studios"] = fetchFavoritedStudios( $link );
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
          <a class="btn btn-link" role="button" href="search_button.php">Search</a>
          <?php
            if ($_SESSION["isAdmin"] == 'Yes') {
              echo '<a class="btn btn-link" role="button" href="admin.php">Admin Panel</a>';
            }
          ?>
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
      echo "<p class='name'>" . $_SESSION["displayName"] . "</p>";
      echo "<p class='subName'>@" . $_SESSION["username"] . "</p>";
      echo "<p class='subName'>" . $_SESSION["bio"] . "</p>";
      ?>

      <a data-toggle="modal" data-target="#editProfile" class="btn btn-light action-button changePic" role="button">
        Edit Profile
      </a>
      <div class="genreContainer d-flex flex-row">
        <!-- <?php
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
        ?> -->
      </div>
    </div>
    <div class="d-flex flex-column text-center studioSection">

      <!-- Display the studios the user owns -->
      <div class="studioHeader d-flex flex-row">
        <h1>Your Studios</h1>
        <a data-toggle="modal" data-target="#newStudio" class="btn btn-light action-button addStudio" role="button">New Studio</a>
      </div>
      <?php
      if (@$_SESSION["users_studios"]) {
        foreach ($_SESSION["users_studios"] as $s) {
          echo "<form method='POST' action='user-profile.php'>";
          echo "<button type='submit' name='studio-clicked' value=" . $s["id"] . " class='studio'>";
          echo "<div class='studioTitle text-left'>" . $s["title"] . "</div>";
          echo "<hr />";
          echo "<p class='studioDescription text-left'>" . $s["description"] . "</p>";
          // echo "<div class='studioGenres d-flex flex-row'>";
          // echo "</div>";
          echo "</button>";
          echo "</form>";
        }
      } else {
        echo "<p>No Studios Yet</p>";
      }

      // Display the studios the user is a collaborator on
      echo "<div class='studioHeader d-flex flex-row'>";
      echo "<h1>Collaborator Studios</h1>";
      echo "</div>";
      if (@$_SESSION["users_collab_studios"]) {
        foreach ($_SESSION["users_collab_studios"] as $s) {
          echo "<form method='POST' action='user-profile.php'>";
          echo "<button type='submit' name='studio-clicked' value=" . $s["id"] . " class='studio'>";
          echo "<div class='studioTitle text-left'>@" . $s["owner"] . "/" . $s["title"] . "</div>";
          echo "<hr />";
          echo "<p class='studioDescription text-left'>" . $s["description"] . "</p>";
          // echo "<div class='studioGenres d-flex flex-row'>";
          // foreach ($s["genres"] as $g) {
          //   echo "<p class='btn btn-light action-button genres'>" . $g . "</p>";
          // }
          // echo "</div>";
          echo "</button>";
          echo "</form>";
        }
      } else {
        echo "<p>You are not a collaborator on any studios</p>";
      }
      // Display the studios the user has favorited
      echo "<div class='studioHeader d-flex flex-row'>";
      echo "<h1>Favorited Studios</h1>";
      echo "</div>";
      if (@$_SESSION["favorited-studios"]) {
        foreach ($_SESSION["favorited-studios"] as $s) {
          echo "<form method='POST' action='user-profile.php'>";
          echo "<button type='submit' name='studio-clicked' value=" . $s["id"] . " class='studio'>";
          echo "<div class='studioTitle text-left'>@" . $s["owner"] . "/" . $s["title"] . "</div>";
          echo "<hr />";
          echo "<p class='studioDescription text-left'>" . $s["description"] . "</p>";
          // echo "<div class='studioGenres d-flex flex-row'>";
          // foreach ($s["genres"] as $g) {
          //   echo "<p class='btn btn-light action-button genres'>" . $g . "</p>";
          // }
          // echo "</div>";
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
