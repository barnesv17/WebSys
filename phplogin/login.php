<?php 
$servername = "localhost";
$username = "root";
$password = "";
$db = "websys_login";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $db);
// // Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }

function saltGenerator($password) {
  $salt = hash($password, uniqid(mt_rand(), true));
  return $salt;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['username'];
  $passwd = $_POST['passwd'];
  $hashed_passwd = password_hash($passwd, PASSWORD_BCRYPT);
  
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
</head>
<body>
  <form id="logIn" method="post" action="login_insecure.php">
    <label for="user">Username</label>
    <input id="user" type="text" name="username">
    <label for="pass">Password</label>
    <input id="pass" type="password" name="passwd">
    <input type="submit" id="submit" name="submit" value="Log In"/>
  </form>
</body>
</html>