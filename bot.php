<?php

$token = '7273381403:AAE-EjxshXqFemoRaKrxrKYDpZtQgm6MluE'; // Замените на ваш токен
$apiUrl = 'https://api.telegram.org/bot' . $token . '/';
$webhookUrl = 'https://hauntingclaire.ru/bot.php'; // Замените на URL вашего скрипта

$url = $apiUrl . 'setWebhook';
$data = [
    'url' => $webhookUrl
];
$options = [
    'http' => [
        'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data),
    ],
];
$context = stream_context_create($options);
file_get_contents($url, false, $context);
