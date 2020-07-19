<?php
include __DIR__ . "/src/common.inc.php";
use Telegram\Bot\Api;

include('vendor/autoload.php');
//$Api = new Api('')
// API ключ

$apiKey = "b1f2de21066ee19280abfdbdcf6ce24d";
$lat = 55.75;
$lon = 37.62;
$url = "http://api.openweathermap.org/data/2.5/weather?lat=" . $lat . "&lon=" . $lon . "&lang=ru&units=metric&appid=" . $apiKey;
//$url = "http://api.openweathermap.org/data/2.5/weather?q=" . $city . "&lang=ru&units=metric&appid=" . $apiKey;

$contents = file_get_contents($url);
$weather = json_decode($contents);
$temp_now = $weather->main->temp;
$icon=$weather->weather[0]->icon;
//$today = date("j.m.Y, H:i");
$cityname = $weather->name;
$humidity = $weather->main->humidity;
$description = $weather->weather[0]->description;
$src = "https://openweathermap.org/img/wn/" . $icon . "@2x.png";

echo
    $cityname."<br />".
    "Влажность воздуха " . $humidity."%<br />".
    $temp_now."°C<br />".$description . "
<img src='$src' class='condition'/>";

?>