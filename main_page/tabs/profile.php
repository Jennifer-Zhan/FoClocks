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

$statusMsg = '';
// File upload path
if(isset($_POST["edit_profile"]) ){
	//update the time zone; store in session
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['timeZone']=$_POST['time_zones'];
	$_SESSION['theme']=$_POST['theme'];
/*
	if($_SESSION['theme']=="green"){
		echo '<link rel="stylesheet" type="text/css"
 		 href="stylesheets/profie_green.css">';
	}*/
	// upload the picture
	$targetDir = "uploads/";
	$fileName = basename($_FILES["file"]["name"]);
	$targetFilePath = $targetDir . $fileName;
	$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
        	$fname = $_POST['fname'];
	        $lname = $_POST['lname'];
	        $uid = $_SESSION['uid'];
            // Insert image file name into database
            $update = $conn->query("UPDATE `profile_info` SET `image`='".$fileName."', `first_name`='".$fname."', `last_name`='".$lname."'");
            if($update){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            }else{
                $statusMsg = "File upload failed, please try again.";
            } 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';
}

// Display status message
echo $statusMsg;
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Function page</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<?php
	if(empty($_SESSION['theme'])){
		$_SESSION['theme']="red";
	}
	if($_SESSION['theme']=="red"){
		echo '<link id="red" rel="stylesheet" type="text/css" href="stylesheets/profile.css" >';
	}
	else if($_SESSION['theme']=="green"){
		echo '<link id="green" rel="stylesheet" type="text/css" href="stylesheets/profie_green.css" >';
	}
	else{
		echo '<link id="blue" rel="stylesheet" type="text/css" href="stylesheets/profie_blue.css" >';
	}
	
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="profile.js"></script>
	<script>
	</script>
	<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap');
	</style>
</head>
<body>


<!--<img src="getImage.php?id=1" width="175" height="200" />-->
<div class="profile_change_block">

		<div class="profile_change_block_inner">
						<a href="../index_r.php" class="title"><ion-icon name="arrow-back-outline"></ion-icon>Back To Overview Tab</a>
						<p class="change_profile">Change Profile</p>
				<div class="profile_change_block_upper">
            <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $uid = $_SESSION['uid'];
            $query = $conn->query("SELECT * FROM profile_info WHERE uid='".$uid."'");

            if($query->num_rows > 0){
                while($row = $query->fetch_assoc()){
                    $imageURL = 'uploads/'.$row["image"];
                    ?>
									<img id="profile_picture" src="<?php echo $imageURL; ?>" alt="" />
                <?php }
            }else{ ?>
							<p>No image(s) found...</p>
            <?php } ?>
					<form class="edit_profile" action="profile.php" method="post" enctype="multipart/form-data">
						<p class="change_pics_hits">Change Picture?</p>
						<input type="file" name="file" id="ImageToUpload">
						<p class="change_pics_hits">First Name:</p><input type="text" name="fname" class="fNameinput" value="">
						<p class="change_pics_hits">Last Name:</p><input type="text" name="lname" class="lNameinput" value="">
						<p class="change_pics_hits">Time Zones:</p>
						<select id="time_zones" name="time_zones">
							<option value="UTC-5">UTC-5: New York</option>
							<option value="UTC-8">UTC-8: State of California</option>
							<option value="UTC+8">UTC+8: Shanghai</option>
							<option value="UTC+9">UTC+9: Tokyo</option>
						</select>
						<p class="change_pics_hits">Theme Colors</p>
<!--						<div class="color_selector">-->
						<select id="time_zones" name="theme">
							<option value="red">Red</option>
							<option value="green">Green</option>
							<option value="blue">Blue</option>
						</select>
<!--						</div>-->
						<!--
						<div class="color_selector">
							<input type="button" id="red" name="red" value="red" class="red_color" onclick="changeTheme('stylesheets/profile.css')">
							<input type="button" id="green" name="green" value="green" class="green_color" onclick="changeTheme('stylesheets/profie_green.css')">
							<input type="button" id="blue" name="blue" value="blue" class="blue_color" onclick="changeTheme('stylesheets/profie_blue.css')">
						</div>-->
						<input type="submit" value="Submit Changes" name="edit_profile" class="submit_input" id="submit_input">
					</form>
				</div>
		</div>
</div>
<script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
</body>