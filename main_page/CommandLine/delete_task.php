<?php
$conn = new mysqli('localhost', 'root', '', 'websys_project');
$id=$_POST['id'];
$sql ="UPDATE `onetime_task`
    SET `deletion` = 1
    WHERE `taskid` = '$id'";
if ($conn->query($sql) === TRUE) {
    echo "data deleted";
}
else 
{
    echo "failed";
}
?>