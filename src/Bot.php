<?php

namespace App;

use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class Bot
{
    /**
     * @throws TelegramSDKException
     */
    public function run()
    {
        $telegram = new Api(getenv('TELEGRAM_BOT_TOKEN'));

        // Получаем данные из вебхука
        $update = $telegram->getWebhookUpdate();

        // Проверяем, есть ли сообщение
        if (isset($update['message'])) {
            $message = $update['message'];
            $chatId = $message['chat']['id'];
            $text = $message['text'];

            if ($text === '/start') {
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'hello',
                ]);
            } elseif ($text === '/create_file') {
                mkdir('files');
                $file = fopen('files/file.txt', 'w');
                fwrite($file, 'hello');
                fclose($file);

                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'create file',
                ]);
            } else {
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'ты ввел неизвестную команду'
                ]);
            }
        }
    }
}