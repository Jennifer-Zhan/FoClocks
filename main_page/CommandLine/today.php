<?php
$conn = new mysqli('localhost', 'root', '', 'websys_project');

$query = "select * from onetime_task where deletion = 0";
$result = $conn->query($query);
// get current date
$date = date('Y-m-d');
if ($conn->query($query) == TRUE) {
    $numRecords = $result->num_rows;
    echo '<table>';
    for ($i=0; $i < $numRecords; $i++) {
        $record = $result->fetch_assoc();
        if($record['day']==$date){
            $id=$record['taskid'];
            echo '<tr id="row_'."$id".'" class="row">';
            echo '<th class="TaskName">'.$record['name'].'</th>';
            echo '<th class="WorkDate">'.$record['day'].'</th>';
            echo '<th class="time">'.$record['time'].'</th>';
            echo '<th class="timeZone">'.$record['timeZone'].'</th>';
            echo '<th class="tag">'.$record['tag'].'</th>';
            echo '<th class="details">'.$record['details'].'</th>';
            echo '</tr>';
        }
    }
}
else{
    echo "failed";
}
?>