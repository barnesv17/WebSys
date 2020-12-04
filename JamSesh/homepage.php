<?php
  session_start();

include 'assets/php/db_conn.php';

// Define variables and initialize with empty values
$email = $password = $confirm_password = $username = "";
$email_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Validate email
  if (empty(trim($_POST["email"]))) {
    $email_err = "Please enter an email";
    echo "<script>alert( 'Please enter an email' );</script>";
  } else {
    // Prepare a select statement
    $sql = "SELECT * FROM users WHERE email = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_email);
      // Set parameters
      $param_email = trim($_POST["email"]);
      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
          $email_err = "This email already has a registered account";
          echo "<script>alert( 'This email already has a registered account' );</script>";
        } else {
          $email = trim($_POST["email"]);
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
      // Close statement
      mysqli_stmt_close($stmt);
    }
  }

  // Validate username
  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter a username";
    echo "<script>alert( 'Please enter a username' );</script>";
  } else {
    $username = trim($_POST["username"]);
  }

  // Validate password
  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter a password.";
    echo "<script>alert( 'Please enter a password.' );</script>";
  } elseif (strlen(trim($_POST["password"])) < 6) {
    $password_err = "Password must have atleast 6 characters.";
    echo "<script>alert( 'Password must have atleast 6 characters.' );</script>";
  } else {
    $password = trim($_POST["password"]);
  }

  // Validate confirm password
  if (empty(trim($_POST["confirm_password"]))) {
    $confirm_password_err = "Please confirm password.";
    echo "<script>alert( 'Please confirm password.' );</script>";
  } else {
    $confirm_password = trim($_POST["confirm_password"]);
    if (empty($password_err) && ($password != $confirm_password)) {
      $confirm_password_err = "Password did not match.";
      echo "<script>alert( 'Password did not match.' );</script>";
    }
  }

  // Check input errors before inserting in database
  if (empty($email_err) && empty($password_err) && empty($username_err) && empty($confirm_password_err)) {

    // Prepare an insert statement
    $sql = "INSERT INTO users (email, password, username) VALUES (?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_password, $param_username);

      // Set parameters
      $param_email = $email;
      $param_password = password_hash($password, PASSWORD_DEFAULT);
      $param_username = $username;

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Redirect to user-profile page
        header("location: user-profile.php");
      } else {
        echo "Something went wrong. Please try again later.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }
    // Direct to the user-profile page
    // Prepare a select statement
    $sql = "SELECT email, password, username, displayName, bio, profilePic FROM users WHERE email = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_email);
      // Set parameters
      $param_email = $email;
      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);
        // Check if email exists, if yes then verify password
        if (mysqli_stmt_num_rows($stmt) == 1) {
          // Bind result variables
          mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password, $username, $displayName, $bio, $profilePic);
          if (mysqli_stmt_fetch($stmt)) {
            session_start();

            // Store data in session variables
            $_SESSION["loggedin"] = true;
            // $_SESSION["id"] = $id;
            $_SESSION["email"] = $email;
            $_SESSION["username"] = $username;
            $_SESSION["displayName"] = $displayName;
            $_SESSION["bio"] = $bio;
            $_SESSION["profilePic"] = $profilePic;

            // Redirect user to user profile page
            header("location: user-profile.php");
          }
        }
      }
    }
  }
  // Close connection
  mysqli_close($link);
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>JamSesh - Home</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/Homepage-Nav.css">
  <link rel="stylesheet" href="assets/css/Homepage.css">
</head>

<body>
  <!-- Try and remove the style from the line below -->
  <div class="top" data-bs-parallax-bg="true" style="background: url(&quot;assets/img/teal.png&quot;);">
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
      <div class="container"><a class="navbar-brand" href="homepage.php">JamSesh</a>
        <div class="collapse navbar-collapse" id="navcol-1">
          <ul class="nav navbar-nav mr-auto">
            <!-- <li class="nav-item"><a class="nav-link active" href="#">Home</a></li> -->
          </ul>
          <span class="navbar-text actions">
            <a class="login" href="login.php">Log In</a>
            <a class="btn btn-light action-button" role="button" href="#">Sign Up</a>
          </span>
        </div>
      </div>
    </nav>

    <section class="d-flex">
      <div class="container description">
        <h2 id="builtForMusicians">Built for Musicians</h2>
        <p id="summary">JamSesh provides an environment for remote musicians to compose music collaboratively. Share a
          Studio and begin composing today.</p>
      </div>
      <div class="text-center d-xl-flex justify-content-xl-center form-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="signupForm" method="post">
          <h2 class="text-center" id="create">Create an account.</h2>
          <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>" id="email">
            <input class="form-control" type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
          </div>
          <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>" id="username">
            <input class="form-control" type="username" name="username" placeholder="Username" value="<?php echo $username; ?>">
          </div>
          <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>" id="password">
            <input class="form-control" type="password" name="password" placeholder="Password" value="<?php echo $password; ?>">
          </div>
          <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>" id="confirmPassword">
            <input class="form-control" type="password" name="confirm_password" placeholder="Password (repeat)" value="<?php echo $confirm_password; ?>">
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary btn-block" id="formButton" value="Submit">Sign Up</a>
          </div>
          <a class="already" href="login.php">You already have an account? Login here.</a>
        </form>
      </div>
    </section>
  </div>

  <div class="container">
    <div class="row text-center bottomIcons">
      <div class="col-sm">
        <i class="fa fa-user"></i>
      </div>
      <div class="col-sm">
        <i class="fa fa-microphone"></i>
      </div>
      <div class="col-sm">
        <i class="fa fa-play-circle-o"></i>
      </div>
    </div>
    <div class="row text-center d-xl-flex justify-content-xl-center align-items-xl-center">
      <div class="col-sm">
        <p>Create a personalized account alongside millions of other developers</p>
      </div>
      <div class="col-sm">
        <p>Upload audio recordings for each instrument's part to your Studio</p>
      </div>
      <div class="col-sm">
        <p>Play your recordings individually or together to test a piece's sound</p>
      </div>
    </div>
  </div>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/bs-init.js"></script>
</body>

</html>