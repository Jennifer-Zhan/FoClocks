<?php
$conn = new mysqli('localhost', 'root', '', 'websys_project');
$searchRequirements=strtolower($_POST['searchRequirements']);
$insQuery="SELECT * FROM onetime_task WHERE LOWER(name) LIKE '%".$searchRequirements."%' OR LOWER(day) LIKE '%".$searchRequirements."%' OR LOWER(time) LIKE '%".$searchRequirements."%' OR LOWER(timeZone) LIKE '%".$searchRequirements."%' OR LOWER(tag) LIKE '%".$searchRequirements."%' OR LOWER(details) LIKE '%".$searchRequirements."%'";
$result=$conn->query($insQuery);
if ($conn->query($insQuery) == TRUE) {
    $numRecords = $result->num_rows;
    echo '<table>';
    for ($i=0; $i < $numRecords; $i++) {
        $record = $result->fetch_assoc();
        echo '<tr>';
        echo '<th class="TaskName">'.$record['name'].'</th>';
        echo '<th class="WorkDate">'.$record['day'].'</th>';
        echo '<th class="time">'.$record['time'].'</th>';
        echo '<th class="timeZone">'.$record['timeZone'].'</th>';
        echo '<th class="tag">'.$record['tag'].'</th>';
        echo '<th class="details">'.$record['details'].'</th>';
        echo '</tr>';
    }
    echo '</table>';
}
else 
{
    echo "failed";
}
?>