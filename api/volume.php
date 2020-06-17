<?php
$vol = $_GET["vol"];
shell_exec("mpc volume ".$vol);
echo "Changed";
?>