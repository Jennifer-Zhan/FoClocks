CREATE TABLE `users` (
 `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `username` varchar(255) DEFAULT NULL,
 `hash` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`uid`)
);

CREATE TABLE `onetime_task` (
 `taskid` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(100) DEFAULT NULL,
 `day` date DEFAULT NULL,
 `time` varchar(100) DEFAULT NULL,
 `timeZone` varchar(50) DEFAULT NULL,
 `tag` varchar(100) DEFAULT NULL,
 `details` varchar(255) DEFAULT NULL,
 `uid` int(10) unsigned NOT NULL,
 `deletion` int(3) DEFAULT 0,
 PRIMARY KEY (`taskid`),
 FOREIGN KEY(uid) REFERENCES users(uid) 
);

CREATE TABLE `command_line` (
 `lineid` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `command_line` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`lineid`)
);

CREATE TABLE `permissions` (
 `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `permname` varchar(255) DEFAULT NULL,
 `description` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`pid`)
);

CREATE TABLE `profile_info` (
 `infoid` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `image` longtext DEFAULT NULL,
 `first_name` varchar(255) DEFAULT NULL,
 `last_name` varchar(255) DEFAULT NULL,
 `uid` int(10) unsigned NOT NULL,
 PRIMARY KEY (`infoid`),
 FOREIGN KEY(uid) REFERENCES users(uid) 
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `quotes` (
 `quotesid` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `quotes` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`quotesid`)
);

INSERT INTO `quotes` (quotes) VALUES ("We must use time as a tool, not as a crutch.");
INSERT INTO `quotes` (quotes) VALUES ("Never to old to learn.");
INSERT INTO `quotes` (quotes) VALUES ("Time is money.");
INSERT INTO `quotes` (quotes) VALUES ("Time waits for no one.");
INSERT INTO `quotes` (quotes) VALUES ("Build your own dreams or someone else will hire you to build theirs.");
INSERT INTO `quotes` (quotes) VALUES ("A year from now you may wish you had started today.");
INSERT INTO `quotes` (quotes) VALUES ("Light tomorrow with today.");
INSERT INTO `quotes` (quotes) VALUES ("Don’t count the days, make the days count.");




