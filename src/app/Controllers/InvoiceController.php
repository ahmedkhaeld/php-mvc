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
        return '<form action="/invoices/create" method="post">
                   <label>Amount</label>
                    <input type="text" name="amount">
                </form>';
    }

    public function store(): void
    {
        $amount= $_POST['amount'];
        var_dump($amount);
    }

}