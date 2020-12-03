CREATE TABLE studios (
    id int(11) NOT NULL
    , owner varchar(50)
    , instruments mediumtext DEFAULT ''
    , settings mediumtext DEFAULT ''
    , PRIMARY KEY (id)
    , FOREIGN KEY (owner) REFERENCES owners(id)
);

CREATE TABLE users (
    email varchar(50)
    , password varchar(255) NOT NULL
    , username varchar(255) DEFAULT 
);