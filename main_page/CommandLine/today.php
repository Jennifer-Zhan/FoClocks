<?php
$conn = new mysqli('localhost', 'root', '', 'websys_project');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$uid=$_SESSION['uid'];
$query = "select * from onetime_task where deletion = 0 AND uid=$uid";
$result = $conn->query($query);
// get current date
/*
if($_SESSION['timeZone']=="UTC-5"){
    $date = date('Y-m-d');
    $date = date_create($date);
    date_timezone_set( $date, timezone_open('America/New_York'));
}*/
if ($conn->query($query) == TRUE) {
    $numRecords = $result->num_rows;
    echo '<table>';
    for ($i=0; $i < $numRecords; $i++) {
        $record = $result->fetch_assoc();
        $date = date('Y-m-d');
        if($record['day']==$date){
            $date_time=$record['day']." ".$record['time'];
            //manage time zone display
            if($_SESSION['timeZone']=="UTC-5"){
                if($record['timeZone']=="UTC-5"){
                    $date = date_create($date_time, timezone_open('America/New_York'));
                    date_timezone_set( $date, timezone_open('America/New_York'));
                }
                else if($record['timeZone']=="UTC-8"){
                    $date = date_create($date_time, timezone_open('America/Los_Angeles'));
                    date_timezone_set( $date, timezone_open('America/New_York'));
                }
                else if($record['timeZone']=="UTC+9"){
                    $date = date_create($date_time, timezone_open('Asia/Shanghai'));
                    date_timezone_set( $date, timezone_open('America/New_York'));
                }
                else{
                    $date = date_create($date_time, timezone_open('Asia/Shanghai'));
                    date_timezone_set( $date, timezone_open('America/New_York'));
                }
            }
            else if($_SESSION['timeZone']=="UTC-8"){
                if($record['timeZone']=="UTC-5"){
                    $date = date_create($date_time, timezone_open('America/New_York'));
                    date_timezone_set( $date, timezone_open('America/Los_Angeles'));
                }
                else if($record['timeZone']=="UTC-8"){
                    $date = date_create($date_time, timezone_open('America/Los_Angeles'));
                    date_timezone_set( $date, timezone_open('America/Los_Angeles'));
                }
                else if($record['timeZone']=="UTC+9"){
                    $date = date_create($date_time, timezone_open('Asia/Tokyo'));
                    date_timezone_set( $date, timezone_open('America/Los_Angeles'));
                }
                else {
                    $date = date_create($date_time, timezone_open('Asia/Shanghai'));
                    date_timezone_set( $date, timezone_open('America/Los_Angeles'));
                }
            }
            else if($_SESSION['timeZone']=="UTC+8"){
                if($record['timeZone']=="UTC-5"){
                    $date = date_create($date_time, timezone_open('America/New_York'));
                    date_timezone_set( $date, timezone_open('Asia/Shanghai'));
                }
                else if($record['timeZone']=="UTC-8"){
                    $date = date_create($date_time, timezone_open('America/Los_Angeles'));
                    date_timezone_set( $date, timezone_open('Asia/Shanghai'));
                }
                else if($record['timeZone']=="UTC+9"){
                    $date = date_create($date_time, timezone_open('Asia/Tokyo'));
                    date_timezone_set( $date, timezone_open('Asia/Shanghai'));
                }
                else {
                    $date = date_create($date_time, timezone_open('Asia/Shanghai'));
                    date_timezone_set( $date, timezone_open('Asia/Shanghai'));
                }
            }
            else {
                if($record['timeZone']=="UTC-5"){
                    $date = date_create($date_time, timezone_open('America/New_York'));
                    date_timezone_set( $date, timezone_open('Asia/Tokyo'));
                }
                else if($record['timeZone']=="UTC-8"){
                    $date = date_create($date_time, timezone_open('America/Los_Angeles'));
                    date_timezone_set( $date, timezone_open('Asia/Tokyo'));
                }
                else if($record['timeZone']=="UTC+9"){
                    $date = date_create($date_time, timezone_open('Asia/Tokyo'));
                    date_timezone_set( $date, timezone_open('Asia/Tokyo'));
                }
                else {
                    $date = date_create($date_time, timezone_open('Asia/Shanghai'));
                    date_timezone_set( $date, timezone_open('Asia/Tokyo'));
                }
            }

            $id=$record['taskid'];
            echo '<tr id="row_'."$id".'" class="row">';
            echo '<th class="TaskName">'.$record['name'].'</th>';
            echo '<th class="WorkDate">'.date_format($date, 'Y-m-d H:i:s').'</th>';
            echo '<th class="tag">'.$record['tag'].'</th>';
            echo '<th class="details">'.$record['details'].'</th>';
            echo '<th><button class="delete_button" id="delete_'."$id".'"><ion-icon name="close-circle-outline" class="delete_icon"></ion-icon></button></th>';
            echo '</tr>';
        }
    }
    echo '</table>';
}
else{
    echo "failed";
}
?>