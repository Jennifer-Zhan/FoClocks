<?php
  // do some validation here to ensure id is safe

  // connect the database
  $dbOk = false;
  @ $conn = new mysqli('localhost', 'root', '', 'websyslab9');
  if ($conn->connect_error) {
      echo '<div class="messages">Could not connect to the database. Error: ';
      echo $conn->connect_errno . ' - ' . $conn->connect_error . '</div>';
  } else {
      $dbOk = true;
  }

  $uid = $_SESSION['uid'];
  $sql = "SELECT image FROM profile_info WHERE uid='"$uid"'";
  $result = $conn->query($sql);
  $uid_record = $result->fetch_assoc();
  $image=$uid_record['image'];

  header("Content-type: image/jpeg");
  echo $image;
?>