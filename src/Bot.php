<?php

namespace App;

use mysqli;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class Bot
{
    private $conn;

    public function __construct()
    {

    }

    /**
     * @throws TelegramSDKException
     * @throws Exception
     */
    public function run()
    {
        $telegram = new Api(getenv('TELEGRAM_BOT_TOKEN'));

        // Получаем данные из вебхука
        $update = $telegram->getWebhookUpdate();

        // Проверяем, есть ли сообщение
        $message = $update['message'];
        $chatId = $message['chat']['id'];
        $text = $message['text'];

        if ($text === '/start') {
            $response = "Введите ваш никнейм:";
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $response
            ]);
        } elseif (isset($update['message']['text'])) {
            $nickname = $update['message']['text'];
            // Сохраните никнейм в базу данных
            $mysqli = new mysqli('db', 'telegram_bot', 'telegram_bot', 'telegram_bot');
            if ($mysqli->connect_error) {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $stmt = $mysqli->prepare("INSERT INTO users (chat_id, nickname) VALUES (?, ?)");
            $stmt->bind_param('is', $chatId, $nickname);
            $stmt->execute();
            $stmt->close();
            $mysqli->close();

            $response = "Ваш никнейм сохранен: $nickname";
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $response
            ]);
        }
            }
}