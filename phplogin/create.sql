CREATE TABLE IF NOT EXISTS users (
    user VARCHAR(100) NOT NULL
    , pass VARCHAR(100) NOT NULL
    , PRIMARY KEY(user)
);

INSERT INTO users VALUES
    ('wildg', '12345')
    , ('gwild37', 'password')
    , ('gabewild37', '12301998')
    , ('gdude37', '43210')
    ;

CREATE TABLE IF NOT EXISTS users_secure (
    user VARCHAR(100) NOT NULL
    , salt VARCHAR(100) NOT NULL
    , pass VARCHAR(100) NOT NULL
    , PRIMARY KEY(user)
);