CREATE TABLE Friend(
	friendId SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL,
	email text NOT NULL,
	password varchar(50) NOT NULL,
	age INTEGER,
	location text,
	gender text,
	info text
);

CREATE TABLE Post(
	postId SERIAL PRIMARY KEY,
	sender INTEGER REFERENCES Friend(friendId),
	postTime Timestamp,
	title text,
	content text
);

CREATE TABLE Message(
	msgId SERIAL PRIMARY KEY,
	sender INTEGER REFERENCES Friend(friendId),
	receiver INTEGER REFERENCES Friend(friendId),
	content text
)
