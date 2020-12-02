<?php
  // TO DO: Get user from the database
  $user = [
    "username" => "barnev",
    "profilePic" => "assets/img/profile-pictures/profilepic1.jpg",
    "displayName" => "Virginia Barnes",
    "bio" => "this is an example bio",
  ];
 ?>

<!-- Check for edit profile updates -->
 <?php
   if( isset($_POST['save-changes'] ) ) {

     // Profile Picture
     if( isset( $_FILES['profile-pic'] ) ) {
       if( @mime_content_type($_FILES["profile-pic"]["tmp_name"]) == "image/png" ||
       @mime_content_type($_FILES["profile-pic"]["tmp_name"]) == "image/jpeg" ) { // check that it is an image
         $file_name = $_FILES['profile-pic']['name'];
         move_uploaded_file( $_FILES["profile-pic"]["tmp_name"], "assets/img/profile-pictures/".$file_name );
         $user["profilePic"] = "assets/img/profile-pictures/".$file_name;
       }
     }

     //Bio
     if( $_POST['bio'] != "" ) {
       $user["bio"] = $_POST['bio'];
     }
     // Display Name
     if( $_POST['display-name'] != "" ) {
       $user["displayName"] = $_POST['display-name'];
     }
     // Username
     if( $_POST['username'] != "" ) {
       $user["username"] = $_POST['username'];
     }
   }
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
          <a class="btn btn-light action-button" role="button" href="homepage.php">Log Out</a>
        </span>
      </div>
    </div>
  </nav>

  <!-- Edit Profile Modal -->
  <div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="editProfileLabel"
    aria-hidden="true">
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
                echo $user["bio"];
                echo "</textarea>";

                // Display Name
                echo "<label for='profileNameInput'>Change Profile Name</label>";
                echo "<input type='text' name='display-name' class='form-control' id='profileNameInput' placeholder='" . $user["displayName"] . "'>";

                // Username
                echo "<label for='usernameInput'>Change Username</label>";
                echo "<div class='input-group'>";
                  echo "<div class='input-group-prepend'>";
                    echo "<div class='input-group-text'>@</div>";
                  echo "</div>";
                  echo "<input type='text' name='username' class='form-control' id='usernameInput' placeholder='" . $user["username"] . "'>";
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

  <section class="d-xl-flex flex-row pad">
    <div class="d-flex flex-column text-center bio">

      <?php
        echo "<img src='" . $user["profilePic"] . "' alt='profile picture' class='pic'>";
        echo "<p class='subName'>@" . $user["username"] . "</p>";
        echo "<p class='name'>" . $user["displayName"] . "</p>";
        echo "<p class='subName'>" . $user["bio"] . "</p>";
       ?>

      <a data-toggle="modal" data-target="#editProfile" class="btn btn-light action-button changePic" role="button">
        Edit Profile
      </a>
      <hr />
      <div class="genreContainer d-flex flex-row">
        <p class="btn btn-light action-button genres">Classical</p>
        <p class="btn btn-light action-button genres">R&B</p>
        <p class="btn btn-light action-button genres">Rock</p>
        <p class="btn btn-light action-button genres">Pop</p>
      </div>
    </div>
    <div class="d-flex flex-column text-center studioSection">
      <!-- Find a way to not have this container move up whenever a studio is added -->
      <div class="studioHeader d-flex flex-row">
        <h2>Your Studios</h2>
        <p class="btn btn-light action-button addStudio">New Studio</p>
      </div>
      <a class="studio" href="studio.php">
        <div class="studioTitle text-left">Studio 1</div>
        <p class="studioDescription text-left">You can have a little paragraph here describing your project. It can be a
          blurb like blah blah blah or something. You can write your own description if you want.</p>
        <div class="studioGenres d-flex flex-row">
          <p class="btn btn-light action-button genres">R&B</p>
          <p class="btn btn-light action-button genres">Pop</p>
        </div>
      </a>
      <a class="studio" href="studio.php">
        <div class="studioTitle text-left">Studio 2</div>
        <p class="studioDescription text-left">You can have a little paragraph here describing your project. It can be a
          blurb like blah blah blah or something. You can write your own description if you want.</p>
        <div class="studioGenres d-flex flex-row">
          <p class="btn btn-light action-button genres">Classical</p>
        </div>
      </a>
      <a class="studio" href="studio.php">
        <div class="studioTitle text-left">Studio 3</div>
        <p class="studioDescription text-left">You can have a little paragraph here describing your project. It can be a
          blurb like blah blah blah or something. You can write your own description if you want.</p>
        <div class="studioGenres d-flex flex-row">
          <p class="btn btn-light action-button genres">Rock</p>
          <p class="btn btn-light action-button genres">Pop</p>
        </div>
      </a>
    </div>
  </section>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
