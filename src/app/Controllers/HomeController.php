<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Models\Invoice;
use App\Models\User;
use App\Models\UserInvoice;
use App\Services\InvoiceService;
use App\View;

class HomeController
{

    public function index(): View
    {

        App::$container->get(InvoiceService::class)->process([],25);

        return View::make('index');
    }

    public function upload():void
    {

        $filePath = STORAGE_PATH . '/'. $_FILES['receipt']['name'];

        move_uploaded_file($_FILES['receipt']['tmp_name'], $filePath);

        //redirect to the home page indicating that the file was uploaded
        header('Location: /');
       //exit the script to make sure the rest of the code is not executed
        exit;
    }

    public function download():void
    {
       //download pdf file
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="receipt.pdf"');

        readfile(STORAGE_PATH . '/receipt.pdf');
    }
}