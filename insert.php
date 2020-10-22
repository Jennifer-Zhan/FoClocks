<?php
$conn = new mysqli('localhost', 'root', '', 'websys_project');
$name=$_POST['name'];
$timer=$_POST['timer'];
$date = $_POST["date"];
$countdown = $_POST["countdown"];
$sql ="INSERT INTO `onetime_task` (`name`, `timer`, `date`, `countdown`, `deletion`)
        VALUES ('$name', '$timer', '$date','$countdown', 0)";
if ($conn->query($sql) === TRUE) {
    echo "data inserted";
}
else 
{
    echo "failed";
}
?>