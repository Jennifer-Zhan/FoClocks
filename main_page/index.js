$(document).ready(function(){
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
      Countdown_timer(2);
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
      hours = 2;
      minutes = 0;
      seconds = 0;
      show_time=hours + "h "+ minutes + "m " + seconds + "s ";
      clearInterval(timer_interval);
    }

    // when click on countup timer, close and stop the countdown timer.
    AccumulateTimer_bnt.onclick = function() {
      AccumulateTimer.style.display = "block";
      CountdownTimer.style.display = "none";
      hours = 2;
      minutes = 0;
      seconds = 0;
      show_time=hours + "h "+ minutes + "m " + seconds + "s ";
      clearInterval(timer_interval);
    }
    //accumulate timer functions
    /*
    document.getElementById("start").addEventListener("click", timedCount);
    document.getElementById("stop").addEventListener("click", stopCount);
    document.getElementById("stop").addEventListener("click", clearCount);*/
    //Add help alert.
    document.getElementById("help").addEventListener("click", helpText);
    function helpText(){
        var text="Command Line Help\n";
        text+="Add task: add <task name> <working date> <timer type> <countdown time>\n";
        text+="ex: add DS_HW 2020-10-23 Countdown 2\n";
        text+="Edit task: update <task name> <task property you want to update>\n";
        text+="ex: update DS_HW 2020-10-24\n";
        text+="Delete task: delete <task name>\n";
        text+="ex: delete DS_HW\n";
        text+="Navigate through our website: switch <tag name>\n";
        text+="ex: switch home";
        alert(text);
    }

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
        var p = document.createElement("p");
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
        var t = document.createTextNode(command_line);
        p.appendChild(t);
        if (command_line === '') {
            alert("You must write something!");
        } else {
            document.getElementById("text_box").appendChild(p);
        }
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

            var time=sep[2];
            var timeZone=sep[3];
            var tag=sep[4];
            // format the details of the task if it has multiple words.
            var details_type=sep[5];
            details_type=details_type.split("_");
            var details="";
            for (var i=0; i<details_type.length-1; i++){
                details+=details_type[i].toUpperCase();
                details+=" ";
            }
            details+=details_type[details_type.length-1].toUpperCase();
            $.ajax({
                url:'CommandLine/insert.php',
                method:'POST',
                data:{
                    name:name,
                    time:time,
                    timeZone:timeZone,
                    tag:tag,
                    details:details
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
            if(type=="time"){
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
    $("#search").click(function(){
      var searchRequirements = document.getElementById("searchRequirements").value;
      $(".lists").empty();
      $.ajax({
        url:'CommandLine/filter.php',
        method:'POST',
        data:{
          searchRequirements: searchRequirements
        },
        success:function(data){
          $('.lists').html(data);
        }
      })
    });

    // implement the show all button;
    $("#show_all").click(function(){
      $(".lists").empty();
      $.ajax({
        url:'CommandLine/show_all.php',
        method:'POST',
        data:{
        },
        success:function(data){
          $('.lists').html(data);
        }
      })
    });

    /*
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

    // Create a "close" button and append it to each list item
    var myNodelist = document.getElementsByTagName("LI");
    var i;
    for (i = 0; i < myNodelist.length; i++) {
      var span = document.createElement("SPAN");
      var txt = document.createTextNode("\u00D7");
      span.className = "close";
      span.appendChild(txt);
      myNodelist[i].appendChild(span);
    }

    // Click on a close button to hide the current list item
    var close = document.getElementsByClassName("close");
    var i;
    for (i = 0; i < close.length; i++) {
      close[i].onclick = function() {
        var div = this.parentElement;
        div.style.display = "none";
      }
    }

    // Add a "checked" symbol when clicking on a list item
    var list = document.querySelector('ul');
    list.addEventListener('click', function(ev) {
      if (ev.target.tagName === 'LI') {
        ev.target.classList.toggle('checked');
      }
    }, false);

    // Create a new list item when clicking on the "Add" button
    function newElement() {
      var li = document.createElement("li");
      var inputValue = document.getElementById("myInput").value;
      var t = document.createTextNode(inputValue);
      li.appendChild(t);
      if (inputValue === '') {
        alert("You must write something!");
      } else {
        document.getElementById("myList").appendChild(li);
      }
      document.getElementById("myInput").value = "";

      var span = document.createElement("SPAN");
      var txt = document.createTextNode("\u00D7");
      span.className = "close";
      span.appendChild(txt);
      li.appendChild(span);

      for (i = 0; i < close.length; i++) {
        close[i].onclick = function() {
          var div = this.parentElement;
          div.style.display = "none";
        }
      }

    }*/

    
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



