CREATE TABLE Friend(
	friendid SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL,
	email text NOT NULL,
	password varchar(50) NOT NULL,
	age INTEGER,
	location text,
	gender text,
	info text
);

CREATE TABLE Post(
	postid SERIAL PRIMARY KEY,
	sender INTEGER REFERENCES Friend(friendId),
	posttime Timestamp,
	title text,
	content text
);

CREATE TABLE Message(
	msgid SERIAL PRIMARY KEY,
	sender INTEGER REFERENCES Friend(friendId),
	receiver INTEGER REFERENCES Friend(friendId),
	title text,
	senttime Timestamp,
	content text
)
