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

// adding Users
if (isset($_POST['register_form'])) {
    if ($_POST['register_form']) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $recomfirm = $_POST['recomfirm'];
        if($password==$recomfirm){
            $hash=password_hash($password, PASSWORD_DEFAULT);
            $Query_AddUsers = "INSERT INTO `users` (`username`, `hash`) VALUES ('".$username."', '".$hash."')";
            $conn->query($Query_AddUsers);
        }  
    }
}

// sign in
if (isset($_POST['login_form'])) {
    if ($_POST['login_form']) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $Query_hash="SELECT hash FROM users WHERE username='".$username."'";
        $hash_execute=$conn->query($Query_hash);
        if($hash_execute){
            $record = $hash_execute->fetch_assoc();
            $stored_hash=$record['hash'];
            if(password_verify($password , $stored_hash)){
                header("Location: ../index.php");
            }
            else{
                echo "UserName or Password Incorrect!"
            }
        }  
    }
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
  <meta name="google-signin-scope" content="profile email">
  <meta name="google-signin-client_id" content="855327976022-mgtq0odsogclg64js7t7e4agkfk5v0k2.apps.googleusercontent.com">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js?ver=3.0.1"></script>
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <link rel="stylesheet" href="index.css">
  <script src="index.js"></script>
  <script src="../login.js"></script>
</head>
<body>
<!--<header>-->
<!--  <h1>Welcome To FoClocks!</h1>-->
<!--</header>-->

<div class="login_block">
	<div class="png2">
		<img src="2.png" alt="this is a image" width="210" class="png2"/></button>
	</div>
	<p class="title">FoClocks <br /><br />feeling good today?</p>
	<div class="bottonb">
		<p class="button_enter"><a href="../index.php">enter without login</a></p>
		<div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
    <button type="button" id="user_login">Sign In</button>
    <form class="login_form" action="index.php" method="post">
      <h4>Log In using FoClocks account</h4>
      <div class="input_block">
        <span class="input_type"><br />Username: <br /></span><input type="text" name="username" value="">
        <p></p>
        <span class="input_type"><br />Password: <br /></span><input type="text" name="password" value=""><br /><br />
        <input type="submit" name="login_form" value="Add">
      </div>
    </form>
    <button type="button" id="register">New User - Sign up</button>
    <form class="register_form" action="index.php" method="post">
      <h4>Sign up for a new account</h4>
      <div class="input_block">
        <span class="input_type"><br />Username: <br /></span><input type="text" name="username" value="">
        <p></p>
        <span class="input_type"><br />Password: <br /></span><input type="text" name="password" value="">
        <span class="input_type"><br />Recomfirm Password: <br /></span><input type="text" name="recomfirm" value=""><br /><br />
        <input type="submit" name="register_form" value="submit">
      </div>
    </form>
    
	</div>

<!--	<div id="clock">-->
<!--		<canvas id="canvas" width="400" height="400"-->
<!--						style="background-color:#c8d5f6">-->
<!--		</canvas>-->
<!--	</div>-->
</div>



<!--<script>-->
<!--  var canvas = document.getElementById("canvas");-->
<!--  var ctx = canvas.getContext("2d");-->
<!--  var radius = canvas.height / 2;-->
<!--  ctx.translate(radius, radius);-->
<!--  radius = radius * 0.90-->
<!--  setInterval(drawClock, 1000);-->
<!--</script>-->

</body>
</html>