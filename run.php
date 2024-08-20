<?php

use App\Bot;
use Telegram\Bot\Exceptions\TelegramSDKException;

require __DIR__ . '/vendor/autoload.php';

$bot = new Bot();

try {
    $bot->run();
} catch (TelegramSDKException $e) {
    echo $e->getMessage();
}
