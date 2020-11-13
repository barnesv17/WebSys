<?php 
$servername = "localhost";
$username = "root";
$password = "";
$db = "websys_login";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
</head>
<body>
  <form>
    <label for="user">Username</label>
    <input id="user" type="text">
    <label for="pass">Password</label>
    <input id="pass" type="password">
  </form>
</body>
</html>