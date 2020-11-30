CREATE TABLE `users` (
 `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `username` varchar(255) DEFAULT NULL,
 `hash` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`uid`)
);

CREATE TABLE `onetime_task` (
 `taskid` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(100) DEFAULT NULL,
 `time` date DEFAULT NULL,
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


INSERT INTO onetime_task VALUES
  (1, "WEBSYS PROJECT", '2020-12-2', 'EST', 'academic', 'some details...',1, 0),
  (2, "COMPUTER ORGANIZATION HW",'2020-12-9', 'EST', 'academic', 'some details...',1, 0),
  (3, "PREPARE fOR INTERVIEW", '2020-12-1', 'EST', 'work', 'some details...',1, 0)

