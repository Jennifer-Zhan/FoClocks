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
                $Query_uid="SELECT uid FROM users WHERE username='".$username."'";
                $uid_execute=$conn->query($Query_uid);
                $uid_record = $uid_execute->fetch_assoc();
                $uid=$uid_record['uid'];
                echo $uid;
                $Query_finduid="SELECT uid FROM profile_info WHERE uid='".$uid."'";
                $uid_find = $conn->query($Query_finduid);
                session_start();
                if($uid_find->num_rows>0){
                  $_SESSION['uid'] = $uid;
                  echo $_SESSION['uid'];
                  header("Location: main_page/index.php");

                }
                else{
                  $Query_profile="INSERT INTO `profile_info` (`uid`) VALUES ('".$uid."')";
                  $success_add=$conn->query($Query_profile);
                  echo $success_add;
                  $_SESSION['uid'] = $uid;
                  echo "New account log in";
                  header("Location: main_page/index.php");
                }
            }
            else{
                echo "UserName or Password Incorrect!";
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
  <link rel="stylesheet" href="homepage_resouces/index.css">
  <script src="homepage_resouces/index.js"></script>
</head>
<body>
<!--<header>-->
<!--  <h1>Welcome To FoClocks!</h1>-->
<!--</header>-->

<div class="login_block">
<!--	<div class="png2">-->
<!--		<img src="homepage_resouces/2.png" alt="this is a image" width="210" class="png2"/></button>-->
<!--	</div>-->
	<p class="title">FoClocks<br />
	<div class="login_infos">
		<p class="login">Login</p>
		<div class="botton_bar">
			<p class="enter_not_login"><a href="../index_v4.php">Enter Without Login</a></p>
			<div id="my-signin2"></div>
			<p class="or">OR</p>
			<form class="login_form" action="index.php" method="post">
				<p class="user_name">Username:</p><br />
				<input class="input_type" type="text" name="username" value="">
				<p class="user_pw">Password:</p>
				<input class="input_type" type="text" name="password" value="">
				<input class="login_submit" type="submit" name="login_form" value="Submit">
			</form>
			<p class="not_have_account">Do Not Have An Account Yet?</p>
			<a class="sign_in_button" href="index_sign.php">Create An Account</a>
<!--			<button type="button" id="user_login">Sign In with FoClocks Account</button>-->
<!--			<br/>-->
<!--			<button type="button" id="register">New User - Sign up a FoClocks Account</button>-->
		</div>
	</div>
</div>
<div id="foclocks_login">
  <div id="login_inner">
  <span id="close_login">&times;</span>
  <form class="login_form" action="index.php" method="post">
    <h4>Log In using FoClocks account</h4>
      <div class="input_block">
        <span class="input_type"><br />Username: <br /></span><input type="text" name="username" value="">
        <span class="input_type"><br />Password: <br /></span><input type="text" name="password" value=""><br /><br />
        <input type="submit" name="login_form" value="submit">
      </div>
  </form>
  </div>
</div>
<div id="register_block">
  <div id="register_inner">
    <span id="close_register">&times;</span>
    <form id="register_form" action="index.php" method="post">
    <h4>Sign up for a new account</h4>
    <div class="input_block">
      <span class="input_type"><br />Username: <br /></span><input type="text" name="username" value="">
      <span class="input_type"><br />Password: <br /></span><input type="text" name="password" value="">
      <span class="input_type"><br />Recomfirm Password: <br /></span><input type="text" name="recomfirm" value=""><br /><br />
      <input type="submit" name="register_form" value="submit">
    </div>
    </form>
  </div>
</div>





<!--<script>-->
<!--  var canvas = document.getElementById("canvas");-->
<!--  var ctx = canvas.getContext("2d");-->
<!--  var radius = canvas.height / 2;-->
<!--  ctx.translate(radius, radius);-->
<!--  radius = radius * 0.90-->
<!--  setInterval(drawClock, 1000);-->
<!--</script>-->

<script>
  function onSuccess(googleUser) {
    console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
  }
  function onFailure(error) {
    console.log(error);
  }
  function renderButton() {
    gapi.signin2.render('my-signin2', {
      'scope': 'profile email',
      'width': 432,
      'height': 48,
      'longtitle': true,
      // 'theme': 'dark',
      'onsuccess': onSuccess,
      'onfailure': onFailure
    });
  }
</script>

<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>

</body>
</html>