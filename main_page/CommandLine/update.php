<?php
$conn = new mysqli('localhost', 'root', '', 'websys_project');
$name=$_POST['name'];

if (isset($_POST['day'])){
    $day=$_POST['day'];
    $sql ="UPDATE `onetime_task`
    SET `day` = '$day'
    WHERE `name` = '$name'";
}
else if (isset($_POST['time'])){
    $time=$_POST['time'];
    $sql ="UPDATE `onetime_task`
    SET `time` = '$time'
    WHERE `name` = '$name'";
}
else if (isset($_POST['timeZone'])){
    $timeZone=$_POST['timeZone'];
    $sql ="UPDATE `onetime_task`
    SET timeZone = '$timeZone'
    WHERE `name` = '$name'";
}
else if (isset($_POST['tag'])){
    $tag=$_POST['tag'];
    $sql ="UPDATE `onetime_task`
    SET tag = '$tag'
    WHERE `name` = '$name'";
}
else {
    $details=$_POST['details'];
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