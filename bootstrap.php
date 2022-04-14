<?php

use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';
(new Dotenv(__DIR__ . '/.env.example'))->load();
echo sprintf('%s, %s, %s', getenv('PDO_DSN'), $_ENV['PDO_USERNAME'], $_SERVER['PDO_PASSWORD']);
