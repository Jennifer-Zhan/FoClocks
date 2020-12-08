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


