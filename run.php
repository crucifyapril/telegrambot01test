<?php

use App\Bot;
use Telegram\Bot\Exceptions\TelegramSDKException;

require_once './vendor/autoload.php';

$bot = new Bot();

try {
    $bot->run();
} catch (TelegramSDKException $e) {
    echo $e->getMessage();
}
