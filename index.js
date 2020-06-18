let api_address = window.location.host;

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
var source = "";
function update() {
    info()
    .then(information => {
        $("#radio-station-time").html(information.time);
        $("#radio-station-name").html(information.title);
        $("#volume-slider").val(information.volume);
        if (information.source != "") { source = information.source; }
    });
}

setInterval(() => {
    update();
}, 1000);

update();

document.getElementById("volume-slider").addEventListener("change", ev => {
    let new_volume = $("#volume-slider").val();
    volume(new_volume);
    console.log("Changed volume to "+new_volume);
});