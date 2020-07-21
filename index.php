<?php
include __DIR__ . "/src/common.inc.php";
include('vendor/autoload.php');
use Telegram\Bot\Api;
$currencies = ['AUD', 'AZN', 'AMD', 'BYN', 'BGN', 'BRL', 'HUF', 'KRW', 'HKD', 'DKK', 'USD', 'EUR', 'RUB', 'INR',
    'KZT', 'CAD', 'KGS', 'CNY', 'MDL', 'TMT', 'NOK', 'PLN', 'RON', 'XDR', 'SGD', 'TJS', 'TRY', 'UZS', 'UAH', 'GBP',
'CZK', 'SEK', 'CHF', 'ZAR', 'JPY'];

function convertCurrency($amount, $fromCurrency, $toCurrency)
{
    $apikey = '4207695fb8eeab4720b1';
    $query =  urlencode("{$fromCurrency}_{$toCurrency}");
    $json = file_get_contents("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}");
    $obj = json_decode($json, true);
    $val = (float)($obj["$query"]);
    $total = $val * $amount;
    return number_format($total, 2, '.', '');
}

function generatePairKeyBoard($selectedCurrency, $currencies)
{
    $keyBoard = [];
    $keyRow = [];
    $counter = 0;
    foreach($currencies as $value)
    {
        if ($selectedCurrency == $value)
        {
            continue;
        }
        $keyRow[] = $selectedCurrency . " " . $value;
        $counter++;
        if ($counter % 4 == 0)
        {
            $keyBoard[] = $keyRow;
            $keyRow = [];
        }
    }
    if (!empty($keyRow))
    {
        $keyBoard[] = $keyRow;
    }
    return $keyBoard;
}

function generateKeyBoard($currencies) {
    $keyBoard = [];
    $keyRow = [];
    $counter = 0;
    foreach($currencies as $value)
    {
        $keyRow[] = $value;
        $counter++;
        if ($counter % 4 == 0)
        {
            $keyBoard[] = $keyRow;
            $keyRow = [];
        }
    }
    if (!empty($keyRow))
    {
        $keyBoard[] = $keyRow;
    }
    return $keyBoard;
}

function isCurrencyCode($code, $currencies) {
    $code = mb_strtoupper($code);
    return (preg_match('/^\w{3}$/', $code) && in_array($code, $currencies));
}

function isCurrencyCodesPair($text, $currencies) {
    $isPair = false;
    if (preg_match('/^\w{3}\s\w{3}$/', $text)) {
        $text = mb_strtoupper($text);
        $pair = explode(" ", $text);
        $isPair = (isCurrencyCode($pair[0], $currencies) && isCurrencyCode($pair[1], $currencies));
    }
    return $isPair;
}

$telegram = new Api('1319707453:AAGpynbcay-SL9DQXY2EZHeEH5zOQqbj3ac'); //Устанавливаем токен, полученный у BotFather
$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя
$text = $result["message"]["text"]; //Текст сообщения

$chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
$keyboard = [["USD RUB"],["EUR RUB"],["Выбрать валютную пару"]]; //Клавиатура
$reply_markup = [ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ];
$reply_markup = json_encode($reply_markup);

if($text){
    if ($text == "/start") {
        $reply = "Добро пожаловать в бота! Укажите буквенные коды валютной пары через пробел";
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    } elseif ($text == "USD RUB") {
        $reply = "курс доллара США к рублю: " . convertCurrency(1, 'USD', 'RUB');
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    } elseif ($text == "EUR RUB"){
        $reply = "курс евро к рублю: " . convertCurrency(1, 'EUR', 'RUB');
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    } elseif ($text == "/help") {
        $reply = "Названия кодов валют можно посмотреть по ссылке http://www.cbr.ru/currency_base/daily/ \n
        Пример сообщения, которое Вы можете отправить боту: krw inr";
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    } elseif ($text == "Выбрать валютную пару") {
        $reply = "Выберите первый элемент валютной пары";
        $keyboard = generateKeyBoard($currencies); //Клавиатура
        $reply_markup = [ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ];
        $reply_markup = json_encode($reply_markup);
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    } elseif (isCurrencyCode($text, $currencies)) {
        $reply = "Выберите второй элемент валютной пары";
        $keyboard = generatePairKeyBoard($text, $currencies); //Клавиатура
        $reply_markup = [ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ];
        $reply_markup = json_encode($reply_markup);
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    } elseif (isCurrencyCodesPair($text, $currencies)) {
        $text = mb_strtoupper($text);
        $pair = explode(" ", $text);
        $reply = convertCurrency(1, $pair[0], $pair[1]) . "";
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    } else {
        $reply = "Повторите ввод";
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    }
} else {
    $reply = "Отправьте текстовое сообщение";
    $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
}



//$telegram->sendMessage()


$apiKey = "4207695fb8eeab4720b1";
$currency1 = 'USD';
$currency2 = 'EUR';

//echo convertCurrency(1, 'USD', 'RUB');

