CREATE TABLE t_user (
id int NOT NULL AUTO_INCREMENT,
lastname VARCHAR(255) NOT NULL,
firstname VARCHAR(255),
email VARCHAR(255),
username VARCHAR(255),
password VARCHAR(255),
PRIMARY KEY (id)
);

INSERT INTO t_user(
	lastname,
	firstname,
	email,
	username,
	password
) VALUES (
	"Nicola",
	"SMITH",
	"nicky.smith@mymail.somewhere.uk",
	"nickys",
	"dummy-password-1"
);
	
	
INSERT INTO t_user(
	lastname,
	firstname,
	email,
	username,
	password
) VALUES (
	"David",
	"BROWN",
	"david.brown@another.mail.uk",
	"dbrown",
	"dummy-password-2"
);

INSERT INTO t_user(
	lastname,
	firstname,
	email,
	username,
	password
) VALUES (
	"Karen",
	"WILSON",
	"karen.wilson@mymail.com",
	"karen",
	"dummy-password-3"
);





INSERT INTO t_user(
	lastname,
	firstname,
	email,
	username,
	password
) VALUES (
	?,
	?,
	?,
	?,
	?
);