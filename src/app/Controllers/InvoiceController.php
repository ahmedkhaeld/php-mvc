<?php

namespace App\Controllers;

use App\Attributes\Route;
use App\View;

class InvoiceController
{
    #[Route('/invoices')]
    public function index(): View
    {
        return View::make('invoices/index', ['invoices'=>'invoice1' ]);
    }

    #[Route('/invoices/create')]
    public function create(): View
    {
        return View::make('invoices/create');
    }

    #[Route('/invoices/create', 'post')]
    public function store(): void
    {
        $amount= $_POST['amount'];
        var_dump($amount);
    }

}