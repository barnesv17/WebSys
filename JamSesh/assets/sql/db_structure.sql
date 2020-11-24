CREATE TABLE users (
    username VARCHAR(20) NOT NULL
    , profilePic VARCHAR(100)
    , displayName VARCHAR(20)
    , PRIMARY KEY(username)
);

CREATE TABLE studios (
    studioID INT NOT NULL
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

