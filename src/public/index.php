<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\InvoiceController;

require __DIR__ . '/../vendor/autoload.php';

session_start();

const STORAGE_PATH = __DIR__ . '/../storage/';
const VIEWS_PATH = __DIR__ . '/../views/';


$router = new App\Router();


$router->get('/', [HomeController::class, 'index'])
        ->get('/invoices', [InvoiceController::class, 'index'])
        ->get('/invoices/create', [InvoiceController::class, 'create'])
        ->post('/invoices/create', [InvoiceController::class, 'store'])
;


echo $router->resolve($_SERVER['REQUEST_URI'],strtolower( $_SERVER['REQUEST_METHOD']));