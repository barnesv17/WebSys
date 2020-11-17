
<!DOCTYPE html>
<html>
  <head>
    <title>Lab 9 - Gradebook</title>
    <link rel="stylesheet" href="lab9.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <h1>Lab 9 - Gradebook</h1>
    <form id="optionBar" method="post" action="lab9.php">
      <input type="submit" class="naviBtn" id="showStudentInfo" name="options" value="Students General Info"/>
      <input type="submit" class="naviBtn" id="showCourseInfo" name="options" value="Courses General Info"/>
      <button class="naviBtn" id="studentsByOrder">Students By Orders <i class="fa fa-caret-down"></i></button>
      <input type="submit" class="naviBtn" id="showGrades" name="options" value="All Grades"/>
      <input type="submit" class="naviBtn" id="showAce" name="options" value="Ace Students"/>
      <input type="submit" class="naviBtn" id="showAvg" name="options" value="Courses Average"/>
      <input type="submit" class="naviBtn" id="showEnroll" name="options" value="Courses Enrollment Status"/>
    </form>
    <div id="tables">

      <?php include 'db_conn.php'; // include db connection info, and sql queries
        // Create connection
        $conn = new mysqli($servername, $username, $password, $db);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        function printStudents($conn, $query) {
          $students = mysqli_query( $conn, $query );
          echo "<div class='table' id='studentInfo'>";
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
          echo "</div>";
          echo "<div id='studentBtns'>
                  <button type='button' class='opBtns' id='addStudent'>Add Row</button>
                  <button type='button' class='opBtns' id='addStudentCol'>Add Attribute</button>
                </div>";
        }
        try {
          if (isset($_POST['options'])) {
            switch($_POST['options']) {
              case 'Students General Info':
                $students = mysqli_query( $conn, "SELECT * FROM students;" );
                echo "<h2>Student General Info</h2>";
                echo "<div class='table' id='studentInfo'>";
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
                echo "</div>";
                echo "<div id='studentBtns'>
                        <button type='button' class='opBtns' id='addStudent'>Add Row</button>
                        <button type='button' class='opBtns' id='addStudentCol'>Add Attribute</button>
                      </div>";
              break;

              case 'Courses General Info':
                $courses = mysqli_query( $conn, "SELECT * FROM courses;" );
                echo "<h2>Course General Info</h2>";
                echo "<div class='table' id='courseInfo'>";
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
                echo "</div>";
                echo "<div id='courseBtns'>
                        <button type='button' class='opBtns' id='addCourse'>Add Course</button>
                        <button type='button' class='opBtns' id='addCourseCol'>Add Attribute</button>
                      </div>";
              break;

              case 'All Grades':
                $grades = mysqli_query( $conn,
                          "select s.RIN, s.firstname, s.lastname, c.prefix, c.title, g.grade from students s, grades g, courses c
                          where s.RIN = g.RIN and c.crn = g.crn
                          order by RIN asc, lastname ASC, firstname ASC, grade DESC" );
                if (!$grades || mysqli_num_rows($grades) == 0) {
                  echo "<h2>There are no grades. Would you like to add some?</h2>";
                }
                else {
                  echo "<h2>Grades Info</h2>";
                  echo "<div class='table' id='gradesInfo'>";
                  echo "<table border='3'>";
                  echo "<tr>";
                  echo "<th>RIN</th>";
                  echo "<th>First Name</th>";
                  echo "<th>Last Name</th>";
                  echo "<th>Prefix</th>";
                  echo "<th>Title</th>";
                  echo "<th>Grade</th>";
                  echo "</tr>";
                  while( $row=mysqli_fetch_array($grades)) {
                    echo "<tr>";
                    echo "<td>" . $row['RIN'] . "</td>";
                    echo "<td>" . $row['firstname'] . "</td>";
                    echo "<td>" . $row['lastname'] . "</td>";
                    echo "<td>" . $row['prefix'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['grade'] . "</td>";
                    echo "</tr>";
                  }
                }
                echo "</table>";
                echo "</div>";
                echo "<div id='gradeBtns'>
                        <button type='button' class='opBtns' id='addGrades'>Add Grade</button>
                      </div>";
                break;

              case 'By RIN':
                echo "<h2>Students By RIN</h2>";
                printStudents( $conn, $studentsByRin);

              break;

              case 'By Last Name':
                echo "<h2>Students By Last Name</h2>";
                printStudents( $conn, $studentsByLn);
              break;

              case 'By RCS ID':
                echo "<h2>Students By RCS ID</h2>";
                printStudents( $conn, $studentsByRcs);
              break;

              case 'By First Name':
                echo "<h2>Students By First Name</h2>";
                printStudents( $conn, $studentsByFn);
              break;

              case 'Ace Students':
                $students = mysqli_query( $conn, $studentsByGrade);
                if (!$students || mysqli_num_rows($students) == 0) {
                  echo "<h2>There are no grades. Would you like to add some?</h2>";
                  echo "<button type='button' class='opBtns' id='addGrades'>Add Grade</button>";
                }
                else {
                  echo "<h2>Ace Students</h2>";
                  echo "<div class='table' id='studentInfo'>";
                  echo "<table border='3'>";
                  echo "<tr>";
                  echo "<th>RIN</th>";
                  echo "<th>First Name</th>";
                  echo "<th>Last Name</th>";
                  echo "<th>Street</th>";
                  echo "<th>City</th>";
                  echo "<th>State</th>";
                  echo "<th>Zip</th>";
                  echo "</tr>";
                  while( $row=mysqli_fetch_array($students)) {
                    echo "<tr>";
                    echo "<td>" . $row['RIN'] . "</td>";
                    echo "<td>" . $row['firstname'] . "</td>";
                    echo "<td>" . $row['lastname'] . "</td>";
                    echo "<td>" . $row['street'] . "</td>";
                    echo "<td>" . $row['city'] . "</td>";
                    echo "<td>" . $row['state'] . "</td>";
                    echo "<td>" . $row['zip'] . "</td>";
                    echo "</tr>";
                  }
                }
                echo "</table>";
                echo "</div>";
              break;

              case 'Courses Average':
                $students = mysqli_query( $conn, $coursesAvg);
                if (!$students || mysqli_num_rows($students) == 0) {
                  echo "<h2>There are no grades. Would you like to add some?</h2>";
                  echo "<button type='button' class='opBtns' id='addGrades'>Add Grade</button>";
                }
                else {
                  echo "<h2>Course Averages</h2>";
                  echo "<div class='table' id='studentInfo'>";
                  echo "<table border='3'>";
                  echo "<tr>";
                  echo "<th>Course Title</th>";
                  echo "<th>Sections</th>";
                  echo "<th>Average Grade</th>";
                  echo "<th>Year</th>";
                  echo "</tr>";
                  while( $row=mysqli_fetch_array($students)) {
                    echo "<tr>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['section'] . "</td>";
                    echo "<td>" . $row['avg_grade'] . "</td>";
                    echo "<td>" . $row['year'] . "</td>";
                    echo "</tr>";
                  }
                }
                echo "</table>";
                echo "</div>";
              break;

              case 'Courses Enrollment Status':
                $students = mysqli_query( $conn, $coursesEnrollment);
                if (!$students || mysqli_num_rows($students) == 0) {
                  echo "<h2>There are no grades. Would you like to add some?</h2>";
                  echo "<button type='button' class='opBtns' id='addGrades'>Add Grade</button>";
                }
                else {
                  echo "<h2>Courses Enrollment Status</h2>";
                  echo "<div class='table' id='studentInfo'>";
                  echo "<table border='3'>";
                  echo "<tr>";
                  echo "<th>Course Title</th>";
                  echo "<th>Sections</th>";
                  echo "<th>Student Count</th>";
                  echo "<th>Year</th>";
                  echo "</tr>";
                  while( $row=mysqli_fetch_array($students)) {
                    echo "<tr>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['section'] . "</td>";
                    echo "<td>" . $row['num_students'] . "</td>";
                    echo "<td>" . $row['year'] . "</td>";
                    echo "</tr>";
                  }
                }
                echo "</table>";
                echo "</div>";
              break;

              default:
                echo "choose sth";
            }
          }
        } catch(Exception $e) {
          echo $e->getMessage();
        }

        mysqli_close($conn);
      ?>
    </div>
    <div id="modifier">
      <?php include 'db_conn.php';
        // Include db operation handling here, so success msg returns under the form
        $conn = new mysqli($servername, $username, $password, $db);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        try {
          if (isset($_POST['dbOp'])) {
            if ($_POST['dbOp'] == 'Add Student') {
              $rin = $_POST['RIN'];
              $rcs = $_POST['RCS'];
              $fn = $_POST['fn'];
              $ln = $_POST['ln'];
              $alias = $_POST['alias'];
              $phone = $_POST['phone'];
              $studentInsert = "INSERT INTO students (RIN, RCSID, firstname, lastname, alias, phone) VALUES ({$rin}, '{$rcs}', '{$fn}', '{$ln}', '{$alias}', {$phone});";
              // var_dump($studentInsert);
              if (mysqli_query($conn, $studentInsert)) {
                echo "Added student $fn $ln successfully";
              } else {
                echo "Error: " . $studentInsert . "<br>" . mysqli_error($conn);
              }
            }
            else if ($_POST['dbOp'] == 'Add Grade') {
              $grdCRN = $_POST['grdCRN'];
              $grdRIN = $_POST['grdRIN'];
              $grade = $_POST['grade'];
              if (!mysqli_query($conn, $createGrades)) {
                echo "Error: " . $createGrades . "<br>" . mysqli_error($conn);
              }
              $gradeInsert = "insert into grades values (NULL, {$grdCRN}, {$grdRIN}, {$grade});";
              if (mysqli_query($conn, $gradeInsert)) {
                echo "Added grade $grade successfully for $grdRIN";
              } else {
                echo "Error: " . $gradeInsert . "<br>" . mysqli_error($conn);
              }
            }
              

            if ($_POST['dbOp'] == 'Add Student Attribute') {
              $studentAttr = $_POST['stuAttr'];
              $studentAlter = "ALTER TABLE students ADD {$studentAlter} varchar(100);";
              if (mysqli_query($conn, $studentAlter)) {
                echo "Added column $studentAttr to table successfully";
              } else {
                echo "Error: " . $studentAlter . "<br>" . mysqli_error($conn);
              }
            }

            if ($_POST['dbOp'] == 'Add Course') {
              $crn = $_POST['CRN'];
              $prefix = $_POST['prefix'];
              $number = $_POST['number'];
              $title = $_POST['title'];
              $courseInsert = "INSERT INTO courses (CRN, prefix, num, title) VALUES ({$crn}, '{$prefix}', {$number}, '{$title}');";
              if (mysqli_query($conn, $courseInsert)) {
                echo "Added course $prefix-$number $title to table successfully";
              } else {
                echo "Error: " . $courseInsert . "<br>" . mysqli_error($conn);
              }
            }

            if ($_POST['dbOp'] == 'Add Course Attribute') {
              $courseAttr = $_POST['addCourseAttr'];
              $courseAlter = "ALTER TABLE courses ADD {$studentAlter} varchar(100);";
              if (mysqli_query($conn, $courseAlter)) {
                echo "Added column $courseAttr to table successfully";
              } else {
                echo "Error: " . $courseAttr . "<br>" . mysqli_error($conn);
              }
            }

          }
        } catch (Exception $e) {
          echo $e->getMessage();
        }

      ?>
    </div>
  </body>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type="text/javascript" src="lab9.js"></script>
</html>
