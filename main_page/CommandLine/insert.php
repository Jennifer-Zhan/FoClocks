<?php
$conn = new mysqli('localhost', 'root', '', 'websys_project');
$name=$_POST['name'];
$date=$_POST['day'];
$time=$_POST['time'];
$tag = $_POST['tag'];

session_start();

$uid=$_SESSION['uid'];
$sql = "INSERT into onetime_task (`name`, `day`, `time`, `timeZone`, `tag`, `details`, `uid`, `deletion`)
	          VALUES ('".$name."', '".$date."','".$time."','UTF-8','".$tag ."',' ','".$uid."', 0)";
if ($conn->query($sql) === TRUE) {
    echo "data inserted";
}
else 
{
    echo "failed";
}
?>