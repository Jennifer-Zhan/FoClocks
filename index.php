<?php
  $dbOk = false;
  @ $db = new mysqli('localhost', 'root', '', 'websys_project');
  if ($db->connect_error) {
    echo '<div class="messages">Could not connect to the database. Error: ';
    echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
  } else {
    $dbOk = true; 
  }
  $havePost = isset($_POST["save"]);

  $errors = '';
  if ($havePost) {

    $name = htmlspecialchars(trim($_POST["name"]));  
    $timer = htmlspecialchars(trim($_POST["timer"]));
    $date = htmlspecialchars(trim($_POST["date"]));
    $countdown = htmlspecialchars(trim($_POST["countdown"]));
    $focusId = ''; 
    
    if ($name == '') {
      $errors .= '<li> Assignment name may not be blank</li>';
      if ($focusId == '') $focusId = '#name';
    }
    if ($timer == '') {
      if ($focusId == '') $focusId = '#timer';
    }

    if ($date == '') {
      $errors .= '<li> Task working date may not be blank</li>';
      if ($focusId == '') $focusId = '#date';
    }

    if ($countdown == '') {
      if ($focusId == '') $focusId = '#countdown';
    }

    if ($_POST) {
      if ($errors != '') {
        echo '<div class="messages"><h4>Please correct the following errors:</h4><ul>';
        echo $errors;
        echo '</ul></div>';
        echo '<script type="text/javascript">';
        echo '  $(document).ready(function() {';
        echo '    $("' . $focusId . '").focus();';
        echo '  });';
        echo '</script>';
      } else { 
        if ($dbOk) {

          $nameForDb = trim($_POST["name"]);  
          $timerForDb = trim($_POST["timer"]);
          $dateForDb = trim($_POST["date"]);
          $countdownForDb = trim($_POST["countdown"]);
         
          $insQuery = "insert into onetime_task (name, timer, date, countdown, deletion)
          VALUES ('".$nameForDb."', '".$timerForDb."', '".$dateForDb."','".$countdownForDb."', 0)";
          $db->query($insQuery);
         
        }
      }
      header("Location: " . $_SERVER['REQUEST_URI']);
      exit();
    }
  }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Function page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link href="function_page.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script scr="index.js"></script>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap');
    </style>
  </head>
  <body>
    <div class="wholepage">
      <div class="toptags">
        <section id="tag0"><h1><a href="homepage/index.html">HOME</a></h1></section>
        <section id="tag1"><h1>Ongoing tasks</h1></section>
        <section id="tag2"><h1>Completed tasks</h1></section>
        <section id="tag3"><h1>Overview tasks</h1></section>
        <section id="tag4"><h1>Sign In</h1></section>
        <img src="1.png" alt="this is a image" width="60" id="myBtn"/></button>
      </div>
      <div class="bottom">
        <div class="parent">
          <div class="left">
          <h2 id="oneTime">One-Time Tasks</h2>
            <?php
              if ($dbOk) {
                $query = "select * from onetime_task where deletion = 0";
                $result = $db->query($query);
                $numRecords = $result->num_rows;
                for ($i=0; $i < $numRecords; $i++) {
                  $record = $result->fetch_assoc();
                  echo '<section class="singletask">';
                  echo '<h3 class="TaskName">'.$record['name'].'</h3>';
                  echo '<h3 class="WorkDate">'.$record['date'].'</h3>';
                  if($record['timer']=="Countdown"){
                    echo '<button onclick="Countdown_timer('.$record['countdown'].')" type="button" class="TimerType">'.$record['timer'].'</button>';
                  }
                  else if($record['timer']=="Accumulate"){
                    echo '<button id="Accumulate_timer" type="button" class="TimerType">'.$record['timer'].'</button>';
                  }

                  echo '</section>';
                }
              $result->free();
            }
          ?>
        </div>
        <div class="left2">
        <section >
          <h2>Everyday Tasks</h2>
            <section class="singletask"><h3>Task Name: Total Time|Completed days</h3></section>
          </section>
        </div>
         <div class="todylist">
          <section >
            <h2>Today's Todo List:</h2>
            <?php
            if ($dbOk) {

                $query = "select * from onetime_task where deletion = 0";
                $result = $db->query($query);
                $numRecords = $result->num_rows;
                // get current date
                $date = date('Y-m-d');
                echo $date;
                for ($i=0; $i < $numRecords; $i++) {
                  $record = $result->fetch_assoc();
                  if($record['date']==$date){
                    echo '<h3><label><input type="checkbox" name="check">'.$record['name'].'</input></label></h3>';
                  }
                }  
            }
            ?>
            <button type="submit" onclick="some js function">I already finish these!</button>
          </section>
        </div>
      </div>
      </div>
    </div>
    <div id="myModal" class="modal">
      <div class="modal-body">
        <span class="close">&times;</span>
        <form id="addForm" name="addForm" action="index.php" method="post" onsubmit="return validate(this);">
          <fieldset> 
            <div class="formData">
              <label class="field" for="name">Task Name: </label>
              <div class="value"><input type="text" size="30" placeholder="Task Name..." maxlength="33" value="<?php if($havePost && $errors != '') { echo $name; } ?>" name="name" id="name"/></div>
              <br/>
              <label class="field" for="timer">Timer Type:</label>
              <div class="value"><input type="text" size="30" placeholder="Accumulate Timer, Countdown Timer, or Pomodoro clock" maxlength="50" value="<?php if($havePost && $errors != '') { echo $timer; } ?>" name="timer" id="timer"/></div>
              <br/>
              <label class="field" for="date">Task Working Date:</label>
              <div class="value"><input type="date" size="20" maxlength="19" value="<?php if($havePost && $errors != '') { echo $date; } ?>" name="date" id="date" /></div>
              <br/>
              <label class="field" for="countdown">Set Countdown Time:</label>
              <div class="value"><input type="number" size="20" maxlength="20s" value="<?php if($havePost && $errors != '') { echo $countdown; } ?>" name="countdown" id="countdown" min="1" max="5"/></div>

              <input type="submit" value="Add Task" id="save" name="save"/>

            </div>
          </fieldset>
        </form>
      </div>
    </div>

    <div id="Countdown_Outside">
      <div id="CountdownTimer">
        <span class="close_countdown">&times;</span>
        <p id="CountdownTimer_time"></p>
      </div>
    </div>

    <div id="Accumulate_Outside">
      <div id="AccumulateTimer">
        <span class="close_accumulate">&times;</span>
        <form> 
          <input type="button" value="Start!" onClick="timedCount()"> 
          <input type="text" id="txt"> 
          <input type="button" value="Stop!" onClick="stopCount()"> 
          <input type="button" value="Clear!" onClick="clearCount()"> 
        </form> 
      </div>
    </div>  

    <script>
     
      // Get the modal
    var CountdownTimer = document.getElementById("Countdown_Outside");

    // Get the button that opens the modal
    var CountdownTimer_bnt = document.getElementById("Countdown_timer");

    // Get the <span> element that closes the modal
    var CountdownSpan = document.getElementsByClassName("close_countdown")[0];

// When the user clicks the button, open the modal 
    /*CountdownTimer_bnt.onclick = function() {
      CountdownTimer.style.display = "block";
    }*/

// When the user clicks on <span> (x), close the modal
    CountdownSpan.onclick = function() {
      CountdownTimer.style.display = "none";
    }
/*
// When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == CountdownTimer) {
        CountdownTimer.style.display = "none";
      }
    }*/
    var AccumulteTimer = document.getElementById("Accumulate_Outside");
    var AccumulateTimer_bnt = document.getElementById("Accumulate_timer");
    var AccumulateSpan = document.getElementsByClassName("close_accumulate")[0];

    AccumulateTimer_bnt.onclick = function() {
      AccumulteTimer.style.display = "block";
    }

    AccumulateSpan.onclick = function() {
      AccumulteTimer.style.display = "none";
    }


    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
    btn.onclick = function() {
      modal.style.display = "block";
    }

// When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }

// When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
      else if (event.target == CountdownTimer) {
        CountdownTimer.style.display = "none";
      }
    }

  
  // Update the count down every 1 second
  function Countdown_timer(time){
    var click_time = new Date().getTime();
    setInterval(function(){
      calculate(time,click_time);
    }, 1000);
    var CountdownTimer = document.getElementById("Countdown_Outside");
    CountdownTimer.style.display = "block";

  }

  function calculate(time,click_time){
    var now = new Date().getTime();
    var distance = Math.floor(time*3600000-(now-click_time));
    // Time calculations for days, hours, minutes and seconds
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      
    // Output the result in an element with id="demo"
    show_time= hours + "h "+ minutes + "m " + seconds + "s ";
    // If the count down is over, write some text 
    if (distance < 0) {
      clearInterval(distance);
      show_time = "EXPIRED";
    }
    document.getElementById("CountdownTimer_time").innerHTML=show_time;  
  }
    //accumulate timer functions
      var s=0
      var m=0
      var h=0
      var t 
      function timedCount() 
      { 
          var time=h+":"+m+":"+s
          document.getElementById('txt').value=time
          s=s+1 
          if(s==60){
              m+=1
              s=0
          }
          if(m==60){
              h+=1
              m=0
          }
          t=setTimeout("timedCount()",1000) 
      } 
      function stopCount() 
      { 
          clearTimeout(t) 
      } 

      function clearCount()
      {
          s=0
          m=0
          h=0
          time=h+":"+m+":"+s
          document.getElementById('txt').value=time
          clearTimeout(t)
      }
    </script>

  </body>
</html>
