<?php
use MVC\core\Application;
use MVC\controller\SiteController;
use MVC\controller\AuthController;

require_once '..\vendor\autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config =[
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];

$app = new Application((__DIR__),$config);

$app->database->applyMigration();