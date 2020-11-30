<?php
$conn = new mysqli('localhost', 'root', '', 'websys_project');
$name=$_POST['name'];
$time=$_POST['time'];
$timeZone = $_POST["timeZone"];
$tag = $_POST["tag"];
$details = $_POST["details"];

session_start();

$uid=$_SESSION['uid'];
$sql ="INSERT INTO `onetime_task` (`name`, `time`, `timeZone`, `tag`, `details`,`uid`, `deletion`)
        VALUES ('$name', '$time', '$timeZone','$tag', '$details', '$uid', 0)";
if ($conn->query($sql) === TRUE) {
    echo "data inserted";
}
else 
{
    echo "failed";
}
?>