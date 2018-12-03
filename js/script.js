console.log("connected");

//Time Display

function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    m = checkTime(m);
    tt = "AM";
	if (h > 12){h = h-12;tt = "PM";} // probably a better way to do this but this is what I came up with 
    document.getElementById('datetime').innerHTML = h + ":" + m + " " + tt;
    var t = setTimeout(startTime, 20000); // could check more frequently but this is ok
}

function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10 got this from W3 schools
    return i;
}

//Date Display 

var monthNames = ["January", "February", "March", "April", "May", "June",  //W3 schools
  "July", "August", "September", "October", "November", "December"
];

var todaydate = new Date();
var d = todaydate.getDate();
var mo = monthNames[todaydate.getMonth()];
var todayy = document.getElementById("today")
todayy.innerHTML = mo + " " + d;

//Clock Buttons


var forward = document.getElementById("goforward");
forward.addEventListener("click", forwardfunction, false);
function forwardfunction(){
    var d = todaydate.getDate() + 1;
    //d = todaydate.setTime(todaydate.getTime() + (24 * 60 * 60 * 1000));
    // d = new Date((new Date()).valueOf() + 1000*3600*24).getDate();
    todayy.innerHTML = mo + " " + d; 
}

var back = document.getElementById("goback");
back.addEventListener("click", backfunction, false);
function backfunction(){
    var d = todaydate.getDate() - 1;
    todayy.innerHTML = mo + " " + d;        
}

//Add Walk

var newWalk = document.getElementById("add");
newWalk.addEventListener("click", walkfunction, false);


//walk chart 

// d 

function walkfunction(){

    var chart = document.getElementsByClassName("chart");    
    var maxTime = 24;
    // console.log("clicked");

        var today = new Date();
        var h = today.getHours();
        
        var time = parseInt(h / maxTime *100);

        newWalk.style.marginLeft = time+"%";


        // var myRequest = new XMLHttpRequest();

        // myRequest.onreadystatechange = function() {
        //     if (myRequest.readyState == 4) {
        //         walkHistory(myRequest.responseText);
        //     }
        // }
        // myRequest.open("GET", "walks.php", true);
        // myRequest.send();

        // function walkHistory(response) {
            
        //     var walkData = JSON.parse(response);
            
        //     for(var i = 0; i < walkData.length; i++) {
        //         var paw = document.createElement("img").class = "icon";
        //         paw.src = "../assets/paw.svg";
        //         var time = walkData[i].walktime;
        //         console.log(time);
        //         paw.style.width = "time + %"; 

        //         chart.appendChild(paw);
        //     }
        // }
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

