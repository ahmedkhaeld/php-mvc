<?php

namespace App;

use PDO;

/**
 * @property-read ?array db
 */
class Config
{
    protected array $config=[];
    public function __construct(array $env)
    {
        $this->config=[
            'db'=>[
                'driver'=>$env['DB_DRIVER'],
                'host'=>$env['DB_HOST'],
                'database'=>$env['DB_NAME'],
                'user'=>$env['DB_USER'],
                'password'=>$env['DB_PASSWORD'],
            ]
        ];

    }

    public function __get(string $name): mixed
    {
        return $this->config[$name]??null;
    }

}