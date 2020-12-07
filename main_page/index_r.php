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
    <link href="index_r.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="index.js"></script>
</head>
<body>
    <div class="left_block">
			<div class="left_upper_block">
				<div class="title_block">
					<p class="title">FoClocks</p>
					<p id="slogan">Simplify Your Life</p>
				</div>
				<form action="index_r.php" method="post">
					<input class="left_block_search" name="search_block" type="text" value="" placeholder="  Search">
					<input class="left_block_submit" name="search_submit" type="submit" value="Submit">
					<input class="left_block_input left_block_input_1" name="all_tasks" type="button" value="All Tasks">
					<input class="left_block_input left_block_input_2" name="today_tasks" type="button" value="Today">
					<input class="left_block_input left_block_input_3" name="this_week_tasks" type="button" value="Week">
					<input class="left_block_input left_block_input_4" name="history_tasks" type="button" value="History">
				</form>
			</div>
			<div class="time_zone">

			</div>
			<div class="profile_block">
				<div class="polaroid">
					<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ_Cj7uNNkqbx3AIsEqEmYYELsqZpBScS04tg&usqp=CAU"center alt="5 Terre" style="width:100%; height: 140px; object-fit: cover; border-radius: 4px">
					<div class="container">
						<a href="tabs/profile.php" class="profile_name"><ion-icon name="person-circle-outline"></ion-icon>Joker</a>
					</div>
				</div>
			</div>
    </div>
		<div class="tasks_block">
			<div class="add_block">
				<div class="normal_add_block">
					<input class="add_name" name="name" type="text" value="" placeholder="  Task Infos">
					<input class="add_tag" name="tag" type="text" value="" placeholder="  Task Tag">
					<input class="add_time" name="date" type="date" value="">
					<input class="add_time" name="time" type="time" value="">
					<input class="normal_add_submit" name="normal_add_submit" type="submit" value="Submit">
				</div>
				<a href="tabs/command_line_helper.html" id="command_line_hits" style="text-decoration: none; color: grey">Or, using command line (command line inst.)</a>
				<div class="command_block">
					<input id="commandline" type="text" name="command_line" placeholder="  Command Line... Ver.0.1 (beta 1)">
				</div>
			</div>
			<div class="display_tasks">
				<p class="your_tasks">Your Tasks</p>
					<div class="display_lists">
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
		</div>
		<div class="more_infos">
			<div class="inner_more_infos">
				<div class="change_current_infos">
				</div>
				<div class="pomodoro_clocks">
				</div>
				<div class="famous_quotes">
				</div>
			</div>
		</div>
		<script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
</body>
</html>