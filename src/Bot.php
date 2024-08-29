<?php

namespace App;

use PDO;
use PDOException;
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
        $update = json_decode(file_get_contents('php://input'), TRUE);

        if (!$update) {
            exit;
        }

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
            try {
                $pdo = new PDO('mysql:host=db;dbname=telegram_bot', 'telegram_bot', 'telegram_bot');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $pdo->prepare("INSERT INTO users (chat_id, nickname) VALUES (:chat_id, :nickname)");
                $stmt->execute(['chat_id' => $chatId, 'nickname' => $nickname]);

                $response = "Ваш никнейм сохранен: $nickname";
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $response
                ]);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                $response = "Произошла ошибка при сохранении никнейма.";
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $response
                ]);
            }
        }
}
}