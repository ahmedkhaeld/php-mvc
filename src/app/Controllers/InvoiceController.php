<?php

namespace App\Controllers;

use App\View;

class InvoiceController
{
    public function index(): View
    {
        return View::make('invoices/index', ['invoices'=>'invoice1' ]);
    }

    public function create(): View
    {
        return View::make('invoices/create');
    }

    public function store(): void
    {
        $amount= $_POST['amount'];
        var_dump($amount);
    }

}