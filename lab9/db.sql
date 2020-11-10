-- Create a table named courses. It should contain crn (int 11, primary key), prefix (varchar 4, not null), number (smallint 4, not null), and title (varchar 255, not null). Collate should be utf8_general_ci.

create table courses (
    crn int(11) primary key,
    prefix varchar(4) not null,
    number smallint(4) not null,
    title varchar(255) not null
);

-- Create a table named students. It should contain RIN (int 9, primary key), RCSID (char 7), first name (varchar 100, not null), last name (varchar 100, not null), alias (varchar 100, not null), and phone (int 10). Collate should be utf8_general_ci.

create table students (
    RIN int(9) primary key,
    RCSID char(7),
    firstname varchar(100) not null,
    lastname varchar(100) not null,
    alias varchar(100) not null,
    phone int(10)
);

-- 8. List all students RIN, name, and address if their grade in any course was higher than a 90
-- 9. List out the average grade in each course
-- 10. List out the number of students in each course

select s.RIN, s.firstname, s.lastname, s.address from students s, grades g where s.RIN = g.RIN and g.grade > 90;
select avg(grade) from grades group by crn;
select count(RIN) from grades group by crn;