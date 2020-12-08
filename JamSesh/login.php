<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to user-profile page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: user-profile.php");
    exit;
}

// Include config file
include 'assets/php/db_conn.php';

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
        echo "<script>alert( 'Please enter email.' );</script>";
    } else{
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
        echo "<script>alert( 'Please enter your password.' );</script>";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT email, password, username, displayName, bio, profilePic FROM users WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $email, $hashed_password, $username, $displayName, $bio, $profilePic);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
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
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The username and/or password you entered is incorrect.";
                            echo "<script>alert( 'The username and/or password you entered is incorrect' );</script>";
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                    echo "<script>alert( 'No account found with that email.' );</script>";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
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
  <title>JamSesh - Login</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/Homepage-Nav.css">
  <link rel="stylesheet" href="assets/css/Homepage.css">
  <link rel="stylesheet" href="assets/css/Login.css">
</head>

<body>
  <!-- Try and remove the style from the line below -->
  <div class="top" data-bs-parallax-bg="true" style="background: url(&quot;assets/img/teal.png&quot;);">
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
      <div class="container"><a class="navbar-brand" href="homepage.php">JamSesh</a>
        <div class="collapse navbar-collapse" id="navcol-1">
          <ul class="nav navbar-nav mr-auto">
          </ul>
          <span class="navbar-text actions">
            <a class="login" href="#">Log In</a>
            <a class="btn btn-light action-button" role="button" href="homepage.php">Sign Up</a>
          </span>
        </div>
      </div>
    </nav>

    <section class="d-flex">
      <div class="text-center d-xl-flex justify-content-xl-center form-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="signupForm" method="post">
          <h2 class="text-center" id="create">Login</h2>
          <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>" id="email">
            <input class="form-control" type="text" name="email" placeholder="Email" value="<?php echo $email; ?>">
          </div>
          <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>" id="password">
            <input class="form-control" type="password" name="password" placeholder="Password"></div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary btn-block" id="formButton" value="Login">Log In</a>
          </div>
          <a class="already" href="homepage.php">Don't have an account? Sign up here.</a>
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
