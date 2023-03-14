<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\InvoiceController;

require __DIR__ . '/../vendor/autoload.php';


$router = new App\Router();


$router->register('/', [HomeController::class, 'index'])
        ->register('/invoices', [InvoiceController::class, 'index'])
        ->register('/invoices/create', [InvoiceController::class, 'create'])
;


echo $router->resolve($_SERVER['REQUEST_URI']);