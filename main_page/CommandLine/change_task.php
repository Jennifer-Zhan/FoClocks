<?php
$conn = new mysqli('localhost', 'root', '', 'websys_project');
$id=$_GET['id'];
$sql_task="SELECT * FROM `onetime_task` where taskid='".$id."'";
$selected_task=$conn->query($sql_task);

if($conn->query($sql_task) == TRUE) {
	$numRecords = $selected_task->fetch_assoc();
	$return_arr = array();
	$name=$numRecords['name'];
	$day=$numRecords['day'];
	$time=$numRecords['time'];
	$timeZone=$numRecords['timeZone'];
	$tag=$numRecords['tag'];
	$details=$numRecords['details'];
	$return_arr[] = array("name" => $name,
	               "day" => $day,
	               "time" => $time,
	               "timeZone" => $timeZone,
	               "tag" => $tag,
	               "details" => $details);
	// Encoding array in JSON format
	echo json_encode($return_arr);
}

/*	
	echo $numRecords['name'];
	echo "\n";
	echo $numRecords['day'];
	echo "\n";
	echo $numRecords['time'];
	echo "\n";
	echo $numRecords['timeZone'];
	echo "\n";
	echo $numRecords['tag'];
	echo "\n";
	echo $numRecords['details'];*/
else{
	echo "failed";	
}
?>