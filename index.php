<?php
//include __DIR__ . "/src/common.inc.php";
include('vendor/autoload.php');
use Telegram\Bot\Api;

$telegram = new Api('1319707453:AAGpynbcay-SL9DQXY2EZHeEH5zOQqbj3ac'); //Устанавливаем токен, полученный у BotFather
$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя

$text = $result["message"]["text"]; //Текст сообщения
$chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя

$keyboard = [[['text'=>"Отправить геолокацию", 'request_location'=>true]]]; //Клавиатура
$reply = "Добро пожаловать в бота!";
//$telegram->sendMessage()
$reply_markup = [ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ];
$reply_markup = json_encode($reply_markup);
$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);

//$Api = new Api('')
// API ключ



/*$apiKey = "b1f2de21066ee19280abfdbdcf6ce24d";
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
<img src='$src' class='condition'/>";*/

?>