<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\InvoiceController;
use App\View;

require __DIR__ . '/../vendor/autoload.php';

session_start();

const STORAGE_PATH = __DIR__ . '/../storage/';
const VIEWS_PATH = __DIR__ . '/../views/';

try {

    $router = new App\Router();


    $router->get('/', [HomeController::class, 'index'])
        ->post('/upload', [HomeController::class, 'upload'])
        ->get('/download', [HomeController::class, 'download'])
        ->get('/invoices', [InvoiceController::class, 'index'])
        ->get('/invoices/create', [InvoiceController::class, 'create'])
        ->post('/invoices/create', [InvoiceController::class, 'store'])
    ;


    echo $router->resolve($_SERVER['REQUEST_URI'],strtolower( $_SERVER['REQUEST_METHOD']));
}catch (App\Exceptions\RouteNotFoundException $e){
    //send 404 header
    http_response_code(404);
    //render 404 page
    echo View::make('error/404');
}
