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

<<<<<<< HEAD
-- 1. Add address columns
ALTER TABLE students
	ADD street VARCHAR(50)
    , ADD city VARCHAR(50)
    , ADD state VARCHAR(2)
    , ADD zip DECIMAL(5, 0)
    ; 
-- 2. Add year and section number to courses
ALTER TABLE courses
	ADD section DECIMAL(2, 0)
    , ADD year DECIMAL(4, 0)
    ; 
-- 3 create grades table 
CREATE TABLE grades (
	id INT AUTO_INCREMENT
    , crn INT(11)
    , RIN INT(9) 
    , grade INT(3) NOT NULL 
    , PRIMARY KEY(id)
    , FOREIGN KEY(crn) REFERENCES courses(crn)
    , FOREIGN KEY(rin) REFERENCES students(rin)
);

=======
-- 6. ADD 10 grades into the grades table
insert into grades 
values 
    (43694, 661960000, A),
    (43694, 661960001, B),
    (43694, 661960002, C),
    (43694, 661960003, D),
    (43694, 661960004, F),
    (42149, 661960000, A),
    (42149, 661960001, B),
    (42149, 661960002, C),
    (42149, 661960003, D),
    (42149, 661960004, F);

-- 7. List all students in the following sequences; in lexicographical order by RIN, last name, RCSID, and first name.
    select * from students 
    order by 
        RIN ASC,
        lastname ASC,
        RCSID ASC,
        firstname ASC;
>>>>>>> 0c7d90a03470f9209758351b998939bfe665fa8d

-- 8. List all students RIN, name, and address if their grade in any course was higher than a 90
-- 9. List out the average grade in each course
-- 10. List out the number of students in each course

select s.RIN, s.firstname, s.lastname, s.address from students s, grades g where s.RIN = g.RIN and g.grade > 90;
select avg(grade) from grades group by crn;
select count(RIN) from grades group by crn;