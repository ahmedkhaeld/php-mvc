<?php

namespace App;

use PDO;

/**
 * @property-read ?array db
 * @property-read ?array mailer
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
            ],
            'mailer'=>[
                'dsn'=>$env['MAILER_DSN']??'',
            ]
        ];

    }

    public function __get(string $name): mixed
    {
        return $this->config[$name]??null;
    }

}