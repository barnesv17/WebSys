<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "websyslab9";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$courses = mysqli_query( $conn, "SELECT * FROM courses" );
echo "<h2>Courses</h2>";
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

$students = mysqli_query( $conn, "SELECT * FROM students" );
echo "<h2>Students</h2>";
echo "<table border='1'>";
echo "<tr>";
echo "<th>RIN</th>";
echo "<th>RCSID</th>";
echo "<th>First Name</th>";
echo "<th>Last Name</th>";
echo "<th>Alias</th>";
echo "<th>Phone</th>";
echo "</tr>";
while( $row=mysqli_fetch_array($students)) {
  echo "<tr>";
  echo "<td>" . $row['RIN'] . "</td>";
  echo "<td>" . $row['RCSID'] . "</td>";
  echo "<td>" . $row['firstname'] . "</td>";
  echo "<td>" . $row['lastname'] . "</td>";
  echo "<td>" . $row['alias'] . "</td>";
  echo "<td>" . $row['phone'] . "</td>";
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
