<?php
$conn = new mysqli('localhost', 'root', '', 'websys_project');
$name=$_POST['name'];

$sql= "UPDATE `onetime_task`
    SET `deletion` = 1
    WHERE `name` = '$name'";
if ($conn->query($sql) === TRUE) {
    echo "data deleted";
}
else 
{
    echo "failed";
}
?>