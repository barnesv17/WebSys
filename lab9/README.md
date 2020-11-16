
## Dev Log

-- Virginia Barnes

-- Gabe Wild

-- Derek Li

-- Kyle Qin

-- TJ Samules

## SQL Queries

#### Create a table named courses. It should contain crn (int 11, primary key), prefix (varchar 4, not null), number (smallint 4, not null), and title (varchar 255, not null). Collate should be utf8_general_ci.

create table courses (
    crn dec(11) primary key,
    prefix varchar(4) not null,
    number smallint(4) not null,
    title varchar(255) not null
);

#### Create a table named students. It should contain RIN (int 9, primary key), RCSID (char 7), first name (varchar 100, not null), last name (varchar 100, not null), alias (varchar 100, not null), and phone (int 10). Collate should be utf8_general_ci.

create table students (
    RIN dec(9) primary key,
    RCSID char(7),
    firstname varchar(100) not null,
    lastname varchar(100) not null,
    alias varchar(100) not null,
    phone dec(10)
);

#### Add address columns
ALTER TABLE students
	ADD street VARCHAR(50)
    , ADD city VARCHAR(50)
    , ADD state VARCHAR(2)
    , ADD zip DECIMAL(5, 0)
    ; 
#### Add year and section number to courses
ALTER TABLE courses
	ADD section DECIMAL(2, 0)
    , ADD year DECIMAL(4, 0)
    ; 
#### create grades table 
CREATE TABLE grades (
	id INT AUTO_INCREMENT
    , crn DEC(11)
    , RIN DEC(9) 
    , grade INT(3) NOT NULL 
    , PRIMARY KEY(id)
    , FOREIGN KEY(crn) REFERENCES courses(crn)
    , FOREIGN KEY(rin) REFERENCES students(rin)
);

#### insert 4 courses into the courses table
INSERT INTO courses VALUES 
    (40327, 'CSCI', 4440, 'Software Design and Documentation', 02, 2021)
    , (42678, 'CSCI', 4150, 'Intro to AI', 01, 2021)
    , (42806, 'ITWS', 4500, 'Web Science Systems Development', 01, 2021)
    , (43695, 'ITWS', 2210, 'Intro to HCI', 01, 2021)
; 

#### insert 4 students into the students table
INSERT INTO students VALUES
    (661858455, 'wildg', 'Gabriel', 'Wild', 'Gabe', 3237089229, '519 Congress St.', 'Troy', 'NY', '12180')
    , (661858456, 'wildg', 'Gabriel', 'Wild', 'Gabe Clone', 3237089229, '519 Congress St.', 'Troy', 'NY', '12180')
    , (661858457, 'wildg', 'Gabriel', 'Wild', 'Gabe Clone #2', 3237089229, '519 Congress St.', 'Troy', 'NY', '12180')
    , (661858458, 'wildg', 'Gabriel', 'Wild', 'Gabe Clone #3', 3237089229, '519 Congress St.', 'Troy', 'NY', '12180')
;

#### ADD 10 grades into the grades table
insert into grades 
values 
    (NULL, 40327, 661858455, 100),
    (NULL, 42678, 661858455, 97),
    (NULL, 40327, 661858456, 70),
    (NULL, 42678, 661858456, 65),
    (NULL, 40327, 661858457, 100),
    (NULL, 42678, 661858457, 105),
    (NULL, 42806, 661858457, 50),
    (NULL, 40327, 661858458, 78),
    (NULL, 42678, 661858458, 96),
    (NULL, 42806, 661858458, 75);

#### List all students in the following sequences; in lexicographical order by RIN, last name, RCSID, and first name.
    select * from students 
    order by 
        RIN ASC;
    select * from students 
    order by 
        lastname ASC;
    select * from students 
    order by 
        RCSID ASC;
    select * from students 
    order by 
        firstname ASC;

#### List all students RIN, name, and address if their grade in any course was higher than a 90
#### List out the average grade in each course
#### List out the number of students in each course

select s.RIN, s.firstname, s.lastname, s.street, s.city, s.state, s.zip from students s, grades g where s.RIN = g.RIN and g.grade > 90;
select c.title, c.section, c.year, CAST(avg(g.grade) AS DECIMAL(5, 2)) as avg_grade from grades g, courses c where g.crn = c.crn group by g.crn;
select c.title, c.section, c.year, (select count(g.RIN) from grades g where g.crn = c.crn) as num_students from courses c;