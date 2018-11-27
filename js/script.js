console.log("connected");

//Time Display

function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    m = checkTime(m);
    tt = "AM";
	if (h > 12){
	h = h-12
    tt = "PM";
    }
    document.getElementById('datetime').innerHTML = h + ":" + m + " " + tt;
    var t = setTimeout(startTime, 20000);
}

function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}

//Date Display 

var monthNames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

var todaydate = new Date();
var d = todaydate.getDate();
var mo = monthNames[todaydate.getMonth()];
document.getElementById("today").innerHTML = mo + " " + d;

//Clock Buttons


var forward = document.getElementById("goforward");
forward.style.cursor= "pointer";
forward.addEventListener("click", forwardfunction, false);
function forwardfunction(){
    console.log("clicked");
}

var back = document.getElementById("goback");
back.style.cursor= "pointer";
back.addEventListener("click", backfunction, false);
function backfunction(){
    console.log("clicked");        
}

//Add Walk

var newWalk = document.getElementById("newalk");
newalk.addEventListener("click", walkfunction, false);

function walkfunction(){
    display: block;
}