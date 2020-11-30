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
if(isset($_POST["edit_profile"]) && !empty($_FILES["file"]["name"])){
	$targetDir = "uploads/";
	$fileName = basename($_FILES["file"]["name"]);
	$targetFilePath = $targetDir . $fileName;
	$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
	session_start();
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

//adding info to user's profile
/*
if (isset($_POST['edit_profile'])) {
    if ($_POST['edit_profile']) {
    	session_start();

        $name = $_FILES['file']['name'];
  		$target_dir = "uploads/";
  		$target_file = $target_dir . basename($_FILES["file"]["name"]);
  		// Select file type
  		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  		// Valid file extensions
  		$extensions_arr = array("jpg","jpeg","png","gif");
  		// Check extension
  		if( in_array($imageFileType,$extensions_arr) ){
	        $fname = $_POST['fname'];
	        $lname = $_POST['lname'];
	        $uid = $_SESSION['uid'];
	        echo $uid;
	        echo $name;
	        echo '\n';
	        echo $target_file;
	        $Query_AddInfo = "UPDATE `profile_info` SET `image`='".$name."', `first_name`='".$fname."', `last_name`='".$lname."'";
	        $conn->query($Query_AddInfo);
	        move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name);
	    }
    }
}*/
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Function page</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link href="stylesheets/profile.css" rel="stylesheet" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap');
	</style>
</head>
<body>
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

<!--<img src="getImage.php?id=1" width="175" height="200" />-->
<form class="edit_profile" action="profile.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="file" id="ImageToUpload">
    <span class="input_type"><br />First Name: <br /></span><input type="text" name="fname" value="">
	<span class="input_type"><br />Last Name: <br /></span><input type="text" name="lname" value="">
    <input type="submit" value="Submit Changes" name="edit_profile">
</form>
</body>