<?php 
$servername = "localhost";
$username = "root";
$password = "";
$db = "websyslab9";

$studentSorted = "select * from students order by RIN ASC, lastname ASC, RCSID ASC, firstname ASC;";

$studentsByRin = "select * from students order by RIN ASC;";
$studentsByLn = "select * from students order by lastname ASC;";
$studentsByRcs = "select * from students order by RCSID ASC;";
$studentsByFn = "select * from students order by firstname ASC;";

$studentsByGrade = "select s.RIN, s.firstname, s.lastname, s.street, s.city, s.state, s.zip from students s, grades g where s.RIN = g.RIN and g.grade > 90;";

$coursesAvg = "select c.title, c.section, c.year, CAST(avg(g.grade) AS DECIMAL(5, 2)) as avg_grade from grades g, courses c where g.crn = c.crn group by g.crn;";

$coursesEnrollment = "select c.title, c.section, c.year, (select count(g.RIN) from grades g where g.crn = c.crn) as num_students from courses c;";

$createGrades = "CREATE TABLE IF NOT EXISTS grades (id INT AUTO_INCREMENT, crn DEC(11), RIN DEC(9) , grade INT(3) NOT NULL , PRIMARY KEY(id), FOREIGN KEY(crn) REFERENCES courses(crn), FOREIGN KEY(rin) REFERENCES students(rin));"
?>