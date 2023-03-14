<?php

namespace App\Controllers;

class InvoiceController
{
    public function index(): string
    {
        return 'Invoices';
    }

    public function create(): string
    {
        return 'Create Invoice';
    }

}