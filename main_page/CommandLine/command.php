<?php
$conn = new mysqli('localhost', 'root', '', 'websys_project');
$command_line=$_POST['command_line'];
$sql ="INSERT INTO `command_line` (`command_line`)
        VALUES ('$command_line')";
if ($conn->query($sql) === TRUE) {
    echo "Command RUN";
}
else 
{
    echo "failed";
}
?>