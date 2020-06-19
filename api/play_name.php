<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function endsWith($string, $endString) 
{ 
    $len = strlen($endString); 
    if ($len == 0) { 
        return true; 
    } 
    return (substr($string, -$len) === $endString); 
};


$name = $_GET["name"];
$search = "http://de1.api.radio-browser.info/json/stations/search?name=".urlencode($name); //."&country=Germany" ;
$json = file_get_contents( $search );

if ($json === false || $json == "[]") {
    echo "not found" ;
    exit ;
}
$res = json_decode($json);

$stream = $res[0]->url;

echo $stream;

shell_exec("mpc clear");

if (endswith($stream, ".m3u")) {
    shell_exec("mpc load ".$stream);
} else {
    shell_exec("mpc add ".$stream);

}

shell_exec("mpc play");
?>