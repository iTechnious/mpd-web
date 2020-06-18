<?php
$data = nl2br(shell_exec("mpc"));
$bang = explode("\n", $data);

if (count($bang) < 3) {
    echo "Stopped";
    exit;
}

$title = $bang[0];

$stats = $bang[1];
$time = explode("/", explode("   ", $bang[1])[1])[0];

echo $title;
?>