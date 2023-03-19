<?php

namespace App\Controllers;

use App\Attributes\Get;
use App\Attributes\Route;
use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\View;

class InvoiceController
{
    #[Get('/invoices')]
    public function index(): View
    {
        //here we are filtering the invoices by status, all accepts int as parameter
        //means we could pass any int value and nothing wrong with the logic, but we want to pass only the status
        //so, we do the validation by ourselves
        $invoices=(new Invoice())->all(InvoiceStatus::PAID);

        return View::make('invoices/index', ['invoices'=>$invoices]);
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