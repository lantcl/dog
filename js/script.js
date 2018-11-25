console.log("connected");

function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    m = checkTime(m);
	if (h > 12){
	h = h-12}
    document.getElementById('datetime').innerHTML =
    h + ":" + m;
    var t = setTimeout(startTime, 30000);

//console.log(h);
}

function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}

var monthNames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

var todaydate = new Date();
var d = todaydate.getDate();
var mo = monthNames[todaydate.getMonth()];
document.getElementById("today").innerHTML = mo + " " + d;