<?php
$data = nl2br(shell_exec("mpc"));
$bang = explode("\n", $data);

$title = explode("<br", $bang[0])[0];

$stats = $bang[1];
$part = explode("/", $stats)[1];
$part = explode(" ", $part);
$time = $part[count($part)-1];

$player = $bang[2];
$part = explode("  ", $player)[0];
$volume = explode(":", $part)[1];
$volume = str_replace(" ", "", $volume);

$res = array("title"=>$title,"time"=>$time,"volume"=>$volume);
echo json_encode($res);
?>