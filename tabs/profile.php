<?php
// connect the database
$dbOk = false;
@ $conn = new mysqli('localhost', 'root', '', 'websys_project');
if ($conn->connect_error) {
    echo '<div class="messages">Could not connect to the database. Error: ';
    echo $conn->connect_errno . ' - ' . $conn->connect_error . '</div>';
} else {
    $dbOk = true;
}

//adding info to user's profile
if (isset($_POST['edit_profile'])) {
    if ($_POST['edit_profile']) {
        $image = $_POST['ImageToUpload'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $uid = $_SESSION['uid'];
        $Query_AddInfo = "INSERT INTO `profile_info` (`image`, `first_name`, `last_name`) VALUES ('".$image."', '".$fname."','".$lname."') WHERE uid = '"$uid"'" ;
        $conn->query($Query_AddInfo);
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Function page</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link href="index_v1.css" rel="stylesheet" type="text/css">
    <link href="console.css" rel="stylesheet" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="index.js"></script>
	<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap');
	</style>
</head>
<body>
<form class="edit_profile" action="profile.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="ImageToUpload" id="ImageToUpload">
    <span class="input_type">First Name: <br /></span><input type="text" name="fname" value="">
	<span class="input_type"><br />Last Name: <br /></span><input type="text" name="lname" value="">
    <input type="submit" value="Submit Changes" name="edit_profile">
</form>
</body>