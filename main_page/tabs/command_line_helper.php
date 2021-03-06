<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>command line helper</title>
	<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
	if($_SESSION['theme']=="red"){
		echo '<link id="red" rel="stylesheet" type="text/css" href="stylesheets/command_line.css" >';
	}
	else if($_SESSION['theme']=="green"){
		echo '<link id="green" rel="stylesheet" type="text/css" href="stylesheets/command_line_green.css" >';
	}
	else{
		echo '<link id="blue" rel="stylesheet" type="text/css" href="stylesheets/command_line_blue.css" >';
	}
	
	?>
</head>
<body>
<div class="CL_block">
	<div class="CL_inner">
		<a href="../index_r.php" class="title"><ion-icon name="arrow-back-outline"></ion-icon>Back To Overview Tab</a>
		<p class="command_line">Command Line Help</p>
		<div class="inst">
			<p class="sub_t">Add Task:</p>
			<p class="content">add {task name} {working data} {working time} {tag}</p>
			<p class="example_code">ex: add DS_HW 2020-10-23 16:00 study</p>
			<p class="sub_t">Edit Task:</p>
			<p class="content">update {task name} {task property you want to update} {updated value of that property}</p>
			<p class="example_code">ex: update DS_HW tag review</p>
			<p class="sub_t">Delete Task:</p>
			<p class="content">delete task: delete {task name}</p>
			<p class="example_code">ex: delete DS_HW</p>
			<p class="sub_t">Navigate through Our Website:</p>
			<p class="content">switch {tab name}</p>
			<p class="example_code">ex: switch profile</p>
		</div>
	</div>
</div>
<script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
</body>
</html>