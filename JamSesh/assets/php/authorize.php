<?php include 'db_conn.php';

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

try {
  if(isset($_GET['addAdmin'])) {
    $email = $_GET['addAdmin'];
    $sql = "UPDATE `users` SET isAdmin = 'Yes' WHERE email = '{$email}';";
    $result = mysqli_query($conn, $sql);
    echo "<br/><br/><span>Admin {$delete_email} authorized successfully...!!</span>";
    header("location: ../../admin.php");
    exit;
  }

  if(isset($_GET['rmAdmin'])) {
    $email = $_GET['rmAdmin'];
    $sql = "UPDATE `users` SET isAdmin = 'No' WHERE email = '{$email}';";
    $result = mysqli_query($conn, $sql);
    echo "<br/><br/><span>Admin {$delete_email} authorized successfully...!!</span>";
    header("location: ../../admin.php");
    exit;
  }

  $conn->close();
}  catch(Exception $e) {
  echo $e->getMessage();
}


?>