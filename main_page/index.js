
$(document).ready(function(){
    function showTime(){
      var timeZone=document.getElementById("timezone_text").textContent;
      var date = new Date();
      if(timeZone=="UTC-5"){
        console.log("1111");
        date.toLocaleString("en-US", {timeZone: "America/New_York"})
        console.log(date);
      }
      else if(timeZone=="UTC+8"){
        date.toLocaleString("en-US", {timeZone: "Asia/Shanghai"})
      }
      var h = date.getHours(); // 0 - 23
      var m = date.getMinutes(); // 0 - 59
      var s = date.getSeconds(); // 0 - 59
      var session = "AM";
      
      if(h == 0){
          h = 12;
      }
      
      if(h > 12){
          h = h - 12;
          session = "PM";
      }
      
      h = (h < 10) ? "0" + h : h;
      m = (m < 10) ? "0" + m : m;
      s = (s < 10) ? "0" + s : s;
      
      var time = h + ":" + m + ":" + s + " " + session;
      document.getElementById("MyClockDisplay").innerText = time;
      document.getElementById("MyClockDisplay").textContent = time;
      
      setTimeout(showTime, 1000);
      
    }

    showTime();

    // change task interactive; when clicking on each row of table, users could change the info of the task clicking on.
    var row = document.getElementsByClassName("row");
    for (var i=0; i<row.length; i++){
      console.log(row[i].id);
      row[i].addEventListener("click", interact_fuction);
    }

    function interact_fuction() {
      var id = this.id[this.id.length-1];
      $.ajax({
          url:'CommandLine/change_task.php',
          method:'GET',
          data:{
            id: id
          },
          dataType: 'JSON',
          success:function(data){
            document.getElementById("changeTasksName").value=data[0].name;
            document.getElementById("day_c").value=data[0].day;
            document.getElementById("time_c").value=data[0].time;
            document.getElementById("timeZone_c").value=data[0].timeZone;
            document.getElementById("tag_c").value=data[0].tag;
            document.getElementById("details_c").value=data[0].details;
          }

      })
    }

    // Get the modal
    var CountdownTimer = document.getElementById("Countdown_Outside");

    // Get the button that opens the modal
    var CountdownTimer_bnt = document.getElementById("countdown_button");

    // Get the <span> element that closes the modal
    var CountdownSpan = document.getElementsByClassName("close_countdown")[0];

    var AccumulateTimer = document.getElementById("Accumulate_Outside");
    var AccumulateTimer_bnt = document.getElementById("accumulate_button");
    var AccumulateSpan = document.getElementsByClassName("close_accumulate")[0];

    // When the user clicks the button, open the modal
    CountdownTimer_bnt.onclick = function() {
      CountdownTimer.style.display = "block";
      AccumulateTimer.style.display = "none";
      Countdown_timer(25/60);
    }

    // When the user clicks on <span> (x), close the modal
    var hours;
    var minutes;
    var seconds;
    var show_time;


    AccumulateSpan.onclick = function() {
      AccumulateTimer.style.display = "none";
    }

    var timer_interval;
    function Countdown_timer(time){
      var click_time = new Date().getTime();
      timer_interval=setInterval(function(){
        calculate(time,click_time);
      }, 1000);
      var CountdownTimer = document.getElementById("Countdown_Outside");
      CountdownTimer.style.display = "block";

    }

    function calculate(time,click_time){
      var now = new Date().getTime();
      distance = Math.floor(time*3600000-(now-click_time));
      // Time calculations for days, hours, minutes and seconds
      hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Output the result in an element with id="demo"
      show_time= hours + "h "+ minutes + "m " + seconds + "s ";
      // If the count down is over, write some text
      if (distance < 0) {
        clearInterval(distance);
        show_time = "EXPIRED";
      }
      document.getElementById("CountdownTimer_time").innerHTML=show_time;
      console.log(show_time);
    }

    CountdownSpan.onclick = function() {
      CountdownTimer.style.display = "none";
      hours = 0;
      minutes = 25;
      seconds = 0;
      show_time=hours + "h "+ minutes + "m " + seconds + "s ";
      clearInterval(timer_interval);
    }

    // when click on countup timer, close and stop the countdown timer.
    AccumulateTimer_bnt.onclick = function() {
      AccumulateTimer.style.display = "block";
      CountdownTimer.style.display = "none";
      hours = 0;
      minutes = 25;
      seconds = 0;
      show_time=hours + "h "+ minutes + "m " + seconds + "s ";
      clearInterval(timer_interval);
    }
    //accumulate timer functions
    
    document.getElementById("start").addEventListener("click", timedCount);
    document.getElementById("stop").addEventListener("click", stopCount);
    document.getElementById("stop").addEventListener("click", clearCount);
    //Add help alert.
 

    //Trigger button click on enter
    var input = document.getElementById("commandline");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("commandButton").click();
        }
    });

    //function for console command line execution and instructions implement.
    $("#commandButton").click(function(){
        //var p = document.createElement("p");
        var command_line = document.getElementById("commandline").value;
        $.ajax({
          url:'CommandLine/command.php',
          method:'POST',
          data:{
            command_line: command_line
          },
          success:function(data){
            alert(data);
          }

        })
        //var t = document.createTextNode(command_line);
        //p.appendChild(t);
        /*
        if (command_line === '') {
            alert("You must write something!");
        } else {
            document.getElementById("text_box").appendChild(p);
        }*/
        document.getElementById("commandline").value = "";
        var sep=command_line.split(" ");
        /*implement add instruction*/
        if(sep[0]=="add"){
            var name_type=sep[1];
            // format the name of task if it has multiple words.
            name_type=name_type.split("_");
            var name="";
            for (var i=0; i<name_type.length-1; i++){
                name+=name_type[i].toUpperCase();
                name+=" ";
            }
            name+=name_type[name_type.length-1].toUpperCase();
            var day=sep[2];
            var time=sep[3];
            var tag=sep[4];
            
            $.ajax({
                url:'CommandLine/insert.php',
                method:'POST',
                data:{
                    name:name,
                    day:day,
                    time:time,
                    tag:tag
                },
                success:function(data){
                    alert(data);
                    window.location.reload();
                }
            });  
        }
        /*implement update instruction*/
        else if(sep[0]=="update"){
            var name_type=sep[1];
            name_type=name_type.split("_");
            var name="";
            for (var i=0; i<name_type.length-1; i++){
                name+=name_type[i].toUpperCase();
                name+=" ";
            }
            name+=name_type[name_type.length-1].toUpperCase();
            var type=sep[2];
            var update_var=sep[3];
            if(type=="date"){
                var day=update_var;
                $.ajax({
                    url:'CommandLine/update.php',
                    method:'POST',
                    data:{
                        name:name,
                        day:day
                    },
                    success:function(data){
                        alert(data);
                        window.location.reload();
                    }
                });  
            }
            else if(type=="time"){
                var time=update_var;
                $.ajax({
                    url:'CommandLine/update.php',
                    method:'POST',
                    data:{
                        name:name,
                        time:time
                    },
                    success:function(data){
                        alert(data);
                        window.location.reload();
                    }
                });  
            }
            /*if update_var is a number, then it should be the countdown value */
            else if(type=="timeZone"){
                var timeZone=update_var;
                $.ajax({
                    url:'CommandLine/update.php',
                    method:'POST',
                    data:{
                        name:name,
                        timeZone:timeZone
                    },
                    success:function(data){
                        alert(data);
                        window.location.reload();
                    }
                });  
            }
            else if(type=="tag"){
                var tag=update_var;
                $.ajax({
                    url:'CommandLine/update.php',
                    method:'POST',
                    data:{
                        name:name,
                        tag:tag
                    },
                    success:function(data){
                        alert(data);
                        window.location.reload();s
                    }
                });  
            }
            else{
                var details_type=update_var;
                details_type=details_type.split("_");
                var details="";
                for (var i=0; i<details_type.length-1; i++){
                  details+=details_type[i].toUpperCase();
                  details+=" ";
                }
                details+=details_type[details_type.length-1].toUpperCase();
                $.ajax({
                    url:'CommandLine/update.php',
                    method:'POST',
                    data:{
                        name:name,
                        details:details
                    },
                    success:function(data){
                        alert(data);
                        window.location.reload();
                    }
                });  
            }
        }

        /*implement delete instruction*/
        else if(sep[0]=="delete"){
            var name_type=sep[1];
            // deal with multiple-words task name.
            name_type=name_type.split("_");
            var name="";
            for (var i=0; i<name_type.length-1; i++){
                name+=name_type[i].toUpperCase();
                name+=" ";
            }
            name+=name_type[name_type.length-1].toUpperCase();

            $.ajax({
                url:'CommandLine/delete.php',
                method:'POST',
                data:{
                    name:name,
                },
                success:function(data){
                    alert(data);
                }
            });  
        }

        /*implement nagivating through the website*/
        else if (sep[0]=="switch"){
            var page_str=sep[1];
            pageRedirect(page_str);
        }   
    });

    // search bar;
    $(".left_block_submit").click(function(){
      var searchRequirements = document.getElementsByClassName("left_block_search")[0].value;
      $(".display_lists").empty();
      $.ajax({
        url:'CommandLine/filter.php',
        method:'POST',
        data:{
          searchRequirements: searchRequirements
        },
        success:function(data){
          $('.display_lists').html(data);
          var row = document.getElementsByClassName("row");
          for (var i=0; i<row.length; i++){
            console.log(row[i].id);
            row[i].addEventListener("click", interact_fuction);
          }
        }
      })
    });

    // implement the all tasks button;
    
    $("#show_all").click(function(){
      $(".display_lists").empty();
      $.ajax({
        url:'CommandLine/show_all.php',
        method:'POST',
        data:{
        },
        success:function(data){
          $('.display_lists').html(data);
          var row = document.getElementsByClassName("row");
          for (var i=0; i<row.length; i++){
            console.log(row[i].id);
            row[i].addEventListener("click", interact_fuction);
          }
        }
      })
    });

    // implement the today button;
    $("#show_today").click(function(){
      $(".display_lists").empty();
      $.ajax({
        url:'CommandLine/today.php',
        method:'POST',
        data:{
        },
        success:function(data){
          $('.display_lists').html(data);
          var row = document.getElementsByClassName("row");
          for (var i=0; i<row.length; i++){
            console.log(row[i].id);
            row[i].addEventListener("click", interact_fuction);
          }
        }
      })
    });
    
    /*implement redirect page function*/
    function pageRedirect(page_str) {
        if(page_str=="completed"){
            window.location.replace("http://localhost/project/completed%20task.html");
        }
        else if(page_str=="home"){
            window.location.replace("http://localhost/project/homepage/index.html");
        }
        else if(page_str=="overview"){
            window.location.replace("http://localhost/project/overview.html");
        }
    }

  
});
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



