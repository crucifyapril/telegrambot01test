<?php

namespace src;

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
        $update = $telegram->getWebhookUpdates();

        // Проверяем, есть ли сообщение
        if (isset($update['message'])) {
            $message = $update['message'];
            $chatId = $message['chat']['id'];
            $text = $message['text'];

            // Отправляем обратно полученное сообщение
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $text
            ]);
        }
    }
}