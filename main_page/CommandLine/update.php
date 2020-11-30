<?php
$conn = new mysqli('localhost', 'root', '', 'websys_project');
$name=$_POST['name'];
$time=$_POST['time'];
$timeZone=$_POST['timeZone'];
$tag=$_POST['tag'];
$details=$_POST['details'];

if (!($_POST['timeZone'])&&!($_POST['tag'])&&!($_POST['details'])) {
    $sql ="UPDATE `onetime_task`
    SET `time` = '$time'
    WHERE `name` = '$name'";
}
else if (!($_POST['time'])&&!($_POST['tag'])&&!($_POST['details'])){
    $sql ="UPDATE `onetime_task`
    SET timeZone = '$timeZone'
    WHERE `name` = '$name'";
}
else if (!($_POST['time'])&&!($_POST['timeZone'])&&!($_POST['details'])){
    $sql ="UPDATE `onetime_task`
    SET tag = '$tag'
    WHERE `name` = '$name'";
}
else {
    $sql ="UPDATE `onetime_task`
    SET details= '$details'
    WHERE `name` = '$name'";
}

if ($conn->query($sql) === TRUE) {
    echo "data updated";
}
else 
{
    echo "failed";
}
?>