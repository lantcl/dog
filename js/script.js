console.log("connected");

//Time Display


(function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    m = checkTime(m);
    tt = "AM";
	if (h > 12){h = h-12;tt = "PM";} // probably a better way to do this but this is what I came up with 
    document.getElementById('datetime').innerHTML = h + ":" + m + " " + tt;
    var t = setTimeout(startTime, 20000); // could check more frequently but this is ok
})();
//iife

function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10 got this from W3 schools
    return i;
}

//Date Display 

var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

var todaydate = new Date();
var d = todaydate.getDate();
var mo = monthNames[todaydate.getMonth()];
var todayy = document.getElementById("today")
todayy.innerHTML = mo + " " + d;
var curDate = todaydate;

//Clock Buttons


var forward = document.getElementById("goforward");
forward.addEventListener("click", forwardfunction, false);
function forwardfunction(){
    //curDate = new Date(curDate.parse() + 86400);
    curDate = new Date(Date.parse(curDate) + 86400000);

    //d = todaydate.setTime(todaydate.getTime() + (24 * 60 * 60 * 1000));
    // d = new Date((new Date()).valueOf() + 1000*3600*24).getDate();
    d = curDate.getDate();
    mo = monthNames[curDate.getMonth()];

    todayy.innerHTML = mo + " " + d;
    //curDate = d;
}

var back = document.getElementById("goback");
back.addEventListener("click", backfunction, false);
function backfunction(){
    curDate = new Date(Date.parse(curDate) - 86400000);
    d = curDate.getDate();
    mo = monthNames[curDate.getMonth()];

    todayy.innerHTML = mo + " " + d;       
    //curDate = d;
}


//Add Walk

window.onload = function(){

function walkfunction(){

    //display add walk icon based on current time 
    var newWalk = document.getElementById("add");
    var chart = document.getElementById("chart");    
    var maxTime = 24;
    var todayT = new Date();
    var h = todayT.getHours();
    

    var time = parseInt(h / maxTime *100);

    newWalk.style.marginLeft = time+"%";
    
    //get the walk data for today from the database 

    var myRequest = new XMLHttpRequest();

        myRequest.onreadystatechange = function() {
            if (myRequest.readyState == 4) {
                walkHistory(myRequest.responseText);
            }
        }
        myRequest.open("GET", "walks.php", true);
        myRequest.send();

        function walkHistory(response) {
            
            var walkData = JSON.parse(response);
            for(var i = 0; i < walkData.length; i++) { 
                
                chart = document.getElementById("chart");
                var aTag = document.createElement('a');
                var paw = document.createElement('img');
                
                aTag.setAttribute("href", "walk-record.php?id="+walkData[i].id);
                paw.setAttribute("class", "icon");
                
                //display a blue icon for walks
                //display a brown icon for walks where the dog pooped hehe

                    if(walkData[i].poo == "1"){
                        paw.setAttribute("src", "assets/poopaw.svg")
                    } else {
                        paw.setAttribute("src", "assets/paw.svg");
                    }

                var time = walkData[i].walktime;
                var newTime = time.substring(0, 2);
                var Wtime = parseInt(newTime / maxTime *100);
            
                //console.log(Wtime);
                paw.style.marginLeft = Wtime+"%";
                aTag.appendChild(paw);
                chart.appendChild(aTag);
            }
        }

}
walkfunction();
}
//minutes seconds in the day


// var walkTime = ;

// w = Math.round(maxTime / walkTime )*10; //should give percent value
//Percentage = (number * 100 / total);
//icon width = w +'%';


// for (var i=0; i<walkData; i++){
//     // var a = document.createElement("a");
//     var paw = document.createElement("img").id = "icon";
//     paw.src = "../assets/paw.svg";
//     var place = walkData[i].walktime;
//     paw.style.width = "place + %"; 

//     chart.appendChild(paw);
// }
