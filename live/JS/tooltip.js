document.getElementById("tool").onclick = function() {mouseoverz()};
document.getElementById("toolclose").onclick = function() {mouseoutz()};


function mouseoverz() {
    document.getElementById("tooltip").style.display = "block";
}
function mouseoutz() {
    document.getElementById("tooltip").style.display = "none";
}


document.getElementById("algoopen").onclick = function() {mouseopen()};
document.getElementById("algoclose").onclick = function() {mouseclose()};


function mouseopen() {
    document.getElementById("algotext").style.display = "block";
}
function mouseclose() {
    document.getElementById("algotext").style.display = "none";
}

