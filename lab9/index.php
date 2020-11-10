<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$courses = mysqli_query( $conn, "SELECT * FROM courses" );
echo "<table border='1'>";
echo "<tr>";
echo "<th>CRN</th>";
echo "<th>Prefix</th>";
echo "<th>Number</th>";
echo "<th>Title</th>";
echo "</tr>";
while( $row=mysqli_fetch_array($courses)) {
  echo "<tr>";
  echo "<td>" . $row['crn'] . "</td>";
  echo "<td>" . $row['prefix'] . "</td>";
  echo "<td>" . $row['number'] . "</td>";
  echo "<td>" . $row['title'] . "</td>";
  echo "</tr>";
}
echo "</table>";

mysqli_close( $conn );
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Lab 9 - Gradebook</title>
  </head>
  <body>


  </body>
</html>
