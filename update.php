<?php
$conn = new mysqli('localhost', 'root', '', 'websys_project');
$name=$_POST['name'];
$timer=$_POST['timer'];
$date = $_POST["date"];
$countdown = $_POST["countdown"];
if (!($_POST['date'])&&!($_POST['countdown'])) {
    $sql ="UPDATE `onetime_task`
    SET timer = '$timer'
    WHERE `name` = '$name'";
}
else if(!($_POST['timer'])&&!($_POST['date'])){
    $sql ="UPDATE `onetime_task`
    SET countdown = '$countdown'
    WHERE `name` = '$name'";
}
else {
    $sql ="UPDATE `onetime_task`
    SET date = '$date'
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