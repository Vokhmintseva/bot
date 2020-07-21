<?php
include __DIR__ . "/src/common.inc.php";
include('vendor/autoload.php');
use Telegram\Bot\Api;



$telegram = new Api('1319707453:AAGpynbcay-SL9DQXY2EZHeEH5zOQqbj3ac'); //Устанавливаем токен, полученный у BotFather
$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя

$text = $result["message"]["text"]; //Текст сообщения
$chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
$keyboard = [['text'=>'USD RUB', 'url'=>'http://www.cbr.ru/currency_base/daily/'],['EUR RUB']]; //Клавиатура
$reply = "Добро пожаловать в бота! Укажите буквенные коды валютной пары через пробел";
/*if($text){
    if ($text == "/start") {

    }*/


//$telegram->sendMessage()
$reply_markup = [ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ];
$reply_markup = json_encode($reply_markup);
$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);

/*$apiKey = "4207695fb8eeab4720b1";
$currency1 = 'USD';
$currency2 = 'EUR';
function convertCurrency($amount, $from_currency, $to_currency)
{
    $apikey = '4207695fb8eeab4720b1';
    $from_Currency = urlencode($from_currency);
    $to_Currency = urlencode($to_currency);
    $query =  "{$from_Currency}_{$to_Currency}";
    $json = file_get_contents("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}");
    $obj = json_decode($json, true);
    $val = floatval($obj["$query"]);
    $total = $val * $amount;
    return number_format($total, 2, '.', '');
}
echo convertCurrency(1, 'USD', 'RUB');*/

