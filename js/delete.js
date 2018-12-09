console.log("connected");

//Time Display
var newWalk = document.getElementById("add");
var popbox = document.getElementById("popbox");
var chart = document.getElementById("chart");

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

var kill = document.getElementById("kill");
var destroy = document.getElementById("destroyRecord");
var heading = document.getElementById("heading");
var recordColumns = document.getElementById("recordColumns");

destroy.addEventListener("click", deleteFunction, false);

function deleteFunction(){
    recordColumns.innerHTML = '';
    heading.innerHTML = 'Are you really sure?'; 
    destroy.remove();
    kill.style.display = "block";
}