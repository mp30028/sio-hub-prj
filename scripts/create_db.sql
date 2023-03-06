DROP DATABASE IF EXISTS `sio_hub_db`;

CREATE DATABASE `sio_hub_db`;

USE `sio_hub_db`;

DROP TABLE IF EXISTS `t_user`;


CREATE TABLE t_user (
id int NOT NULL AUTO_INCREMENT,
lastname VARCHAR(255) NOT NULL,
firstname VARCHAR(255),
email VARCHAR(255),
username VARCHAR(255),
password VARCHAR(255),
PRIMARY KEY (id)
);

LOCK TABLES `t_user` WRITE;

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





/************************************

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
************************************/

UNLOCK TABLES;

DROP USER IF EXISTS 'sio-hub-app'@'%';
CREATE USER 'sio-hub-app'@'%' IDENTIFIED WITH mysql_native_password BY 'P^ssWord*0009';
ALTER USER 'sio-hub-app'@'%' IDENTIFIED WITH mysql_native_password BY 'P^ssWord*0009';
GRANT ALL PRIVILEGES ON sio_hub_db.* TO 'sio-hub-app'@'%';

DROP USER IF EXISTS 'root'@'%';
CREATE USER 'root'@'%' IDENTIFIED WITH mysql_native_password BY 'R007Password*009';
ALTER USER 'root'@'%' IDENTIFIED WITH mysql_native_password BY 'R007Password*009';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%';