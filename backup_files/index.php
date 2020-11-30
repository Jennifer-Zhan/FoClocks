<?php
$dbOk = false;
@ $db = new mysqli('localhost', 'root', '', 'websys_project');
if ($db->connect_error) {
    echo '<div class="messages">Could not connect to the database. Error: ';
    echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
} else {
    $dbOk = true;
}
$havePost = isset($_POST["save"]);

$errors = '';
if ($havePost) {
    $name = htmlspecialchars(trim($_POST["name"]));
    $timer = htmlspecialchars(trim($_POST["timer"]));
    $date = htmlspecialchars(trim($_POST["date"]));
    $countdown = htmlspecialchars(trim($_POST["countdown"]));
    $focusId = '';

    if ($name == '') {
        $errors .= '<li> Assignment name may not be blank</li>';
        if ($focusId == '') $focusId = '#name';
    }
    if ($timer == '') {
        if ($focusId == '') $focusId = '#timer';
    }

    if ($date == '') {
        $errors .= '<li> Task working date may not be blank</li>';
        if ($focusId == '') $focusId = '#date';
    }

    if ($countdown == '') {
        if ($focusId == '') $focusId = '#countdown';
    }

    if ($_POST) {
        if ($errors != '') {
            echo '<div class="messages"><h4>Please correct the following errors:</h4><ul>';
            echo $errors;
            echo '</ul></div>';
            echo '<script type="text/javascript">';
            echo '  $(document).ready(function() {';
            echo '    $("' . $focusId . '").focus();';
            echo '  });';
            echo '</script>';
        } else {
            if ($dbOk) {

                $nameForDb = trim($_POST["name"]);
                $timerForDb = trim($_POST["timer"]);
                $dateForDb = trim($_POST["date"]);
                $countdownForDb = trim($_POST["countdown"]);

                $insQuery = "insert into onetime_task (name, timer, date, countdown, deletion)
          VALUES ('".$nameForDb."', '".$timerForDb."', '".$dateForDb."','".$countdownForDb."', 0)";
                $db->query($insQuery);

            }
        }
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Function page</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link href="index_v1.css" rel="stylesheet" type="text/css">
    <link href="console.css" rel="stylesheet" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="index.js"></script>
	<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap');
	</style>
</head>
<body>
<div class="toptags">
	<section id="tag1"><a href="homepage/index.php">HOME</a></section>
	<section id="tag2"><a href="completed%20task.html">Completed</a></section>
	<section id="tag3"><a href="overview.html">Overview</a></section>
	<section id="tag4"><a href="tabs/profile.php">Profile</a></section>
	<section id="history"><a href="">History</a></section>
  <img src="1.png" alt="this is a image" width="60" id="myBtn"/></button>
</div>
<div class="bottom">
	<div class="parent">
		<div class="left">
			<h2 id="oneTime">One-Time Tasks</h2>
        <?php
        if ($dbOk) {
            $query = "select * from onetime_task where deletion = 0";
            $result = $db->query($query);
            $numRecords = $result->num_rows;
            for ($i=0; $i < $numRecords; $i++) {
                $record = $result->fetch_assoc();
                echo '<section class="singletask">';
                echo '<h3 class="TaskName">'.$record['name'].'</h3>';
                echo '<h3 class="WorkDate">'.$record['date'].'</h3>';
                if($record['timer']=="Countdown"){
                    echo '<button onclick="Countdown_timer('.$record['countdown'].')" type="button" class="TimerType">'.$record['timer'].'</button>';
                }
                else if($record['timer']=="Accumulate"){
                    echo '<button id="Accumulate_timer" type="button" class="TimerType">'.$record['timer'].'</button>';
                }

                echo '</section>';
            }
            $result->free();
        }
        ?>
		</div>

		<div class="left2">
			<section >
				<h2 id="everyday">Everyday Tasks</h2>
				<section class="singletask"><h3>Task Name: Total Time|Completed days</h3></section>
			</section>
		</div>

		<div class="todaylist">
			<div>
				<div id="myDIV" class="header">
					<h2 style="margin:5px">My To Do List</h2>
					<br />
					<input type="text" class="input_4" id="myInput" placeholder="Title...">
					<span onclick="newElement()" class="addBtn">Add</span>
				</div>
				<br />
				<ul id="myList">
                <?php
                if ($dbOk) {
                    $query = "select * from onetime_task where deletion = 0";
                    $result = $db->query($query);
                    $numRecords = $result->num_rows;
                    // get current date
                    $date = date('Y-m-d');
                    for ($i=0; $i < $numRecords; $i++) {
                        $record = $result->fetch_assoc();
                        if($record['date']==$date){
                            echo '<li>'.$record['name'].'</li>';
                        }
                    }
                }
                ?>
			    </ul>
				<div class="finished">
					<button id="bottonf" type="submit" onclick="some js function">I already finish these!</button>
				</div>
				</section>
			</div>
        </div>

        <div id="help_box">
            <button type="button" id="help">HELP</button>
        </div>    

        <div id="console">
            <div id="text_box">
                <p id="console_content"></p>
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
            </div>
            <div id="command_input">
                <input id="commandline" type="text" name="command_line" placeholder="Command line">
                <button type="button" id="commandButton">run</button>
            </div>
        </div>
	</div>

	<!--add task popup window-->
	<div id="myModal" class="modal">
		<div class="modal-body">
			<span class="close">&times;</span>
			<form id="addForm" name="addForm" action="index.php" method="post" onsubmit="return validate(this);">
				<!--          <fieldset>-->
				<div class="formData">
					<label class="field" for="name">Task Name: </label>
					<div class="value"><input class="input_1" type="text" size="30" placeholder="Task Name..." maxlength="33" value="<?php if($havePost && $errors != '') { echo $name; } ?>" name="name" id="name"/></div>
					<br/>
					<label class="field" for="timer">Timer Type:</label>
					<div class="value"><input class="input_1" type="text" size="30" placeholder="Accumulate Timer..." maxlength="50" value="<?php if($havePost && $errors != '') { echo $timer; } ?>" name="timer" id="timer"/></div>
					<br/>
					<label class="field" for="date">Task Working Date:</label>
					<div class="value"><input class="input_1" type="date" size="20" maxlength="19" value="<?php if($havePost && $errors != '') { echo $date; } ?>" name="date" id="date" /></div>
					<br/>
					<label class="field" for="countdown">Set Countdown Time:</label>
					<div class="value"><input class="input_1" type="number" size="20" maxlength="20s" value="<?php if($havePost && $errors != '') { echo $countdown; } ?>" name="countdown" id="countdown" min="1" max="5"/></div>
					<br />
					<input type="submit" value="Add Task" class="input_2" id="save" name="save"/>

				</div>
				<!--          </fieldset>-->
			</form>
		</div>
	</div>

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
				<input type="button" class="input_bnt" value="Start!" onClick="timedCount()">
				<input type="text" id="txt">
				<input type="button" class="input_bnt" value="Stop!" onClick="stopCount()">
				<input type="button" class="input_bnt" value="Clear!" onClick="clearCount()">
			</form>
		</div>
	</div>

</body>
</html>
