let api_address = window.location.host;
const ws = new WebSocket("ws://" + api_address + ":8080")

var source = "";
function update(information) {
    $("#radio-station-time").html(information.time);
    $("#radio-station-song").html(information.song);
    $("#radio-station-name").html(information.station);
    $("#volume-slider").val(information.volume);
    if (information.pic == "") { document.getElementById("radio-station-picture").src = "https://garciaflorian.github.io/music-player-for-materialize/assets/music/fun.png"; }
    else { document.getElementById("radio-station-picture").src=information.pic; }
    

    if (information.source != "") { source = information.source; }
}

ws.onmessage = (e) => {
    console.log("RECEIVED >> " + e.data);
    update(JSON.parse(e.data));
};

$(document).ready(function(){
    $('.modal').modal();
});

function play_by_name() {
    let name = $("#search-and-play-input").val();
    return new Promise((resolve, reject) => {
        fetch("http://" + api_address + "/api/play_name.php?name=" + name)
            .then(res => res.text())
            .then(res => resolve(res));
    });
}

function play_url(url) {
    return new Promise((resolve, reject) => {
        fetch("http://" + api_address + "/api/play_url.php?stream=" + url)
            .then(res => res.text())
            .then(res => resolve(res));
    });
}


function info() {
    return new Promise((resolve, reject) => {
        fetch("http://" + api_address + "/api/info.php")
            .then(res => res.json())
            .then(res => resolve(res));
    });
}

function volume(volume) {
    return new Promise((resolve, reject) => {
        fetch("http://" + api_address + "/api/volume.php?vol=" + volume.toString())
            .then(res => res.text())
            .then(res => resolve(res));
    });
}

function stop() {
    return new Promise((resolve, reject) => {
        fetch("http://" + api_address + "/api/stop.php")
            .then(res => res.text())
            .then(res => resolve(res));
    });
}

function resume() {
    return new Promise((resolve, reject) => {
        fetch("http://" + api_address + "/api/play_url.php?stream=" + source)
            .then(res => res.text())
            .then(res => resolve(res));
    });
}

/*
setInterval(() => {
    update();
}, 1000);
*/

// update();

document.getElementById("volume-slider").addEventListener("change", ev => {
    let new_volume = $("#volume-slider").val();
    volume(new_volume);
    console.log("Changed volume to "+new_volume);
});