CREATE TABLE users (
    username VARCHAR(20) NOT NULL
    , profilePic VARCHAR(100)
    , displayName VARCHAR(20)
    , PRIMARY KEY(username)
);

CREATE TABLE studios (
    studioID INT AUTO_INCREMENT NOT NULL
    , studioName VARCHAR(50) NOT NULL
    , settings BIT NOT NULL-- include all settings later
    , gitPath VARCHAR(100) NOT NULL 
    , PRIMARY KEY(studioID)
);

CREATE TABLE studioOwners (
    username VARCHAR(20) NOT NULL
    , studioID INT NOT NULL
    , PRIMARY KEY(username, studioID)
    , FOREIGN KEY(studioID) REFERENCES studios(studioID)
    , FOREIGN KEY(username) REFERENCES users(username)
);

CREATE TABLE genres (
    studioID INT NOT NULL 
    , genre VARCHAR(20) NOT NULL
    , PRIMARY KEY(studioID, genre)
    , FOREIGN KEY(studioID) REFERENCES studios(studioID)
);

CREATE TABLE studioAdmins (
    username VARCHAR(20) NOT NULL
    , studioID INT NOT NULL
    , PRIMARY KEY(username, studioID)
    , FOREIGN KEY(username) REFERENCES users(username)
    , FOREIGN KEY(studioID) REFERENCES studios(studioID)
);

CREATE TABLE contributions (
    username VARCHAR(20) NOT NULL 
    , studioID INT NOT NULL
    , instrument VARCHAR(20) NOT NULL 
    , gitDiffPath VARCHAR(100) NOT NULL
    , timesubmitted DATETIME NOT NULL 
    , PRIMARY KEY (username, studioID, instrument, timesubmitted)
    , FOREIGN KEY (username) REFERENCES users(username)
    , FOREIGN KEY (studioID) REFERENCES studios(studioID)
);

INSERT INTO users VALUES
    ("wildg@rpi.edu", NULL, "wildg")
    , ("gabewild37@gmail.com", NULL, NULL)
    , ("gdude37@gmail.com", NULL, NULL);

INSERT INTO studios VALUES
    (NULL, "My Studio", 1, "/repos/My-Studio");

INSERT INTO studioOwners VALUES 
    ("wildg@rpi.edu", 1);

INSERT INTO genres VALUES 
    (1, "Rock")
    , (1, "Alternative");

INSERT INTO studioAdmins VALUES
    ("gabewild37@gmail.com", 1)
    , ("gdude37@gmail.com", 1);

-- Sample Queries
SELECT s.studioName, g.genre FROM studios s, genres g WHERE s.studioID = g.studioID;
SELECT s.studioName, so.username, sa.username FROM studios s, studioOwners so, studioAdmins sa WHERE s.studioID = so.studioID AND so.studioID = sa.studioID;
INSERT INTO contributions VALUES("gdude37@gmail.com",1,"Lead Guitar","repos/diffs/My-Studio",CURRENT_TIMESTAMP);