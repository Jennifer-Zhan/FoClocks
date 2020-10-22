$(document).ready(function(){
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

    }

    //function for console command line execution and instructions implement.
    $("#commandButton").click(function(){
        var p = document.createElement("p");
        var inputCommand = document.getElementById("commandline").value;
        var t = document.createTextNode(inputCommand);
        p.appendChild(t);
        if (inputCommand === '') {
            alert("You must write something!");
        } else {
            document.getElementById("text_box").appendChild(p);
        }
        document.getElementById("commandline").value = "";
        var sep=inputCommand.split(" ");
        /*implement add instruction*/
        if(sep[0]=="add"){
            var name=sep[1];
            var timer=sep[3];
            var date=sep[2];
            var countdown=sep[4];
            $.ajax({
                url:'insert.php',
                method:'POST',
                data:{
                    name:name,
                    timer:timer,
                    date:date,
                    countdown:countdown
                },
                success:function(data){
                    alert(data);
                }
            });  
        }
        /*implement update instruction*/
        else if(sep[0]=="update"){
            var name=sep[1];
            var update_var=sep[2];
            if(update_var.includes("-")){
                var date=update_var;
                $.ajax({
                    url:'update.php',
                    method:'POST',
                    data:{
                        name:name,
                        date:date
                    },
                    success:function(data){
                        alert(data);
                    }
                });  
            }
            /*if update_var is a number, then it should be the countdown value */
            else if(!isNaN(update_var)){
                var countdown=update_var;
                $.ajax({
                    url:'update.php',
                    method:'POST',
                    data:{
                        name:name,
                        countdown:countdown
                    },
                    success:function(data){
                        alert(data);
                    }
                });  
            }
            else{
                var timer=update_var;
                $.ajax({
                    url:'update.php',
                    method:'POST',
                    data:{
                        name:name,
                        timer:timer
                    },
                    success:function(data){
                        alert(data);
                    }
                });  
            }
        }

        /*implement delete instruction*/
        else if(sep[0]=="delete"){
            var name=sep[1];
            $.ajax({
                url:'delete.php',
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

    //Trigger button click on enter
    var input = document.getElementById("commandline");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("commandButton").click();
        }
    });

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
});


