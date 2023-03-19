<?php

declare(strict_types=1);

namespace App\Controllers;


use App\Attributes\Get;
use App\Attributes\Post;
use App\Services\InvoiceService;
use App\View;

class HomeController
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }
    #[Get('/')]
    #[Get('/home')]
    public function index(): View
    {

       $this->invoiceService->process([],23);

        return View::make('index');
    }
    #[Post('/upload')]
    public function upload():void
    {

        $filePath = STORAGE_PATH . '/'. $_FILES['receipt']['name'];

        move_uploaded_file($_FILES['receipt']['tmp_name'], $filePath);

        //redirect to the home page indicating that the file was uploaded
        header('Location: /');
       //exit the script to make sure the rest of the code is not executed
        exit;
    }

    #[Get('/download')]
    public function download():void
    {
       //download pdf file
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="receipt.pdf"');

        readfile(STORAGE_PATH . '/receipt.pdf');
    }
}