CREATE TABLE IF NOT EXISTS users (
    user VARCHAR(100)
    , pass VARCHAR(100)
    , PRIMARY KEY(user, pass)
);

INSERT INTO users VALUES
    ('wildg', '12345')
    , ('gwild37', 'password')
    , ('gabewild37', '12301998')
    , ('gdude37', '43210')
    ;