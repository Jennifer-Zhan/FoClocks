<?php
$dbOk = false;
@ $db = new mysqli('localhost', 'root', '', 'websys_project');
if ($db->connect_error) {
    echo '<div class="messages">Could not connect to the database. Error: ';
    echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
} else {
    $dbOk = true;
}

$errors = '';

//get inputs from the Add infos form and insert to the database.
if (isset($_POST['changeButton_c'])) {
    if ($_POST['changeButton_c']){ {
	    $name = htmlspecialchars(trim($_POST["addTasksName"]));
	    $time = htmlspecialchars(trim($_POST["time_c"]));
	    $timeZone = htmlspecialchars(trim($_POST["timeZone_c"]));
	    $tag = htmlspecialchars(trim($_POST["tag_c"]));
	    $details = htmlspecialchars(trim($_POST["details_c"]));
		$insQuery = "insert into onetime_task (name, time, timeZone, tag, details, deletion)
	          VALUES ('".$name."', '".$time."', '".$timeZone."','".$tag ."', '".$details."', 0)";
	    $db->query($insQuery);
    }
}

//get inputs from change infos and update the database if the task name matches.
if (isset($_POST['changeButton'])) {
    if ($_POST['changeButton']){ {
	    $name = htmlspecialchars(trim($_POST["changeTasksName"]));
	    $time = htmlspecialchars(trim($_POST["time"]));
	    $timeZone = htmlspecialchars(trim($_POST["timeZone"]));
	    $tag = htmlspecialchars(trim($_POST["tag"]));
	    $details = htmlspecialchars(trim($_POST["details"]));
	    if($time!=""){
	    	$insQuery = "UPDATE onetime_task SET `time` = '".$time."' WHERE `name` = '".$name."';";
	    	$db->query($insQuery);
	    }
	    if($timeZone!=""){
	    	$insQuery = "UPDATE onetime_task SET `timeZone` = '".$timeZone."' WHERE `name` = '".$name."';";
	    	$db->query($insQuery);
	    }
	    if($tag!=""){
	    	$insQuery = "UPDATE onetime_task SET `tag` = '".$tag."' WHERE `name` = '".$name."';";
	    	$db->query($insQuery);
	    }
	    if($details!=""){
	    	$insQuery = "UPDATE onetime_task SET `details` = '".$details."' WHERE `name` = '".$name."';";
	    	$db->query($insQuery);
	    }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Foclocks</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link href="index_v2.css" rel="stylesheet" type="text/css">
	<!--	<link href="console.css" rel="stylesheet" type="text/css">-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="index.js"></script>
</head>
<body>
<div class="info_bar">
	<section id="tag1"><a href="homepage/index.php">HOME</a></section>
	<section id="tag2"><a href="completed%20task.html">Completed</a></section>
	<section id="tag3"><a href="overview.html">Overview</a></section>
	<section id="tag4"><a href="">Sign In</a></section>
	<section id="history"><a href="">History</a></section>
</div>
<div class="todolists">
	<input id="searchRequirements" name="searchRequirements" placeholder="Search By:">
	<button id="searchTime" name="searchTime"><p class="hover_tag">Time</p></button>
	<button id="searchName" name="searchName">Name</button>
	<button id="searchTag" name="searchTag">Tag</button>
	<button id="sortedByTime" name="sortedByTime">Sorted By Time</button>
	<!--			<button id="sortedByTime" name="sortedByTime">sortedByTime</button>-->
	<div class="lists">
      <?php
      if ($dbOk) {
          $query = "select * from onetime_task where deletion = 0";
          $result = $db->query($query);
          $numRecords = $result->num_rows;
          echo '<table>';
          for ($i=0; $i < $numRecords; $i++) {
              $record = $result->fetch_assoc();
              echo '<tr>';
              echo '<th class="TaskName">'.$record['name'].'</th>';
              echo '<th class="WorkDate">'.$record['date'].'</th>';
              /*
              if($record['timer']=="Countdown"){
                  echo '<th><button onclick="Countdown_timer('.$record['countdown'].')" type="button" class="TimerType">'.$record['timer'].'</button></th>';
              }
              else if($record['timer']=="Accumulate"){
                  echo '<th><button id="Accumulate_timer" type="button" class="TimerType">'.$record['timer'].'</button></th>';
              }*/
              echo '</tr>';
          }
          echo '</table>';
          $result->free();
      }
      ?>
	</div>
</div>
<div class="change_tasks">
	<input id="changeTasksName" name="changeTasksName" placeholder="Task">
	<div class="change_infos">
		<input id="time" name="time" placeholder="time"><br />
		<input id="timeZone" name="timeZone" placeholder="time zone"><br />
		<input id="tag" name="tag" placeholder="tag"><br />
		<textarea id="details" name="details" placeholder="details..." rows="3"></textarea><br />
		<button id="changeButton" name="changeButton">Change Infos</button>
	</div>
</div>
<div class="add_tasks">
	<input id="addTasksName" name="addTasksName" placeholder="Task">
	<div class="change_infos">
		<input id="time" name="time_c" placeholder="time"><br />
		<input id="timeZone" name="timeZone_c" placeholder="time zone"><br />
		<input id="tag" name="tag_c" placeholder="tag"><br />
		<textarea id="details" name="details_c" placeholder="details..." rows="3"></textarea><br />
		<button id="changeButton" name="changeButton_c">Add Infos</button>
	</div>
</div>
<div class="console">
	<button type="button" id="console_button">Submit</button>
	<!--			<div class="inside_console">-->
    <?php
    if ($dbOk) {
        $query = "select * from command_line where lineid < 10";
        $result = $db->query($query);
        $numRecords = $result->num_rows;
        for ($i=0; $i < $numRecords; $i++) {
            $record = $result->fetch_assoc();
            echo '<p>'.$record['command_line'].'</p>';
        }
        $result->free();
    }
    ?>
	<textarea id="commandline" type="text" name="command_line" placeholder="type something... [console Ver.0.1]"></textarea>

	<!--			</div>-->
</div>
<div class="timer">

</div>
<div class="map">

</div>
</body>
</html>
