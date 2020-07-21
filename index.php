<?php
include __DIR__ . "/src/common.inc.php";
include('vendor/autoload.php');
use Telegram\Bot\Api;
$currencyArray = ['AUD', 'AZN', 'AMD', 'BYN', 'BGN', 'BRL', 'HUF', 'KRW', 'HKD', 'DKK', 'USD', 'EUR', 'RUB', 'INR',
    'KZT', 'CAD', 'KGS', 'CNY', 'MDL', 'TMT', 'NOK', 'PLN', 'RON', 'XDR', 'SGD', 'TJS', 'TRY', 'UZS', 'UAH', 'GBP',
'CZK', 'SEK', 'CHF', 'ZAR', 'JPY'];

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

$telegram = new Api('1319707453:AAGpynbcay-SL9DQXY2EZHeEH5zOQqbj3ac'); //Устанавливаем токен, полученный у BotFather
$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя

$text = $result["message"]["text"]; //Текст сообщения
$chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
$keyboard = [['USD RUB'],['EUR RUB']]; //Клавиатура
$reply_markup = [ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ];
$reply_markup = json_encode($reply_markup);
if($text){
    if ($text == "/start") {
        $reply = "Добро пожаловать в бота! Укажите буквенные коды валютной пары через пробел";
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    } elseif ($text == "USD RUB") {
        $reply = convertCurrency(1, 'USD', 'RUB');
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    } else {
        $reply = "Добро пожаловать в бота! Укажите буквенные коды валютной пары через пробел";
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    }
}



//$telegram->sendMessage()


$apiKey = "4207695fb8eeab4720b1";
$currency1 = 'USD';
$currency2 = 'EUR';

//echo convertCurrency(1, 'USD', 'RUB');

