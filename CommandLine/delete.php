<?php
$conn = new mysqli('localhost', 'root', '', 'websys_project');
$name=$_POST['name'];
$sql ="DELETE FROM onetime_task WHERE `name` = '$name'";
if ($conn->query($sql) === TRUE) {
    echo "data deleted";
}
else 
{
    echo "failed";
}
?>