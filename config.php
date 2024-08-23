<?php

use Doctrine\DBAL\DriverManager;

$connectionParams = [
    'url' => 'sqlite:identifier.sqlite',
];

$conn = DriverManager::getConnection($connectionParams);