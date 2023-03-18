<?php

declare(strict_types=1);

use App\App;
use App\Container;
use App\Config;
use App\Controllers\HomeController;
use App\Controllers\InvoiceController;
use App\Router;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


session_start();

const STORAGE_PATH = __DIR__ . '/../storage/';
const VIEWS_PATH = __DIR__ . '/../views/';

    $container = new Container();
    $router = new Router($container);

    $router->get('/', [HomeController::class, 'index'])
        ->post('/upload', [HomeController::class, 'upload'])
        ->get('/download', [HomeController::class, 'download'])
        ->get('/invoices', [InvoiceController::class, 'index'])
        ->get('/invoices/create', [InvoiceController::class, 'create'])
        ->post('/invoices/create', [InvoiceController::class, 'store'])
    ;

(new App(
    $container,
    $router,
    ['uri'=>$_SERVER['REQUEST_URI'],'method'=>$_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
))->run();
