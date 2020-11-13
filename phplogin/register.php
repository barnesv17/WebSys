<?php 

if($_POST["user"] && $_POST["pass"])
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

    echo $hash_default_salt;
    echo $user;

    $sql = "INSERT INTO users VALUES
<<<<<<< HEAD
                ('" . $user . "' , '" . $hash_default_salt . "');";

    echo $sql;
=======
                (" + $user + "," + $hash_default_salt + ");";
>>>>>>> 07cace55475030defc305560347b6377cca2d3b5

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
</head>
<body>
  <form action="<?php $_PHP_SELF ?>" method="POST">
    <label for="user">Username</label>
    <input id="user" name="user" type="text">
    <label for="pass">Password</label>
    <input id="pass" name="pass" type="password">
    <input type="submit">
  </form>
</body>
</html>