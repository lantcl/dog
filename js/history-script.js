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

var records = document.getElementById("records");
var dateSubmit = document.getElementById("dateSubmit");
var historyDate;

dateSubmit.addEventListener("click", searchHistory, false);

function searchHistory(e){
    var myRequest = new XMLHttpRequest; 
    //var historyDate = document.getElementById("historyDate");
    //console.log(historyDate.value);


myRequest.onreadystatechange = function(){   

    if(myRequest.readyState === 4){        
    
    
        // console.log(myRequest.responseText);
        var walks = JSON.parse(myRequest.responseText);

        if(walks.length == 0){
                //console.log("none");
            records.innerHTML = '';
            var noRecords = document.createElement("h2")
            noRecords.innerHTML = 'No records';
            records.appendChild(noRecords);

        } else {
        //console.log(walks);
        records.innerHTML = '';
        for(var i=0; i<walks.length; i++){

            var details = document.createElement("p")
            var time = document.createElement("h2")
            
            tt = "AM";
                if (walks[i].walktime > "12:00"){
                    var fixTime = walks[i].walktime.substring(0, 2)-12;
                    var stayTime = walks[i].walktime.substring(2, 5);
                    tt = "PM";
                    var textNode = document.createTextNode(fixTime + stayTime + ' '+tt);
                } else {
            
            var textNode = document.createTextNode(walks[i].walktime+ ' '+tt);
            }

            details.innerHTML = "details";
            
            var newaTag = document.createElement("a");
            var div = document.createElement("div");
            newaTag.setAttribute("href", "walk-record.php?id="+walks[i].id);
            
            newaTag.appendChild(details);
            
            time.appendChild(textNode);

            div.appendChild(time);
            div.appendChild(newaTag);

            records.appendChild(div);

            }

        }
    } 
};

    historyDate = document.getElementById("historyDate");
    myRequest.open("POST", "history-process.php", true);
    myRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded"); 
    myRequest.send("date=" + historyDate.value);  
}
