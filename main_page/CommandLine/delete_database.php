<?php
$conn = new mysqli('localhost', 'root', '', 'websys_project');
$id=$_POST['id'];
$sql= "DELETE FROM `onetime_task`
    WHERE `taskid` = '$id'";
if ($conn->query($sql) === TRUE) {
    echo "data deleted";
}
else 
{
    echo "failed";
}
?>