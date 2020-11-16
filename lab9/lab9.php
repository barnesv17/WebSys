
<!DOCTYPE html>
<html>
  <head>
    <title>Lab 9 - Gradebook</title>
  </head>
  <body>
    <h1>Lab 9 - Gradebook</h1>
    <form id="optionBar" method="post" action="lab9.php">
      <input type="submit" class="naviBtn" id="showStudentInfo" name="showstudents" value="Student General Info"/>
      <input type="submit" class="naviBtn" id="showCourseInfo" name="showcourses" value="Courses General Info"/>
      <input type="submit" class="naviBtn" id="showSortedStudents" name="showSortedStudents" value="Students By Order"/>
      <input type="submit" class="naviBtn" id="showAce" name="showAce" value="Ace Students"/>
      <input type="submit" class="naviBtn" id="showAvg" name="showCoursesAvg" value="Courses Average"/>
      <input type="submit" class="naviBtn" id="showEnroll" name="showEnroll" value="Courses Enrollment Status"/>
    </form>
    <div id="tables">
    <!-- <form id="filter" method="post" action="lab9.php">
                  <input type="submit" class="filter" name="Filter" value="By RIN"/>
                  <input type="submit" class="filter" name="Filter" value="By Last Name"/>
                  <input type="submit" class="filter" name="Filter" value="By RCS ID"/>
                  <input type="submit" class="filter" name="Filter" value="By First Name"/>
    </form> -->
      <?php include 'db_conn.php';
        // Create connection
        $conn = new mysqli($servername, $username, $password, $db);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        try {
          if (isset($_POST['showcourses'])) {
            $courses = mysqli_query( $conn, "SELECT * FROM courses;" );
            echo "<div class='table' id='courseInfo'>";
            echo "<h2>Courses</h2>";
            echo "<table border='3'>";
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
            echo "<button type='button' id='cAddCol'>Add Column</button>";
            echo "<button type='button' id='cAddRow'>Add Row</button>";
            echo "</div>";
          }
        } catch(Exception $e) {
          echo $e->getMessage();
        }
        try {
          if (isset($_POST['showstudents'])) {
            $students = mysqli_query( $conn, "SELECT * FROM students;" );
            echo "<div class='table' id='studentInfo'>";
            echo "<h2>Students</h2>";
            echo "<table border='3'>";
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
            echo "<button type='button' id='sAddCol'>Add Column</button>";
            echo "<button type='button' id='sAddRow'>Add Row</button>";
            echo "</div>";
          }
        } catch(Exception $e) {
          echo $e->getMessage();
        }
        try {
          if (isset($_POST['showSortedStudents'])) {
            // if (isset($_POST['Filter'])) {
            //   echo "haha";
            //   switch ($_POST['Filter']) {
            //     case 'By RIN':
            //       echo "haha";
            //       $query = $studentsByRin );
            //       break;
            //     case 'By Last Name':
            //       $students = mysqli_query( $conn, $studentsByLn);
            //       break;
            //     case 'By RCS ID':
            //       $students = mysqli_query( $conn, $studentsByRcs);
            //       break;
            //     case 'By First Name':
            //       $students = mysqli_query( $conn, $studentsByFn);
            //       break;
            //     default: 
            //     break;
            //   }
            // }
            $students = mysqli_query( $conn, $studentSorted);
            echo "<div class='table' id='studentInfo'>";
            echo "<h2>Students</h2>";
            echo "<table border='3'>";
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
            echo "<button type='button' id='sAddCol'>Add Column</button>";
            echo "<button type='button' id='sAddRow'>Add Row</button>";
            echo "</div>";
          }
        } catch(Exception $e) {
          echo $e->getMessage();
        }


        $conn->close();
      ?>
    </div>
  </body>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
  <script type="text/javascript" src="lab9.js"></script>
</html>


