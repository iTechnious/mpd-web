<?php
$data = nl2br(shell_exec("mpc"));
$bang = explode("\n", $data);

$title = exec("mpc current --format=%title%");

if ($title == "") {
    $time = "";
} else {
    //$title = explode("<br", $bang[0])[0];

    $stats = $bang[1];
    $part = explode("/", $stats)[1];
    $part = explode(" ", $part);
    $time = $part[count($part)-1];
}

$part = exec("mpc volume");
$volume = explode(":", $part)[1];
$volume = str_replace(" ", "", $volume);
$volume = str_replace("%", "", $volume);

$source = exec("mpc current --format=%file%");

$station = exec("mpc current --format=%name%");

$res = array("title"=>$title,"source"=>$source,"station"=>$station,"time"=>$time,"volume"=>$volume);
echo json_encode($res);
?>