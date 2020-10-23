CREATE TABLE `onetime_task` (
 `taskid` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(100) DEFAULT NULL,
 `timer` varchar(50) DEFAULT NULL,
 `date` date DEFAULT NULL,
 `countdown` int(5) DEFAULT NULL,
 `deletion` int(3) DEFAULT NULL,
 PRIMARY KEY (`taskid`)
);

INSERT INTO onetime_task VALUES
  (1, "WEBSYS PROJECT", "Countdown", '2020-10-17', 2, 0),
  (2, "COMPUTER ORGANIZATION HW", "Countdown", '2020-10-17', 2, 0),
  (3, "PREPARE fOR INTERVIEW", "Accumulate", '2020-10-17',0, 0),
  (4, "PREPARE fOR WEBSYS QUIZ", "Accumulate", '2020-10-18',0,0),
  (5, "FOCS HW", "Accumulate", '2020-10-18',0,0)