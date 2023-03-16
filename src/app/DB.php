<?php

namespace App;

use PDO;

/**
 * @mixin PDO
 */
class DB
{
    private PDO $pdo;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        //default options
        $options = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->pdo = new PDO($config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['database'], $config['user'], $config['password'], $config['options'] ?? $options);

        }catch (\PDOException $e){
            throw new \PDOException($e->getMessage(),(int)$e->getCode());
        }
    }

    /**
     * @return PDO
     * get the pdo connection
     */
    public function __call(string $name, array $arguments): mixed
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }
}