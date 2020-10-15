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
  (1, "Websys Project", "Countdown", '2020-10-16', 2, 0),
  (2, "Computer Organization HW", "Countdown", '2020-10-16', 2, 0),
  (3, "Prepare for Interview", "Accumulate", '2020-10-16',0, 0),
  (4, "Prepare for Websys Quiz", "Accumulate", '2020-10-15',0,0),
  (5, "FOCS HW", "Accumulate", '2020-10-15',0,0)