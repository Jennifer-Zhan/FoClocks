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
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(empty($_SESSION['timeZone'])){
	$_SESSION['timeZone']="UTC-5";
}

//get inputs from the Add infos form and insert to the database.
/*
if (isset($_POST['normal_add_submit'])) {
    if ($_POST['normal_add_submit']){
        $name = htmlspecialchars(trim($_POST["name"]));
        $date = htmlspecialchars(trim($_POST["date"]));
        $time = htmlspecialchars(trim($_POST["time"]));
        $tag = htmlspecialchars(trim($_POST["tag"]));
        if (session_status() == PHP_SESSION_NONE) {
    		session_start();
		}
        $uid=$_SESSION['uid'];
        $timeZone=$_SESSION['timeZone'];
        $insQuery = "INSERT into onetime_task (`name`, `day`, `time`, `timeZone`, `tag`, `details`, `uid`, `deletion`)
	          VALUES ('".$name."', '".$date."','".$time."','".$timeZone."','".$tag."',' ','".$uid."', 0)";
        $db->query($insQuery);

        session_destroy();
        $_POST=[];
    }*/


//get inputs from change infos and update the database if the task name matches.
if (isset($_POST['changeTask'])) {
    if ($_POST['changeTask']){
        $name = htmlspecialchars(trim($_POST["changeTasksName"]));
        $day = htmlspecialchars(trim($_POST["day"]));
        $time = htmlspecialchars(trim($_POST["time"]));
        $timeZone = htmlspecialchars(trim($_POST["timeZone"]));
        $tag = htmlspecialchars(trim($_POST["tag"]));
        $details = htmlspecialchars(trim($_POST["details"]));
        $insQuery = "UPDATE onetime_task SET `day` = '".$day."',`time` = '".$time."',`timeZone` = '".$timeZone."',
         `tag`= '".$tag."', `details`='".$details."' WHERE `name` = '".$name."'";
        $db->query($insQuery);
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
    <?php
    
	if($_SESSION['theme']=="red"){
		echo '<link id="red" rel="stylesheet" type="text/css" href="index_r.css" >';
	}
	else if($_SESSION['theme']=="green"){
		echo '<link id="green" rel="stylesheet" type="text/css" href="index_r_green.css" >';
	}
	else{
		echo '<link id="blue" rel="stylesheet" type="text/css" href="index_r_blue.css" >';
	}
	
	?>
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
				<input class="left_block_search" name="search_block" type="text" value="" placeholder="  Search">
				<button class="left_block_submit" name="search_submit"><p class="hover_tag">Submit</p></button>
				
					<!--<input class="left_block_submit" name="search_submit" type="submit" value="Submit">-->
				<button id="show_all" class="left_block_input left_block_input_1" name="all_tasks">All Tasks</button>
				<button id="show_today" class="left_block_input left_block_input_2" name="today_tasks">Today</button>
				<button id="show_week" class="left_block_input left_block_input_3" name="this_week_tasks">Week</button>
				<button id="show_history" class="left_block_input left_block_input_4" name="history_tasks">History</button>
			</div>
			<div class="time_zone">
				<?php 
				if (session_status() == PHP_SESSION_NONE) {
    				session_start();
				}
				$timeZone_setting=$_SESSION['timeZone'];
				echo '<p id=timezone_text>'.$timeZone_setting.'</p>';
				?>
				
				<div id="MyClockDisplay" class="clock" onload="showTime()"></div>
			</div>
			<div class="profile_block">
				<div class="polaroid">
					<?php
					$sql_profile = "SELECT * FROM profile_info";
					$result = $db->query($sql_profile);
					if ($result->num_rows == 0){
						echo '<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ_Cj7uNNkqbx3AIsEqEmYYELsqZpBScS04tg&usqp=CAU"center alt="5 Terre" style="width:100%; height: 140px; object-fit: cover; border-radius: 4px">';
						echo '<div class="container">
						<a href="tabs/profile.php" class="profile_name"><ion-icon name="person-circle-outline" class="profile_icon"></ion-icon>Joker</a>
						</div>';
					}
					else{
						$sql_info="SELECT * FROM profile_info where infoid=(SELECT max(infoid) FROM profile_info)";
						$result = $db->query($sql_profile);
						$row = $result->fetch_assoc();
						echo '<img src="tabs/uploads/'.$row['image'].'"center alt="5 Terre" style="width:100%; height: 140px; object-fit: cover; border-radius: 4px">';
						echo '<div class="container">
						<a href="tabs/profile.php" class="profile_name"><ion-icon name="person-circle-outline" class="profile_icon"></ion-icon>'.$row['first_name'].' '.$row['last_name'].'</a>
						</div>';
					}
					
				
					?>
				</div>
			</div>
    </div>

		<div class="tasks_block">
			<div class="add_block">
				<form class="normal_add_submit" action="index_r.php" method="post">
				<div class="normal_add_block">
					<input id="add_name" class="add_name" name="name" type="text" value="" placeholder="  Task Infos">
					<input id="add_tag" class="add_tag" name="tag" type="text" value="" placeholder="  Task Tag">
					<input id="add_date" class="add_time" name="date" type="date" value="">
					<input id="add_time" class="add_time" name="time" type="text" value="">
					<input id="normal_add_submit_button" class="normal_add_submit" name="normal_add_submit" type="submit" value="Submit">
				</div>
				</form>
				
				<a href="tabs/command_line_helper.html" id="command_line_hits" style="text-decoration: none; color: grey">Or, using command line (command line inst.)</a>

				<div class="command_block">
					<button type="button" id="commandButton">Submit</button>
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
								$date_time=$record['day']." ".$record['time'];
								if (session_status() == PHP_SESSION_NONE) {
            						session_start();
    							}
    							//manage time zone display
								if($_SESSION['timeZone']=="UTC-5"){
									if($record['timeZone']=="UTC-5"){
										$date = date_create($date_time, timezone_open('America/New_York'));
										date_timezone_set( $date, timezone_open('America/New_York'));
									}
									else if($record['timeZone']=="UTC-8"){
										$date = date_create($date_time, timezone_open('America/Los_Angeles'));
										date_timezone_set( $date, timezone_open('America/New_York'));
									}
									else if($record['timeZone']=="UTC+9"){
										$date = date_create($date_time, timezone_open('Asia/Shanghai'));
										date_timezone_set( $date, timezone_open('America/New_York'));
									}
									else{
										$date = date_create($date_time, timezone_open('Asia/Shanghai'));
										date_timezone_set( $date, timezone_open('America/New_York'));
									}
								}
								else if($_SESSION['timeZone']=="UTC-8"){
									if($record['timeZone']=="UTC-5"){
										$date = date_create($date_time, timezone_open('America/New_York'));
										date_timezone_set( $date, timezone_open('America/Los_Angeles'));
									}
									else if($record['timeZone']=="UTC-8"){
										$date = date_create($date_time, timezone_open('America/Los_Angeles'));
										date_timezone_set( $date, timezone_open('America/Los_Angeles'));
									}
									else if($record['timeZone']=="UTC+9"){
										$date = date_create($date_time, timezone_open('Asia/Tokyo'));
										date_timezone_set( $date, timezone_open('America/Los_Angeles'));
									}
									else {
										$date = date_create($date_time, timezone_open('Asia/Shanghai'));
										date_timezone_set( $date, timezone_open('America/Los_Angeles'));
									}
								}
								else if($_SESSION['timeZone']=="UTC+8"){
									if($record['timeZone']=="UTC-5"){
										$date = date_create($date_time, timezone_open('America/New_York'));
										date_timezone_set( $date, timezone_open('Asia/Shanghai'));
									}
									else if($record['timeZone']=="UTC-8"){
										$date = date_create($date_time, timezone_open('America/Los_Angeles'));
										date_timezone_set( $date, timezone_open('Asia/Shanghai'));
									}
									else if($record['timeZone']=="UTC+9"){
										$date = date_create($date_time, timezone_open('Asia/Tokyo'));
										date_timezone_set( $date, timezone_open('Asia/Shanghai'));
									}
									else {
										$date = date_create($date_time, timezone_open('Asia/Shanghai'));
										date_timezone_set( $date, timezone_open('Asia/Shanghai'));
									}
								}
								else {
									if($record['timeZone']=="UTC-5"){
										$date = date_create($date_time, timezone_open('America/New_York'));
										date_timezone_set( $date, timezone_open('Asia/Tokyo'));
									}
									else if($record['timeZone']=="UTC-8"){
										$date = date_create($date_time, timezone_open('America/Los_Angeles'));
										date_timezone_set( $date, timezone_open('Asia/Tokyo'));
									}
									else if($record['timeZone']=="UTC+9"){
										$date = date_create($date_time, timezone_open('Asia/Tokyo'));
										date_timezone_set( $date, timezone_open('Asia/Tokyo'));
									}
									else {
										$date = date_create($date_time, timezone_open('Asia/Shanghai'));
										date_timezone_set( $date, timezone_open('Asia/Tokyo'));
									}
								}
	
								$id=$record['taskid'];
								echo '<tr id="row_'."$id".'" class="row">';
								echo '<th class="TaskName">'.$record['name'].'</th>';
								echo '<th class="WorkDate">'.date_format($date, 'Y-m-d H:i:s').'</th>';
								echo '<th class="tag">'.$record['tag'].'</th>';
								echo '<th class="details">'.$record['details'].'</th>';
								echo '<th><button class="delete_button" id="delete_'."$id".'"><ion-icon name="close-circle-outline" class="delete_icon"></ion-icon></button></th>';
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
					<form class="changeTask" action="index_r.php" method="post">
					<input id="changeTasksName" name="changeTasksName" placeholder="Task">
					<input id="day_c" name="day" placeholder="Date"><br />
					<input id="time_c" name="time" placeholder="time"><br />
					<input id="timeZone_c" name="timeZone" placeholder="time zone"><br />
					<input id="tag_c" name="tag" placeholder="tag"><br />
					<textarea id="details_c" name="details" placeholder="details..." rows="3"></textarea><br />
					<input type="submit" id="changeButton" name="changeTask" value="Change Infos">
					</div>
					</form>
				</div>
				<div class="pomodoro_clocks">
					<div id="Countdown_Outside">
						<div id="CountdownTimer">
							<span class="close_countdown">&times;</span>
							<p id="CountdownTimer_time"></p>
						</div>
					</div>
					<div id="Accumulate_Outside">
						<div id="AccumulateTimer">
							<span class="close_accumulate">&times;</span>
							<p id="AccumulateTimer_time"></p>
						</div>
					</div>
					<div>
					<button id="countdown_button">Pomodoro</button>
					<button id="accumulate_button">Relax</button>	
					</div>
				</div>
				<div class="famous_quotes">
					<?php
					$sqlQuote = "SELECT quotes FROM quotes ORDER BY RAND() LIMIT 1";
					$result = $db->query($sqlQuote);
					$record = $result->fetch_assoc();
					echo $record['quotes'];
					?>
				</div>
			</div>
		</div>
		<script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
</body>
</html>