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

function walkfunction(){
    display: block;
}