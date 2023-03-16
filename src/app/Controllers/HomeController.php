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
            $db=new PDO ('mysql:host=db;dbname=mvc','root','root');

            $email='ahmed@gmail.com';
            $query='SELECT * FROM users WHERE email=?';
            $statement=$db->prepare($query);
            $statement->execute([$email]);

            foreach ($statement->fetchAll() as $user){
                echo '<pre>';
                echo $user['email'];
                echo '<pre>';

            }

        }catch (\PDOException $e){
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