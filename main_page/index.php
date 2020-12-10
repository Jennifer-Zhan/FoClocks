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
if (isset($_POST['addTask'])) {
    if ($_POST['addTask']){
	    $name = htmlspecialchars(trim($_POST["addTasksName"]));
	    $time = htmlspecialchars(trim($_POST["time_c"]));
	    $timeZone = htmlspecialchars(trim($_POST["timeZone_c"]));
	    $tag = htmlspecialchars(trim($_POST["tag_c"]));
	    $details = htmlspecialchars(trim($_POST["details_c"]));
	    session_start();
	    $uid=$_SESSION['uid'];
		$insQuery = "insert into onetime_task (name, time, timeZone, tag, details, uid, deletion)
	          VALUES ('".$name."', '".$time."', '".$timeZone."','".$tag ."', '".$details."','".$uid."', 0)";
	    $db->query($insQuery);
    }
}

//get inputs from change infos and update the database if the task name matches.
if (isset($_POST['changeTask'])) {
    if ($_POST['changeTask']){ 
	    $name = htmlspecialchars(trim($_POST["changeTasksName"]));
	    $time = htmlspecialchars(trim($_POST["time"]));
	    $timeZone = htmlspecialchars(trim($_POST["timeZone"]));
	    $tag = htmlspecialchars(trim($_POST["tag"]));
	    $details = htmlspecialchars(trim($_POST["details"]));
	    if($time!=""){
	    	$insQuery = "UPDATE onetime_task SET `time` = '".$time."' WHERE `name` = '".$name."'";
	    	$db->query($insQuery);
	    }
	    if($timeZone!=""){
	    	$insQuery = "UPDATE onetime_task SET `timeZone` = '".$timeZone."' WHERE `name` = '".$name."'";
	    	$db->query($insQuery);
	    }
	    if($tag!=""){
	    	$insQuery = "UPDATE onetime_task SET `tag` = '".$tag."' WHERE `name` = '".$name."'";
	    	$db->query($insQuery);
	    }
	    if($details!=""){
	    	$insQuery = "UPDATE onetime_task SET `details` = '".$details."' WHERE `name` = '".$name."'";
	    	$db->query($insQuery);
	    }
    }
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$uid=$_SESSION['uid'];
$sqlTask = "select * from onetime_task where deletion = 0 AND uid=$uid";

//sort the task table by time
if(isset($_POST['sortedByTime'])){
    if($_POST['sortedByTime']){
	    $sqlTask = 'SELECT * FROM `onetime_task` ORDER BY `time`';
	    $db->query($sqlTask);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Foclocks</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link href="index.css" rel="stylesheet" type="text/css">
	<!--	<link href="console.css" rel="stylesheet" type="text/css">-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="index.js"></script>
	<script>
		function changeTheme(value){
		 var sheets = document.getElementsByTagName('link'); 
     sheets[0].href = value;
		}
	</script>
</head>
<body>
<button id="help">help</button>
	<button name="red" class="c_color" onclick="changeTheme('index.css')">red scene</button>
	<button name="green" class="c_color" onclick="changeTheme('index_green.css')">green scene</button>
	<button name="blue" class="c_color" onclick="changeTheme('index_blue.css')">blue scene</button>
<div class="info_bar">
	<section id="tag1"><a href="../index.php">HOME</a></section>
	<section id="tag2"><a href="../backup_files/completed%20task.html">Completed</a></section>
	<section id="tag3"><a href="../backup_files/overview.html">Overview</a></section>
	<section id="tag4"><a href="tabs/profile.php">Profile</a></section>
	<section id="history"><a href="">History</a></section>
</div>
<div class="todolists">
	<input id="searchRequirements" name="searchRequirements" placeholder="Search By:">
	<button id="search" name="search"><p class="hover_tag">Search</p></button>
	<button id="show_all" name="show_all"><p class="hover_tag">Show All</p></button>
	<!--
	<button id="searchName" name="searchName">Name</button>
	<button id="searchTag" name="searchTag">Tag</button>-->
	<form class="buttons" action="index.php" method="post">
		<input type='submit' id="sortedByTime" name="sortedByTime" value="Sorted By Time">
	</form>
	<!--			<button id="sortedByTime" name="sortedByTime">sortedByTime</button>-->
	<div class="lists">
      <?php
      if ($dbOk) {
      	  
          $result = $db->query($sqlTask);
          $numRecords = $result->num_rows;
          echo '<table>';
          for ($i=0; $i < $numRecords; $i++) {
              $record = $result->fetch_assoc();
              echo '<tr>';
              echo '<th class="TaskName">'.$record['name'].'</th>';
              echo '<th class="WorkDate">'.$record['time'].'</th>';
              echo '<th class="timeZone">'.$record['timeZone'].'</th>';
              echo '<th class="tag">'.$record['tag'].'</th>';
              echo '<th class="details">'.$record['details'].'</th>';
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
	<form class="changeTask" action="index.php" method="post">
	<input id="changeTasksName" name="changeTasksName" placeholder="Task">
	<div class="change_infos">
		<input id="time" name="time" placeholder="time"><br />
		<input id="timeZone" name="timeZone" placeholder="time zone"><br />
		<input id="tag" name="tag" placeholder="tag"><br />
		<textarea id="details" name="details" placeholder="details..." rows="3"></textarea><br />
		<input type="submit" id="changeButton" name="changeTask" value="Change Infos">
	</div>
	</form>
</div>
<div class="add_tasks">
	<form class="addTask" action="index.php" method="post">
	<input id="addTasksName" name="addTasksName" placeholder="Task">
	<div class="change_infos">
		<input id="time_c" name="time_c" placeholder="time"><br />
		<input id="timeZone_c" name="timeZone_c" placeholder="time zone"><br />
		<input id="tag_c" name="tag_c" placeholder="tag"><br />
		<textarea id="details_c" name="details_c" placeholder="details..." rows="3"></textarea><br />
		<input type="submit" id="changeButton_c" name="addTask" value="Add Infos">
	</div>
	</form>
</div>
<div class="console">
	<button type="button" id="commandButton">Submit</button>
	<div id="text_box">
        <?php
	    if ($dbOk) {
	        $query = "select * from command_line";
	        $result = $db->query($query);
	        $numRecords = $result->num_rows;
	        for ($i=0; $i < $numRecords; $i++) {
	            $record = $result->fetch_assoc();
	            echo '<p>'.$record['command_line'].'</p>';
	        }
	        $result->free();
	    }
	    ?>
    </div>
    <div id="command_input">
        <input id="commandline" type="text" name="command_line" placeholder="Command line">
    </div>
	<!--			<div class="inside_console">-->
	

	<!--			</div>-->
</div>
<div class="timer">
<div id="Countdown_Outside">
	<div id="CountdownTimer">
		<span class="close_countdown">&times;</span>
		<p id="CountdownTimer_time"></p>
	</div>
</div>
<div id="Accumulate_Outside">
	<div id="AccumulateTimer">
		<span class="close_accumulate">&times;</span>
		<form class="input_3">
			<input id="start" type="button" class="input_bnt" value="Start!" onclick="timedCount()">
			<input type="text" id="txt">
			<input id="stop" type="button" class="input_bnt" value="Stop!" onClick="stopCount()">
			<input id="clear" type="button" class="input_bnt" value="Clear!" onClick="clearCount()">
		</form>
	</div>
</div>
<button id="countdown_button">CountDown Timer</button>
<button id="accumulate_button">CountUp Timer</button>	
</div>

<div class="map">

</div>
</body>
</html>