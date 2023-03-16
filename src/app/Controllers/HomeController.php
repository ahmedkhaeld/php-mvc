<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Models\Invoice;
use App\Models\User;
use App\Models\UserInvoice;
use App\View;

class HomeController
{

    public function index(): View
    {

       $email='gemi@gmail.com';
        $fullName='gemi';
        $amount=200;

        $userModel=new User();
        $invoiceModel=new Invoice();

        $invoiceID=(new UserInvoice($userModel,$invoiceModel))->register(
            [
                'email'=>$email,
                'full_name'=>$fullName,
            ],
            [
                'amount'=>$amount,
            ]
        );

        return View::make('index' , ['invoice'=>$invoiceModel->find($invoiceID)]);
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