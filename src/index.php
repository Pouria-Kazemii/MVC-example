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

$app = new Application(dirname(__DIR__),$config);

$app->router->get('/',[SiteController::class,'home']);

$app->router->get('/contact',[SiteController::class,'contact']);
$app->router->post('/contact',[SiteController::class ,'handleContact']);

$app->router->get('/login',[AuthController::class , 'login']);
$app->router->post('/login',[AuthController::class , 'login']);

$app->router->get('/register',[AuthController::class,'register']);
$app->router->post('/register',[AuthController::class,'register']);


$app->run();