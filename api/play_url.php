<?php
$stream = $_GET["stream"];
shell_exec("mpc clear");
shell_exec("mpc add ".$stream);
shell_exec("mpc play");
echo "Playing";
?>