<?php
declare(strict_types=1);
require dirname(__DIR__) . '/vendor/autoload.php';
use Lila\\Controller\\MainController;
use Lila\\Http\\Request;
use Lila\\Http\\Router;
$router = new Router();
$main = new MainController();
$router->get('/', [$main, 'home']);
$router->get('/manifest.json', [$main, 'manifest']);
$router->dispatch(Request::fromGlobals())->send();
