CREATE TABLE `onetime_task` (
 `taskid` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(100) DEFAULT NULL,
 `timer` varchar(50) DEFAULT NULL,
 `date` date DEFAULT NULL,
 `countdown` int(5) DEFAULT NULL,
 `deletion` int(3) DEFAULT NULL,
 PRIMARY KEY (`taskid`)
);

CREATE TABLE `command_line` (
 `lineid` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `command_line` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`lineid`)
);

CREATE TABLE `users` (
 `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `username` varchar(255) DEFAULT NULL,
 `hash` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`uid`)
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
  (1, "WEBSYS PROJECT", "Countdown", '2020-10-17', 2, 0),
  (2, "COMPUTER ORGANIZATION HW", "Countdown", '2020-10-17', 2, 0),
  (3, "PREPARE fOR INTERVIEW", "Accumulate", '2020-10-17',0, 0),
  (4, "PREPARE fOR WEBSYS QUIZ", "Accumulate", '2020-10-18',0,0),
  (5, "FOCS HW", "Accumulate", '2020-10-18',0,0)

