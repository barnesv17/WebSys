<?php 

function register() 
{
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

    $pass = $_POST['pass'];
    $user = $_POST['user'];

    $hash_default_salt = password_hash($pass, PASSWORD_BCRYPT); 

    $sql = "INSERT INTO users VALUES
                (" + $user + "," + $hash_default_salt + ");";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}

if(isset($_POST['submit']))
{
    register();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
</head>
<body>
  <form method="post" action="register.php">
    <label for="user">Username</label>
    <input id="user" type="text">
    <label for="pass">Password</label>
    <input id="pass" type="password">
    <input id="submit" type="submit">
  </form>
</body>
</html>