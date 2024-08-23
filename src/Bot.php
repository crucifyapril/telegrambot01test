<?php

namespace App;

use Doctrine\DBAL\Exception;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Doctrine\DBAL\DriverManager;

class Bot
{
    private $conn;

    public function __construct()
    {

        $connectionParams = [
            'url' => 'sqlite:///' . __DIR__ . '/../database.sqlite',
            'driver' => 'pdo_sqlite',
        ];
        $this->conn = DriverManager::getConnection($connectionParams);
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
        if (isset($update['message'])) {
            $message = $update['message'];
            $chatId = $message['chat']['id'];
            $text = $message['text'];

            if ($text === '/start') {
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Please enter your username:',
                ]);
            } elseif ($text !== '/start') {
                // Запись никнейма в базу данных
                $stmt = $this->conn->executeQuery('INSERT INTO users (username) VALUES (?)', [$text]);

                // Отправка подтверждения
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Your username has been saved!',
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