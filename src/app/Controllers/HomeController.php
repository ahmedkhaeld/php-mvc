<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use PDO;

class HomeController
{

    public function index(): View
    {
        try {

            $db =new PDO( $_ENV['DB_DRIVER'].':host='. $_ENV['DB_HOST'] .';dbname='. $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(),(int)$e->getCode());
        }

       $email='gmal@gmail.com';
        $fullName='gmal';
        $amount=200;

        try {
            //begin transaction
            $db->beginTransaction();
            $newUser=$db->prepare(
                'INSERT INTO users (email,full_name,is_active, created_at) 
                    VALUES (?, ?, 1, NOW())'
            );

            $newInvoice=$db->prepare(
                'INSERT INTO invoices (amount, user_id) 
                    VALUES (?, ?)'
            );

            $newUser->execute([$email,$fullName]);
            $userId=(int)$db->lastInsertId();

            $newInvoice->execute([$amount,$userId]);
            //commit transaction
            $db->commit();
        }catch (\PDOException $e){
            //rollback transaction after make sure the transaction is started
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            throw new \PDOException($e->getMessage(),(int)$e->getCode());
        }


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