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

$studentByGrade = "select s.RIN, s.firstname, s.lastname, s.street, s.city, s.state, s.zip from students s, grades g where s.RIN = g.RIN and g.grade > 90;";
?>